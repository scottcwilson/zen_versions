# Zen Cart v2.2.2 backport bundle

Base: exact `v2.2.2` tag, commit `63cf0ec3324d49767d25a07d168cdecb829e4d2a`.

This bundle contains production and distribution files only. Test-suite files are intentionally excluded. The overlay ZIP contains the same 59 paths represented by the patch.

## Included work

- PRs #7557, #7623, #7714, #7835, #7837, #7858, #7860, #7897, #7924, #7931, and #7932, plus remediation of the PR #7482 implementation already present in the tag.
- PR #7932 is unmerged at packaging time, so its final reviewed head is pinned to `8ebf8758a8c04128d8bfccb37f42f8cd30fe7a7d`.
- Commits `33c2d0dae`, `1832c05a3`, `96101e205`, `81916997f`, `c073d475a`, `a356336d5`, `3ca486905`, `de6096611`, `ceb3bdcd3`, `c0ec264ce`, `39aa17831`, `aa7fdf572`, `88dfddf01`, `b1fbbdfbc`, `2d5e0f917`, `652b9e39d`, `e02bdc28e`, `47536a1e6`, `d4f1c8692`, and `c5e8b1834`.
- `25e93e7b2` and `c7cad22c3` are already ancestors of `v2.2.2`, so they are not duplicated in the patch.
- PR #7835 is commit `81916997f`, and is intentionally treated as 2.2-specific.
- PR #7837 is commit `c073d475a`.
- The PayPal work includes context commits `a356336d5` and `3ca486905` before `de6096611`, followed by `aa7fdf572`.

## Backport integration notes

- PR #7623 is combined with PR #7931's trusted-proxy handling. The Buy Now referer check runs only after configuration is loaded, so forwarded host data is considered only for a configured trusted proxy.
- The tag already contains PR #7482. Its global “more than twice” duplicate-key detector is replaced with a protected-scalar check that rejects repeated or array-shaped Zen Cart scalar keys after URL-decoding, leading-space normalization, and PHP-style dot/space normalization, while leaving repeated unknown plugin keys available. Decoded control bytes are rejected because PHP truncates parameter names at a NUL byte. Matching is intentionally case-insensitive, which is stricter than PHP's native key handling.
- PR #7557's follow-up limits are included: query strings are capped at 256 bytes normally and 2048 bytes on the known checkout and payment-return pages. The tag's raw control/non-ASCII-byte check is retained.
- The Buy Now referer check is defense-in-depth only because same-site referers can be forged. A no-action `shopping_cart&products_id=...` request remains allowed because the core Buy Now redirect can legitimately preserve that URL shape.
- PR #7932's final head keeps the narrow early checkout routing rejection and does not aggressively reject the legitimate `shopping_cart` redirect shape.
- New upstream `@since` versions are preserved and suffixed with `(backported)`.
- No test files are included and the full test suite was not run.

## Known compatibility notes

- The upload hardening restricts destinations to the standard images, media, uploads, and admin-attachments roots. A custom plugin using another upload root must call `setPermittedDestinationBase()` for its intended root.
- `33c2d0dae` fixes the `ONLY_FULL_GROUP_BY` query problem while retaining the historical simple sum of tax rates. It does not introduce priority-based compounded tax calculation.
- The trusted-proxy feature is inactive unless `TRUSTED_PROXIES` is configured. Direct requests continue to use native HTTPS and peer-address indicators.
- Custom storefront or payment-plugin URLs longer than 256 bytes must use one of the checkout pages granted the 2048-byte allowance or adapt this limit locally. This is the principal compatibility risk inherited from PR #7482/#7557.

## Validation performed

- PHP 8.2 syntax lint on all changed PHP files.
- Targeted trusted-proxy, forwarded-host, native-HTTPS, IPv6-host, routing-map, parameter-pollution normalization, encoded-control-key, plugin-array, and query-length smoke checks.
- `git diff --check` and backport-annotation checks.
