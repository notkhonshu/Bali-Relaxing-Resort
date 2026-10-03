const initType12 = (root) => {
    if (root.dataset.ready) return;
    root.dataset.ready = 'true';

    const items = [...root.querySelectorAll('[data-type12-item]')];
    const lightbox = root.querySelector('[data-type12-lightbox]');
    const image = root.querySelector('[data-type12-image]');
    const counter = root.querySelector('[data-type12-counter]');

    if (!items.length || !lightbox || !image) return;

    const total = items.length;
    let current = 0;

    const show = (index) => {
        current = (index + total) % total;

        const source = items[current].querySelector('img');

        image.src = source.currentSrc || source.src;
        image.alt = source.alt;

        if (counter) counter.textContent = `${current + 1} / ${total}`;
    };

    const open = (index) => {
        show(index);
        if (!lightbox.open) lightbox.showModal();
    };

    items.forEach((item, i) => item.addEventListener('click', () => open(i)));

    root.querySelector('[data-type12-prev]')?.addEventListener('click', () => show(current - 1));
    root.querySelector('[data-type12-next]')?.addEventListener('click', () => show(current + 1));
    root.querySelector('[data-type12-close]')?.addEventListener('click', () => lightbox.close());

    /* Click on the dark backdrop closes the viewer */
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) lightbox.close();
    });

    /* Arrow keys only while the viewer is open (Escape is handled natively by <dialog>) */
    lightbox.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') show(current + 1);
        if (e.key === 'ArrowLeft') show(current - 1);
    });

    /* Swipe on touch devices */
    let startX = null;

    lightbox.addEventListener('pointerdown', (e) => {
        startX = e.clientX;
    });

    lightbox.addEventListener('pointerup', (e) => {
        if (startX === null) return;

        const delta = e.clientX - startX;
        startX = null;

        if (Math.abs(delta) > 50) show(current + (delta < 0 ? 1 : -1));
    });

    lightbox.addEventListener('pointercancel', () => {
        startX = null;
    });
};

const bootType12 = () => document.querySelectorAll('[data-type12]').forEach(initType12);

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', bootType12);
else bootType12();