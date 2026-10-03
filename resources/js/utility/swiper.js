const initType3 = (root) => {
    const SPEED = 800;

    const rooms = JSON.parse(root.dataset.rooms || '[]');
    const feature = root.querySelector('[data-type3-feature]');
    const list = root.querySelector('[data-type3-list]');
    const sliderEl = root.querySelector('[data-type3-slider]');
    const wrapper = root.querySelector('[data-type3-wrapper]');
    const template = root.querySelector('[data-type3-template]');
    const prev = root.querySelector('[data-type3-prev]');
    const next = root.querySelector('[data-type3-next]');

    if (!feature || !list || !sliderEl || !wrapper || !template) return;

    if (rooms.length < 2) {
        list.classList.add('hidden');
        return;
    }

    const total = rooms.length;

    let active = 0;
    let swiper = null;
    let busy = false;
    let ring = Array.from({ length: total - 1 }, (_, step) => step + 1);

    const baseParams = {
        speed: SPEED,
        grabCursor: true,
        watchOverflow: false,
        slidesPerView: 1.6,
        spaceBetween: 22,
        breakpoints: {
            640: { slidesPerView: 2.4 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
        },
    };

    const featureField = (name) => feature.querySelector(`[data-feature="${name}"]`);

    const wait = (ms) => new Promise((resolve) => window.setTimeout(resolve, ms));

    const preload = (url) =>
        new Promise((resolve) => {
            const img = new Image();
            img.onload = resolve;
            img.onerror = resolve;
            img.src = url;
        });

    const metaText = (room) => `Sized ${room.sized} | Total Rooms: ${room.total}`;

    const setFeatureText = (room) => {
        const cta = featureField('cta');

        featureField('title').textContent = room.title;
        featureField('subtitle').textContent = metaText(room);
        featureField('description').textContent = room.description;

        if (room.url) {
            cta.href = room.url;
            cta.textContent = room.cta;
            cta.classList.remove('hidden');
        } else {
            cta.classList.add('hidden');
        }
    };

    const swapImage = async (room) => {
        await preload(room.img.url);

        const current = featureField('img');
        const incoming = current.cloneNode();

        incoming.src = room.img.url;
        incoming.alt = room.img.alt;
        incoming.style.position = 'absolute';
        incoming.style.inset = '0';
        current.after(incoming);

        const fade = incoming.animate([{ opacity: 0 }, { opacity: 1 }], {
            duration: 800,
            easing: 'ease',
            fill: 'forwards',
        });

        await fade.finished;

        current.remove();
        incoming.style.position = '';
        incoming.style.inset = '';
        fade.cancel();
    };

    const animateFeature = async (index) => {
        const room = rooms[index];
        const block = featureField('title').parentElement;

        const leave = block.animate(
            [
                { opacity: 1, transform: 'translateX(0)' },
                { opacity: 0, transform: 'translateX(-24px)' },
            ],
            { duration: 300, easing: 'ease-in', fill: 'forwards' }
        );

        const image = swapImage(room);

        await leave.finished;
        setFeatureText(room);

        const enter = block.animate(
            [
                { opacity: 0, transform: 'translateX(24px)' },
                { opacity: 1, transform: 'translateX(0)' },
            ],
            { duration: 600, easing: 'cubic-bezier(0.22, 1, 0.36, 1)' }
        );

        leave.cancel();
        await Promise.all([enter.finished, image]);
    };

    const createItem = (index) => {
        const room = rooms[index];
        const node = template.content.firstElementChild.cloneNode(true);
        const img = node.querySelector('[data-item="img"]');

        node.dataset.index = index;
        img.src = room.img.url;
        img.alt = room.img.alt;
        node.querySelector('[data-item="title"]').textContent = room.title;
        node.querySelector('[data-item="subtitle"]').textContent = metaText(room);

        return node;
    };

    const isVisible = (rect, box) => rect.right > box.left + 1 && rect.left < box.right - 1;

    const transitionList = (clicked, previous, clickedEl, side) => {
        const box = sliderEl.getBoundingClientRect();
        const clickedRect = clickedEl.getBoundingClientRect();
        const slot = clickedRect.width + (swiper.params.spaceBetween || 0);

        const positions = new Map();
        Array.from(swiper.slides).forEach((el) => {
            positions.set(Number(el.dataset.index), el.getBoundingClientRect().left);
        });

        ring = ring.filter((room) => room !== clicked);
        clickedEl.remove();

        if (side === 'start') {
            ring.unshift(previous);
            wrapper.prepend(createItem(previous));
        } else {
            ring.push(previous);
            wrapper.appendChild(createItem(previous));
        }

        swiper.update();

        if (side === 'start') swiper.slideTo(0, 0, false);

        const direction = side === 'start' ? -1 : 1;

        Array.from(swiper.slides).forEach((el) => {
            const rect = el.getBoundingClientRect();
            if (!isVisible(rect, box)) return;

            const from = positions.get(Number(el.dataset.index));
            const isNew = from === undefined;
            const dx = isNew ? slot * direction : from - rect.left;
            if (!isNew && Math.abs(dx) < 1) return;

            el.animate(
                [
                    { transform: `translateX(${dx}px)`, opacity: isNew ? 0 : 1 },
                    { transform: 'translateX(0)', opacity: 1 },
                ],
                { duration: SPEED, easing: 'cubic-bezier(0.22, 1, 0.36, 1)' }
            );
        });
    };

    const select = async (index, clickedEl, side = 'end') => {
        if (index === active || busy) return;
        busy = true;

        const previous = active;
        active = index;

        transitionList(index, previous, clickedEl, side);

        await Promise.all([animateFeature(index), wait(SPEED)]);

        busy = false;
    };

    const onSlide = () => {
        if (busy) return;

        const box = sliderEl.getBoundingClientRect();
        let leftmost = null;
        let best = Infinity;

        Array.from(swiper.slides).forEach((el) => {
            const distance = Math.abs(el.getBoundingClientRect().left - box.left);
            if (distance < best) {
                best = distance;
                leftmost = el;
            }
        });

        if (leftmost) select(Number(leftmost.dataset.index), leftmost, 'end');
    };

    const renderList = () => {
        wrapper.replaceChildren();
        ring.forEach((roomIndex) => wrapper.appendChild(createItem(roomIndex)));

        swiper = new Swiper(sliderEl, {
            ...baseParams,
            loop: false,
            on: {
                slideChangeTransitionEnd: onSlide,
            },
        });
    };

    if (next) {
        next.addEventListener('click', () => {
            const el = wrapper.firstElementChild;
            if (el) select(Number(el.dataset.index), el, 'end');
        });
    }

    if (prev) {
        prev.addEventListener('click', () => {
            const el = wrapper.lastElementChild;
            if (el) select(Number(el.dataset.index), el, 'start');
        });
    }

    wrapper.addEventListener('click', (event) => {
        const item = event.target.closest('[data-type3-item]');
        if (!item) return;
        select(Number(item.dataset.index), item, 'end');
    });

    renderList();
};

const initType5 = (root) => {
    const SCROLL_PER_SLIDE = 0.6;

    const stage = root.querySelector('[data-type5-stage]');
    const slides = [...root.querySelectorAll('[data-type5-slide]')];
    const tabs = [...root.querySelectorAll('[data-type5-tab]')];
    const counter = root.querySelector('[data-type5-counter]');

    if (!stage || slides.length < 2 || root.dataset.ready) return;

    root.dataset.ready = 'true';

    const total = slides.length;
    const pad = (n) => String(n).padStart(2, '0');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const pinned = Boolean(window.gsap && window.ScrollTrigger);

    let current = 0;
    let desired = 0;
    let busy = false;
    let layer = 1;
    let trigger = null;

    const sync = (index) => {
        tabs.forEach((tab, i) => tab.classList.toggle('is-active', i === index));
        slides.forEach((slide, i) => slide.setAttribute('aria-hidden', i === index ? 'false' : 'true'));
        if (counter) counter.textContent = `${pad(index + 1)} / ${pad(total)}`;
    };

    const settle = () => {
        if (busy || desired === current) return;
        go(current + Math.sign(desired - current));
    };

    const go = (target) => {
        const index = (target + total) % total;
        if (index === current || busy) return;

        const from = slides[current];
        const to = slides[index];
        const direction = index > current ? 1 : -1;

        current = index;
        sync(index);

        if (!window.gsap) {
            from.classList.add('invisible');
            to.classList.remove('invisible');
            return;
        }

        busy = true;
        layer += 1;

        const fromContent = from.querySelector('[data-type5-content]');
        const toContent = to.querySelector('[data-type5-content]');
        const toImg = to.querySelector('[data-type5-img]');

        gsap.set(to, {
            zIndex: layer,
            autoAlpha: 1,
            clipPath: direction > 0 ? 'inset(0% 0% 0% 100%)' : 'inset(0% 100% 0% 0%)',
        });
        gsap.set(toImg, { scale: 1.2 });
        gsap.set(toContent, { y: 40, autoAlpha: 0 });

        const tl = gsap.timeline({
            defaults: { ease: 'power3.inOut' },
            onComplete: () => {
                gsap.set(from, { autoAlpha: 0 });
                gsap.set(fromContent, { y: 0, autoAlpha: 1 });
                busy = false;
                settle();
            },
        });

        tl.to(fromContent, { y: -30, autoAlpha: 0, duration: 0.5, ease: 'power2.in' }, 0)
            .to(to, { clipPath: 'inset(0% 0% 0% 0%)', duration: 1.1 }, 0)
            .to(toImg, { scale: 1, duration: 1.6, ease: 'power3.out' }, 0)
            .to(toContent, { y: 0, autoAlpha: 1, duration: 0.8, ease: 'power3.out' }, 0.55);

        if (reduceMotion) tl.timeScale(100);
    };

    const jump = (index) => {
        layer += 1;

        slides.forEach((slide, i) => {
            gsap.set(slide, {
                autoAlpha: i === index ? 1 : 0,
                zIndex: i === index ? layer : 0,
                clipPath: 'inset(0% 0% 0% 0%)',
            });
        });

        gsap.set(root.querySelectorAll('[data-type5-content]'), { y: 0, autoAlpha: 1 });
        gsap.set(root.querySelectorAll('[data-type5-img]'), { scale: 1 });

        current = index;
        desired = index;
        sync(index);
    };

    const scrollToSlide = (index) => {
        const clamped = Math.max(0, Math.min(total - 1, index));
        const top = trigger.start + (trigger.end - trigger.start) * (clamped / (total - 1));

        window.scrollTo({ top, behavior: reduceMotion ? 'auto' : 'smooth' });
    };

    const navigate = (index) => {
        if (pinned) scrollToSlide(index);
        else go(index);
    };

    if (pinned) {
        gsap.registerPlugin(ScrollTrigger);

        trigger = ScrollTrigger.create({
            trigger: root,
            start: 'top top',
            end: () => `+=${Math.round(root.offsetHeight * SCROLL_PER_SLIDE * (total - 1))}`,
            pin: true,
            anticipatePin: 1,
            invalidateOnRefresh: true,
            snap: {
                snapTo: 1 / (total - 1),
                duration: { min: 0.2, max: 0.6 },
                delay: 0.1,
                ease: 'power1.inOut',
            },
            onUpdate: (self) => {
                desired = Math.round(self.progress * (total - 1));
                settle();
            },
        });

        if (trigger.progress > 0.001) jump(Math.round(trigger.progress * (total - 1)));
    }

    tabs.forEach((tab, i) => tab.addEventListener('click', () => navigate(i)));

    let startX = null;

    stage.addEventListener('pointerdown', (e) => {
        startX = e.clientX;
    });

    stage.addEventListener('pointerup', (e) => {
        if (startX === null) return;
        const delta = e.clientX - startX;
        startX = null;
        if (Math.abs(delta) > 50) navigate((pinned ? desired : current) + (delta < 0 ? 1 : -1));
    });

    stage.addEventListener('pointercancel', () => {
        startX = null;
    });

    root.setAttribute('tabindex', '0');
    root.addEventListener('keydown', (e) => {
        const base = pinned ? desired : current;
        if (e.key === 'ArrowRight') navigate(base + 1);
        if (e.key === 'ArrowLeft') navigate(base - 1);
    });
};
const initType7 = (root) => {
    const sliderEl = root.querySelector('[data-type7-slider]');

    if (!sliderEl || sliderEl.swiper) return;

    const count = sliderEl.querySelectorAll('.swiper-slide').length;
    const delay = Number(sliderEl.dataset.autoplayDelay) || 3500;
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    new Swiper(sliderEl, {
        speed: 900,
        grabCursor: true,
        watchOverflow: false,
        loop: count > 4,
        rewind: count <= 4,
        slidesPerView: 1.3,
        slidesPerGroup: 1,
        spaceBetween: 20,
        autoplay: reduceMotion
            ? false
            : {
                delay,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
        breakpoints: {
            640: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
        },
    });
};

document.querySelectorAll('[data-type3]').forEach(initType3);
document.querySelectorAll('[data-type5]').forEach(initType5);
document.querySelectorAll('[data-type7]').forEach(initType7);