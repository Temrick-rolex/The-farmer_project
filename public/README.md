# `public/` — intended document root

Today The Farmer still serves from the **project root** so existing shared-hosting URLs (`/index.php`, `/product.php`) keep working.

When you can point Apache / nginx at a subfolder, move these web entry points into `public/`:

- `index.php`, `product.php`, `opportunity.php`, `regform.php`, `process.php`
- `dashboard/`
- `Assets/` (or the `assets` symlink)

Then set `BASE_URL` from `app/config/config.php` (it already computes a root-relative path from `DOCUMENT_ROOT`).

Keep `app/`, `database/` and `tools/` **outside** the document root. `app/.htaccess` already denies HTTP access if they stay web-visible.

Full product docs: [docs/README.md](../docs/README.md).
