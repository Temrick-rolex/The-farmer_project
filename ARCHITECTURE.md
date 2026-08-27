# The Farmer — Architecture & Dashboard UI/UX Blueprint

**Product:** Cameroonian farm-products e-commerce + community (partnerships, mentorship, jobs)  
**Stack target:** PHP + MySQL, Oswald + Nunito Sans, orange/green farm theme, prices in **XAF**  
**Audience:** Families and growers in Yaoundé first, then Cameroon and CEMAC  

This document is the implementation spec. The repository now follows it: reusable includes, a dedicated `/dashboard/` workspace, and three role-specific dashboards.

---

## 1. Proposed modern file structure

The old layout was six flat `.php` files plus `Assets/`. That does not scale to auth, vendors, or admin. The tree below separates **what the browser may request** from **what only PHP should include**, and leaves empty rooms for MySQL.

```text
The-farmer_project/
├── index.php                     # Public home (entry point)
├── product.php                   # Shop
├── opportunity.php               # Programs
├── regform.php                   # Register / login  → POST process.php
├── process.php                   # Form front door (method="POST" only)
├── profile.php                   # 302 → dashboard/account/profile.php
├── settings.php                  # 302 → dashboard/account/settings.php
│
├── app/                          # Not a public feature surface
│   ├── .htaccess                 # Deny direct HTTP
│   ├── config/
│   │   ├── config.php            # BASE_URL, ASSET_URL, DB_* placeholders
│   │   └── demo-data.php         # Seed rows until models talk to MySQL
│   ├── includes/
│   │   ├── init.php              # require config + helpers + demo data
│   │   ├── head.php              # <head>, fonts, asset() CSS
│   │   ├── header.php            # Public navbar (no Profile / Settings)
│   │   ├── footer.php            # Public footer + cart drawer
│   │   └── cart.php
│   ├── helpers/
│   │   └── functions.php         # e(), url(), asset(), money(), current_user()
│   ├── controllers/
│   │   └── process.php           # login, register, logout, profile, password
│   └── models/                   # Future PDO layer
│       ├── User.php
│       ├── Product.php
│       ├── Order.php
│       └── Opportunity.php
│
├── dashboard/                    # Authenticated workspace only
│   ├── index.php                 # Role-aware redirect
│   ├── includes/
│   │   ├── layout-start.php      # shell + sidebar + topbar
│   │   ├── layout-end.php
│   │   ├── sidebar.php           # Avatar, nav, Profile, Settings, Logout
│   │   └── topbar.php
│   ├── user/
│   │   ├── index.php             # Customer overview
│   │   ├── orders.php
│   │   ├── opportunities.php
│   │   └── messages.php
│   ├── farmer/
│   │   ├── index.php             # Vendor overview
│   │   ├── products.php          # Inventory
│   │   ├── product-new.php       # Add product (POST)
│   │   └── orders.php            # Fulfilment
│   ├── admin/
│   │   ├── index.php             # Platform analytics
│   │   ├── users.php
│   │   ├── products.php          # Approval queue
│   │   ├── opportunities.php     # Program moderation
│   │   └── settings.php          # System settings
│   └── account/
│       ├── profile.php           # Shared Profile (all roles)
│       └── settings.php          # Language, theme, XAF/USDT/€, change password
│
├── Assets/                       # Existing folder (keep the capital A)
│   ├── CSS/main.css              # Design system
│   ├── CSS/dashboard.css         # Sidebar workspace
│   ├── JS/main.js
│   ├── JS/dashboard.js           # Mobile sidebar
│   ├── Image/
│   └── fontawesome/
├── assets/ → Assets              # Linux-friendly lowercase alias
│
├── database/schema.sql           # users, products, orders, opportunities
├── public/                       # Future document root (see public/README.md)
├── tools/dev-server.js           # Preview without system PHP
└── ARCHITECTURE.md               # This blueprint
```

### Why this shape

