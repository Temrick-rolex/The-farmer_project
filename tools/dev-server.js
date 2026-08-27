#!/usr/bin/env node
/**
 * Preview server for The Farmer.
 * Production uses PHP (`php -S 0.0.0.0:8080`). This Node runtime implements
 * enough of our template subset (require, <?= ?>, if/foreach, helpers)
 * so the workspace can be previewed without a system PHP install.
 */
'use strict';

const http = require('http');
const fs = require('fs');
const path = require('path');
const { URL } = require('url');
const querystring = require('querystring');

const ROOT = path.resolve(__dirname, '..');
const PORT = Number(process.env.PORT || 8080);
const HOST = '0.0.0.0';
const BASE_URL = '';
const ASSET_URL = '/Assets';

const SKIP_RENDER = new Set([
  path.join(ROOT, 'app/includes/init.php'),
  path.join(ROOT, 'app/config/config.php'),
  path.join(ROOT, 'app/helpers/functions.php'),
  path.join(ROOT, 'app/config/demo-data.php'),
  path.join(ROOT, 'app/controllers/process.php'),
  path.join(ROOT, 'app/config/database.php'),
]);

const DEMO_USER = {
  uid: 1,
  id: '01XJ00F',
  name: 'John Doe',
  first_name: 'John',
  email: 'john@thefarmer.cm',
  phone: '+237 605 048 910',
  address: 'Yaoundé, Simbock — Mendong',
  city: 'Yaoundé',
  country: 'Cameroon',
  role: 'customer',
  gender: 'Male',
  payment: 'Mobile money',
  member_since: '2024',
  avatar: 'Image/profile.jpg',
  wallet: 12400,
  language: 'english',
  theme: 'light',
  currency: 'xaf',
  status: 'active',
};

const DEMO = {
  TF_ORDERS: [
    { id: 'TF-1042', item: 'Mixed Citrus Platter — 6 kg', date: '12 Aug 2026', amount: 6000, status: 'delivered', tone: 'ok' },
    { id: 'TF-1017', item: 'Mature Orange Tree (Valencia)', date: '28 Jul 2026', amount: 30000, status: 'in_delivery', tone: 'warn' },
    { id: 'TF-1004', item: 'Fresh Orange Juice — 1 L × 4', date: '11 Jul 2026', amount: 7200, status: 'delivered', tone: 'ok' },
    { id: 'TF-0988', item: 'Orchard Box — 1 month', date: '02 Jul 2026', amount: 12000, status: 'delivered', tone: 'ok' },
    { id: 'TF-0961', item: 'Farm Visit & Self-Harvest × 2', date: '18 Jun 2026', amount: 30000, status: 'completed', tone: 'ok' },
  ],
  TF_FARMER_ORDERS: [
    { id: 6, public_id: 'TF-1048', buyer: 'Bella Ngwa', item: 'Fresh Oranges — 5 kg × 2', amount: 7000, status: 'packing', city: 'Yaoundé', tone: 'warn' },
    { id: 7, public_id: 'TF-1046', buyer: 'Jean-Claude Mbarga', item: 'Mature Tangerine Tree', amount: 25000, status: 'in_delivery', city: 'Bafoussam', tone: 'warn' },
    { id: 8, public_id: 'TF-1043', buyer: 'Aminata Salla', item: 'Mixed Citrus Platter', amount: 6000, status: 'packing', city: 'Bamenda', tone: 'warn' },
    { id: 9, public_id: 'TF-1039', buyer: 'Patrick Etoundi', item: 'Farm Visit × 3', amount: 45000, status: 'paid', city: 'Douala', tone: 'warn' },
  ],
};

