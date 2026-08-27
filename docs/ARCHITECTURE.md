# Architecture

## Request lifecycle

```text
Browser
  GET  /index.php  ──► app/includes/init.php
                       ├─ config.php   BASE_URL, session, .env
                       ├─ functions.php
                       ├─ database.php PDO
                       └─ autoload     app/models/*.php
                    ──► head.php + header.php
                    ──► page markup
                    ──► footer.php + cart + main.js

Browser
  POST /process.php ──► app/controllers/process.php
                       CSRF → action switch → model → redirect / JSON
```

Dashboard pages also `require_login()` (layout) and often `require_role([...])`.

## Directory map

```text
The-farmer_project/
├── index.php, product.php, opportunity.php, regform.php
├── process.php                  # public alias → app/controllers/process.php
├── profile.php, settings.php    # 302 into dashboard/account/
├── app/                         # not a public feature (Apache deny)
│   ├── config/                  # config.php, database.php
│   ├── helpers/functions.php
│   ├── includes/                # init, head, header, footer, cart
│   ├── controllers/process.php
│   └── models/                  # User, Product, Order, …
├── dashboard/                   # authenticated workspace
│   ├── user/  farmer/  admin/  account/
│   └── includes/                # sidebar, topbar, layout
├── Assets/                      # CSS, JS, Image, fontawesome
├── database/the_farmer.sql      # schema + seed
├── tools/dev-server.js          # Node preview without PHP
└── docs/                        # this documentation
```

`BASE_URL` is computed from `DOCUMENT_ROOT` so the same includes work at `/` or in a subfolder. `asset()` always emits **forward slashes**.

## Includes (DRY)

Public page:

```php
require_once __DIR__ . '/app/includes/init.php';
$tf_nav = 'home';
require TF_APP . '/includes/head.php';
require TF_APP . '/includes/header.php';
// markup
require TF_APP . '/includes/footer.php';
```

Dashboard page:

```php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_login(); // or require_role(['farmer','admin'])
$tf_role = 'customer';
$tf_page = 'overview';
require TF_DASHBOARD . '/includes/layout-start.php';
// markup
require TF_DASHBOARD . '/includes/layout-end.php';
```

## Models

| Class | Responsibility |
| --- | --- |
| `User` | Find, present, create, profile, password, settings, status |
| `Product` | Catalog, vendor listings, pending queue, stock |
| `Order` | Checkout transaction, customer/vendor views, sales |
| `Opportunity` | Live programs, applications |
| `Message` | Inbox, send, unread |
| `Setting` | `platform_settings` key/value |
| `Newsletter` | Unique emails |
| `Rating` | One score per user (1–5) |

SQL goes through `Database::run / fetch / fetchAll` with **bound parameters**.

## Front-end

- `Assets/CSS/main.css` — design tokens, storefront, auth, profile cards.
- `Assets/CSS/dashboard.css` — sidebar workspace.
- `Assets/JS/main.js` — theme, cart, shop filters, validation, checkout fetch.
- `Assets/JS/dashboard.js` — mobile sidebar + locked profile form.

`window.TF_*` (base, CSRF, catalog, process URL) is printed in `head.php` via `tf_js()` (JSON with HEX flags).

## Preview vs production

| | PHP (`php -S`) | Node (`tools/dev-server.js`) |
| --- | --- | --- |
| Templates | Real PHP | Subset renderer (`<?= ?>`, colon `if`/`foreach`) |
| MySQL | Required for mutations | Seed arrays, no persistence |
| Auth | Server session `tf_sid` + `$_SESSION['user_id']` | HMAC cookie `tf_session` (preview only) |
| Security headers / throttle | Yes | Not applied |

Production path is PHP + MySQL. Node exists so this workspace can be previewed without a system PHP install.
