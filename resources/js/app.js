// Bootstrap
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Chart.js
import Chart from 'chart.js/auto';
window.Chart = Chart;

// =============================================
// Theme Toggle (Dark Mode)
// =============================================
const THEME_KEY = 'shortlink-theme';

function getPreferredTheme() {
    const stored = localStorage.getItem(THEME_KEY);
    if (stored) return stored;
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

function setTheme(theme) {
    document.documentElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem(THEME_KEY, theme);
    updateThemeIcon(theme);
}

function updateThemeIcon(theme) {
    const btn = document.getElementById('themeToggle');
    if (!btn) return;
    const icon = btn.querySelector('i');
    if (!icon) return;
    icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
}

// Apply theme immediately
setTheme(getPreferredTheme());

document.addEventListener('DOMContentLoaded', () => {
    // Theme toggle button
    const themeBtn = document.getElementById('themeToggle');
    if (themeBtn) {
        updateThemeIcon(getPreferredTheme());
        themeBtn.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-bs-theme');
            setTheme(current === 'dark' ? 'light' : 'dark');
        });
    }

    // =============================================
    // Sidebar Toggle (Mobile)
    // =============================================
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            if (sidebarOverlay) sidebarOverlay.classList.toggle('show');
        });

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        }
    }

    // =============================================
    // Copy to Clipboard
    // =============================================
    document.querySelectorAll('[data-copy]').forEach(btn => {
        btn.addEventListener('click', () => {
            const text = btn.getAttribute('data-copy');
            navigator.clipboard.writeText(text).then(() => {
                const originalHTML = btn.innerHTML;
                btn.classList.add('copied');
                btn.innerHTML = '<i class="bi bi-check2"></i> Copied!';
                setTimeout(() => {
                    btn.classList.remove('copied');
                    btn.innerHTML = originalHTML;
                }, 2000);
            });
        });
    });

    // =============================================
    // Toast Notifications
    // =============================================
    const toastContainer = document.getElementById('toastContainer');
    if (toastContainer) {
        toastContainer.querySelectorAll('.toast').forEach(toastEl => {
            const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
            toast.show();
        });
    }

    // =============================================
    // Slug Availability Check
    // =============================================
    const slugInput = document.getElementById('slugInput');
    const slugFeedback = document.getElementById('slugFeedback');
    let slugTimeout = null;

    if (slugInput && slugFeedback) {
        slugInput.addEventListener('input', () => {
            clearTimeout(slugTimeout);
            const slug = slugInput.value.trim();

            if (!slug) {
                slugFeedback.innerHTML = '';
                slugInput.classList.remove('is-valid', 'is-invalid');
                return;
            }

            slugFeedback.innerHTML = '<span class="text-muted"><i class="bi bi-hourglass-split"></i> Checking...</span>';

            slugTimeout = setTimeout(() => {
                fetch(`/api/check-slug?slug=${encodeURIComponent(slug)}`)
                    .then(r => r.json())
                    .then(data => {
                        if (data.available) {
                            slugInput.classList.remove('is-invalid');
                            slugInput.classList.add('is-valid');
                            slugFeedback.innerHTML = '<span class="text-success"><i class="bi bi-check-circle-fill"></i> Available!</span>';
                        } else {
                            slugInput.classList.remove('is-valid');
                            slugInput.classList.add('is-invalid');
                            slugFeedback.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle-fill"></i> Already taken</span>';
                        }
                    })
                    .catch(() => {
                        slugFeedback.innerHTML = '';
                    });
            }, 400);
        });
    }

    // =============================================
    // Animated Counters
    // =============================================
    document.querySelectorAll('[data-count]').forEach(el => {
        const target = parseInt(el.getAttribute('data-count'), 10);
        const duration = 1000;
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = Math.floor(current).toLocaleString();
        }, 16);
    });

    // =============================================
    // Confirm Delete
    // =============================================
    document.querySelectorAll('[data-confirm-delete]').forEach(form => {
        form.addEventListener('submit', (e) => {
            if (!confirm('Are you sure you want to delete this link? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
});