| Concern | Where it lives | Rule |
|---|---|---|
| Browser URL | Root `*.php` + `/dashboard/` | One feature per file, no logic soup |
| Markup reused 4+ times | `app/includes/` and `dashboard/includes/` | `require` only — never copy-paste the nav |
| Money, user, URLs | `app/helpers/functions.php` | `money()` always formats **integer XAF** |
| POST bodies | `process.php` → `app/controllers/process.php` | `method="POST"` (never `method="$_POST"`) |
| Assets | `asset('CSS/main.css')` → `/Assets/CSS/main.css` | **Forward slashes only** |
| MySQL | `app/models/*` + `database/schema.sql` | Hash passwords; never SELECT them back |

`BASE_URL` is computed from `DOCUMENT_ROOT` so the same includes work at `/`, `/The-farmer_project/`, or a future `/public/` document root.

When the host allows it, point the vhost at `public/` and move the entry PHP + `dashboard/` + `Assets/` there. Leave `app/` and `database/` above the web root.

---

## 2. Navigation architecture reorganization

Profile and Settings are **account** screens. They do not belong next to “Products” on a public marketing site. Putting them in the storefront navbar confused guests and mixed two mental models (browse vs. manage).

### Public navbar

Applied to `index.php`, `product.php`, `opportunity.php`, `regform.php` via `app/includes/header.php`.

| Slot | Item | Notes |
|---|---|---|
| Brand | Logo + “The **Farmer**” | → `index.php` |
| Primary | Home · Products · Opportunities | Active state via `$tf_nav` |
| Actions | Theme toggle | Already in `main.js` |
| Actions | Cart icon + count | Opens the shared cart drawer |
| Actions | **Log in** + **Register** | Both go to `regform.php` |
| Actions (session) | **Dashboard** | Replaces login/register when `$_SESSION['user']` exists |

**Removed from the public bar:** Settings link, Profile user icon.

The public footer Explore column now lists Home, Products, Opportunities, Log in / Register — not “My profile”.

### Dashboard sidebar (all `/dashboard/` pages)

Applied through `dashboard/includes/sidebar.php`.

```text
┌─────────────────────────────┐
│ [logo] The Farmer           │
│                             │
│ (avatar) John Doe           │
│ Customer · Yaoundé          │
│                             │
│ WORKSPACE                   │
│  ▸ Dashboard Overview       │
│    My Orders                │
│    Saved Opportunities      │
│    Messages / Support       │
│                             │
│ USER MANAGEMENT             │
│    Profile                  │
│    Settings                 │
│      · Language             │
│      · Theme                │
│      · Currency XAF/USDT/€  │
│                             │
│  Back to shop               │
│  [ Log out ]   ← POST       │
└─────────────────────────────┘
```

Role-specific workspace links:

- **Customer** — Overview, My Orders, Saved Opportunities, Messages  
- **Farmer / vendor** — Overview, Inventory, Orders to fulfil, Add product, Messages  
- **Admin** — Overview, User management, Product approval, Opportunity moderation, Messages  

Profile and Settings stay under **User management** for every role (`dashboard/account/*.php`). That is the DRY home for identity.

Logout is a `POST` form to `process.php?action=logout` — never a GET link.

### How includes keep this DRY

Every public page is now:

```php
<?php
require_once __DIR__ . '/app/includes/init.php';
$tf_nav = 'home';                       // home | products | opportunity | auth
$tf_title = 'The Farmer — Fresh citrus from Cameroon';
require TF_APP . '/includes/head.php';
require TF_APP . '/includes/header.php';
?>
<main><!-- page-only markup --></main>
<?php require TF_APP . '/includes/footer.php'; ?>
```

Every dashboard page is:

```php
<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'customer';                  // customer | farmer | admin
$tf_page = 'overview';                  // marks the sidebar active item
$tf_heading = 'Overview';
$tf_title = 'Customer dashboard · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>
<!-- page-only markup: stats, tables, forms -->
<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
```

`layout-start.php` pulls `head.php` (with `dashboard.css`), then `sidebar.php` and `topbar.php`. Change the nav once; twelve screens update.

`url()` and `asset()` always emit **root-relative forward-slash** paths (`/Assets/CSS/main.css`), so a page at `/dashboard/farmer/index.php` does not break images the way `Assets\CSS\index.css` did on Linux.

