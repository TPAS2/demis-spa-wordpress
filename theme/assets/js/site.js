// Mobile menu
const toggle = document.querySelector('.nav-toggle');
const nav = document.getElementById('nav');
toggle.addEventListener('click', () => {
  const open = nav.classList.toggle('open');
  toggle.setAttribute('aria-expanded', open);
});
nav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
  nav.classList.remove('open');
  toggle.setAttribute('aria-expanded', 'false');
}));

// Treatment tabs
const tabs = document.querySelectorAll('.tab');
const panels = document.querySelectorAll('.panel');
function showTab(name) {
  tabs.forEach(t => {
    const on = t.dataset.tab === name;
    t.classList.toggle('is-active', on);
    t.setAttribute('aria-selected', on);
  });
  panels.forEach(p => p.classList.toggle('is-active', p.dataset.panel === name));
}
tabs.forEach(t => t.addEventListener('click', () => showTab(t.dataset.tab)));
document.querySelectorAll('.card[data-tab]').forEach(c =>
  c.addEventListener('click', () => showTab(c.dataset.tab)));

// Header height (for snapping) and the page list on the right
const siteTop = document.getElementById('top');
const setTopHeight = () => document.documentElement.style.setProperty('--top-h', siteTop.offsetHeight + 'px');
setTopHeight();
window.addEventListener('resize', setTopHeight);

const pages = [...document.querySelectorAll('.snap[data-label]')];
const list = document.querySelector('#side-nav ul');
const links = pages.map(p => {
  const li = document.createElement('li');
  const a = document.createElement('a');
  a.href = '#' + p.id;
  a.textContent = p.dataset.label;
  li.appendChild(a);
  list.appendChild(li);
  return a;
});
function markActive() {
  const line = siteTop.offsetHeight + window.innerHeight * 0.3;
  let current = 0;
  pages.forEach((p, i) => { if (p.getBoundingClientRect().top <= line) current = i; });
  if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2) current = pages.length - 1;
  links.forEach((a, i) => {
    a.classList.toggle('is-active', i === current);
    if (i === current) a.setAttribute('aria-current', 'true'); else a.removeAttribute('aria-current');
  });
}
window.addEventListener('scroll', markActive, { passive: true });
window.addEventListener('resize', markActive);
markActive();

// Every page is one screen: snap to it, and shrink a page just enough to fit the window
const allPanels = document.querySelectorAll('.panel');
const MIN_ZOOM_DESKTOP = 0.55;
const MIN_ZOOM_PHONE = 0.74;

