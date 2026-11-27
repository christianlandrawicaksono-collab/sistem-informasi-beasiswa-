import './bootstrap';
import { animate, inView, scroll, stagger, hover, press } from 'framer-motion/dom';

const NOMU_EASE = [0.16, 1, 0.3, 1];

document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // 1. Mobile Navigation Drawer Toggle
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu-drawer');
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            menuToggle.setAttribute('aria-expanded', String(isHidden));
            if (isHidden && !prefersReducedMotion) {
                animate(mobileMenu, { opacity: [0, 1], y: [-8, 0] }, { duration: 0.25, ease: NOMU_EASE });
            }
        });
    }

    // 2. Interactive Flow / Journey Step Tabs (Landing Page)
    const journeyBtns = document.querySelectorAll('[data-journey-step]');
    const journeyPanels = document.querySelectorAll('[data-journey-panel]');
    if (journeyBtns.length > 0 && journeyPanels.length > 0) {
        journeyBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-journey-step');
                journeyBtns.forEach((b) => {
                    const active = b.getAttribute('data-journey-step') === target;
                    b.setAttribute('data-active', active ? 'true' : 'false');
                });
                journeyPanels.forEach((panel) => {
                    const match = panel.getAttribute('data-journey-panel') === target;
                    if (match) {
                        panel.classList.remove('hidden');
                        if (!prefersReducedMotion) {
                            animate(panel, { opacity: [0, 1], y: [8, 0] }, { duration: 0.3, ease: NOMU_EASE });
                        }
                    } else {
                        panel.classList.add('hidden');
                    }
                });
            });
        });
    }

    if (prefersReducedMotion) {
        return;
    }

    // 3. Top Scroll Progress Line
    const scrollBar = document.querySelector('[data-motion="scroll-progress"]');
    if (scrollBar) {
        scroll(animate(scrollBar, { scaleX: [0, 1] }, { ease: 'linear' }));
    }

    // 4. Hero Stagger Entrance (Immediate above-the-fold choreography)
    const heroItems = document.querySelectorAll('[data-motion="hero-item"]');
    if (heroItems.length > 0) {
        animate(
            heroItems,
            { opacity: [0, 1], y: [20, 0] },
            { duration: 0.65, delay: stagger(0.07), ease: NOMU_EASE }
        );
    }

    // 5. Scroll-Triggered Section Reveals
    document.querySelectorAll('[data-motion="reveal"]').forEach((el) => {
        el.style.opacity = '0';
        inView(
            el,
            () => {
                animate(
                    el,
                    { opacity: [0, 1], y: [18, 0] },
                    { duration: 0.55, ease: NOMU_EASE }
                );
            },
            { amount: 0.1 }
        );
    });

    // 6. Staggered Bento / Scholarship Card Grids
    document.querySelectorAll('[data-motion="stagger-grid"]').forEach((grid) => {
        const cards = grid.querySelectorAll('[data-motion-card]');
        if (cards.length === 0) return;

        cards.forEach((c) => {
            c.style.opacity = '0';
        });

        inView(
            grid,
            () => {
                animate(
                    cards,
                    { opacity: [0, 1], y: [20, 0], scale: [0.98, 1] },
                    { duration: 0.5, delay: stagger(0.06), ease: NOMU_EASE }
                );
            },
            { amount: 0.08 }
        );
    });

    // 7. Smooth Table Row Stagger
    document.querySelectorAll('[data-motion="table-stagger"]').forEach((tbody) => {
        const rows = tbody.querySelectorAll('tr');
        if (rows.length === 0) return;

        inView(
            tbody,
            () => {
                animate(
                    rows,
                    { opacity: [0, 1], x: [-8, 0] },
                    { duration: 0.38, delay: stagger(0.04), ease: NOMU_EASE }
                );
            },
            { amount: 0.05 }
        );
    });

    // 8. Progress Bar Smooth Fill
    document.querySelectorAll('[data-motion="progress-fill"]').forEach((bar) => {
        const targetWidth = bar.getAttribute('data-width') || '0%';
        bar.style.width = '0%';
        inView(bar, () => {
            animate(bar, { width: [0, targetWidth] }, { duration: 0.75, ease: NOMU_EASE });
        });
    });

    // 9. Tactile Hover & Press Physics via Framer Motion Gestures
    hover('[data-motion="card-hover"]', (element) => {
        animate(element, { y: -4 }, { duration: 0.22, ease: NOMU_EASE });
        return () => animate(element, { y: 0 }, { duration: 0.22, ease: NOMU_EASE });
    });

    press('[data-motion="pill-press"]', (element) => {
        animate(element, { scale: 0.97 }, { duration: 0.12, ease: NOMU_EASE });
        return () => animate(element, { scale: 1 }, { duration: 0.18, ease: NOMU_EASE });
    });
});
