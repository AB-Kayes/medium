import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Initialize dark mode on page load
(function () {
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();

Alpine.data('darkMode', () => ({
    dark: document.documentElement.classList.contains('dark'),

    init() {
        // Sync with current state on init
        this.dark = document.documentElement.classList.contains('dark');
    },

    toggle() {
        if (this.dark) {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
            this.dark = false;
        } else {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
            this.dark = true;
        }
    },

    isDark() {
        return this.dark;
    }
}));

Alpine.start();