---

## 3. Complete dashboard UI/UX design specs

Shared chrome for A, B and C:

- **Layout:** CSS Grid `268px 1fr`. Sidebar is `position: sticky; height: 100vh`. Main column has a sticky topbar + padded content.
- **Type:** Headings Oswald, UI Nunito Sans (same tokens as the storefront).
- **Colour:** Sidebar `--green-900` (`#122d1c`). Active item: orange left border + warm wash. Stat icons use `--green-100` / `--orange-100` tiles. Prices and primary CTAs stay **orange**. Status pills reuse `.badge` / `.badge.orange`.
- **Surfaces:** `--surface` cards, `--line` borders, `--shadow-sm` — identical to product cards on the shop.
- **Responsive:** At `≤900px` the sidebar becomes an off-canvas drawer (`transform: translateX(-105%)`), opened by the hamburger in the topbar, closed by the X, the scrim, Escape, or a nav tap. Stat grids collapse to one column at `≤1024px`. Tables scroll horizontally inside `.table-wrap`.
- **Motion:** Same `--ease` curve as the storefront. Honour `prefers-reduced-motion` from `main.css`.
- **Currency:** Every amount is integer **XAF** (`1,245,000 XAF`). Settings may *display* USDT or € later; settlement stays XAF.

### A. Customer dashboard — `dashboard/user/index.php`

**Goal:** “What did I buy, what programs am I in, what is in my wallet?”

**Wireframe**

```text
Welcome back, John.                         [ Shop the harvest ]
Your citrus orders, saved programs and
wallet — all from Yaoundé to your door.

┌──────────────┐ ┌──────────────┐ ┌──────────────┐
│ 🛒 Total     │ │ 🤝 Active    │ │ 👛 Wallet /  │
│    orders  8 │ │    opps    2 │ │    dividend  │
│ +2 this month│ │ 1 accepted   │ │ 12,400 XAF   │
└──────────────┘ └──────────────┘ └──────────────┘

Recent orders                                         [ View all ]
┌──────────────┬────────────┬──────────┬─────────────┐
│ Product      │ Date       │ Amount   │ Status      │
│ Mixed Citrus │ 12 Aug 2026│ 6,000 XAF│ Delivered   │
│ Valencia tree│ 28 Jul 2026│30,000 XAF│ In delivery │
└──────────────┴────────────┴──────────┴─────────────┘

┌ Update profile ─────────────┐  ┌ Settings ──────────────────┐
│ Name, phone, Yaoundé address│  │ Language, theme, XAF/USDT/€│
└─────────────────────────────┘  └────────────────────────────┘
```

**HTML/CSS structure**

- `.dash-welcome` (flex, wrap) + `.btn.btn-accent` CTA
- `.stat-grid` → three `.stat-card` (icon tile + `.k` / `.v` / `.hint`)
- `.panel` + `.dash-table` for orders (columns: Product, Date, Amount, Status)
- `.quick-grid` of `.quick-card` links to Profile and Settings

**Child pages:** `orders.php` (full history), `opportunities.php` (saved programs), `messages.php` (support inbox).

### B. Farmer / vendor dashboard — `dashboard/farmer/index.php`

**Goal:** Run a plot like a shop: sales, stock, pack the next moto to Yaoundé.

**Wireframe**

```text
Good day, grower Jean-Claude.               [ + Add new product ]
Track sales, restock citrus and fulfil
orders heading out of Simbock / Mendong.

┌ Total sales      ┐ ┌ Products listed ┐ ┌ Pending orders ┐
│ 1,245,000 XAF    │ │ 12              │ │ 5              │
│ This season      │ │ 1 sold out      │ │ 3 still to pack│
└──────────────────┘ └─────────────────┘ └────────────────┘

╔══════════════════════════════════════════════════════╗
║ List something new from the orchard                  ║
║ Trees, baskets, juice or a farm visit — priced XAF   ║
║                                      [ Add product ] ║
╚══════════════════════════════════════════════════════╝

Inventory (name, stock, price XAF, status)   |  To fulfil
 Mature Orange Tree    18   30,000   Live    |  Bella Ngwa · To pack
 Mixed Citrus Platter   9    6,000   Low     |  Aminata · Bamenda
```

