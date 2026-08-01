<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/protec_favicon.png?v=<?= @filemtime('assets/images/protec_favicon.png') ?: time() ?>">
    <title>Protec General Insurance</title>
    <meta name="description"
        content="A new chapter in general insurance begins soon. Not just simpler. Not just digital. Just... smarter.">

    <!-- Open Graph / Social Media Meta Tags -->
    <?php
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $baseUrl = $protocol . ($_SERVER['HTTP_HOST'] ?? 'protecins.com') . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        $ogImage = $baseUrl . "assets/images/protec_logo.png";
    ?>
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $baseUrl ?>">
    <meta property="og:title" content="Protec General Insurance">
    <meta property="og:description" content="A new chapter in general insurance begins soon. Not just simpler. Not just digital. Just... smarter.">
    <meta property="og:image" content="<?= $ogImage ?>">
    <meta property="og:image:secure_url" content="<?= $ogImage ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:site_name" content="Protec General Insurance">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Protec General Insurance">
    <meta name="twitter:description" content="A new chapter in general insurance begins soon. Not just simpler. Not just digital. Just... smarter.">
    <meta name="twitter:image" content="<?= $ogImage ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=TASA+Orbiter:wght@400..800&family=Inter:wght@300;400;600;800&display=swap"
        rel="stylesheet">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/MotionPathPlugin.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link rel="preload" as="image" href="assets/images/hero_banner.jpg">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= @filemtime('assets/css/style.css') ?: '3' ?>">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="#" class="logo">
                <img src="assets/images/protec_logo.png" alt="Protec General Insurance" class="logo-img">
            </a>
            <ul class="nav-links">
                <li><a href="#our-edge">Our Promise</a></li>
                <li><a href="#designed-different">What's Coming?</a></li>
                <li><a href="#about-us">About Us</a></li>
                <li><a href="#join-us">Join Us</a></li>
            </ul>
            <div class="hamburger-menu" id="mobile-menu-btn">
                <svg id="pointsBurger" viewBox="0 0 200 200">
                    <g fill="none" stroke="#333" stroke-width="10" stroke-linecap="round">
                        <line id="line1_6" x1="40" y1="70" x2="160" y2="70" />
                        <line id="line2_6" x1="40" y1="100" x2="160" y2="100" />
                        <line id="line3_6" x1="40" y1="130" x2="160" y2="130" />
                        <circle id="point1_6" cx="100" cy="85" r="5" opacity="0" />
                        <circle id="point2_6" cx="100" cy="115" r="5" opacity="0" />
                    </g>
                </svg>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg-overlay"></div>
        <img src="assets/images/hero_banner.jpg" alt="Father lifting his daughter" class="hero-image" loading="eager" fetchpriority="high">
        <img src="assets/images/protec_brandbook__v2.png" alt="Protec Art" class="hero-art-overlay" loading="eager" fetchpriority="high">

        <div class="hero-content">
            <div class="hero-top-subtitle">
                <p>Not just simple. Not just digital. Just... smarter.</p>
            </div>

            <div class="hero-main">
                <h1 class="hero-title">
                    <span style="display: block;">A NEW CHAPTER IN</span>
                    <span style="display: block;">GENERAL INSURANCE</span>
                    <span style="display: block;">BEGINS SOON</span>
                </h1>
            </div>

            <div class="hero-layout-grid">
                <div class="hero-left-col">
                    <div class="hero-bottom-features">
                        <div class="hero-feature">
                            <p><strong>Insurance that starts with you.</strong><br>Not policies.<br>Not templates.<br>Not legacy thinking.</p>
                        </div>
                        <div class="hero-feature">
                            <p>At Protec Insurance, everything begins with the customer and that changes everything that
                                follows.</p>
                        </div>
                        <div class="hero-feature hero-feature-right">
                            <p><strong>Customer-first.<br>Smarter by design.</strong></p>
                        </div>
                    </div>
                </div>

                <div class="hero-right-col">
                    <div class="hero-buttons">
                        <a href="#designed-different" class="btn btn-hero-primary">Stay Tuned &rarr;</a>
                        <a href="#join-us" class="btn btn-hero-secondary">Join Our Journey &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Registration Marquee -->
    <div class="hero-marquee-wrapper">
        <div class="hero-marquee">
            <span>Protec General Insurance Limited has received its Certificate of Registration from IRDAI. We look forward to serving you soon</span>
        </div>
    </div>

    <!-- Our Promise (Our Edge) Section -->
    <section id="our-edge" class="our-edge">
        <div class="container">
            <h2 class="our-edge-title">OUR PROMISE</h2>

            <!-- Tab Bar -->
            <div class="edge-tabs">
                <div class="edge-tab active" data-target="customer-first">Customer First</div>
                <div class="edge-tab" data-target="smarter-insurance">Smarter Insurance</div>
                <div class="edge-tab" data-target="ai-powered">AI-Powered</div>
                <div class="edge-tab" data-target="trust">Trust</div>
            </div>

            <!-- Tab Panels -->
            <div class="edge-panel active" id="customer-first">
                <div class="edge-panel-left">
                    <h3 class="edge-panel-title">Customer<br>First</h3>
                    <p class="edge-panel-desc">Everything begins with understanding real lives, not assumptions.</p>
                </div>
                <div class="edge-panel-right">
                    <img src="assets/images/our_edge/customer _first.jpg" alt="Customer First - Family with agent">
                </div>
            </div>

            <div class="edge-panel" id="smarter-insurance">
                <div class="edge-panel-left">
                    <h3 class="edge-panel-title">Smarter<br>Insurance</h3>
                    <p class="edge-panel-desc">Policies designed around your life, not the other way around.</p>
                </div>
                <div class="edge-panel-right">
                    <img src="assets/images/our_edge/smarter_insurance.jpg" alt="Smarter Insurance">
                </div>
            </div>

            <div class="edge-panel" id="ai-powered">
                <div class="edge-panel-left">
                    <h3 class="edge-panel-title">AI-Powered</h3>
                    <p class="edge-panel-desc">Technology that works quietly in the background, always for you.</p>
                </div>
                <div class="edge-panel-right">
                    <img src="assets/images/our_edge/ai_powered.jpg" alt="AI Powered">
                </div>
            </div>

            <div class="edge-panel" id="trust">
                <div class="edge-panel-left">
                    <h3 class="edge-panel-title">Trust</h3>
                    <p class="edge-panel-desc">Built on transparency, accountability and a promise we keep.</p>
                </div>
                <div class="edge-panel-right">
                    <img src="assets/images/our_edge/trust.jpg" alt="Trust">
                </div>
            </div>

            <!-- Dots -->
            <div class="edge-dots">
                <span class="edge-dot active" data-target="customer-first"></span>
                <span class="edge-dot" data-target="smarter-insurance"></span>
                <span class="edge-dot" data-target="ai-powered"></span>
                <span class="edge-dot" data-target="trust"></span>
            </div>
        </div>
    </section>

    <!-- Designed to Feel Different -->
    <section id="designed-different" class="designed-different">
        <div class="container">
            <div class="designed-header">
                <div class="designed-title-row">
                    <h2 class="designed-main-title">
                        <span class="highlight-line">DESIGNED</span><br>
                        <span class="highlight-line">TO FEEL DIFFERENT.</span><br>
                        <span class="highlight-line">INSURANCE THAT</span><br>
                        <span class="highlight-line">WORKS FOR YOU.</span>
                    </h2>
                    <div class="designed-icon-wrapper">
                        <video id="star-video" src="assets/videos/purple_object_rotate.mp4" autoplay loop muted playsinline disablepictureinpicture style="display:none;"></video>
                        <canvas id="star-canvas" class="icon-star"></canvas>
                    </div>
                </div>

                <div class="designed-bottom-row">
                    <input type="email" class="designed-line-input" placeholder="Enter your email address">
                    <div class="designed-signup">
                        <span class="signup-text">Be the first to know</span>
                        <button class="signup-btn">Sign Up</button>
                    </div>
                </div>
            </div>

            <div class="product-cards">
                <div class="card active">
                    <img src="assets/images/design_to_feel/Products_img.jpg" alt="Products">
                    <div class="blue-tint"></div>
                    <div class="blue-multiply"></div>
                    <div class="card-overlay">
                        <h3>Products</h3>
                        <p>designed for the way you live</p>
                    </div>
                </div>
                <div class="card">
                    <img src="assets/images/design_to_feel/Service_img.jpg" alt="Service">
                    <div class="blue-tint"></div>
                    <div class="blue-multiply"></div>
                    <div class="card-overlay">
                        <h3>Service</h3>
                        <p>handled with care, not call scripts</p>
                    </div>
                </div>
                <div class="card">
                    <img src="assets/images/design_to_feel/claims_img.jpg" alt="Claims">
                    <div class="blue-tint"></div>
                    <div class="blue-multiply"></div>
                    <div class="card-overlay">
                        <h3>Claims</h3>
                        <p>that moves at the speed of now</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Start with Customer -->
    <section class="start-customer">
        <img src="assets/images/wavy_bg.png" alt="Abstract wavy background" class="wavy-bg">
        <video src="assets/videos/protec_insurance.mp4" autoplay loop muted playsinline disablepictureinpicture
            controlslist="nodownload" oncontextmenu="return false;" class="wavy-bg"></video>
        <div class="container start-content">
            <h2>Start with the customer.<br>End with smarter protection.</h2>
            <p class="start-desc">You don't need more insurance. You need better insurance.</p>
        </div>
    </section>

    <!-- Our Story Slider -->
    <section id="about-us" class="our-story-slider">
        <div class="container story-container">
            <h3 class="story-section-title">About Us</h3>

            <div class="story-slider-wrapper">
                <button class="story-arrow left-arrow" id="story-prev">
                    <img src="assets/images/left_arrow.png" alt="Previous">
                </button>

                <div class="story-slides">
                    <!-- Slide 1 -->
                    <div class="story-slide active" data-index="0">
                        <div class="slide-left">
                            <h2>LED BY<br>EXPERTS.<br>BUILT BY<br>INNOVATORS.</h2>
                        </div>
                        <div class="slide-middle">
                            <div class="slide-3-video-wrapper">
                                <video src="assets/videos/animte_vids.mp4" autoplay loop muted playsinline
                                    disablepictureinpicture controlslist="nodownload" oncontextmenu="return false;"
                                    class="icon-swirl-slide-3"></video>
                            </div>
                        </div>
                        <div class="slide-right">
                            <p>Protec is led by seasoned insurance leader <strong>Mr. Aditya Sharma</strong>, Co-founder and Managing Director & CEO *. A Fellow of the Insurance Institute of India (FIII), he brings over 25 years of
                            experience scaling businesses, leading high-performing teams, and driving growth across
                            distribution, risk and operations.</p>
                            <p>Under his leadership, Protec has assembled a team of
                            accomplished insurance professionals, distribution leaders and technology experts, united by a
                            shared purpose: <strong>making insurance simpler, smarter and more customer-centric.</strong> <small style="font-size: 0.75em; font-style: italic;">*(subject to regulatory approvals)</small></p>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="story-slide" data-index="1">
                        <div class="slide-left">
                            <h2>BACKED BY<br>A LEGACY<br>OF TRUST</h2>
                        </div>
                        <div class="slide-middle">
                            <div class="video-crop-wrapper">
                                <video src="assets/videos/animation_vids.mp4" autoplay loop muted playsinline
                                    disablepictureinpicture controlslist="nodownload" oncontextmenu="return false;"
                                    class="icon-swirl-cropped"></video>
                            </div>
                        </div>
                        <div class="slide-right">
                            <p>Protec is promoted by the <strong>M. Pallonji Group</strong>, a diversified business
                                conglomerate with over 95 years of operating history and interests spanning financial
                                services, insurance, logistics, shipping, industrial services, and automotive
                                businesses.</p>
                            <p>Protec is co-promoted by Mr. Divya Sehgal, a seasoned investor with deep expertise in
                                building and scaling financial services businesses, and Mr. Namit Agarwal, along with
                                other marquee investors.</p>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="story-slide" data-index="2">
                        <div class="slide-left">
                            <h2>BUILDING<br>INSURANCE<br>AROUND<br>PEOPLE</h2>
                        </div>
                        <div class="slide-middle">
                            <video src="assets/videos/purple_abstract_swirl.mp4" autoplay loop muted playsinline
                                disablepictureinpicture controlslist="nodownload" oncontextmenu="return false;"
                                class="icon-swirl"></video>
                        </div>
                        <div class="slide-right">
                            <p>For too long, insurance has been built around products rather than people. Policies
                                become more complex, forms get longer, and customers are left to navigate the fine
                                print. Protec starts with the customer.</p>
                            <p>We are building smarter insurance solutions for the way Indians live, work, and manage
                                risk today. Combining deep insurance expertise with AI and digital technology, we make
                                insurance simpler, faster, more transparent, and easier to understand.</p>
                        </div>
                    </div>
                </div>

                <button class="story-arrow right-arrow" id="story-next">
                    <img src="assets/images/right_arrow.png" alt="Next">
                </button>
            </div>

            <div class="story-dots">
                <span class="story-dot active" data-index="0"></span>
                <span class="story-dot" data-index="1"></span>
                <span class="story-dot" data-index="2"></span>
            </div>
        </div>
    </section>

    <!-- Build What Insurance -->
    <section id="join-us" class="build-insurance">
        <div class="container">
            <h2 class="build-main-title">BUILD&nbsp; WHAT<br>INSURANCE SHOULD<br>HAVE&nbsp; BEEN</h2>

            <div class="build-tabs">
                <div class="build-tab active" data-tab="partner">Partner with Us</div>
                <div class="build-tab" data-tab="careers">Careers</div>
            </div>

            <!-- Partner with Us Panel -->
            <div class="build-content build-panel active" id="panel-partner">
                <div class="partner-left">
                    <h3>partner with us</h3>
                    <p class="partner-subtext">We're crafting an ecosystem to redefine protection reach across India. If you're passionate about building distribution and creating extraordinary customer experiences, we'd love to build with you.</p>

                    <div class="partner-features">
                        <div class="p-feature">
                            <span class="bullet"></span>
                            <div>
                                <h4>First-Mover Edge</h4>
                                <p>Shape the ecosystem before it's saturated.</p>
                            </div>
                        </div>
                        <div class="p-feature">
                            <span class="bullet"></span>
                            <div>
                                <h4>Built Together</h4>
                                <p>We co-design distribution models, not just hand over a product catalogue.</p>
                            </div>
                        </div>
                        <div class="p-feature">
                            <span class="bullet"></span>
                            <div>
                                <h4>Smarter Tools</h4>
                                <p>AI quoting, instant issuance, real-time dashboards.</p>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="who-can-partner">
                        <h4>Who can partner</h4>
                        <p>Brokers | Agents | Digital Dist | Fintech | Affinity</p>
                    </div> -->
                </div>

                <div class="partner-right">
                    <video src="assets/videos/build_what.mp4" autoplay loop muted playsinline disablepictureinpicture
                        controlslist="nodownload" oncontextmenu="return false;" class="floating-icon icon-pill"></video>
                    <p class="email-contact">Reach out: <a href="mailto:partner@protecins.com">partner@protecins.com</a>
                    </p>
                </div>
            </div>

            <!-- Careers Panel -->
            <div class="build-content build-panel" id="panel-careers">
                <div class="partner-left">
                    <h3 class="careers-title">Work on what actually matters.</h3>
                    <p class="partner-subtext">If you're curious, driven, and ready to challenge how things have always
                        been done — you'll feel at home here.</p>

                    <div class="partner-features careers-features">
                        <div class="p-feature">
                            <span class="bullet"></span>
                            <div>
                                <h4>Day-one ownership</h4>
                                <p>Real problems, real decisions, from your first week.</p>
                            </div>
                        </div>
                        <div class="p-feature">
                            <span class="bullet"></span>
                            <div>
                                <h4>Build, don't inherit</h4>
                                <p>Processes and culture are being written for the first time, by you.</p>
                            </div>
                        </div>
                        <div class="p-feature">
                            <span class="bullet"></span>
                            <div>
                                <h4>Grow with the company</h4>
                                <p>Early joiners shape direction. Your roles will outlast any job description.</p>
                            </div>
                        </div>
                        <div class="p-feature">
                            <span class="bullet"></span>
                            <div>
                                <h4>Intelligence over hierarchy</h4>
                                <p>The best idea wins, regardless of title.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="partner-right">
                    <video src="assets/videos/careers_vid.mp4" autoplay loop muted playsinline disablepictureinpicture
                        controlslist="nodownload" oncontextmenu="return false;"
                        class="floating-icon icon-careers"></video>
                    <p class="email-contact">Email: <a href="mailto:careers@protecins.com">careers@protecins.com</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer" id="footer">
        <div class="footer-inner">
            <div class="footer-top">
                <div class="brand-card">
                    <div class="brand-logo">
                        <a href="index.php" class="footer-logo-link">
                            <img src="assets/images/protec_logo.png" alt="ProTec General Insurance" class="footer-logo-img">
                        </a>
                    </div>
                    <p>Building customer-first general insurance experiences with responsible protection, digital
                        journeys
                        and trusted service support.</p>
                    <div class="cta-row">
                        <a class="btn btn-primary" href="#designed-different">Stay Tuned</a>
                        <a class="btn btn-secondary"
                            href="https://www.linkedin.com/company/protec-insurance/" target="_blank"
                            rel="noopener">Follow on LinkedIn</a>
                    </div>
                </div>

                <nav class="footer-col" aria-label="Services">
                    <h3>Services</h3>
                    <ul class="footer-links">
                        <li><a href="fraudawareness.php">Fraud Awareness</a></li>
                        <li><a href="staytuned.php">Contact Us</a></li>
                        <li><a href="#designed-different">Stay Tuned</a></li>
                    </ul>
                </nav>

                <nav class="footer-col" aria-label="Legal">
                    <h3>Legal</h3>
                    <ul class="footer-links">
                        <li style="display: none;"><a href="legal.php">Advertising Policy</a></li>
                        <li style="display: none;"><a href="legal.php">Corporate Governance</a></li>
                        <li style="display: none;"><a href="legal.php">Procurement / Vendor Registration</a></li>
                        <li><a href="fraudawareness.php">Section 41 & Rebate Prohibition</a></li>
                    </ul>
                </nav>

                <nav class="footer-col" aria-label="Important Links">
                    <h3>Important Links</h3>
                    <ul class="footer-links">
                        <li style="display: none;"><a href="aboutus.php">Board of Directors</a></li>
                        <li style="display: none;"><a href="legal.php">Governance Documents</a></li>
                        <li><a href="fraudawareness.php">Cyber Crime Reporting</a></li>
                    </ul>
                </nav>

                <nav class="footer-col" aria-label="Others" style="display: none;">
                    <h3>Others</h3>
                    <ul class="footer-links">
                        <li style="display: none;"><a href="legal.php">Downloads</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="registered-office">
            <div class="registered-office-card">
                <h3>Registered Office</h3>
                <p>
                    <strong>ProTec General Insurance Limited</strong><br />
                    REGISTERED ADDRESS:<br />
                    14 FLR-2, 44 DADY SHETH H, CAWASJI PATEL RD HC FORT,<br />
                    Town Hall, Mumbai - 400001, Maharashtra
                </p>
            </div>
        </div>

        <div class="footer-bottom">
            <div>© <span id="footerYear"></span> ProTec General Insurance Limited. All rights reserved.</div>
            <div>
                Need help? <a href="mailto:procare@protecins.com">procare@protecins.com</a>
            </div>
        </div>

        <!-- IN-PAGE CAUTION SCROLL MESSAGE -->
        <aside class="fraud-scroll-widget" aria-label="Caution scroll message">
            <div class="fraud-scroll-inner">
                <div class="fraud-label">Caution</div>
                <div class="fraud-marquee">
                    <span>IRDAI is not involved in activities like selling insurance policies, announcing bonus or
                        investment of premiums. Public receiving such phone calls are requested to lodge a police
                        complaint.</span>
                </div>
            </div>
        </aside>
    </footer>

    <script>
        document.getElementById("footerYear").textContent = new Date().getFullYear();
    </script>

    <button id="goToTopBtn" class="go-to-top" title="Back to Top">
        <span class="gtt-inner">
            <svg class="gtt-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="18 15 12 9 6 15"></polyline>
            </svg>
        </span>
    </button>
    <script src="https://unpkg.com/lenis@1.1.13/dist/lenis.min.js"></script>
    <script src="assets/js/script.js?v=<?= @filemtime('assets/js/script.js') ?: '3' ?>"></script>
</body>

</html>
