# Zen Cart v2.2.2 backports overlay: comparison with stock 2.2.2

- **Compared:** `patches/security_080426/v2.2.2-patch-july2026/zencart-v2.2.2-backports-overlay`
- **Against:** `zencart-2.2.2`
- **Date:** 2026-10-30

**Of the 59 files, 2 contain critical security fixes and 5 are performance fixes.** Another 42 contain lower-severity security fixes, and 10 are functional fixes. All 59 differ from stock 2.2.2, and `includes/routing_map.php` is the only new file.

The bundle assigns no severities, so these labels are my own, based on reading the diffs. I traced the critical paths through the code but did not run an exploit against them. Each file is counted once, by its main purpose.

| Category | Files | Distinct issues |
|---|---:|---:|
| Critical security | 2 | 2 |
| Other security | 42 | about 14 |
| Performance | 5 | 2 |
| Functional or cleanup | 10 | – |
| **Total** | **59** | |

## Critical (2)

- **`ipn_main_handler.php`:** allows forged PayPal notifications and SQL injection, with no login needed.
  - **Validation bypass:** stock code ignores a failed PayPal validation when `custom` starts with `EC-`, so anyone can skip the check by posting that value.
  - **SQL injection:** the same request can then reach an `UPDATE` with `$_POST['txn_id']` concatenated in raw, for example with `payment_status=Denied`.
- **`includes/classes/shopping_cart.php`:** a second-order SQL injection that any customer with an account can trigger. `$_POST['id']` values are stored in the cart without a cast, then inserted unescaped by `restore_contents()` at login.

## Other security (42)

- **Trusted proxy, spoofed IP and HTTPS headers (10 files):** two `application_top.php`, two `init_file_db_names.php`, `Request.php`, `functions_traffic.php`, two `dist-configure.php`, two `zc_install` templates.
- **Admin XSS and parameter injection (7):** `coupon_admin`, `customers`, `featured`, `featured_categories`, `specials`, `sqlpatch`, `gv_mail`.
- **Session fixation (5):** `sessions.php`, `login`, `create_account`, `password_reset`, `admin_access`.
- **Storefront output escaping (4):** `account_history_info`, `contact_us`, `gv_send`, `order_status`.
- **CSRF (3):** `functions_general_shared`, `init_sanitize`, `checkout_process`.
- **PayPal (4):** two admin notification XSS files, `paypaldp` (CVV exposed in page HTML) and `paypal_curl` (TLS settings, log masking).
- **Upload path restrictions (2):** `upload.php`, `banner_manager`.
- **Single-file fixes (7):**
  - `mfa.php`: brute-force lockout, likely the most serious in this group.
  - `orders.php`: checks a download belongs to the order.
  - `display_logs.php`: restricts access to superusers.
  - `functions_email.php`: Reply-To header injection.
  - `functions_customers.php`: case-insensitive duplicate email check.
  - `ot_group_pricing.php`: caps the discount at the order total.
  - `auto.non_captcha_observer.php`: adds the anti-spam check to Ask a Question.

## Performance (5)

- **Fewer wasted catalog lookups (4):** `routing_map.php`, `functions_lookups.php`, `init_add_crumbs.php`, `init_category_path.php`.
- **Cart limit message (1):** `lang.english.php` only adds the text for the 200-item cart cap.

These only cut wasted work from bot traffic and will not speed up normal page loads; the lookup gate actually adds one cached query per request. The bundle includes no benchmarks. The cart cap itself and the early 406 rejections are also load protections, but they sit in files counted as security.

## Functional or cleanup (10)

`order_total`, `shipping`, `SideboxFinder`, `column_left`, `column_right`, `tpl_modules_mobile_menu`, `class.search`, `init_admin_auth`, `paypal_currency_check`, `paypal_functions`.

## Problems in the bundle

1. **The `.patch` file is out of date:** it lacks the 2026-08-04 `application_top.php` fix, so applying it brings back the 406 errors on listing pages with SEO URLs. It also is not covered by `SHA256SUMS.txt`, so use the overlay or ZIP. The ZIP matches its checksum and the overlay directory.
2. **Stores behind a proxy can break after install:** the overlay does not change a live `configure.php`, so `TRUSTED_PROXIES` stays undefined. Behind a TLS-terminating proxy, `$request_type` becomes `NONSSL` and every visitor appears to have the proxy's IP. The README's "inactive unless configured" understates this.
3. **`paypaldp.php` still stores the CVV:** it moves from the page HTML to `$_SESSION`, and is only cleared in `before_process()`. If a customer abandons checkout after that point, the CVV stays in the session, which is a PCI problem wherever sessions are stored in the database. It only affects stores using this retired module.
4. **Testing was limited:** the README says the full test suite was not run and no test files are included. The bundle also includes PR #7932, which was unmerged when it was packaged.