const LIVE_PRODUCTS = [
  { id: 1, vendor_id: 3, sku: 'p1', name: 'Mature Orange Tree (Valencia)', category: 'trees', description: '4–5 year old tree, already bearing fruit. Potted, delivered and ready to plant in your yard.', price_xaf: 30000, stock: 18, status: 'live', image_path: 'Image/product-images/88423a61-a94d-4d96-ba54-62aa4372992c_1500x1875.jpeg', badge: 'Bestseller', rating_avg: 5.0, is_featured: 1 },
  { id: 2, vendor_id: 3, sku: 'p2', name: 'Mature Tangerine Tree', category: 'trees', description: 'Dense, reliable tangerine canopy. Plant it once, harvest it every winter for years.', price_xaf: 25000, stock: 11, status: 'live', image_path: 'Image/product-images/Tangerine-SpotlessFruitsIndia_1024x1024.png', badge: '', rating_avg: 4.5, is_featured: 0 },
  { id: 3, vendor_id: 3, sku: 'p3', name: 'Fresh Oranges — 5 kg basket', category: 'fresh', description: 'Hand-picked Valencia oranges, sweet and juicy. Delivered within 48 hours in Yaoundé.', price_xaf: 3500, stock: 42, status: 'live', image_path: 'Image/product-images/Orange-Fruit-Pieces.jpg', badge: '', rating_avg: 4.8, is_featured: 1 },
  { id: 4, vendor_id: 5, sku: 'p4', name: 'Fresh Lemons — 3 kg', category: 'fresh', description: 'Bright, zesty lemons picked in the morning for maximum juice and aroma.', price_xaf: 2800, stock: 30, status: 'live', image_path: 'Image/product-images/27554428-lemon-fruits-with-leaves-isolated-on-white.jpg', badge: '', rating_avg: 4.5, is_featured: 0 },
  { id: 5, vendor_id: 5, sku: 'p5', name: 'Fresh Limes — 3 kg', category: 'fresh', description: 'Fragrant green limes, perfect for juice, tea, marinades and cooking.', price_xaf: 2500, stock: 22, status: 'live', image_path: 'Image/product-images/Lime-copy-scaled-1.jpg', badge: '', rating_avg: 4.3, is_featured: 0 },
  { id: 6, vendor_id: 3, sku: 'p6', name: 'Mixed Citrus Platter — 6 kg', category: 'fresh', description: 'Our bestsellers on one platter: oranges, tangerines, lemons, limes and grapefruit.', price_xaf: 6000, stock: 9, status: 'live', image_path: 'Image/product-images/images-7.jpeg', badge: 'New', rating_avg: 4.9, is_featured: 1 },
  { id: 7, vendor_id: 3, sku: 'p7', name: 'Fresh Orange Juice — 1 L', category: 'juice', description: 'Cold-pressed the same morning. No sugar, no water, no preservatives.', price_xaf: 1800, stock: 0, status: 'sold_out', image_path: 'Image/product-images/94253411-orange-juice-in-a-glass-bottle-and-orange-fruit-with-green-leaves-isolated-on-white-background.jpg', badge: '', rating_avg: 4.6, is_featured: 1 },
  { id: 8, vendor_id: 5, sku: 'p8', name: 'Fresh Lemon Juice — 1 L', category: 'juice', description: 'Sun-bright lemon juice, pressed to order in our farm kitchen.', price_xaf: 1800, stock: 16, status: 'live', image_path: 'Image/product-images/bottle-lemon-juice-fresh-lemons-25336807.jpg', badge: '', rating_avg: 4.4, is_featured: 0 },
  { id: 9, vendor_id: 5, sku: 'p9', name: 'Sparkling Grapefruit — 750 ml', category: 'juice', description: 'Our cellar\'s pink sparkling grapefruit — dry, fizzy and festive.', price_xaf: 8500, stock: 14, status: 'live', image_path: 'Image/product-images/cd2304634ba009da07e0e2f77650cedc0cf695de213a16fd6171548fed4629d4.jpg', badge: '', rating_avg: 4.2, is_featured: 0 },
  { id: 10, vendor_id: 3, sku: 'p10', name: 'Natural Orange Wine — 750 ml', category: 'juice', description: 'Vegan orange wine from our own harvest. No added sugars, yeasts or sulphites.', price_xaf: 9000, stock: 10, status: 'live', image_path: 'Image/product-images/images2.jpeg', badge: '', rating_avg: 4.7, is_featured: 0 },
  { id: 11, vendor_id: 3, sku: 'p11', name: 'Farm Visit & Self-Harvest', category: 'experience', description: 'Spend a day with our growers, pick your own fruit basket and take the harvest home.', price_xaf: 15000, stock: 30, status: 'live', image_path: 'Image/farm6.jpg', badge: 'Popular', rating_avg: 5.0, is_featured: 1 },
  { id: 12, vendor_id: 5, sku: 'p12', name: 'Orchard Box — 1 month', category: 'experience', description: 'A weekly box of seasonal citrus, fresh juice and farm news delivered to your door.', price_xaf: 12000, stock: 20, status: 'live', image_path: 'Image/farm5.jpg', badge: '', rating_avg: 4.6, is_featured: 0 },
  { id: 13, vendor_id: 3, sku: 'p13', name: 'Pink Grapefruit Tree', category: 'trees', description: 'Young pink grapefruit, grafted on hardy rootstock.', price_xaf: 28000, stock: 6, status: 'pending', image_path: 'Image/product-images/Tangerine-SpotlessFruitsIndia_1024x1024.png', badge: '', rating_avg: 0, is_featured: 0, vendor_name: 'Jean-Claude Mbarga', created_at: '2026-08-24 11:00:00' },
  { id: 14, vendor_id: 5, sku: 'p14', name: 'Honey Tangerine — 4 kg', category: 'fresh', description: 'Sweet honey tangerines from the Douala peri-urban plots.', price_xaf: 3200, stock: 24, status: 'pending', image_path: 'Image/product-images/images-7.jpeg', badge: '', rating_avg: 0, is_featured: 0, vendor_name: 'Patrick Etoundi', created_at: '2026-08-23 16:20:00' },
  { id: 15, vendor_id: 7, sku: 'p15', name: 'Cold-pressed Lime Juice', category: 'juice', description: 'Pressed in Mbalmayo the same morning.', price_xaf: 2000, stock: 40, status: 'pending', image_path: 'Image/product-images/Lime-copy-scaled-1.jpg', badge: '', rating_avg: 0, is_featured: 0, vendor_name: 'Mballa Farms', created_at: '2026-08-22 09:45:00' },
];

