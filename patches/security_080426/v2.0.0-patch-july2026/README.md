# Zen Cart v2.0.0 backport bundle

Base: exact `v2.0.0` tag, commit `7e9875b2ec20a124b7dc703ee32311fb6cb238a5`.

This bundle contains production and distribution files only. Test-suite files are intentionally excluded. The overlay ZIP contains the same 52 paths represented by the patch.

## Included work

- PRs #7482, #7557, #7623, #7837, #7860, #7897, #7924, #7931, and #7932.
- PR #7932 is unmerged at packaging time, so its final reviewed head is pinned to `8ebf8758a8c04128d8bfccb37f42f8cd30fe7a7d`.
- Commits `25e93e7b2`, `c7cad22c3`, `33c2d0dae`, `1832c05a3`, `c073d475a`, `a356336d5`, `3ca486905`, `de6096611`, `ceb3bdcd3`, `c0ec264ce`, `39aa17831`, `aa7fdf572`, `88dfddf01`, `b1fbbdfbc`, `2d5e0f917`, `652b9e39d`, `e02bdc28e`, `47536a1e6`, `d4f1c8692`, and `c5e8b1834`.
- PR #7837 is commit `c073d475a`.
- The PayPal work includes context commits `a356336d5` and `3ca486905` before `de6096611`, followed by `aa7fdf572`.

## Deliberate omissions and adaptations

- `81916997f`/PR #7835 is excluded because it is intentionally treated as 2.2-specific.
- `96101e205` is excluded because it applies only to 2.1.0 and newer.
- PR #7714 is omitted because v2.0.0's `order_status` page is only an unconditional redirect stub and has none of the later order lookup or request handling being fixed.
- PR #7858 is omitted because its plugin-aware shipping and order-total loader subsystem does not exist in v2.0.0. The older loaders already skip missing module files.
- The later `password_reset`, MFA, and featured-categories pages do not exist in v2.0.0, so page-specific changes for those features are omitted. The applicable admin password session-rotation change is retained.
- The DisplayLogs access-control fix is applied to both bundled plugin versions, v3.0.1 and v3.0.2, rather than the source commit's later v3.0.3 path.
- The disabled-plugin sidebox handling is adapted to v2.0.0's existing `SideboxFinder` and layout-box implementation.
- Per request, the `zc_install` configure templates are not changed. Runtime and dist-configure trusted-proxy settings are included.

## Backport integration notes

- The finished v2.0.1 backport patch applied cleanly to the exact v2.0.0 tag. The overlapping tag delta was audited and required no additional adaptation.
- This bundle does not include the unrelated changes made between the v2.0.0 and v2.0.1 tags. It is the requested backport set, not a partial v2.0.1 upgrade.
- PR #7623 is combined with PR #7931's trusted-proxy handling. The Buy Now referer check runs only after configuration is loaded, so forwarded host data is considered only for a configured trusted proxy.
- PR #7482's parameter-pollution check is tightened and narrowed for the backport. Repeated or array-shaped Zen Cart scalar keys are rejected after URL-decoding, leading-space normalization, and PHP-style dot/space normalization, while repeated unknown keys remain available to plugins. Decoded control bytes are rejected in parameter names because PHP truncates names at a NUL byte. Matching is intentionally case-insensitive, which is stricter than PHP's native key handling.
- PR #7557's follow-up limits are included with PR #7482: query strings are capped at 256 bytes normally and 2048 bytes on the known checkout and payment-return pages. The raw control/non-ASCII-byte check is also included.
- The Buy Now referer check is defense-in-depth only because same-site referers can be forged. A no-action `shopping_cart&products_id=...` request remains allowed because the core Buy Now redirect can legitimately preserve that URL shape.
- PR #7932's final head keeps the narrow early checkout routing rejection and does not reject the legitimate `shopping_cart` redirect shape.
- The upload-containment implementation uses a PHP 7.1-compatible prefix check instead of adding a new `str_starts_with()` dependency.
- New upstream `@since` versions are preserved and suffixed with `(backported)`.
- No test files are included and the full test suite was not run.

## Known compatibility notes

- The upload hardening restricts destinations to the standard images, media, uploads, and admin-attachments roots. A custom plugin using another upload root must call `setPermittedDestinationBase()` for its intended root.
- `33c2d0dae` fixes the `ONLY_FULL_GROUP_BY` query problem while retaining the historical simple sum of tax rates. It does not introduce priority-based compounded tax calculation.
- The trusted-proxy feature is inactive unless `TRUSTED_PROXIES` is configured. Direct requests continue to use native HTTPS and peer-address indicators.
- Custom storefront or payment-plugin URLs longer than 256 bytes must use one of the checkout pages granted the 2048-byte allowance or adapt this limit locally. This is the principal compatibility risk inherited from PR #7482/#7557.

## Validation performed

- PHP 8.0 syntax lint on all 52 changed PHP files.
- Targeted trusted-proxy, forwarded-host, native/direct-request, forwarded-chain, routing-map, upload-containment, parameter-pollution normalization, encoded-control-key, plugin-array, and query-length smoke checks.
- `git diff --check`, dash-style, PayPal escaping, rejected-hunk, and backport-annotation checks.
- Patch applicability and exact-content checks against a fresh worktree at the exact `v2.0.0` tag.
