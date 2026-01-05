import '../css/app.css';
import './bootstrap';

// Dark/Light toggle (CSP-safe, no inline)
(() => {
  const html = document.documentElement;

  function applyTheme(theme) {
    const isDark = theme === 'dark';
    html.classList.toggle('dark', isDark);
    localStorage.setItem('theme', theme);

    const icon = document.getElementById('themeIcon');
    const text = document.getElementById('themeText');
    if (icon) icon.textContent = isDark ? '☀️' : '🌙';
    if (text) text.textContent = isDark ? 'Light' : 'Dark';
  }

  // init (runs when module executed)
  const saved = localStorage.getItem('theme');
  const prefersDark = window.matchMedia?.('(prefers-color-scheme: dark)')?.matches;
  applyTheme(saved ?? (prefersDark ? 'dark' : 'light'));

  // bind button (works even if element already exists)
  function bind() {
    const btn = document.getElementById('themeToggle');
    if (!btn || btn.dataset.bound === '1') return;
    btn.dataset.bound = '1';

    btn.addEventListener('click', () => {
      const isDarkNow = html.classList.contains('dark');
      applyTheme(isDarkNow ? 'light' : 'dark');
    });
  }

  bind();
  document.addEventListener('DOMContentLoaded', bind);
})();