const LIVE_OPPS = [
  { id: 1, title: 'Partnership Program', type: 'partnership', body: 'Become an official The Farmer partner: sell on our shelves, buy our trees at partner prices and co-market the harvest across Cameroon and Central Africa.', icon: 'fa-handshake', cta_label: 'Apply as partner', status: 'live', creator_name: 'Ngono Kesseng' },
  { id: 2, title: 'Mentorship Program', type: 'mentorship', body: 'Learn from our best tutors — soil preparation, irrigation, citrus care and how to turn a plot of land into a real, profitable business.', icon: 'fa-hands-holding-child', cta_label: 'Find a mentor', status: 'live', creator_name: 'Ngono Kesseng' },
  { id: 3, title: 'Get Employed', type: 'employment', body: 'Well-paid seasonal and permanent roles on our farm and with our partner companies — from nursery care and orchard work to delivery driving.', icon: 'fa-briefcase', cta_label: 'See open roles', status: 'live', creator_name: 'Ngono Kesseng' },
  { id: 4, title: 'The Farmer News', type: 'news', body: 'Daily updates straight from the field: harvest news, weather, market prices and new opportunities as they happen.', icon: 'fa-newspaper', cta_label: 'Read the latest', status: 'live', creator_name: 'Ngono Kesseng' },
  { id: 5, title: 'Gift & Giveaway', type: 'giveaway', body: 'Join our G&GA program: monthly giveaways of free trees, fruit baskets and harvest tours for the community.', icon: 'fa-gift', cta_label: 'Join the next draw', status: 'live', creator_name: 'Ngono Kesseng' },
  { id: 6, title: 'Big Sales Show', type: 'sale', body: 'Our BSS events: the whole harvest at the best prices of the season — 48 hours only, once a quarter, in Yaoundé.', icon: 'fa-bolt', cta_label: 'Get the date', status: 'live', creator_name: 'Ngono Kesseng' },
  { id: 7, title: 'Youth harvest crew — seasonal', type: 'employment', body: 'Six-week paid harvest crew for growers aged 18–30 around Simbock and Mbalmayo.', icon: 'fa-briefcase', cta_label: 'Apply', status: 'pending', creator_name: 'Ngono Kesseng' },
  { id: 8, title: 'Retail partner — Douala market', type: 'partnership', body: 'Kotto Fresh Ltd. wants a standing weekly citrus supply into Douala central market.', icon: 'fa-handshake', cta_label: 'Review', status: 'pending', creator_name: 'Patrick Etoundi' },
  { id: 9, title: 'Soil clinic — Bafoussam', type: 'mentorship', body: 'Jean-Claude Mbarga hosts a free soil clinic for new citrus growers in Bafoussam.', icon: 'fa-hands-holding-child', cta_label: 'Join', status: 'live', creator_name: 'Jean-Claude Mbarga' },
];

const DEMO_USERS = [
  { id: 1, public_id: '01XJ00F', name: 'John Doe', email: 'john@thefarmer.cm', role: 'customer', city: 'Yaoundé', created_at: '2024-02-11', status: 'active' },
  { id: 2, public_id: '02BN14K', name: 'Bella Ngwa', email: 'bella@thefarmer.cm', role: 'customer', city: 'Yaoundé', created_at: '2025-01-18', status: 'active' },
  { id: 3, public_id: '03JM22P', name: 'Jean-Claude Mbarga', email: 'jean@thefarmer.cm', role: 'farmer', city: 'Bafoussam', created_at: '2024-05-02', status: 'active' },
  { id: 4, public_id: '04AS09M', name: 'Aminata Salla', email: 'aminata@thefarmer.cm', role: 'customer', city: 'Bamenda', created_at: '2025-03-09', status: 'active' },
  { id: 5, public_id: '05PE31D', name: 'Patrick Etoundi', email: 'patrick@thefarmer.cm', role: 'farmer', city: 'Douala', created_at: '2023-11-20', status: 'active' },
  { id: 6, public_id: '06NK18T', name: 'Ngono Kesseng', email: 'ngono@thefarmer.cm', role: 'admin', city: 'Yaoundé', created_at: '2023-08-01', status: 'active' },
  { id: 7, public_id: '07MF44R', name: 'Mballa Farms', email: 'mballa@thefarmer.cm', role: 'farmer', city: 'Mbalmayo', created_at: '2025-06-01', status: 'active' },
];

function asset(p) {
  return ASSET_URL + '/' + String(p).replace(/\\/g, '/').replace(/^\/+/, '');
}

const Product = {
  allLive: () => LIVE_PRODUCTS.filter((p) => p.status === 'live' || p.status === 'sold_out'),
  featured: (n) => LIVE_PRODUCTS.filter((p) => p.is_featured && p.status === 'live').slice(0, n || 4),
  find: (id) => LIVE_PRODUCTS.find((p) => p.id === Number(id)) || null,
  forVendor: (id) => {
    const list = LIVE_PRODUCTS.filter((p) => p.vendor_id === Number(id));
    return list.length ? list : LIVE_PRODUCTS.filter((p) => p.vendor_id === 3);
  },
  pendingApproval: () => LIVE_PRODUCTS.filter((p) => p.status === 'pending'),
  catalogForJs: () => {
    const out = {};
    Product.allLive().forEach((p) => {
      out[String(p.id)] = { name: p.name, price: p.price_xaf, img: asset(p.image_path), stock: p.stock, sku: p.sku };
    });
    return out;
  },
  countForVendor: (id) => Product.forVendor(id).length,
};

const Order = {
  forCustomer: () => DEMO.TF_ORDERS,
  forVendor: () => DEMO.TF_FARMER_ORDERS,
  countForUser: () => DEMO.TF_ORDERS.length,
  pendingCountForVendor: () => DEMO.TF_FARMER_ORDERS.length,
  salesForVendor: () => 1245000,
  count: () => 9,
  revenue: () => 169200,
};

