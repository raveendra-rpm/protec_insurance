document.addEventListener('DOMContentLoaded', () => {

    // ── OUR EDGE ─────────────────────────────────────────
    const edgeTabs = document.querySelectorAll('.edge-tab');
    const edgePanels = document.querySelectorAll('.edge-panel');
    const edgeDots = document.querySelectorAll('.edge-dot');

    function activateEdge(target) {
        // Tabs
        edgeTabs.forEach(t => t.classList.toggle('active', t.dataset.target === target));
        // Panels
        edgePanels.forEach(p => p.classList.toggle('active', p.id === target));
        // Dots
        edgeDots.forEach(d => d.classList.toggle('active', d.dataset.target === target));
    }

    edgeTabs.forEach(tab => {
        tab.addEventListener('click', () => activateEdge(tab.dataset.target));
    });

    edgeDots.forEach(dot => {
        dot.addEventListener('click', () => activateEdge(dot.dataset.target));
    });

    // ── BUILD INSURANCE TABS ──────────────────────────────
    const buildTabs = document.querySelectorAll('.build-tab');
    const buildPanels = document.querySelectorAll('.build-panel');
    buildTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            buildTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const target = tab.dataset.tab;
            buildPanels.forEach(panel => {
                panel.classList.toggle('active', panel.id === `panel-${target}`);
            });
        });
    });

    // ── PRODUCT CARDS HOVER ───────────────────────────────
    const productCards = document.querySelectorAll('.product-cards .card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            productCards.forEach(c => c.classList.remove('active'));
            card.classList.add('active');
        });
    });

    // ── OUR STORY SLIDER ─────────────────────────────────
    const storySlides = document.querySelectorAll('.story-slide');
    const storyDots = document.querySelectorAll('.story-dot');
    const storyPrev = document.getElementById('story-prev');
    const storyNext = document.getElementById('story-next');
    let currentStorySlide = 0;

    function goToStorySlide(index) {
        storySlides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        storyDots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
        currentStorySlide = index;
    }

    if (storyPrev && storyNext) {
        storyPrev.addEventListener('click', () => {
            let index = currentStorySlide - 1;
            if (index < 0) index = storySlides.length - 1;
            goToStorySlide(index);
        });

        storyNext.addEventListener('click', () => {
            let index = currentStorySlide + 1;
            if (index >= storySlides.length) index = 0;
            goToStorySlide(index);
        });

        storyDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                goToStorySlide(index);
            });
        });
    }

    // ── LENIS SMOOTH SCROLLING ────────────────────────────
    if (typeof Lenis !== 'undefined') {
        const lenis = new Lenis();

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }

        requestAnimationFrame(raf);

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (targetId && targetId !== '#') {
                    const targetEl = document.querySelector(targetId);
                    if (targetEl) {
                        e.preventDefault();

                        // Close mobile menu if active
                        let delay = 0;
                        const burgerBtn = document.querySelector("#mobile-menu-btn");
                        if (burgerBtn && burgerBtn.classList.contains('active')) {
                            burgerBtn.click();
                            delay = 400; // Wait for menu layout to restore
                        }

                        setTimeout(() => {
                            if (window.innerWidth <= 768) {
                                // On mobile, sometimes Lenis needs a nudge or we use native scroll
                                targetEl.scrollIntoView({ behavior: 'smooth' });
                            } else {
                                lenis.scrollTo(targetEl, {
                                    duration: 1.5,
                                    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t))
                                });
                            }
                        }, delay);
                    }
                }
            });
        });
    }
});

