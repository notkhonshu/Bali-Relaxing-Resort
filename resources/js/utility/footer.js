const initFooterClock = () => {
    const clocks = document.querySelectorAll('[data-footer-clock]');

    if (!clocks.length) return;

    const format = new Intl.DateTimeFormat('en-GB', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
        timeZone: 'Asia/Makassar',
    });

    const tick = () => {
        const now = new Date();
        const time = format.format(now);

        clocks.forEach((clock) => {
            clock.textContent = time;
            clock.setAttribute('datetime', time);
        });
    };

    tick();
    window.setInterval(tick, 20000);
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFooterClock);
} else {
    initFooterClock();
}