const User = {
  all: () => DEMO_USERS,
  count: () => DEMO_USERS.length,
  find: (id) => DEMO_USERS.find((u) => u.id === Number(id)) || null,
};

const Opportunity = {
  allLive: () => LIVE_OPPS.filter((o) => o.status === 'live'),
  all: () => LIVE_OPPS,
  find: (id) => LIVE_OPPS.find((o) => o.id === Number(id)) || null,
  savedBy: () => [
    { title: 'Partnership Program', icon: 'fa-handshake', application_status: 'pending', applied_at: '2026-08-04' },
    { title: 'Mentorship Program', icon: 'fa-hands-holding-child', application_status: 'accepted', applied_at: '2026-05-12' },
  ],
  countLive: () => LIVE_OPPS.filter((o) => o.status === 'live').length,
  countPending: () => LIVE_OPPS.filter((o) => o.status === 'pending').length,
  countForUser: () => 2,
};

const Message = {
  inbox: () => [
    { sender_name: 'The Farmer Support', subject: 'Delivery today', body: 'Your Valencia tree is out for delivery in Yaoundé today.', created_at: '2026-08-26', is_read: 0 },
    { sender_name: 'Jean-Claude Mbarga', subject: 'Mentorship visit', body: 'Shall we visit the Simbock plot on Saturday morning?', created_at: '2026-08-25', is_read: 0 },
    { sender_name: 'Harvest desk', subject: 'Orchard Box', body: 'Your Orchard Box for August has been packed.', created_at: '2026-08-11', is_read: 1 },
  ],
  unreadCount: () => 2,
  markRead: () => null,
};

const Setting = {
  get: (key, def) => ({
    free_delivery_threshold: '20000',
    delivery_fee: '1000',
    free_delivery_city: 'Yaoundé',
    support_phone: '+237 605 048 910',
    support_email: 'temrick4@gmail.com',
  }[key] || def || ''),
};

class Redirect extends Error {
  constructor(location) {
    super('REDIRECT');
    this.location = location;
  }
}