**HTML/CSS structure**

- Same `.stat-grid` (sales / listed / pending)
- `.cta-strip` green gradient band — primary “Add new product” CTA
- `.split-2` (1.4fr / 1fr): inventory preview + fulfilment queue
- Full inventory at `products.php` with **Edit / Delete** in `.cell-actions`
- `product-new.php`: `<form action="<?= url('process.php') ?>" method="POST">` — name, category, **price_xaf**, stock, description
- `orders.php`: buyer, city (Yaoundé, Bafoussam, Bamenda, Douala), amount, status

Low stock and sold out use `.badge.orange`. Live rows use the green badge.

### C. Admin dashboard — `dashboard/admin/index.php`

**Goal:** See the whole collective: people, money, what may go live.

**Wireframe**

```text
The Farmer at a glance                      [ System settings ]

┌ Total users 2,847 ┐ ┌ Revenue 18.4M XAF ┐ ┌ Active opps 6 ┐
└───────────────────┘ └───────────────────┘ └───────────────┘

User management (name, role, city)   |  Product approval queue
 John Doe        Customer  Yaoundé   |  Pink Grapefruit Tree
 Jean-Claude     Farmer    Bafoussam |  Honey Tangerine — 4 kg

Opportunity program moderation
 Youth harvest crew — seasonal     Employment    Pending
 Retail partner — Douala market    Partnership   Pending
```

**HTML/CSS structure**

- Three platform `.stat-card`s (users, revenue, opportunities)
- `.split-2`: user preview + approval queue
- Full-width `.panel` for program moderation
- `users.php` — directory (ID, role, city, joined)
- `products.php` — Approve / Reject actions (POST later; demo toasts now)
- `opportunities.php` — Publish
- `settings.php` — system defaults (settlement XAF, 20,000 XAF free-delivery threshold) + link to personal Settings

### Interaction notes (all three)

- Topbar: role eyebrow, page title, theme toggle, bell → messages, avatar → profile.
- Flash messages (`.dash-flash-*`) render after `process.php` redirects.
- Destructive actions use `data-confirm` (already in `main.js`).
- Empty states should reuse `.shop-empty` language, not a blank table, when MySQL returns zero rows.

---

## 4. Code implementation & refactoring guidelines

### 4.1 Forms — `method="POST"`, never `method="$_POST"`

`$_POST` is a PHP superglobal, not an HTTP method. Browsers ignore it or treat it as GET. Every mutating form in this project now looks like this:

```html
<form action="<?= e(url('process.php')) ?>" method="POST">
    <input type="hidden" name="action" value="login">
    <!-- fields -->
    <button type="submit" class="btn btn-accent">Log in</button>
</form>
```

`process.php` switches on `$_POST['action']` (`login`, `register`, `logout`, `update_profile`, `change_password`, `add_product`, `update_settings`, `newsletter`). When MySQL lands, call `User::findByEmail()` / `password_verify()` inside those branches — do not add a second front door.

Client-side checks in `main.js` stay as progressive enhancement. After validation they call `form.submit()` so the session is created in PHP.

### 4.2 Asset paths — constant + forward slashes

Broken (Windows-only, fails on a Linux VPS):

```html
<link rel="stylesheet" href="Assets\CSS\index.css">
```

Correct — root-relative, helper-built:

```php
<link rel="stylesheet" href="<?= e(asset('CSS/main.css')) ?>">
<img src="<?= e(asset('Image/RO.png')) ?>" alt="The Farmer logo">
<script src="<?= e(asset('JS/main.js')) ?>"></script>
```

`asset()` is:

```php
function asset(string $path): string
{
    $path = str_replace('\\', '/', $path);
    return ASSET_URL . '/' . ltrim($path, '/');
}
```

`ASSET_URL` is `BASE_URL . '/Assets'` (see `app/config/config.php`). A lowercase `assets → Assets` symlink exists for hosts that normalise case.

