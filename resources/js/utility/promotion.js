const initType10 = (root) => {
    if (root.dataset.ready) return;
    root.dataset.ready = 'true';

    const links = [...root.querySelectorAll('[data-type10-link]')];
    const panels = [...root.querySelectorAll('[data-type10-panel]')];
    const excerpt = root.querySelector('[data-type10-excerpt]');
    const cta = root.querySelector('[data-type10-cta]');
    const lightbox = root.querySelector('[data-type10-lightbox]');
    const track = root.querySelector('[data-type10-track]');
    const aside = root.querySelector('[data-type10-aside]');
    const column = root.querySelector('[data-type10-column]');

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let current = 0;
    let locked = false;
    let lockTimer = null;

    const getOffset = () =>
        parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--type10-offset')) || 0;

    const isDesktop = () => Boolean(track) && getComputedStyle(track).display !== 'none';

    const fade = (el) => {
        if (!el || reduceMotion) return;
        el.animate?.([{ opacity: 0 }, { opacity: 1 }], { duration: 400, easing: 'ease' });
    };

    if (lightbox) {
        const lbImage = lightbox.querySelector('img');

        root.querySelectorAll('[data-type10-zoom]').forEach((button) => {
            button.addEventListener('click', () => {
                const source = button.querySelector('img');

                lbImage.src = source.currentSrc || source.src;
                lbImage.alt = source.alt;
                lightbox.showModal();
            });
        });

        lightbox.addEventListener('click', () => lightbox.close());
    }

    if (!links.length || !panels.length) return;

    const lockExcerptHeight = () => {
        if (!excerpt) return;

        const width = excerpt.offsetWidth;
        if (!width) return;

        const probe = excerpt.cloneNode(false);
        probe.removeAttribute('data-type10-excerpt');
        probe.setAttribute('aria-hidden', 'true');
        probe.style.cssText = `position:absolute;visibility:hidden;pointer-events:none;min-height:0;height:auto;margin:0;width:${width}px`;
        excerpt.parentElement.appendChild(probe);

        let max = 0;
        links.forEach((link) => {
            probe.textContent = link.dataset.description || '';
            max = Math.max(max, probe.offsetHeight);
        });

        probe.remove();
        excerpt.style.minHeight = `${max}px`;
    };

    const layout = () => {
        if (!track || !aside || !column) return;

        if (!isDesktop()) {
            track.style.height = '';
            aside.style.removeProperty('--type10-top');
            return;
        }

        lockExcerptHeight();

        const offset = getOffset();
        const asideH = aside.offsetHeight;
        const visibleH = window.innerHeight - offset;
        const centered = offset + Math.max(24, (visibleH - asideH) / 2);

        aside.style.setProperty('--type10-top', `${Math.round(centered)}px`);

        const lastPanel = panels[panels.length - 1];
        const lastTop = lastPanel.getBoundingClientRect().top - column.getBoundingClientRect().top;
        const height = Math.min(column.offsetHeight, lastTop + asideH);

        track.style.height = `${Math.max(Math.round(height), asideH)}px`;
    };

    const setActive = (index) => {
        if (index === current) return;
        current = index;

        links.forEach((link, i) => {
            const active = i === index;

            link.classList.toggle('is-active', active);

            if (active) link.setAttribute('aria-current', 'true');
            else link.removeAttribute('aria-current');
        });

        const { description, ctaLink, ctaText } = links[index].dataset;

        if (excerpt) {
            excerpt.textContent = description || '';
            fade(excerpt);
        }

        if (cta) {
            if (ctaLink) {
                cta.href = ctaLink;
                if (ctaText) cta.textContent = ctaText;
                cta.classList.remove('hidden');
                fade(cta);
            } else {
                cta.classList.add('hidden');
            }
        }
    };

    const update = () => {
        if (locked) return;

        const offset = getOffset();
        const line = offset + (window.innerHeight - offset) / 2;

        let best = 0;
        let bestDistance = Infinity;

        panels.forEach((panel, i) => {
            const rect = panel.getBoundingClientRect();
            const inside = line >= rect.top && line <= rect.bottom;
            const distance = inside ? 0 : Math.min(Math.abs(rect.top - line), Math.abs(rect.bottom - line));

            if (distance < bestDistance) {
                bestDistance = distance;
                best = i;
            }
        });

        setActive(best);
    };

    const holdLock = () => {
        locked = true;
        window.clearTimeout(lockTimer);
        lockTimer = window.setTimeout(() => {
            locked = false;
            update();
        }, 150);
    };

    let ticking = false;

    const onScroll = () => {
        if (locked) holdLock();
        if (ticking) return;
        ticking = true;

        requestAnimationFrame(() => {
            ticking = false;
            update();
        });
    };

    let layoutQueued = false;

    const queueLayout = () => {
        if (layoutQueued) return;
        layoutQueued = true;

        requestAnimationFrame(() => {
            layoutQueued = false;
            layout();
            update();
        });
    };

    document.addEventListener('scroll', onScroll, { passive: true, capture: true });
    window.addEventListener('resize', queueLayout);
    window.addEventListener('load', queueLayout);
    document.fonts?.ready.then(queueLayout);

    if ('ResizeObserver' in window) {
        const ro = new ResizeObserver(queueLayout);
        if (column) ro.observe(column);
        if (aside) ro.observe(aside);
    }

    root.querySelectorAll('.type10-flyer').forEach((img) => {
        if (!img.complete) img.addEventListener('load', queueLayout, { once: true });
    });

    links.forEach((link, i) => {
        link.addEventListener('click', (e) => {
            e.preventDefault();

            setActive(i);
            holdLock();

            panels[i].scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
        });
    });

    root._type10Update = () => {
        layout();
        update();
    };

    layout();
    update();
};

const bootType10 = () => document.querySelectorAll('[data-type10]').forEach(initType10);

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', bootType10);
else bootType10();