// ── MOBILE MENU GSAP ANIMATION ────────────────────────────
window.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap !== 'undefined') {
        const tl6 = gsap.timeline({ paused: true });

        // Animation des lignes extérieures
        tl6.to(["#line1_6", "#line3_6"], {
            attr: { x1: "100", x2: "100" },
            duration: 0.6,
            ease: "elastic.out(1, 0.3)"
        }, 0)
            .to("#line2_6", {
                scale: 0,
                opacity: 0,
                transformOrigin: "center center",
                duration: 0.3,
                ease: "power2.inOut"
            }, 0)
            .to(["#point1_6", "#point2_6"], {
                opacity: 1,
                duration: 0.2
            }, 0.3)
            .to("#point1_6", {
                motionPath: {
                    path: [
                        { x: 0, y: 0 },
                        { x: 15, y: -15 },
                        { x: 0, y: -30 },
                        { x: -15, y: -15 },
                        { x: 0, y: 0 }
                    ],
                    curviness: 1.5,
                    autoRotate: true
                },
                duration: 1,
                repeat: 1,
                ease: "power1.inOut"
            }, 0.3)
            .to("#point2_6", {
                motionPath: {
                    path: [
                        { x: 0, y: 0 },
                        { x: -15, y: 15 },
                        { x: 0, y: 30 },
                        { x: 15, y: 15 },
                        { x: 0, y: 0 }
                    ],
                    curviness: 1.5,
                    autoRotate: true
                },
                duration: 1,
                repeat: 1,
                ease: "power1.inOut"
            }, 0.3)
            .to(["#point1_6", "#point2_6"], {
                scale: 0.5,
                opacity: 0,
                duration: 0.3,
                ease: "power2.inOut"
            }, 2.3)
            .to("#line1_6", {
                attr: { x1: "50", x2: "150", y1: "100", y2: "100" },
                rotation: 45,
                svgOrigin: "100 100",
                duration: 0.5,
                ease: "back.out(1.5)"
            }, 2.3)
            .to("#line3_6", {
                attr: { x1: "50", x2: "150", y1: "100", y2: "100" },
                rotation: -45,
                svgOrigin: "100 100",
                duration: 0.5,
                ease: "back.out(1.5)"
            }, 2.3);

        const burgerBtn = document.querySelector("#mobile-menu-btn");
        const navLinks = document.querySelector(".nav-links");
        const navItems = document.querySelectorAll(".nav-links li");
        const svgLines = document.querySelectorAll("#pointsBurger line");

        if (burgerBtn && navLinks) {
            burgerBtn.addEventListener("click", () => {
                const isOpen = burgerBtn.classList.toggle('active');
                navLinks.classList.toggle('open');
                document.body.classList.toggle('no-scroll', isOpen);

                if (isOpen) {
                    // Play hamburger to X animation
                    tl6.play();
                    // Turn SVG stroke white after short delay
                    gsap.to(svgLines, { stroke: "#ffffff", duration: 0.3, delay: 0.1 });
                    // Stagger nav items in
                    gsap.fromTo(navItems,
                        { opacity: 0, x: -30 },
                        { opacity: 1, x: 0, duration: 0.4, stagger: 0.08, delay: 0.2, ease: "power2.out" }
                    );
                } else {
                    // Reverse to hamburger
                    tl6.reverse();
                    // Turn SVG stroke back to dark
                    gsap.to(svgLines, { stroke: "#333333", duration: 0.3 });
                    // Fade nav items out
                    gsap.to(navItems, { opacity: 0, x: -20, duration: 0.2, stagger: 0.04, ease: "power2.in" });
                }
            });
        }
    }
});