`main.js` reads `window.TF_ASSET` (set in `head.php`) so cart thumbnails resolve from `/dashboard/...` the same way.

### 4.3 Dashboard include templates

**`dashboard/includes/sidebar.php`** (Profile & Settings isolated here):

```php
<nav class="dash-nav">
    <p class="dash-nav-label">Workspace</p>
    <!-- role-specific links -->

    <p class="dash-nav-label">User management</p>
    <a class="<?= e(tf_active('profile', $tf_page)) ?>"
       href="<?= e(url('dashboard/account/profile.php')) ?>">
        <i class="fa-solid fa-id-badge"></i> Profile
    </a>
    <a class="<?= e(tf_active('settings', $tf_page)) ?>"
       href="<?= e(url('dashboard/account/settings.php')) ?>">
        <i class="fa-solid fa-gears"></i> Settings
    </a>
</nav>

<form action="<?= e(url('process.php')) ?>" method="POST">
    <input type="hidden" name="action" value="logout">
    <button class="btn btn-danger btn-block" type="submit">Log out</button>
</form>
```

**`dashboard/includes/topbar.php`:**

```php
<header class="dash-topbar">
    <button class="icon-btn dash-burger" type="button" data-sidebar-open
            aria-label="Open menu"><i class="fa-solid fa-bars"></i></button>
    <div class="dash-topbar-title">
        <p class="eyebrow">The Farmer · <?= e(tf_role_label($tf_role)) ?></p>
        <h1><?= e($tf_heading) ?></h1>
    </div>
    <!-- theme, bell, avatar -->
</header>
```

Do not put Profile or Settings back into `app/includes/header.php`.

### 4.4 Never display a password

The old `profile.php` rendered:

```html
<input type="password" id="profilePassword" value="457780" readonly>
```

That is a credential leak (HTML, screenshots, shoulder surfing, browser inspect). It is gone.

Rules going forward:

1. Store only `password_hash($plain, PASSWORD_DEFAULT)`.
2. Verify with `password_verify($plain, $hash)`.
3. In the UI show `••••••••` and a **Change password** form (current + new + confirm) on `dashboard/account/settings.php`.
4. The change-password handler must not echo the new secret, not even in a flash message.

```html
<form action="<?= e(url('process.php')) ?>" method="POST">
    <input type="hidden" name="action" value="change_password">
    <label for="current_password">Current password</label>
    <input type="password" id="current_password" name="current_password"
           autocomplete="current-password" required>
    <label for="new_password">New password</label>
    <input type="password" id="new_password" name="new_password"
           autocomplete="new-password" minlength="8" required>
    <label for="confirm_password">Confirm new password</label>
    <input type="password" id="confirm_password" name="confirm_password"
           autocomplete="new-password" minlength="8" required>
    <button type="submit">Update password</button>
</form>
```

### 4.5 Backend (MySQL is wired)

1. Import `database/the_farmer.sql` (schema + seed).
2. Copy `.env.example` → `.env` (`DB_*`). PDO lives in `app/config/database.php`.
3. Models `User`, `Product`, `Order`, `Opportunity`, `Message`, `Setting` read the logged-in account.
4. CSRF on every POST; `password_hash` / `password_verify` on register and login.
5. `/dashboard/` is gated with `require_login()` / `require_role()`; role comes from the account.
6. Optional later: move the document root to `public/` (see `public/README.md`).

Security headers, session cookies, login throttle and the rest of the hardening notes are in [docs/SECURITY.md](docs/SECURITY.md). Product behaviour is in [docs/](docs/README.md).

---

## How to run

```bash
# Preferred — real PHP
php -S 0.0.0.0:8080 -t .

# This workspace (no system PHP) — template-compatible preview
node tools/dev-server.js
```

Open:

- Storefront: `/index.php`, `/product.php`, `/opportunity.php`, `/regform.php`
- Customer: `/dashboard/user/index.php`
- Farmer: `/dashboard/farmer/index.php`
- Admin: `/dashboard/admin/index.php`

Log in with a seeded account (see README). The workspace follows the **role stored on that account**, not a form picker.
