# Development

## Requirements

- PHP 8.0+ with PDO MySQL (production)
- MySQL 5.7+ / MariaDB 10.3+
- Node 18+ only if you use the preview server

## First run

```bash
cp .env.example .env
# set DB_USER / DB_PASS / DB_NAME
mysql -u root -p < database/the_farmer.sql
php -S 0.0.0.0:8080 -t .
```

Visit `http://localhost:8080/index.php`.

`APP_DEBUG=1` in `.env` turns on `display_errors`. Leave it `0` on any shared host.

## Node preview (no PHP)

```bash
node tools/dev-server.js
```

It implements a **subset** of our templates: `require`, `<?= ?>`, colon `if` / `foreach`, helpers, and seed-accurate stubs. Mutations are not stored. Do not treat it as production.

Tokenizer rules that matter when you edit PHP views:

- Colon control structures must be their own `<?php if (...): ?>` tag (no brace `if {` in views).
- `(string)` casts and `?:` are mapped; keep expressions simple.

## Conventions

- One public feature per root `*.php` file.
- Markup reused 4+ times → `app/includes` or `dashboard/includes`.
- Money is integer XAF via `money()`.
- Forms: `method="POST"` `action="<?= e(url('process.php')) ?>"` plus `csrf_field()`.
- Assets: `asset('CSS/main.css')` — forward slashes only.
- Output: `e($value)` in HTML. JSON in `<script>`: `tf_js($value)` (not `e()`).
- Dashboard empty tables: `empty($rows)` so the Node preview agrees with PHP.

## Adding a POST action

1. Add a `case` in `app/controllers/process.php`.
2. Call `require_login()` or `require_role()`.
3. Validate with allow-lists / casts; never interpolate SQL.
4. Redirect with a flash, or `json_response()` for fetch callers.
5. Mirror a no-op flash in `tools/dev-server.js` `handleProcess` if the preview should stay green.

## Tests you can run by hand

1. Guest → `/dashboard/user/index.php` → login page.
2. `john@thefarmer.cm` sees five orders and 12,400 XAF — not another user’s rows.
3. `jean@thefarmer.cm` sees Jean’s listings and sales, not 1,245,000 XAF demo.
4. Customer opening `/dashboard/farmer/product-new.php` is bounced.
5. Profile inputs stay `readonly` until **Update profile**.
6. Checkout as guest JSON → `{ "error": "login" }`.