// ── GSAP SCROLLTRIGGER ANIMATIONS ─────────────────────────
window.addEventListener('load', () => {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        // ─── HELPER: split text into word spans ───────────────
        function splitWords(selector) {
            document.querySelectorAll(selector).forEach(el => {
                // preserve inner html spans (like highlight-line) — skip those
                if (el.dataset.split === 'done') return;
                el.dataset.split = 'done';

                const htmlContent = el.innerHTML;
                const lines = htmlContent.split(/<br\s*\/?>/i);

                const wrappedLines = lines.map(line => {
                    const words = line.trim().split(/\s+/);
                    return words.map(w =>
                        w ? `<span class="gsap-word-wrap"><span class="gsap-word">${w}</span></span>` : ''
                    ).join(' ');
                });

                el.innerHTML = wrappedLines.join('<br>');
            });
        }

        // ─── HELPER: split each char ──────────────────────────
        function splitChars(selector) {
            document.querySelectorAll(selector).forEach(el => {
                if (el.dataset.split === 'done') return;
                el.dataset.split = 'done';
                const text = el.innerText;
                const chars = text.split('');
                el.innerHTML = chars.map(c => {
                    if (c === '\n') return '<br>';
                    if (c.trim() === '') return ' ';
                    return `<span class="gsap-char" style="display:inline-block">${c}</span>`;
                }).join('');
            });
        }

        // ─── CSS for word-wrap masking ─────────────────────────
        const style = document.createElement('style');
        style.textContent = `
            .gsap-word-wrap {
                display: inline-block;
                overflow: hidden;
                vertical-align: bottom;
            }
            .gsap-word {
                display: inline-block;
            }
        `;
        document.head.appendChild(style);

        // ══════════════════════════════════════════════════════
        // HERO SECTION — cinematic entrance
        // ══════════════════════════════════════════════════════
        const heroTl = gsap.timeline({ delay: 0.15 });

        // Subtitle: fade + blur in
        heroTl.fromTo('.hero-top-subtitle p',
            { opacity: 0, filter: 'blur(8px)', y: -12 },
            { opacity: 1, filter: 'blur(0px)', y: 0, duration: 0.9, ease: 'power3.out' }
        );

        // Title lines: clip-path reveal (slide up from bottom)
        heroTl.fromTo('.hero-title span',
            { clipPath: 'inset(100% 0% 0% 0%)', y: 40 },
            {
                clipPath: 'inset(0% 0% 0% 0%)',
                y: 0,
                duration: 0.85,
                stagger: 0.18,
                ease: 'expo.out'
            }, '-=0.5'
        );

        // Buttons: scale + fade
        heroTl.fromTo('.hero-buttons .btn',
            { opacity: 0, scale: 0.8, y: 16 },
            { opacity: 1, scale: 1, y: 0, duration: 0.6, stagger: 0.15, ease: 'back.out(2)' },
            '-=0.4'
        );

        // Bottom features: slide up with stagger
        heroTl.fromTo('.hero-feature',
            { opacity: 0, y: 30 },
            { opacity: 1, y: 0, duration: 0.7, stagger: 0.15, ease: 'power2.out' },
            '-=0.4'
        );

        // Hero Art Overlay Load Animation
        heroTl.to(".hero-art-overlay", {
            clipPath: "inset(0% 0% 0% 0%)",
            duration: 1.5,
            ease: "power3.inOut"
        }, "-=0.8");

        // ══════════════════════════════════════════════════════
        // OUR EDGE SECTION
        // ══════════════════════════════════════════════════════

        // Title: char-by-char reveal
        splitChars('.our-edge-title');
        gsap.from('.our-edge-title .gsap-char', {
            scrollTrigger: { trigger: '.our-edge', start: 'top 80%' },
            opacity: 0,
            y: 40,
            rotateX: -90,
            stagger: 0.04,
            duration: 0.6,
            ease: 'back.out(2)'
        });

        // Tabs bar: slide from left
        gsap.from('.edge-tabs', {
            scrollTrigger: { trigger: '.our-edge', start: 'top 75%' },
            opacity: 0, x: -40, duration: 0.7, ease: 'power3.out'
        });

        // Panel content: clip-path reveal
        gsap.from('.edge-panel.active .edge-panel-left', {
            scrollTrigger: { trigger: '.our-edge', start: 'top 65%' },
            clipPath: 'inset(0% 100% 0% 0%)',
            opacity: 0,
            duration: 0.9,
            ease: 'expo.out'
        });
        gsap.from('.edge-panel.active .edge-panel-right', {
            scrollTrigger: { trigger: '.our-edge', start: 'top 65%' },
            clipPath: 'inset(0% 0% 0% 100%)',
            opacity: 0,
            duration: 0.9,
            ease: 'expo.out',
            delay: 0.15
        });

        // ══════════════════════════════════════════════════════
        // DESIGNED TO FEEL DIFFERENT SECTION
        // ══════════════════════════════════════════════════════

        // Highlight lines: scrub-based stagger reveal
        gsap.to('.highlight-line', {
            scrollTrigger: {
                trigger: '.designed-main-title',
                start: 'top 85%',
                end: 'bottom 40%',
                scrub: 1.2
            },
            opacity: 1,
            y: 0,
            stagger: 0.15,
            ease: 'none'
        });

        // Set initial state for highlight lines
        gsap.set('.highlight-line', { opacity: 0.1, y: 20 });

        // Icon: scale pop
        gsap.from('.designed-icon-wrapper', {
            scrollTrigger: { trigger: '.designed-header', start: 'top 75%' },
            scale: 0, opacity: 0, rotation: -180, duration: 1.1, ease: 'back.out(2)'
        });

        // Bottom row: fade slide
        gsap.from('.designed-bottom-row > *', {
            scrollTrigger: { trigger: '.designed-different', start: 'top 70%' },
            opacity: 0, y: 30, stagger: 0.15, duration: 0.8, ease: 'power2.out'
        });

        // Product cards: staggered clip-path from bottom
        gsap.from('.product-cards .card', {
            scrollTrigger: { trigger: '.product-cards', start: 'top 85%' },
            clipPath: 'inset(100% 0% 0% 0%)',
            opacity: 0,
            duration: 0.85,
            stagger: 0.15,
            ease: 'expo.out'
        });

        // ══════════════════════════════════════════════════════
        // START WITH CUSTOMER SECTION
        // ══════════════════════════════════════════════════════
        gsap.from('.start-content .small-title', {
            scrollTrigger: { trigger: '.start-customer', start: 'top 80%' },
            opacity: 0, letterSpacing: '0.5em', duration: 1, ease: 'power3.out'
        });

        // Word-by-word reveal for h2
        splitWords('.start-content h2');
        gsap.from('.start-content h2 .gsap-word', {
            scrollTrigger: { trigger: '.start-customer', start: 'top 75%' },
            opacity: 0, y: 50, rotateX: -60,
            stagger: 0.06, duration: 0.7, ease: 'back.out(1.5)'
        });

        gsap.from('.start-content .start-desc', {
            scrollTrigger: { trigger: '.start-customer', start: 'top 65%' },
            opacity: 0, y: 20, duration: 0.8, ease: 'power2.out'
        });

        // ══════════════════════════════════════════════════════
        // INSURANCE IN INDIA SECTION
        // ══════════════════════════════════════════════════════

        // Big title: word reveal
        splitWords('.insurance-india-left .section-title');
        gsap.from('.insurance-india-left .section-title .gsap-word', {
            scrollTrigger: { trigger: '.insurance-india', start: 'top 80%' },
            opacity: 0, y: 40, stagger: 0.04, duration: 0.6, ease: 'power3.out'
        });

        // Middle icon: spin in
        gsap.from('.floating-icon.icon-swirl', {
            scrollTrigger: { trigger: '.insurance-india', start: 'top 75%' },
            scale: 0, opacity: 0, rotation: 180, duration: 1.2, ease: 'back.out(1.5)'
        });

        // Right text blocks: staggered slide
        gsap.from('.insurance-india-right > *', {
            scrollTrigger: { trigger: '.insurance-india', start: 'top 70%' },
            opacity: 0, x: 40, stagger: 0.2, duration: 0.7, ease: 'power2.out'
        });

        // ══════════════════════════════════════════════════════
        // BUILD INSURANCE SECTION
        // ══════════════════════════════════════════════════════

        // Title: char-by-char
        splitChars('.build-main-title');
        gsap.from('.build-main-title .gsap-char', {
            scrollTrigger: { trigger: '.build-insurance', start: 'top 80%' },
            opacity: 0, y: 30, stagger: 0.025, duration: 0.5, ease: 'power2.out'
        });

        // Tabs: clip reveal
        gsap.from('.build-tabs', {
            scrollTrigger: { trigger: '.build-insurance', start: 'top 75%' },
            clipPath: 'inset(0% 100% 0% 0%)',
            opacity: 0, duration: 0.8, ease: 'expo.out'
        });

        // Features: stagger up
        gsap.from('.partner-features .p-feature', {
            scrollTrigger: { trigger: '.build-panel.active', start: 'top 80%' },
            opacity: 0, y: 30, stagger: 0.12, duration: 0.65, ease: 'power2.out'
        });
    }

    // ── GO TO TOP BUTTON ──────────────────────────────
    const goToTopBtn = document.getElementById('goToTopBtn');
    if (goToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                goToTopBtn.classList.add('show');
            } else {
                goToTopBtn.classList.remove('show');
            }
        });

        goToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