function e(value) {
  return String(value ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function url(p = '') {
  p = String(p).replace(/\\/g, '/');
  if (!p || p === '/') return BASE_URL + '/index.php';
  if (/^https?:\/\//.test(p)) return p;
  return BASE_URL + '/' + p.replace(/^\/+/, '');
}

function money(n, cur) {
  return Number(n).toLocaleString('en-US') + ' ' + (cur || 'XAF');
}

function tf_active(page, current) {
  return page === current ? 'active' : '';
}

function tf_role_label(role) {
  const map = { customer: 'Customer', farmer: 'Farmer / Vendor', admin: 'Administrator' };
  return map[role] || (role ? String(role) : 'Customer');
}

function tf_role_home(role) {
  if (role === 'farmer') return url('dashboard/farmer/index.php');
  if (role === 'admin') return url('dashboard/admin/index.php');
  return url('dashboard/user/index.php');
}

function phpDirname(p, levels) {
  let out = String(p).replace(/\\/g, '/');
  const n = levels == null ? 1 : Number(levels);
  for (let i = 0; i < n; i++) out = path.posix.dirname(out);
  return out;
}

function isEmpty(v) {
  return v == null || v === false || v === '' || v === 0 || (Array.isArray(v) && v.length === 0);
}

function csrf_token() { return 'preview'; }
function csrf_field() { return '<input type="hidden" name="csrf" value="preview">'; }
function product_category_label(cat) {
  return ({ trees: 'Trees', fresh: 'Fresh fruit', juice: 'Juice & cellar', experience: 'Experiences' }[cat] || cat);
}
function stars_html(avg) {
  avg = Number(avg) || 0;
  let html = '<span class="stars">';
  for (let i = 1; i <= 5; i++) {
    if (avg >= i) html += '<i class="fa-solid fa-star"></i>';
    else if (avg >= i - 0.5) html += '<i class="fa-solid fa-star-half-stroke"></i>';
    else html += '<i class="fa-regular fa-star off"></i>';
  }
  return html + '</span>';
}
function tf_status_label(status) {
  return String(status || '').replace(/_/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
}
function tf_status_ok(status) {
  return ['live', 'delivered', 'completed', 'accepted', 'active', 'paid'].includes(String(status));
}
function in_array(needle, hay) { return (hay || []).indexOf(needle) !== -1; }
function ucfirst(s) { s = String(s || ''); return s ? s.charAt(0).toUpperCase() + s.slice(1) : ''; }
function count(a) { return Array.isArray(a) ? a.length : (a && typeof a === 'object' ? Object.keys(a).length : 0); }
function phpStrtotime(s) {
  const d = new Date(String(s || '').replace(' ', 'T'));
  const t = d.getTime();
  return Number.isNaN(t) ? 0 : Math.floor(t / 1000);
}
function phpDate(fmt, ts) {
  const d = new Date(ts == null ? Date.now() : Number(ts) * 1000);
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  return String(fmt)
    .replace(/Y/g, String(d.getFullYear()))
    .replace(/M/g, months[d.getMonth()])
    .replace(/j/g, String(d.getDate()));
}
function number_format(n, dec, dp, ts) {
  const num = Number(n) || 0;
  const parts = num.toFixed(dec || 0).split('.');
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ts || ',');
  return parts.join(dp || '.');
}
function setting(key, def) { return Setting.get(key, def); }
function defined(name) { return name === 'TF_DB_OK' || name === 'TF_BOOTSTRAPPED'; }
function class_exists() { return true; }

function parseCookies(header) {
  const out = {};
  String(header || '').split(';').forEach((part) => {
    const i = part.indexOf('=');
    if (i > -1) out[part.slice(0, i).trim()] = decodeURIComponent(part.slice(i + 1).trim());
  });
  return out;
}

function readSession(req) {
  const raw = parseCookies(req.headers.cookie).tf_session;
  if (!raw) return {};
  try { return JSON.parse(raw); } catch (err) { return {}; }
}

function sessionCookie(sess) {
  return 'tf_session=' + encodeURIComponent(JSON.stringify(sess)) + '; Path=/; HttpOnly; SameSite=Lax';
}

function makeCtx(req, extra) {
  const session = readSession(req);
  const user = session.user || null;
  const ctx = Object.assign({
    BASE_URL,
    ASSET_URL,
    TF_ROOT: ROOT,
    TF_APP: path.join(ROOT, 'app'),
    TF_DASHBOARD: path.join(ROOT, 'dashboard'),
    TF_EMAIL: 'temrick4@gmail.com',
    TF_PHONE: '+237 605 048 910',
    TF_ADDRESS: 'Simbock / Mendong, Yaoundé — Cameroon',
    TF_DB_OK: true,
    TF_DEMO_USER: Object.assign({}, DEMO_USER),
    _GET: extra && extra._GET ? extra._GET : {},
    tf_nav: '',
    tf_title: 'The Farmer',
    tf_description: 'The Farmer grows healthy citrus in Cameroon.',
    tf_body_class: '',
    tf_dashboard: false,
    tf_page: 'overview',
    tf_heading: 'Dashboard',
    tf_role: (user && user.role) || 'customer',
    tf_flash: session.flash || null,
    _session: session,
  }, DEMO, extra || {});

  ctx.current_user = function () { return user || DEMO_USER; };
  ctx.is_logged_in = function () { return !!(session.user); };
  ctx.flash_get = function () {
    const f = ctx.tf_flash;
    ctx.tf_flash = null;
    if (session.flash) delete session.flash;
    return f;
  };
  ctx.user = ctx.current_user();
  return ctx;
}

function phpExprToJs(expr) {
  let s = String(expr).trim();
  s = s.replace(/__DIR__/g, 'ctx.__DIR__');
  s = s.replace(/__FILE__/g, 'ctx.__FILE__');
  s = s.replace(/\bTF_APP\b/g, 'ctx.TF_APP');
  s = s.replace(/\bTF_DASHBOARD\b/g, 'ctx.TF_DASHBOARD');
  s = s.replace(/\bTF_EMAIL\b/g, 'ctx.TF_EMAIL');
  s = s.replace(/\bTF_PHONE\b/g, 'ctx.TF_PHONE');
  s = s.replace(/\bTF_ADDRESS\b/g, 'ctx.TF_ADDRESS');
  s = s.replace(/\bTF_DB_OK\b/g, 'ctx.TF_DB_OK');
  s = s.replace(/\bASSET_URL\b/g, 'ctx.ASSET_URL');
  s = s.replace(/\bBASE_URL\b/g, 'ctx.BASE_URL');
  s = s.replace(/::/g, '.');
  s = s.replace(/\$([a-zA-Z_][a-zA-Z0-9_]*)/g, 'ctx.$1');
  s = s.replace(/\s+\.\s+/g, ' + ');
  s = s.replace(/\bdirname\s*\(/g, 'phpDirname(');
  s = s.replace(/!empty\s*\(/g, '!isEmpty(');
  s = s.replace(/\bempty\s*\(/g, 'isEmpty(');
  s = s.replace(/\bisset\s*\(/g, '(function(v){return v!==undefined && v!==null;})(');
  s = s.replace(/\(\s*int\s*\)\s*/g, '');
  s = s.replace(/\(\s*float\s*\)\s*/g, '');
  s = s.replace(/\(\s*string\s*\)\s*/g, '');
  s = s.replace(/\?:/g, '||');
  s = s.replace(/\?\?/g, '||');
  s = s.replace(/\btrue\b/g, 'true');
  s = s.replace(/\bfalse\b/g, 'false');
  s = s.replace(/\bnull\b/g, 'null');
  return s;
}

function evalExpr(expr, ctx) {
  const js = phpExprToJs(expr);
  const fn = new Function(
    'ctx', 'e', 'url', 'asset', 'money', 'tf_active', 'tf_role_label', 'tf_role_home',
    'phpDirname', 'isEmpty', 'array_slice', 'json_encode', 'strtoupper', 'substr', 'trim',
    'current_user', 'is_logged_in', 'flash_get', 'Number',
    'csrf_token', 'csrf_field', 'stars_html', 'product_category_label', 'tf_status_label', 'tf_status_ok',
    'in_array', 'ucfirst', 'count', 'date', 'strtotime', 'number_format', 'setting', 'defined', 'class_exists',
    'Product', 'Order', 'User', 'Opportunity', 'Message', 'Setting',
    '"use strict"; return (' + js + ');'
  );
  return fn(
    ctx, e, url, asset, money, tf_active, tf_role_label, tf_role_home,
    phpDirname, isEmpty,
    (arr, off, len) => (arr || []).slice(off, len == null ? undefined : off + len),
    (v) => JSON.stringify(v),
    (s) => String(s).toUpperCase(),
    (s, a, b) => String(s).substr(a, b == null ? undefined : b),
    (s) => String(s).trim(),
    ctx.current_user, ctx.is_logged_in, ctx.flash_get, Number,
    csrf_token, csrf_field, stars_html, product_category_label, tf_status_label, tf_status_ok,
    in_array, ucfirst, count, phpDate, phpStrtotime, number_format, setting, defined, class_exists,
    Product, Order, User, Opportunity, Message, Setting
  );
}

function stripPhpComments(code) {
  return code
    .replace(/\/\*[\s\S]*?\*\//g, '')
    .replace(/#[^\n]*/g, '')
    .replace(/\/\/[^\n]*/g, '');
}

function tokenize(src) {
  const tokens = [];
  const re = /<\?(?:php|=)?[\s\S]*?(?:\?>|$)/g;
  let last = 0;
  let m;
  while ((m = re.exec(src))) {
    if (m.index > last) tokens.push({ type: 'html', value: src.slice(last, m.index) });
    const raw = m[0];
    const isEcho = raw.startsWith('<?=');
    const inner = raw.replace(/^<\?(?:php|=)?/, '').replace(/\?>$/, '');
    tokens.push({ type: isEcho ? 'echo' : 'php', value: inner });
    last = m.index + raw.length;
  }
  if (last < src.length) tokens.push({ type: 'html', value: src.slice(last) });
  return tokens;
}

function splitStatements(code) {
  const clean = stripPhpComments(code).trim();
  if (!clean) return [];
  return clean.split(';').map((s) => s.trim()).filter(Boolean);
}

function findCloser(tokens, start, openRe, closeWord) {
  let depth = 0;
  for (let i = start; i < tokens.length; i++) {
    const t = tokens[i];
    if (t.type !== 'php') continue;
    const c = stripPhpComments(t.value).trim().replace(/;+$/, '');
    if (openRe.test(c)) depth++;
    if (c === closeWord || c === closeWord + ':') {
      depth--;
      if (depth === 0) return i;
    }
  }
  return -1;
}

function splitIfBranches(tokens) {
  const branches = [];
  let current = { cond: null, tokens: [] };
  const first = stripPhpComments(tokens[0].value).trim();
  const ifMatch = first.match(/^if\s*\(([\s\S]*)\)\s*:$/);
  current.cond = ifMatch ? ifMatch[1] : 'false';
  for (let i = 1; i < tokens.length; i++) {
    const t = tokens[i];
    if (t.type === 'php') {
      const c = stripPhpComments(t.value).trim().replace(/;+$/, '');
      if (/^elseif\s*\(/.test(c) && c.endsWith(':')) {
        branches.push(current);
        const em = c.match(/^elseif\s*\(([\s\S]*)\)\s*:$/);
        current = { cond: em ? em[1] : 'false', tokens: [] };
        continue;
      }
      if (c === 'else:' || c === 'else') {
        branches.push(current);
        current = { cond: 'true', tokens: [] };
        continue;
      }
      if (c === 'endif' || c === 'endif:') continue;
    }
    current.tokens.push(t);
  }
  branches.push(current);
  return branches;
}

function renderTokens(tokens, ctx) {
  let out = '';
  for (let i = 0; i < tokens.length; i++) {
    const t = tokens[i];
    if (t.type === 'html') {
      out += t.value;
      continue;
    }
    if (t.type === 'echo') {
      const val = evalExpr(t.value, ctx);
      out += val == null ? '' : String(val);
      continue;
    }
    const raw = stripPhpComments(t.value).trim();
    if (!raw) continue;

    if (/^if\s*\(/.test(raw) && raw.endsWith(':')) {
      const end = findCloser(tokens, i, /^if\s*\(/, 'endif');
      if (end < 0) throw new Error('Unclosed if');
      const block = tokens.slice(i, end + 1);
      const branches = splitIfBranches(block);
      for (const b of branches) {
        let ok = false;
        try { ok = !!evalExpr(b.cond, ctx); } catch (err) { ok = false; }
        if (ok) {
          out += renderTokens(b.tokens, ctx);
          break;
        }
      }
      i = end;
      continue;
    }

    if (/^foreach\s*\(/.test(raw) && raw.endsWith(':')) {
      const end = findCloser(tokens, i, /^foreach\s*\(/, 'endforeach');
      if (end < 0) throw new Error('Unclosed foreach');
      const m = raw.match(/^foreach\s*\(([\s\S]+)\s+as\s+\$([a-zA-Z_][a-zA-Z0-9_]*)\)\s*:$/);
      const list = m ? evalExpr(m[1], ctx) : [];
      const alias = m ? m[2] : 'item';
      const inner = tokens.slice(i + 1, end);
      (list || []).forEach((item) => {
        ctx[alias] = item;
        out += renderTokens(inner, ctx);
      });
      i = end;
      continue;
    }

    splitStatements(t.value).forEach((stmt) => {
      if (stmt === 'endif' || stmt === 'endforeach' || stmt === 'else' || stmt.startsWith('elseif')) return;
      if (stmt.startsWith('return')) return;
      if (/^require(?:_once)?\s+/.test(stmt)) {
        const expr = stmt.replace(/^require(?:_once)?\s+/, '');
        const resolved = evalExpr(expr, ctx);
        out += renderFile(String(resolved), ctx);
        return;
      }
      if (/^redirect\s*\(/.test(stmt)) {
        const inner = stmt.slice(stmt.indexOf('(') + 1, stmt.lastIndexOf(')'));
        throw new Redirect(url(evalExpr(inner, ctx)));
      }
      const assign = stmt.match(/^\$([a-zA-Z_][a-zA-Z0-9_]*)\s*=\s*([\s\S]+)$/);
      if (assign) {
        ctx[assign[1]] = evalExpr(assign[2], ctx);
      }
    });
  }
  return out;
}

function renderFile(filePath, ctx) {
  const abs = path.resolve(String(filePath));
  if (SKIP_RENDER.has(abs)) return '';
  if (!abs.startsWith(ROOT)) throw new Error('Path outside root: ' + abs);
  const src = fs.readFileSync(abs, 'utf8');
  const prevDir = ctx.__DIR__;
  const prevFile = ctx.__FILE__;
  ctx.__DIR__ = path.dirname(abs);
  ctx.__FILE__ = abs;
  const html = renderTokens(tokenize(src), ctx);
  ctx.__DIR__ = prevDir;
  ctx.__FILE__ = prevFile;
  return html;
}

function previewUserFromLogin(loginRaw) {
  const login = String(loginRaw || '').trim().toLowerCase();
  const hit = DEMO_USERS.find((u) => u.email === login || u.name.toLowerCase() === login || u.public_id.toLowerCase() === login);
  if (hit) {
    const first = hit.name.split(/\s+/)[0];
    return Object.assign({}, DEMO_USER, {
      uid: hit.id,
      id: hit.public_id,
      name: hit.name,
      first_name: first,
      email: hit.email,
      role: hit.role,
      city: hit.city,
    });
  }
  const name = String(loginRaw || '').trim() || 'John Doe';
  return Object.assign({}, DEMO_USER, {
    name,
    first_name: name.split(/\s+/)[0],
    email: name.includes('@') ? name : DEMO_USER.email,
  });
}

function handleProcess(req, res, fields, session) {
  const action = fields.action || '';
  const setUser = (user) => {
    session.user = user;
    session.flash = { type: 'success', message: 'Welcome to The Farmer, ' + user.first_name + '.' };
  };

  if (action === 'login') {
    const user = previewUserFromLogin(fields.logname);
    setUser(user);
    res.writeHead(302, { Location: tf_role_home(user.role), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'register') {
    const name = String(fields.Uname || '').trim() || 'John Doe';
    let role = fields.account_type || 'customer';
    if (!['customer', 'farmer'].includes(role)) role = 'customer';
    const first = name.split(/\s+/)[0];
    setUser(Object.assign({}, DEMO_USER, {
      name,
      first_name: first,
      email: fields.email || 'john@thefarmer.cm',
      phone: ((fields.countrycode || '') + ' ' + (fields.telnum || '')).trim(),
      address: fields.adress || DEMO_USER.address,
      role,
      gender: fields.gender || 'Male',
      payment: fields.paymentmode || 'Mobile money',
    }));
    res.writeHead(302, { Location: tf_role_home(role), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'logout') {
    res.writeHead(302, { Location: url('index.php'), 'Set-Cookie': 'tf_session=; Path=/; Max-Age=0' });
    res.end();
    return;
  }

  if (action === 'update_profile' && session.user) {
    session.user.name = fields.name || session.user.name;
    session.user.first_name = String(session.user.name).split(/\s+/)[0];
    session.user.email = fields.email || session.user.email;
    session.user.phone = fields.phone || session.user.phone;
    session.user.address = fields.address || session.user.address;
    session.user.city = fields.city || session.user.city;
    session.user.payment = fields.payment || session.user.payment;
    session.flash = { type: 'success', message: 'Profile saved.' };
    res.writeHead(302, { Location: url('dashboard/account/profile.php'), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'change_password') {
    const next = fields.new_password || '';
    const ok = next.length >= 8 && next === fields.confirm_password && fields.current_password;
    session.flash = ok
      ? { type: 'success', message: 'Password updated. Use it the next time you log in.' }
      : { type: 'error', message: 'Password not changed. Use 8+ characters and match the confirmation.' };
    res.writeHead(302, { Location: url('dashboard/account/settings.php'), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'add_product') {
    session.flash = { type: 'success', message: 'Product submitted. An admin will publish it to the shop.' };
    res.writeHead(302, { Location: url('dashboard/farmer/products.php'), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'update_settings') {
    session.flash = { type: 'success', message: 'Preferences saved to your account.' };
    res.writeHead(302, { Location: url('dashboard/account/settings.php'), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'newsletter') {
    session.flash = { type: 'success', message: "You're on the list! Fresh news, straight from the field." };
    res.writeHead(302, { Location: url('index.php'), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'checkout') {
    const payload = { ok: true, order: 'TF-DEMO', total: 0 };
    if (String(req.headers['content-type'] || '').includes('application/json')) {
      res.writeHead(200, { 'Content-Type': 'application/json; charset=utf-8', 'Set-Cookie': sessionCookie(session) });
      res.end(JSON.stringify(payload));
      return;
    }
    session.flash = { type: 'success', message: 'Order TF-DEMO placed (preview — import MySQL to persist).' };
    res.writeHead(302, { Location: url('dashboard/user/orders.php'), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'rate') {
    if (String(req.headers['content-type'] || '').includes('application/json')) {
      res.writeHead(200, { 'Content-Type': 'application/json; charset=utf-8' });
      res.end(JSON.stringify({ ok: true }));
      return;
    }
  }

  const flashes = {
    approve_product: ['success', 'Listing approved (preview).', 'dashboard/admin/products.php'],
    reject_product: ['success', 'Listing rejected (preview).', 'dashboard/admin/products.php'],
    publish_opportunity: ['success', 'Program published (preview).', 'dashboard/admin/opportunities.php'],
    close_opportunity: ['success', 'Program closed (preview).', 'dashboard/admin/opportunities.php'],
    apply_opportunity: ['success', 'Application sent (preview).', 'dashboard/user/opportunities.php'],
    update_product: ['success', 'Product updated (preview).', 'dashboard/farmer/products.php'],
    delete_product: ['info', 'Listing removed (preview).', 'dashboard/farmer/products.php'],
    fulfill_order: ['success', 'Order status updated (preview).', 'dashboard/farmer/orders.php'],
    toggle_user: ['success', 'User status updated (preview).', 'dashboard/admin/users.php'],
    update_system: ['success', 'System settings saved (preview).', 'dashboard/admin/settings.php'],
    send_message: ['success', 'Message sent (preview).', 'dashboard/user/messages.php'],
  };
  if (flashes[action]) {
    session.flash = { type: flashes[action][0], message: flashes[action][1] };
    res.writeHead(302, { Location: url(flashes[action][2]), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  res.writeHead(302, { Location: url('index.php') });
  res.end();
}

const MIME = {
  '.html': 'text/html; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.js': 'application/javascript; charset=utf-8',
  '.json': 'application/json',
  '.png': 'image/png',
  '.jpg': 'image/jpeg',
  '.jpeg': 'image/jpeg',
  '.gif': 'image/gif',
  '.webp': 'image/webp',
  '.svg': 'image/svg+xml',
  '.ico': 'image/x-icon',
  '.woff': 'font/woff',
  '.woff2': 'font/woff2',
  '.ttf': 'font/ttf',
  '.eot': 'application/vnd.ms-fontobject',
  '.map': 'application/json',
};

function safeJoin(urlPath) {
  const decoded = decodeURIComponent(urlPath.split('?')[0]);
  const rel = decoded.replace(/^\/+/, '');
  const abs = path.normalize(path.join(ROOT, rel));
  if (!abs.startsWith(ROOT)) return null;
  return abs;
}

function readBody(req) {
  return new Promise((resolve, reject) => {
    const chunks = [];
    req.on('data', (c) => chunks.push(c));
    req.on('end', () => resolve(Buffer.concat(chunks).toString('utf8')));
    req.on('error', reject);
  });
}

const server = http.createServer(async (req, res) => {
  try {
    const host = req.headers.host || 'localhost';
    const parsed = new URL(req.url, 'http://' + host);
    let urlPath = parsed.pathname;
    if (urlPath === '/') urlPath = '/index.php';

    if (req.method === 'POST' && (urlPath === '/process.php' || urlPath.endsWith('/process.php'))) {
      const body = await readBody(req);
      let fields = {};
      if (String(req.headers['content-type'] || '').includes('application/json')) {
        try { fields = JSON.parse(body || '{}'); } catch (err) { fields = {}; }
      } else {
        fields = querystring.parse(body);
      }
      handleProcess(req, res, fields, readSession(req));
      return;
    }

    const file = safeJoin(urlPath);
    if (!file) {
      res.writeHead(403);
      res.end('Forbidden');
      return;
    }

    if (file.endsWith('.php')) {
      if (!fs.existsSync(file)) {
        res.writeHead(404, { 'Content-Type': 'text/plain' });
        res.end('Not found');
        return;
      }
      const ctx = makeCtx(req, { _GET: Object.fromEntries(parsed.searchParams) });
      try {
        const html = renderFile(file, ctx);
        const headers = { 'Content-Type': 'text/html; charset=utf-8' };
        if (ctx._session && ctx._session.flash === null) {
          headers['Set-Cookie'] = sessionCookie(ctx._session);
        }
        res.writeHead(200, headers);
        res.end(html);
      } catch (err) {
        if (err instanceof Redirect) {
          res.writeHead(302, { Location: err.location });
          res.end();
          return;
        }
        console.error(err);
        res.writeHead(500, { 'Content-Type': 'text/plain; charset=utf-8' });
        res.end('Template error: ' + err.message + '\n' + err.stack);
      }
      return;
    }

    if (!fs.existsSync(file) || fs.statSync(file).isDirectory()) {
      res.writeHead(404);
      res.end('Not found');
      return;
    }
    const ext = path.extname(file).toLowerCase();
    res.writeHead(200, { 'Content-Type': MIME[ext] || 'application/octet-stream' });
    fs.createReadStream(file).pipe(res);
  } catch (err) {
    console.error(err);
    res.writeHead(500);
    res.end('Server error');
  }
});

server.listen(PORT, HOST, () => {
  console.log('The Farmer preview running on http://' + HOST + ':' + PORT);
});
