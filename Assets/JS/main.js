/* ============================================================
   THE FARMER — main.js
   Nav, theme, cart, search, carousel, forms, toasts
   ============================================================ */
(function () {
  'use strict';

  var $ = function (sel, ctx) { return (ctx || document).querySelector(sel); };
  var $$ = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };

  /* ---------------- Toasts ---------------- */
  var TF = {
    toast: function (msg, type, ms) {
      type = type || 'success';
      ms = ms || 3200;
      var wrap = document.getElementById('toasts');
      if (!wrap) { wrap = document.createElement('div'); wrap.id = 'toasts'; document.body.appendChild(wrap); }
      var icons = { success: 'fa-circle-check', info: 'fa-circle-info', error: 'fa-circle-exclamation' };
      var el = document.createElement('div');
      el.className = 'toast toast-' + type;
      el.setAttribute('role', 'status');
      el.innerHTML = '<i class="fa-solid ' + (icons[type] || icons.success) + '"></i><span></span>';
      el.lastElementChild.textContent = msg;
      wrap.appendChild(el);
      requestAnimationFrame(function () { el.classList.add('in'); });
      setTimeout(function () {
        el.classList.remove('in');
        el.classList.add('out');
        setTimeout(function () { el.remove(); }, 350);
      }, ms);
    }
  };
  window.TF = TF;

  /* ---------------- Catalog + cart ---------------- */
  var CATALOG = window.TF_CATALOG || {};

  var cart = {};
  try { cart = JSON.parse(localStorage.getItem('tf-cart') || '{}') || {}; } catch (e) { cart = {}; }

  function fmt(n) { return n.toLocaleString('en-US') + ' XAF'; }

  function cartCount() { return Object.keys(cart).reduce(function (a, k) { return a + cart[k]; }, 0); }

  function cartSubtotal() {
    return Object.keys(cart).reduce(function (a, k) { return a + (CATALOG[k] ? CATALOG[k].price * cart[k] : 0); }, 0);
  }

  function saveCart() {
    try { localStorage.setItem('tf-cart', JSON.stringify(cart)); } catch (e) {}
    renderCart();
    updateBadges();
  }

  function updateBadges() {
    var n = cartCount();
    $$('.cart-count, .fab-count').forEach(function (el) {
      el.textContent = n;
      el.classList.toggle('show', n > 0);
    });
  }

  function addToCart(id) {
    if (!CATALOG[id]) {
      TF.toast('That product is not in the shop yet.', 'error');
      return;
    }
    if (CATALOG[id].stock != null && cart[id] >= CATALOG[id].stock) {
      TF.toast('Only ' + CATALOG[id].stock + ' left in stock', 'error');
      return;
    }
    cart[id] = (cart[id] || 0) + 1;
    saveCart();
    TF.toast(CATALOG[id].name + ' added to cart');
  }

  function setQty(id, delta) {
    if (!cart[id]) return;
    cart[id] += delta;
    if (cart[id] <= 0) delete cart[id];
    saveCart();
  }

  function removeItem(id) {
    delete cart[id];
    saveCart();
  }

  function renderCart() {
    var box = $('#cartItems');
    var empty = $('#cartEmpty');
    var foot = $('.cart-foot');
    if (!box) return;
    var ids = Object.keys(cart);
    if (ids.length === 0) {
      box.innerHTML = '';
      if (empty) empty.style.display = 'block';
      if (foot) foot.style.display = 'none';
      return;
    }
    if (empty) empty.style.display = 'none';
    if (foot) foot.style.display = 'block';
    box.innerHTML = ids.filter(function (id) { return CATALOG[id]; }).map(function (id) {
      var p = CATALOG[id];
      var q = cart[id];
      return '<div class="ci" data-id="' + id + '">' +
        '<img src="' + p.img + '" alt="' + p.name + '">' +
        '<div><div class="ci-name">' + p.name + '</div>' +
        '<div class="ci-price">' + fmt(p.price) + ' / unit</div>' +
        '<div class="qty">' +
        '<button data-act="dec" aria-label="Decrease quantity"><i class="fa-solid fa-minus"></i></button>' +
        '<span>' + q + '</span>' +
        '<button data-act="inc" aria-label="Increase quantity"><i class="fa-solid fa-plus"></i></button>' +
        '</div></div>' +
        '<div class="ci-right">' +
        '<span class="ci-total">' + fmt(p.price * q) + '</span>' +
        '<button class="ci-remove" data-act="remove" aria-label="Remove item"><i class="fa-solid fa-trash-can"></i></button>' +
        '</div></div>';
    }).join('');
    var sub = cartSubtotal();
    var del = sub >= 20000 ? 0 : 1000;
    var st = $('#cartSubtotal'), d = $('#cartDelivery'), t = $('#cartTotal');
    if (st) st.textContent = fmt(sub);
    if (d) d.textContent = del === 0 ? 'Free' : fmt(del);
    if (t) t.textContent = fmt(sub + del);
  }

  function openCart() {
    var dr = $('#cartDrawer'), ov = $('#cartOverlay');
    if (!dr) return;
    dr.classList.add('open');
    if (ov) ov.classList.add('show');
    dr.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeCart() {
    var dr = $('#cartDrawer'), ov = $('#cartOverlay');
    if (!dr) return;
    dr.classList.remove('open');
    if (ov) ov.classList.remove('show');
    dr.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  /* ---------------- Theme ---------------- */
  function currentTheme() {
    return document.documentElement.getAttribute('data-theme') || 'light';
  }

  function setTheme(t, silent) {
    document.documentElement.setAttribute('data-theme', t);
    try { localStorage.setItem('tf-theme', t); } catch (e) {}
    $$('.theme-toggle i').forEach(function (i) { i.className = 'fa-solid ' + (t === 'dark' ? 'fa-sun' : 'fa-moon'); });
    $$('select[name="theme"]').forEach(function (s) { s.value = t; });
    if (!silent) TF.toast(t === 'dark' ? 'Dark theme on' : 'Light theme on', 'info', 2000);
  }

  /* ---------------- Init ---------------- */
  document.addEventListener('DOMContentLoaded', function () {

    // year
    var y = $('#year');
    if (y) y.textContent = new Date().getFullYear();

    // theme sync (attribute is set pre-paint in each <head>)
    $$('select[name="theme"]').forEach(function (s) { s.value = currentTheme(); });
    $$('.theme-toggle i').forEach(function (i) { i.className = 'fa-solid ' + (currentTheme() === 'dark' ? 'fa-sun' : 'fa-moon'); });

    // theme toggle button
    $$('.theme-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () { setTheme(currentTheme() === 'dark' ? 'light' : 'dark'); });
    });

    // nav: burger + scroll shadow
    var nav = $('.nav');
    var burger = $('.nav-burger');
    if (nav && burger) {
      burger.addEventListener('click', function () {
        var open = nav.classList.toggle('open');
        burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        burger.querySelector('i').className = 'fa-solid ' + (open ? 'fa-xmark' : 'fa-bars');
      });
      $$('.nav-links a').forEach(function (a) {
        a.addEventListener('click', function () {
          nav.classList.remove('open');
          burger.querySelector('i').className = 'fa-solid fa-bars';
          burger.setAttribute('aria-expanded', 'false');
        });
      });
    }
    if (nav) {
      var onScroll = function () { nav.classList.toggle('scrolled', window.scrollY > 8); };
      onScroll();
      window.addEventListener('scroll', onScroll, { passive: true });
    }

    // cart wiring
    var drawer = $('#cartDrawer');
    if (drawer) {
      $('#cartFab').addEventListener('click', openCart);
      $('#cartClose').addEventListener('click', closeCart);
      $('#cartOverlay').addEventListener('click', closeCart);
      $('#cartItems').addEventListener('click', function (e) {
        var btn = e.target.closest('button[data-act]');
        if (!btn) return;
        var id = btn.closest('.ci').getAttribute('data-id');
        var act = btn.getAttribute('data-act');
        if (act === 'inc') setQty(id, 1);
        else if (act === 'dec') setQty(id, -1);
        else if (act === 'remove') { removeItem(id); TF.toast('Item removed', 'info', 1800); }
      });
      $('#checkoutBtn').addEventListener('click', function () {
        if (cartCount() === 0) return;
        if (!window.TF_LOGGED_IN) {
          TF.toast('Log in to place an order.', 'info');
          setTimeout(function () { window.location.href = (window.TF_BASE || '') + '/regform.php'; }, 700);
          return;
        }
        var btn = $('#checkoutBtn');
        btn.disabled = true;
        fetch(window.TF_PROCESS || '/process.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF': window.TF_CSRF || ''
          },
          body: JSON.stringify({ action: 'checkout', csrf: window.TF_CSRF || '', items: cart })
        }).then(function (res) { return res.json().then(function (data) { return { res: res, data: data }; }); })
          .then(function (out) {
            if (out.data && out.data.error === 'login') {
              window.location.href = out.data.redirect || ((window.TF_BASE || '') + '/regform.php');
              return;
            }
            if (!out.data || !out.data.ok) {
              TF.toast((out.data && out.data.error) || 'Could not place the order.', 'error', 4200);
              btn.disabled = false;
              return;
            }
            cart = {};
            saveCart();
            TF.toast('Order ' + out.data.order + ' placed. We will call you to confirm.', 'success', 4200);
            setTimeout(function () {
              window.location.href = (window.TF_BASE || '') + '/dashboard/user/orders.php';
            }, 900);
          })
          .catch(function () {
            TF.toast('Network error. Try again.', 'error');
            btn.disabled = false;
          });
      });
      updateBadges();
      renderCart();
    } else {
      updateBadges();
    }

    $$('.cart-link').forEach(function (a) {
      a.addEventListener('click', function (e) {
        if ($('#cartDrawer')) {
          e.preventDefault();
          openCart();
        }
      });
    });

    // add-to-cart buttons (product cards)
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('[data-add]');
      if (btn) addToCart(btn.getAttribute('data-add'));
    });

    // esc closes cart + mobile nav
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        closeCart();
        if (nav) nav.classList.remove('open');
      }
    });

    /* ---------- Shop: search + category chips ---------- */
    var search = $('#productSearch');
    var chips = $('#catChips');
    var cards = $$('.product-card');
    var emptyMsg = $('#shopEmpty');
    var resultsCount = $('#resultsCount');
    var activeCat = 'all';

    function applyFilter() {
      var q = search ? search.value.trim().toLowerCase() : '';
      var visible = 0;
      cards.forEach(function (c) {
        var matchCat = activeCat === 'all' || c.getAttribute('data-cat') === activeCat;
        var matchQ = !q || c.getAttribute('data-name').toLowerCase().indexOf(q) !== -1;
        var show = matchCat && matchQ;
        c.classList.toggle('hide', !show);
        if (show) visible++;
      });
      if (emptyMsg) emptyMsg.classList.toggle('show', visible === 0);
      if (resultsCount) resultsCount.textContent = visible + (visible === 1 ? ' product' : ' products');
    }

    if (search && chips) {
      search.addEventListener('input', applyFilter);
      chips.addEventListener('click', function (e) {
        var chip = e.target.closest('.chip');
        if (!chip) return;
        $$('.chip', chips).forEach(function (c) { c.classList.remove('active'); });
        chip.classList.add('active');
        activeCat = chip.getAttribute('data-cat');
        applyFilter();
      });
      applyFilter();
    }

    /* ---------- Carousel ---------- */
    var car = $('.carousel');
    if (car) {
      var slides = $$('.carousel img', car);
      var dotsWrap = $('.carousel-dots', car);
      var dots = [];
      if (dotsWrap) {
        dotsWrap.innerHTML = slides.map(function (_, j) {
          return '<button aria-label="Go to slide ' + (j + 1) + '"></button>';
        }).join('');
        dots = $$('.carousel-dots button', car);
      }
      var idx = 0, timer = null;
      function show(i) {
        idx = (i + slides.length) % slides.length;
        slides.forEach(function (s, j) { s.classList.toggle('active', j === idx); });
        dots.forEach(function (d, j) { d.classList.toggle('active', j === idx); });
      }
      function play() { stop(); timer = setInterval(function () { show(idx + 1); }, 4500); }
      function stop() { if (timer) clearInterval(timer); }
      dots.forEach(function (d, j) {
        d.addEventListener('click', function () { show(j); play(); });
      });
      car.addEventListener('mouseenter', stop);
      car.addEventListener('mouseleave', play);
      show(0);
      play();
    }

    /* ---------- Password show/hide ---------- */
    $$('.pw-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var input = document.getElementById(btn.getAttribute('data-for'));
        if (!input) return;
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.querySelector('i').className = 'fa-solid ' + (show ? 'fa-eye-slash' : 'fa-eye');
        btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
      });
    });

    /* ---------- Auth tabs ---------- */
    var tabs = $$('.tab');
    if (tabs.length) {
      function switchPanel(panelId) {
        tabs.forEach(function (t) {
          var on = t.getAttribute('data-panel') === panelId;
          t.classList.toggle('active', on);
          t.setAttribute('aria-selected', on ? 'true' : 'false');
        });
        $$('.form-panel').forEach(function (p) {
          p.classList.toggle('active', p.id === panelId);
        });
      }
      tabs.forEach(function (tab) {
        tab.addEventListener('click', function () { switchPanel(tab.getAttribute('data-panel')); });
      });
      $$('.tab-link').forEach(function (link) {
        link.addEventListener('click', function () { switchPanel(link.getAttribute('data-panel')); });
      });
    }

    /* ---------- Validation helpers ---------- */
    function setInvalid(input, bad, msg) {
      var field = input.closest('.field');
      if (!field) return;
      field.classList.toggle('invalid', bad);
      var err = $('.field-error', field);
      if (err && msg) err.textContent = msg;
    }

    function validEmail(v) { return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v); }

    /* ---------- Signup form ---------- */
    var signup = $('#signupForm');
    if (signup) {
      signup.addEventListener('submit', function (e) {
        var ok = true;
        var name = $('#su-name'), email = $('#su-email'), pw = $('#su-pass'), cpw = $('#su-conf'),
            dob = $('#su-dob'), tel = $('#su-tel'), addr = $('#su-addr');

        if (name.value.trim().length < 2) { setInvalid(name, true, 'Please enter your full name'); ok = false; } else setInvalid(name, false);
        if (!validEmail(email.value.trim())) { setInvalid(email, true, 'Please enter a valid email address'); ok = false; } else setInvalid(email, false);
        if (pw.value.length < 6) { setInvalid(pw, true, 'Password must be at least 6 characters'); ok = false; } else setInvalid(pw, false);
        if (cpw.value !== pw.value || !cpw.value) { setInvalid(cpw, true, 'Passwords do not match'); ok = false; } else setInvalid(cpw, false);
        if (!dob.value) { setInvalid(dob, true, 'Please select your date of birth'); ok = false; } else setInvalid(dob, false);
        if (tel.value.replace(/\D/g, '').length < 8) { setInvalid(tel, true, 'Please enter a valid phone number'); ok = false; } else setInvalid(tel, false);
        if (addr.value.trim().length < 4) { setInvalid(addr, true, 'Please enter your delivery address'); ok = false; } else setInvalid(addr, false);

        if (!ok) {
          e.preventDefault();
          TF.toast('Please fix the highlighted fields', 'error');
        }
      });
    }

    /* ---------- Login form ---------- */
    var login = $('#loginForm');
    if (login) {
      login.addEventListener('submit', function (e) {
        var user = $('#li-user'), pw = $('#li-pass');
        var ok = true;
        if (user.value.trim().length < 2) { setInvalid(user, true, 'Please enter your name or email'); ok = false; } else setInvalid(user, false);
        if (pw.value.length < 4) { setInvalid(pw, true, 'Please enter your password'); ok = false; } else setInvalid(pw, false);
        if (!ok) {
          e.preventDefault();
          TF.toast('Please enter your login details', 'error');
        }
      });
    }

    /* ---------- Settings selects ---------- */
    $$('select[data-pref]').forEach(function (sel) {
      sel.addEventListener('change', function () {
        try { localStorage.setItem(sel.getAttribute('data-pref'), sel.value); } catch (e) {}
        if (sel.name === 'theme') { setTheme(sel.value, true); return; }
        TF.toast('Preference saved: ' + sel.options[sel.selectedIndex].text, 'info', 2200);
      });
    });

    /* ---------- Rate us ---------- */
    var rate = $('#rateStars');
    if (rate) {
      var rating = 0;
      var starBtns = $$('button', rate);
      function paint(n) { starBtns.forEach(function (b, i) { b.classList.toggle('lit', i < n); }); }
      starBtns.forEach(function (b, i) {
        b.addEventListener('mouseenter', function () { paint(i + 1); });
        b.addEventListener('click', function () {
          rating = i + 1;
          paint(rating);
          fetch(window.TF_PROCESS || '/process.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF': window.TF_CSRF || '' },
            body: JSON.stringify({ action: 'rate', csrf: window.TF_CSRF || '', stars: rating })
          }).then(function (r) { return r.json(); }).then(function (data) {
            TF.toast(data && data.ok ? ('Thanks for rating us ' + rating + '/5!') : 'Could not save rating.', data && data.ok ? 'success' : 'error', 2600);
          }).catch(function () { TF.toast('Thanks for rating us ' + rating + '/5!', 'success', 2600); });
        });
      });
      rate.addEventListener('mouseleave', function () { paint(rating); });
    }

    /* ---------- Confirm actions ---------- */
    $$('[data-confirm]').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        if (!confirm(btn.getAttribute('data-confirm'))) e.preventDefault();
      });
    });

    /* ---------- Demo buttons ---------- */
    $$('[data-demo]').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        TF.toast(btn.getAttribute('data-demo'), 'info', 2600);
      });
    });

    /* ---------- Newsletter ---------- */
    var news = $('#newsletterForm');
    if (news) {
      news.addEventListener('submit', function (e) {
        e.preventDefault();
        var em = $('#newsletterEmail');
        if (validEmail(em.value.trim())) {
          TF.toast("You're on the list! Fresh news, straight from the field.", 'success', 3200);
          news.reset();
        } else {
          TF.toast('Please enter a valid email address', 'error');
        }
      });
    }
  });
})();