function setZoom(page, z) {
  [...page.children].forEach(k => { k.style.zoom = z < 1 ? z.toFixed(3) : ''; });
}
// the zoom this page needs so its content is no taller than the space under the header
function zoomFor(page, avail, minZ) {
  setZoom(page, 1);
  let z = 1;
  for (let i = 0; i < 6; i++) {
    const h = page.offsetHeight;
    if (h <= avail + 1) break;
    z = Math.max(minZ, z * (avail / h) * 0.985);
    setZoom(page, z);
    if (z <= minZ) break;
  }
  return z;
}
// the price guide changes height with each tab, so size it for the tallest one
function menuZoom(page, avail, minZ) {
  const current = document.querySelector('.panel.is-active');
  let z = 1;
  allPanels.forEach(pn => {
    allPanels.forEach(x => x.classList.remove('is-active'));
    pn.classList.add('is-active');
    z = Math.min(z, zoomFor(page, avail, minZ));
  });
  allPanels.forEach(x => x.classList.toggle('is-active', x === current));
  setZoom(page, z);
}
function anyTooTall(avail) {
  return pages.some(p => {
    if (p.id === 'menu') {
      const current = document.querySelector('.panel.is-active');
      let bad = false;
      allPanels.forEach(pn => {
        allPanels.forEach(x => x.classList.remove('is-active'));
        pn.classList.add('is-active');
        if (p.offsetHeight > avail + 1) bad = true;
      });
      allPanels.forEach(x => x.classList.toggle('is-active', x === current));
      return bad;
    }
    return p.offsetHeight > avail + 1;
  });
}
function fitSnap() {
  const root = document.documentElement;
  root.classList.remove('snapmode', 'tight');
  pages.forEach(p => setZoom(p, 1));
  if (window.innerHeight >= 360) {
    const phone = window.innerWidth < 900;
    const avail = window.innerHeight - siteTop.offsetHeight;
    root.classList.add('snapmode');
    if (!phone && anyTooTall(avail)) root.classList.add('tight');
    const minZ = phone ? MIN_ZOOM_PHONE : MIN_ZOOM_DESKTOP;
    pages.forEach(p => { if (p.id === 'menu') menuZoom(p, avail, minZ); else zoomFor(p, avail, minZ); });
  }
  markActive();
}
let fitTimer;
window.addEventListener('resize', () => { clearTimeout(fitTimer); fitTimer = setTimeout(fitSnap, 120); });
window.addEventListener('load', fitSnap);
if (document.fonts && document.fonts.ready) document.fonts.ready.then(fitSnap);
fitSnap();
// some hosts resize the frame without a resize event, so also watch the size
let lastW = window.innerWidth, lastH = window.innerHeight;
setInterval(() => {
  if (window.innerWidth !== lastW || window.innerHeight !== lastH) {
    lastW = window.innerWidth; lastH = window.innerHeight;
    fitSnap();
  }
}, 400);

// ---------- Language, opening hours and booking ----------
const HOURS = (window.DEMIS_CONFIG && window.DEMIS_CONFIG.hours) || { Mon: [8, 17], Tue: [8, 17], Wed: [8, 17], Thu: [8, 17], Fri: [8, 17], Sat: [10, 14] };
const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
const LANGS = [['en', 'English', 'EN'], ['el', 'Ελληνικά', 'EL'], ['tr', 'Türkçe', 'TR'], ['ru', 'Русский', 'RU'], ['fr', 'Français', 'FR'], ['de', 'Deutsch', 'DE']];
const HAS_I18N = typeof I18N !== 'undefined' && typeof UI !== 'undefined';
let lang = 'en';
const ORIGINAL_TITLE = document.title;
const ui = key => HAS_I18N ? ((UI[lang] && UI[lang][key]) || UI.en[key] || '') : '';
const fmt = h => h + ':00';
const norm = s => s.replace(/\s+/g, ' ').trim();

// "Open now" badge from the real opening hours (Cyprus time)
function updateBadge() {
  const state = document.getElementById('open-state');
  const sub = document.getElementById('open-hours');
  if (!state || !sub || !HAS_I18N) return;
  try {
    const p = Object.fromEntries(new Intl.DateTimeFormat('en-GB', { timeZone: 'Asia/Nicosia', weekday: 'short', hour: 'numeric', minute: 'numeric', hour12: false })
      .formatToParts(new Date()).map(x => [x.type, x.value]));
    const now = (+p.hour % 24) + (+p.minute) / 60;
    const day = p.weekday.slice(0, 3);
    const today = HOURS[day];
    const dot = document.querySelector('.hero-chip .dot');
    if (today && now >= today[0] && now < today[1]) {
      state.textContent = ui('open');
      sub.textContent = ui('until').replace('{t}', fmt(today[1]));
      dot.classList.remove('closed');
      return;
    }
    dot.classList.add('closed');
    state.textContent = ui('closed');
    const i = DAYS.indexOf(day);
    let label = '';
    if (today && now < today[0]) label = ui('today').replace('{t}', fmt(today[0]));
    else for (let n = 1; n <= 7; n++) {
      const d = DAYS[(i + n) % 7];
      if (HOURS[d]) {
        label = n === 1 ? ui('tomorrow').replace('{t}', fmt(HOURS[d][0]))
                        : ui('day').replace('{d}', UI[lang].days[d]).replace('{t}', fmt(HOURS[d][0]));
        break;
      }
    }
    sub.textContent = label;
  } catch (e) { /* keep the default text */ }
}

