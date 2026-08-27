# Security

This document is the threat model and the controls in the code. It is not a pentest report.

## Sessions

The live PHP app owns a real server-side session. The cookie is only an id.

| Rule | How |
| --- | --- |
| Cookie name | `tf_sid` (not `PHPSESSID`) |
| Cookie flags | `HttpOnly`, `SameSite=Lax`, `Secure` on HTTPS, host-only, path = `BASE_URL/` |
| Transport | Cookies only (`use_only_cookies`, `use_trans_sid=0`, `use_strict_mode`) |
| What is stored | `user_id` — never the password, never the full user row |
| Login | Wipe session → `session_regenerate_id(true)` → new CSRF → issue cookie |
| Logout | Empty session, expire cookie (same flags), destroy, start a blank session so a flash can show “signed out” |
| Idle | 2 hours; **Remember me** slides to 30 days |
| Absolute | 7 days; **Remember me** 30 days from login |
| Rotation | New session id every 15 minutes while signed in |
| Binding | SHA-256 of `User-Agent`; mismatch drops the session |
| Cache | Signed-in pages send `Cache-Control: private, no-store` |
| Deleted / unknown id | Auth keys dropped; guest view |
| Suspended | Full logout, then an error flash |

The Node preview cannot use PHP’s session store, so it keeps a compact `tf_session` cookie. That cookie is **HMAC-SHA256 signed** and has `exp`; unsigned or expired values are ignored. It is still a preview, not a production session store.

## AuthN / AuthZ

- Role is loaded from `users.role` only. Register allow-list: `customer`, `farmer`.
- `require_login()` on every dashboard layout. `require_role()` on farmer/admin screens **and** matching POST actions.
- Login throttle: 8 failures / 15 minutes per session.
- Passwords: `password_hash(..., PASSWORD_DEFAULT, ['cost' => 12])` and `password_verify`. Never echoed, never stored plain.
- Change-password requires the current secret and 8+ matching characters.
- Support messages always go to `tf_admin_id()` — clients cannot pick `recipient_id` (no inbox IDOR).
- Farmers only update/delete/fulfil rows they own (admin may override).

## CSRF

- 32-byte token in the session (`hash_equals`).
- Hidden field `csrf` on every HTML form (including logout).
- JSON callers send `csrf` in the body and/or `X-CSRF`.
- Failed checks redirect to a **same-host** referer (`redirect_back`) or home — not an open redirect.

## XSS

- Views escape with `e()` (`htmlspecialchars` ENT_QUOTES UTF-8).
- Boot JSON uses `tf_js()` (`JSON_HEX_TAG | HEX_AMP | HEX_APOS | HEX_QUOT`).
- Cart HTML built in JS runs through `escHtml()`.
- Product names from the catalog are treated as text, not markup.

## SQL injection

- All queries use PDO prepared statements and bound parameters.
- Multi-statements disabled when the driver supports it.
- Autoload only allows `[A-Za-z_][A-Za-z0-9_]*` class names.

## Headers (PHP + Apache)

- `Content-Security-Policy` with a per-request script nonce
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: SAMEORIGIN` (clickjacking)
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Permissions-Policy` camera/microphone/geolocation/payment off
- `X-XSS-Protection: 0` (modern browsers; CSP instead)
- `display_errors` off unless `APP_DEBUG=1`

Inline scripts in `head.php` carry `nonce="<?= e(csp_nonce()) ?>"`. External JS (`main.js`, `dashboard.js`) is `'self'` plus the same nonce.

## Paths and files

- `asset()` rejects `..` and `scheme:` paths.
- `redirect()` only follows `http(s)` URLs whose host matches `HTTP_HOST`.
- Apache: `Options -Indexes`; `/app`, `/database`, `/tools`, `.env`, `.git` forbidden.
- `app/.htaccess`, `database/.htaccess`, `tools/.htaccess` deny all.
- `.env` is gitignored.

## Input validation (high-signal)

- Emails: `FILTER_VALIDATE_EMAIL`
- Passwords: minimum 8
- Product category / payment / language / theme / currency / country / gender: allow-lists
- Cart: integer product ids, qty 1–99
- Checkout exceptions: `RuntimeException` (stock) shown; other throwables mapped to a generic error
- Admin settings: integers for fees, email filter for support mail
- Message body clipped to 2,000 characters

## What this app does not claim

- No WAF, no 2FA, no email verification, no password-reset mailer.
- Rate limit is **per session**, not per IP (shared hosting friendly).
- Node preview **does not** enforce PHP security headers or the login throttle; it is a template preview.
- Serve PHP over HTTPS in production and point the vhost at `public/` when you can (see `public/README.md`) so `app/` and `database/` sit above the document root.
