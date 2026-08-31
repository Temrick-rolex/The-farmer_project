/* ============================================================
   THE FARMER — dashboard.js
   Collapsible sidebar + locked profile form.
   ============================================================ */
(function () {
  'use strict';

  var shell = document.getElementById('dashShell');
  if (!shell) return;

  function openSidebar() {
    shell.classList.add('sidebar-open');
    var scrim = document.getElementById('dashScrim');
    if (scrim) scrim.hidden = false;
  }

  function closeSidebar() {
    shell.classList.remove('sidebar-open');
    var scrim = document.getElementById('dashScrim');
    if (scrim) scrim.hidden = true;
  }

  document.querySelectorAll('[data-sidebar-open]').forEach(function (btn) {
    btn.addEventListener('click', openSidebar);
  });
  document.querySelectorAll('[data-sidebar-close]').forEach(function (btn) {
    btn.addEventListener('click', closeSidebar);
  });
  window.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeSidebar();
  });

  document.querySelectorAll('.dash-nav a').forEach(function (a) {
    a.addEventListener('click', closeSidebar);
  });

  var form = document.getElementById('profileForm');
  if (!form) return;

  var editBtn = document.getElementById('profileEditBtn');
  var saveBtn = document.getElementById('profileSaveBtn');
  var cancelBtn = document.getElementById('profileCancelBtn');
  var fields = form.querySelectorAll('input:not([type="hidden"]), select');
  var snapshot = {};

  function capture() {
    snapshot = {};
    fields.forEach(function (el) { snapshot[el.name] = el.value; });
  }

  function lock() {
    form.classList.add('is-locked');
    fields.forEach(function (el) {
      if (el.tagName === 'SELECT') el.disabled = true;
      else el.readOnly = true;
    });
    if (editBtn) editBtn.hidden = false;
    if (saveBtn) saveBtn.hidden = true;
    if (cancelBtn) cancelBtn.hidden = true;
  }

  function unlock() {
    capture();
    form.classList.remove('is-locked');
    fields.forEach(function (el) {
      if (el.tagName === 'SELECT') el.disabled = false;
      else el.readOnly = false;
    });
    if (editBtn) editBtn.hidden = true;
    if (saveBtn) saveBtn.hidden = false;
    if (cancelBtn) cancelBtn.hidden = false;
    var first = form.querySelector('input:not([type="hidden"])');
    if (first) first.focus();
  }

  function restore() {
    fields.forEach(function (el) {
      if (snapshot[el.name] != null) el.value = snapshot[el.name];
    });
    lock();
  }

  lock();
  if (editBtn) editBtn.addEventListener('click', unlock);
  if (cancelBtn) cancelBtn.addEventListener('click', restore);
  form.addEventListener('submit', function () {
    fields.forEach(function (el) {
      if (el.tagName === 'SELECT') el.disabled = false;
    });
  });
})();