// Booking form
const bookingForm = document.getElementById('booking-form');
const bookingNote = document.getElementById('booking-note');
let lastNote = null;
function showNote(key, kind) {
  lastNote = key ? { key, kind } : null;
  if (!bookingNote) return;
  bookingNote.textContent = key ? ui(key) : '';
  bookingNote.classList.toggle('error', kind === 'error');
}
function localISO(d) {
  const z = n => String(n).padStart(2, '0');
  return d.getFullYear() + '-' + z(d.getMonth() + 1) + '-' + z(d.getDate());
}
function fillTimes() {
  if (!bookingForm) return;
  const dateEl = bookingForm.elements['date'];
  const timeEl = document.getElementById('b-time');
  const keep = timeEl.value;
  timeEl.innerHTML = '';
  const add = (value, text) => { const o = document.createElement('option'); o.value = value; o.textContent = text; timeEl.appendChild(o); };
  if (!dateEl.value) { add('', ui('pickDate')); return; }
  const hrs = HOURS[DAYS[new Date(dateEl.value + 'T12:00:00').getDay()]];
  if (!hrs) { add('', ui('closedDay')); return; }
  add('', ui('pickTime'));
  for (let m = hrs[0] * 60; m <= hrs[1] * 60 - 30; m += 30) {
    const t = String(Math.floor(m / 60)).padStart(2, '0') + ':' + String(m % 60).padStart(2, '0');
    add(t, t);
  }
  if ([...timeEl.options].some(o => o.value === keep)) timeEl.value = keep;
}
if (bookingForm) {
  const dateEl = bookingForm.elements['date'];
  dateEl.min = localISO(new Date());
  dateEl.addEventListener('change', fillTimes);
  fillTimes();
  const fields = ['name', 'phone', 'email', 'treatment', 'date', 'time'].map(n => bookingForm.elements[n]);
  fields.forEach(f => f.addEventListener('input', () => f.removeAttribute('aria-invalid')));
  bookingForm.addEventListener('submit', async e => {
    e.preventDefault();
    const f = bookingForm.elements;
    fields.forEach(x => x.removeAttribute('aria-invalid'));
    const fail = (field, key) => { field.setAttribute('aria-invalid', 'true'); showNote(key, 'error'); field.focus(); };
    const day = f.date.value ? DAYS[new Date(f.date.value + 'T12:00:00').getDay()] : '';
    if (!f.name.value.trim()) return fail(f.name, 'needName');
    if (!f.phone.value.trim()) return fail(f.phone, 'needPhone');
    if (f.email.value.trim() && !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(f.email.value.trim())) return fail(f.email, 'badEmail');
    if (!f.treatment.value) return fail(f.treatment, 'needTreatment');
    if (!f.date.value) return fail(f.date, 'needDate');
    if (f.date.value < localISO(new Date())) return fail(f.date, 'pastDate');
    if (!HOURS[day]) return fail(f.date, 'sunday');
    if (!f.time.value) return fail(f.time, 'needTime');
    if (!f.consent.checked) { showNote('needConsent', 'error'); f.consent.focus(); return; }
    if (f.botcheck.value) return; // a bot filled the hidden field
    const endpoint = bookingForm.dataset.endpoint;
    const button = bookingForm.querySelector('button[type="submit"]');
    if (!endpoint) { showNote('preview', 'ok'); return; }
    button.disabled = true;
    showNote('sending', 'ok');
    try {
      const res = await fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({
          access_key: bookingForm.dataset.accessKey || undefined,
          subject: 'New booking request from ' + f.name.value.trim(),
          from_name: "Demi's Spa website",
          name: f.name.value.trim(), phone: f.phone.value.trim(), email: f.email.value.trim(),
          treatment: f.treatment.value, date: f.date.value, time: f.time.value,
          notes: f.notes.value.trim(), language: lang, botcheck: ''
        })
      });
      let ok = res.ok;
      try { const data = await res.json(); if (data && data.success === false) ok = false; } catch (err) { /* not JSON */ }
      if (!ok) throw new Error('send failed');
      showNote('success', 'ok');
      bookingForm.reset();
      fillTimes();
    } catch (err) {
      showNote('failure', 'error');
    } finally {
      button.disabled = false;
    }
  });
}

