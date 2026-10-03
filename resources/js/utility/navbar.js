const navbar = document.querySelector('[data-navbar]');

if (navbar) {
    const SCROLL_THRESHOLD = 20;

    const toggle = navbar.querySelector('[data-navbar-toggle]');
    const mobileMenu = navbar.querySelector('[data-navbar-mobile]');

    const isMenuOpen = () => !!mobileMenu && !mobileMenu.classList.contains('hidden');
    const setScrolled = () => {
        const scrolled = window.scrollY > SCROLL_THRESHOLD || isMenuOpen();
        navbar.dataset.scrolled = scrolled ? 'true' : 'false';
    };

    const setMenu = (open) => {
        if (!toggle || !mobileMenu) return;

        mobileMenu.classList.toggle('hidden', !open);
        toggle.setAttribute('aria-expanded', String(open));
        setScrolled();
    };

    setScrolled();
    window.addEventListener('scroll', setScrolled, { passive: true });

    if (toggle && mobileMenu) {
        toggle.addEventListener('click', () => setMenu(!isMenuOpen()));
        mobileMenu.addEventListener('click', (e) => {
            if (e.target.closest('a')) setMenu(false);
        });
        window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => {
            if (e.matches) setMenu(false);
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isMenuOpen()) {
                setMenu(false);
                toggle.focus();
            }
        });
    }
    navbar.querySelectorAll('[data-navbar-subtoggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const submenu = btn.closest('li')?.querySelector('[data-navbar-submenu]');
            if (!submenu) return;

            const open = btn.getAttribute('aria-expanded') === 'true';

            btn.setAttribute('aria-expanded', String(!open));
            btn.querySelector('svg')?.classList.toggle('rotate-180', !open);
            submenu.classList.toggle('hidden', open);
        });
    });
}