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
]);

const DEMO_USER = {
  id: '01XJ00F',
  name: 'John Doe',
  first_name: 'John',
  email: 'johndoe@gmail.com',
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
};

const DEMO = {
  TF_ORDERS: [
    { id: 'TF-1042', item: 'Mixed Citrus Platter — 6 kg', date: '12 Aug 2026', amount: 6000, status: 'Delivered', tone: 'ok' },
    { id: 'TF-1017', item: 'Mature Orange Tree (Valencia)', date: '28 Jul 2026', amount: 30000, status: 'In delivery', tone: 'warn' },
    { id: 'TF-1004', item: 'Fresh Orange Juice — 1 L × 4', date: '11 Jul 2026', amount: 7200, status: 'Delivered', tone: 'ok' },
    { id: 'TF-0988', item: 'Orchard Box — 1 month', date: '02 Jul 2026', amount: 12000, status: 'Delivered', tone: 'ok' },
    { id: 'TF-0961', item: 'Farm Visit & Self-Harvest × 2', date: '18 Jun 2026', amount: 30000, status: 'Completed', tone: 'ok' },
  ],
  TF_SAVED_OPPORTUNITIES: [
    { title: 'Partnership Program', status: 'Under review', applied: '04 Aug 2026', icon: 'fa-handshake' },
    { title: 'Mentorship Program', status: 'Accepted', applied: '12 May 2026', icon: 'fa-hands-holding-child' },
  ],
  TF_MESSAGES: [
    { from: 'The Farmer Support', preview: 'Your Valencia tree is out for delivery in Yaoundé today.', time: 'Today · 09:14', unread: true },
    { from: 'Amina — Mentorship', preview: 'Shall we visit the Simbock plot on Saturday morning?', time: 'Yesterday', unread: true },
    { from: 'Harvest desk', preview: 'Your Orchard Box for August has been packed.', time: '11 Aug', unread: false },
  ],
  TF_FARMER_PRODUCTS: [
    { id: 'p1', name: 'Mature Orange Tree (Valencia)', stock: 18, price: 30000, status: 'Live' },
    { id: 'p2', name: 'Mature Tangerine Tree', stock: 11, price: 25000, status: 'Live' },
    { id: 'p3', name: 'Fresh Oranges — 5 kg basket', stock: 42, price: 3500, status: 'Live' },
    { id: 'p6', name: 'Mixed Citrus Platter — 6 kg', stock: 9, price: 6000, status: 'Low stock' },
    { id: 'p7', name: 'Fresh Orange Juice — 1 L', stock: 0, price: 1800, status: 'Sold out' },
    { id: 'p11', name: 'Farm Visit & Self-Harvest', stock: 30, price: 15000, status: 'Live' },
  ],
  TF_FARMER_ORDERS: [
    { id: 'TF-1048', buyer: 'Bella Ngwa', item: 'Fresh Oranges — 5 kg × 2', amount: 7000, status: 'To pack', city: 'Yaoundé' },
    { id: 'TF-1046', buyer: 'Jean-Claude Mbarga', item: 'Mature Tangerine Tree', amount: 25000, status: 'To deliver', city: 'Bafoussam' },
    { id: 'TF-1043', buyer: 'Aminata Salla', item: 'Mixed Citrus Platter', amount: 6000, status: 'To pack', city: 'Bamenda' },
    { id: 'TF-1039', buyer: 'Patrick Etoundi', item: 'Farm Visit × 3', amount: 45000, status: 'Confirmed', city: 'Douala' },
  ],
  TF_ADMIN_USERS: [
    { id: '01XJ00F', name: 'John Doe', role: 'Customer', city: 'Yaoundé', joined: '2024', status: 'Active' },
    { id: '02BN14K', name: 'Bella Ngwa', role: 'Customer', city: 'Yaoundé', joined: '2025', status: 'Active' },
    { id: '03JM22P', name: 'Jean-Claude Mbarga', role: 'Farmer', city: 'Bafoussam', joined: '2024', status: 'Active' },
    { id: '04AS09M', name: 'Aminata Salla', role: 'Customer', city: 'Bamenda', joined: '2025', status: 'Active' },
    { id: '05PE31D', name: 'Patrick Etoundi', role: 'Farmer', city: 'Douala', joined: '2023', status: 'Active' },
    { id: '06NK18T', name: 'Ngono Kesseng', role: 'Admin', city: 'Yaoundé', joined: '2023', status: 'Active' },
  ],
  TF_APPROVAL_QUEUE: [
    { vendor: 'Jean-Claude Mbarga', product: 'Pink Grapefruit Tree', price: 28000, submitted: '24 Aug 2026' },
    { vendor: 'Patrick Etoundi', product: 'Honey Tangerine — 4 kg', price: 3200, submitted: '23 Aug 2026' },
    { vendor: 'Mballa Farms', product: 'Cold-pressed Lime Juice', price: 2000, submitted: '22 Aug 2026' },
  ],
  TF_OPPORTUNITY_QUEUE: [
    { title: 'Youth harvest crew — seasonal', type: 'Employment', from: 'Farm HR', status: 'Pending' },
    { title: 'Retail partner — Douala market', type: 'Partnership', from: 'Kotto Fresh Ltd', status: 'Pending' },
    { title: 'Soil clinic — Bafoussam', type: 'Mentorship', from: 'Jean-Claude Mbarga', status: 'Live' },
  ],
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

function asset(p) {
  return ASSET_URL + '/' + String(p).replace(/\\/g, '/').replace(/^\/+/, '');
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
  return v == null || v === false || v === '' || (Array.isArray(v) && v.length === 0);
}

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
    TF_DEMO_USER: Object.assign({}, DEMO_USER),
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
  s = s.replace(/\bASSET_URL\b/g, 'ctx.ASSET_URL');
  s = s.replace(/\bBASE_URL\b/g, 'ctx.BASE_URL');
  s = s.replace(/\$([a-zA-Z_][a-zA-Z0-9_]*)/g, 'ctx.$1');
  s = s.replace(/\s+\.\s+/g, ' + ');
  s = s.replace(/\bdirname\s*\(/g, 'phpDirname(');
  s = s.replace(/!empty\s*\(/g, '!isEmpty(');
  s = s.replace(/\bempty\s*\(/g, 'isEmpty(');
  s = s.replace(/\bisset\s*\(/g, '(function(v){return v!==undefined && v!==null;})(');
  s = s.replace(/\(\s*int\s*\)\s*/g, '');
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
    ctx.current_user, ctx.is_logged_in, ctx.flash_get, Number
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

function handleProcess(req, res, fields, session) {
  const action = fields.action || '';
  const headers = [];
  const setUser = (user) => {
    session.user = user;
    session.flash = { type: 'success', message: 'Welcome to The Farmer, ' + user.first_name + '.' };
  };

  if (action === 'login') {
    const name = String(fields.logname || '').trim() || 'John Doe';
    let role = fields.role || 'customer';
    if (!['customer', 'farmer', 'admin'].includes(role)) role = 'customer';
    const first = name.split(/\s+/)[0];
    setUser(Object.assign({}, DEMO_USER, {
      name,
      first_name: first,
      email: name.includes('@') ? name : 'johndoe@gmail.com',
      role,
    }));
    headers.push(['Set-Cookie', sessionCookie(session)]);
    res.writeHead(302, { Location: tf_role_home(role), 'Set-Cookie': sessionCookie(session) });
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
      email: fields.email || 'johndoe@gmail.com',
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
    session.user.payment = fields.payment || session.user.payment;
    session.flash = { type: 'success', message: 'Profile updated (demo — persist to MySQL next).' };
    res.writeHead(302, { Location: url('dashboard/account/profile.php'), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'change_password') {
    const next = fields.new_password || '';
    const ok = next.length >= 8 && next === fields.confirm_password && fields.current_password;
    session.flash = ok
      ? { type: 'success', message: 'Password updated. Use this password the next time you log in.' }
      : { type: 'error', message: 'Password not changed. Use 8+ characters and match the confirmation.' };
    res.writeHead(302, { Location: url('dashboard/account/settings.php'), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'add_product') {
    session.flash = { type: 'success', message: 'Product submitted for review. An admin will publish it to the shop.' };
    res.writeHead(302, { Location: url('dashboard/farmer/products.php'), 'Set-Cookie': sessionCookie(session) });
    res.end();
    return;
  }

  if (action === 'update_settings') {
    session.flash = { type: 'info', message: 'Preferences saved on this device.' };
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
      const fields = querystring.parse(body);
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
      const ctx = makeCtx(req);
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
