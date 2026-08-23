/* ============================================================
   پُست‌یار × Gentelella v4 — رفتارهای پوسته
   ۱) جمع/باز شدن سایدبار دسکتاپ (rail mode) با ذخیره وضعیت
   ۲) دراور سایدبار موبایل + backdrop
   صرفاً لایه نمایشی؛ هیچ منطق برنامه‌ای را تغییر نمی‌دهد.
   ============================================================ */
(function () {
  'use strict';
  // ═══ نوار تب پایین: اتصال عمومی (برای پنل ادمین که binder اختصاصی ندارد) ═══
  document.addEventListener('click', function (e) {
    var item = e.target.closest ? e.target.closest('.mobile-nav-item[data-target]') : null;
    if (!item) return;
    var id = item.getAttribute('data-target');
    if (window.switchSection) { try { window.switchSection(id); } catch (err) {} }
    var items = document.querySelectorAll('.mobile-nav-item');
    for (var i = 0; i < items.length; i++) items[i].classList.remove('active');
    item.classList.add('active');
  });

  var RAIL_KEY = 'postyar:sidebar-rail';
  var body = document.body;
  var sidebar = document.querySelector('.g-sidebar');
  var toggle = document.getElementById('g-sidebar-toggle');
  var backdrop = document.getElementById('g-sidebar-backdrop');

  function isDesktop() {
    return window.matchMedia('(min-width: 769px)').matches;
  }

  function applyRailLabels() {
    if (!sidebar) return;
    sidebar.querySelectorAll('.menu-item').forEach(function (item) {
      var text = item.querySelector('.nav-text');
      if (text && text.textContent.trim()) {
        item.setAttribute('data-rail-label', text.textContent.trim());
      }
    });
  }

  function setRail(on) {
    body.classList.toggle('sidebar-rail', on);
    if (toggle) {
      toggle.setAttribute('aria-pressed', on ? 'true' : 'false');
      toggle.setAttribute('aria-label', on ? 'باز کردن منو' : 'جمع کردن منو');
    }
    if (on) applyRailLabels();
  }

  if (toggle) {
    toggle.addEventListener('click', function () {
      if (isDesktop()) {
        var on = !body.classList.contains('sidebar-rail');
        setRail(on);
        try { sessionStorage.setItem(RAIL_KEY, on ? '1' : '0'); } catch (e) { /* ignore */ }
      } else if (sidebar && backdrop) {
        // موبایل: سایدبار به‌صورت دراور باز می‌شود
        var open = sidebar.classList.toggle('open');
        body.classList.toggle('sidebar-open', open);
        backdrop.classList.toggle('show', open);
      }
    });
  }

  // بستن دراور موبایل با کلیک روی backdrop
  if (backdrop && sidebar) {
    backdrop.addEventListener('click', function () {
      sidebar.classList.remove('open');
      body.classList.remove('sidebar-open');
      backdrop.classList.remove('show');
    });
  }

  // بازیابی وضعیت ذخیره‌شده (فقط دسکتاپ)
  var saved = '0';
  try { saved = sessionStorage.getItem(RAIL_KEY) || '0'; } catch (e) { /* ignore */ }
  if (saved === '1' && isDesktop()) {
    setRail(true);
  }

  // به‌روزرسانی breadcrumb با کلیک روی آیتم‌های منو (delegation — مستقل از ترتیب لود اسکریپت‌ها)
  var crumb = document.getElementById('g-crumb');
  if (crumb && sidebar) {
    sidebar.addEventListener('click', function (e) {
      var item = e.target.closest ? e.target.closest('.menu-item') : null;
      if (!item) return;
      var t = item.querySelector('.nav-text');
      if (t) {
        setTimeout(function () { crumb.textContent = t.textContent.trim(); }, 0);
      }
    });
  }
})();
