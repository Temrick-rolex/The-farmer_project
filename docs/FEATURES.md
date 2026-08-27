# Features

## Public storefront

| URL | Page |
| --- | --- |
| `/index.php` | Home — hero, about, featured harvest, carousel, testimonials |
| `/product.php` | Shop — search, category chips, live + sold-out listings |
| `/opportunity.php` | Programs — apply (logged in) or go to register |
| `/regform.php` | Create account / log in |
| `/process.php` | **POST only** front door for every mutation |
| `/profile.php` | Redirects to `dashboard/account/profile.php` |
| `/settings.php` | Redirects to `dashboard/account/settings.php` |
| `/dashboard/index.php` | Redirects to the role home after login |

Public navbar: Home, Products, Opportunities, theme, cart, Log in / Register (or **Dashboard** when signed in). Profile and Settings are not in this bar.

## Customer dashboard (`dashboard/user/`)

- **Overview** — order count (this month), programs followed, wallet in XAF, recent orders.
- **My orders** — full history from `orders` for that `user_id`.
- **Saved opportunities** — applications / saves for that user.
- **Messages** — inbox for that `recipient_id`; writing sends to the active admin.

## Farmer dashboard (`dashboard/farmer/`)

- **Overview** — sales from this vendor’s `order_items`, listing counts, pending fulfilment.
- **Inventory** — this vendor’s products only.
- **Add product** — pending listing, admin must publish.
- **Edit product** — own listing (or any listing if admin).
- **Orders to fulfil** — orders that include this vendor’s items.

## Admin dashboard (`dashboard/admin/`)

- **Overview** — user count, revenue, live programs, approval queue.
- **Users** — directory; suspend / restore (not yourself).
- **Product approval** — live / rejected + vendor message.
- **Opportunity moderation** — publish / close.
- **System settings** — delivery threshold, fee, city, support phone/email.

## Shared account (`dashboard/account/`)

- **Profile** — fields are **read-only** until **Update profile**; then Save / Cancel.
- **Settings** — language, theme, display currency; change password (current + new + confirm).

## POST actions (`process.php`)

Every mutating form posts here with `action` and a CSRF token.

| `action` | Who | Effect |
| --- | --- | --- |
| `login` | Guest | Session from matching account role |
| `register` | Guest | Customer or farmer account, `password_hash` |
| `logout` | User | Destroy session |
| `update_profile` | User | Name, email, phone, address, city, payment |
| `change_password` | User | Verify current, hash new (8+ chars) |
| `update_settings` | User | language / theme / currency allow-lists |
| `add_product` | Farmer, admin | Pending listing |
| `update_product` | Owner or admin | Name, category, price, stock |
| `delete_product` | Owner or admin | Pending/rejected only |
| `approve_product` / `reject_product` | Admin | Status + message to vendor |
| `publish_opportunity` / `close_opportunity` | Admin | Program status |
| `apply_opportunity` | User | Application row |
| `checkout` | User | Order + stock decrement (JSON or form) |
| `fulfill_order` | Farmer (own items) or admin | packing / in_delivery / delivered |
| `toggle_user` | Admin | active ↔ suspended |
| `update_system` | Admin | Validated platform settings |
| `send_message` | User | To the active admin only |
| `rate` | User | 1–5 stars |
| `newsletter` | Guest | Unique email subscribe |

JSON clients send `Content-Type: application/json` plus `csrf` and/or header `X-CSRF`.
