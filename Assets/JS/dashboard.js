/* ============================================================
   THE FARMER — dashboard.js
   Collapsible sidebar, flash fade, demo table actions.
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
})();
