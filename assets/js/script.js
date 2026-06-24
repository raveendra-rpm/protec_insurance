document.addEventListener('DOMContentLoaded', () => {

    // ── OUR EDGE ─────────────────────────────────────────
    const edgeTabs  = document.querySelectorAll('.edge-tab');
    const edgePanels = document.querySelectorAll('.edge-panel');
    const edgeDots  = document.querySelectorAll('.edge-dot');

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
                        const burgerBtn = document.querySelector("#mobile-menu-btn");
                        if (burgerBtn && burgerBtn.classList.contains('active')) {
                            burgerBtn.click();
                        }
                        
                        lenis.scrollTo(targetEl, {
                            duration: 1.5,
                            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t))
                        });
                    }
                }
            });
        });
    }
});

// ── HERO ART ANIMATION ON LOAD ────────────────────────────
window.addEventListener('load', () => {
    const heroArt = document.querySelector('.hero-art-overlay');
    if (heroArt) {
        // Adding loaded class triggers the CSS animation
        heroArt.classList.add('loaded');
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

        // Hero Section Animations
        const heroTl = gsap.timeline();
        heroTl.from(".hero-top-subtitle", { opacity: 0, y: -20, duration: 0.8, ease: "power2.out" })
              .from(".hero-title span", { opacity: 0, y: 30, duration: 0.8, stagger: 0.2, ease: "power2.out" }, "-=0.4")
              .from(".hero-buttons .btn", { opacity: 0, y: 20, duration: 0.6, stagger: 0.2, ease: "back.out(1.5)" }, "-=0.4")
              .from(".hero-feature", { opacity: 0, y: 20, duration: 0.8, stagger: 0.2, ease: "power2.out" }, "-=0.4");

        // Our Edge Section
        gsap.from(".our-edge-title", {
            scrollTrigger: { trigger: ".our-edge", start: "top 80%" },
            opacity: 0, y: 30, duration: 0.8, ease: "power2.out"
        });
        gsap.from(".edge-panel.active", {
            scrollTrigger: { trigger: ".our-edge", start: "top 70%" },
            opacity: 0, x: -30, duration: 0.8, ease: "power2.out"
        });

        // Designed to Feel Different Section
        gsap.to(".highlight-line", {
            scrollTrigger: {
                trigger: ".designed-main-title",
                start: "top 85%",
                end: "bottom 50%",
                scrub: 1
            },
            opacity: 1,
            stagger: 0.1,
            ease: "none"
        });
        gsap.from(".designed-bottom-row", {
            scrollTrigger: { trigger: ".designed-different", start: "top 70%" },
            opacity: 0, y: 20, duration: 0.8, ease: "power2.out"
        });
        gsap.from(".product-cards .card", {
            scrollTrigger: { trigger: ".product-cards", start: "top 85%" },
            opacity: 0, y: 40, duration: 0.8, stagger: 0.2, ease: "power2.out"
        });

        // Start with Customer Section
        gsap.from(".start-content h2", {
            scrollTrigger: { trigger: ".start-customer", start: "top 80%" },
            opacity: 0, scale: 0.9, duration: 0.8, ease: "power2.out"
        });
        gsap.from(".start-content .start-desc", {
            scrollTrigger: { trigger: ".start-customer", start: "top 70%" },
            opacity: 0, y: 20, duration: 0.8, ease: "power2.out"
        });

        // Insurance in India Section
        gsap.from(".insurance-india-left .section-title", {
            scrollTrigger: { trigger: ".insurance-india", start: "top 80%" },
            opacity: 0, x: -30, duration: 0.8, ease: "power2.out"
        });
        gsap.from(".insurance-india-right > *", {
            scrollTrigger: { trigger: ".insurance-india", start: "top 75%" },
            opacity: 0, y: 20, duration: 0.6, stagger: 0.2, ease: "power2.out"
        });

        // Build Insurance Section
        gsap.from(".build-main-title", {
            scrollTrigger: { trigger: ".build-insurance", start: "top 80%" },
            opacity: 0, y: 30, duration: 0.8, ease: "power2.out"
        });
        gsap.from(".build-tabs", {
            scrollTrigger: { trigger: ".build-insurance", start: "top 75%" },
            opacity: 0, y: 20, duration: 0.6, ease: "power2.out"
        });
        gsap.from(".partner-features .p-feature", {
            scrollTrigger: { trigger: ".build-panel.active", start: "top 80%" },
            opacity: 0, y: 20, duration: 0.6, stagger: 0.15, ease: "power2.out"
        });
    }
});