// Language selector
function translateAll() {
  document.querySelectorAll('[data-i18n]').forEach(el => {
    if (!el.dataset.en) el.dataset.en = norm(el.innerHTML);
    const entry = I18N[el.dataset.en];
    el.innerHTML = (lang !== 'en' && entry && entry[lang]) || el.dataset.en;
  });
}
function applyLang(code, remember) {
  lang = code;
  document.documentElement.lang = code;
  translateAll();
  links.forEach((a, i) => { a.textContent = (UI[lang].nav || {})[pages[i].dataset.label] || pages[i].dataset.label; });
  document.title = code === 'en' ? ORIGINAL_TITLE : ui('title');
  document.getElementById('lang-code').textContent = (LANGS.find(l => l[0] === code) || LANGS[0])[2];
  document.querySelectorAll('#lang-menu button').forEach(b => b.setAttribute('aria-selected', b.dataset.code === code));
  updateBadge();
  fillTimes();
  if (lastNote) showNote(lastNote.key, lastNote.kind);
  if (remember) { try { localStorage.setItem('lang', code); } catch (e) { /* ignore */ } }
  fitSnap();
}
(function languageSelector() {
  const box = document.getElementById('lang');
  if (!box) return;
  if (!HAS_I18N) { box.hidden = true; return; }
  const btn = document.getElementById('lang-btn');
  const menu = document.getElementById('lang-menu');
  LANGS.forEach(([code, name, short]) => {
    const li = document.createElement('li');
    const b = document.createElement('button');
    b.type = 'button'; b.dataset.code = code; b.setAttribute('role', 'option');
    b.innerHTML = '<span></span><small>' + short + '</small>';
    b.firstChild.textContent = name;
    b.addEventListener('click', () => { applyLang(code, true); close(); btn.focus(); });
    li.appendChild(b); menu.appendChild(li);
  });
  const close = () => { menu.hidden = true; btn.setAttribute('aria-expanded', 'false'); };
  btn.addEventListener('click', () => {
    const open = menu.hidden;
    menu.hidden = !open;
    btn.setAttribute('aria-expanded', open);
  });
  document.addEventListener('click', e => { if (!box.contains(e.target)) close(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
  let start = 'en';
  try { start = localStorage.getItem('lang') || ''; } catch (e) { start = ''; }
  if (!LANGS.some(l => l[0] === start)) {
    const wanted = (navigator.languages || [navigator.language || 'en']).map(x => String(x).slice(0, 2).toLowerCase());
    start = wanted.find(x => LANGS.some(l => l[0] === x)) || 'en';
  }
  applyLang(start, false);
})();
if (!HAS_I18N) updateBadge();

// Intro animation shown when entering the site (once per visit)
(function intro() {
  const el = document.getElementById('intro');
  const video = document.getElementById('intro-video');
  if (!el || el.hidden) return;
  const root = document.documentElement;
  const close = () => {
    if (el.classList.contains('hide')) return;
    el.classList.add('hide');
    root.classList.remove('intro-open');
    try { sessionStorage.setItem('intro-seen', '1'); } catch (e) { /* ignore */ }
    setTimeout(() => { el.hidden = true; video.pause(); }, 1000);
  };
  root.classList.add('intro-open');
  document.getElementById('intro-skip').addEventListener('click', close);
  document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
  video.addEventListener('ended', () => setTimeout(close, 600));
  video.addEventListener('error', () => setTimeout(close, 2500));
  const started = video.play();
  if (started && started.catch) started.catch(() => setTimeout(close, 2500));
  setTimeout(close, 8000);
})();
