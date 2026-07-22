<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protec General Insurance</title>
    <meta name="description"
        content="A new chapter in general insurance begins soon. Not just simpler. Not just digital. Just... smarter.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=TASA+Orbiter:wght@400..800&family=Inter:wght@300;400;600;800&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/MotionPathPlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=2">
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
        <img src="assets/images/hero_banner.jpg" alt="Father lifting his daughter" class="hero-image">
        <img src="assets/images/protec_brandbook__v2.png" alt="Protec Art" class="hero-art-overlay">

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
                <div class="hero-buttons">
                    <a href="stay_tuned.php" class="btn btn-hero-primary">Stay Tuned &rarr;</a>
                    <a href="#" class="btn btn-hero-secondary">Join Our Journey &rarr;</a>
                </div>
            </div>

            <div class="hero-bottom-features">
                <div class="hero-feature">
                    <p>Insurance that starts with you.<br><strong>Not policies. Not templates.<br>Not legacy
                            thinking.</strong></p>
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
    </section>

    <!-- Our Edge Section -->
    <section id="our-edge" class="our-edge">
        <div class="container">
            <h2 class="our-edge-title">OUR EDGE</h2>

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
                    <img src="assets/images/our_edge/smarter_insurance​.jpg" alt="Smarter Insurance">
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
                        <video src="assets/videos/purple_object_rotate.mp4" autoplay loop muted playsinline
                            disablepictureinpicture controlslist="nodownload" oncontextmenu="return false;"
                            class="icon-star"></video>
                    </div>
                </div>

                <div class="designed-bottom-row">
                    <p class="designed-sub">Designed for your life,<br>powered by intelligence,<br>backed by real
                        people.</p>
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
            <p class="small-title">Protec Insurance</p>
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
                            <p>Protec's leadership team brings together experienced general insurance professionals and
                                technology leaders united by a common purpose: making insurance work better for
                                customers.</p>
                            <p>With decades of expertise across underwriting, claims, distribution, risk management, and
                                technology, we are building an insurer that combines operational excellence with
                                innovation to deliver smarter customer experiences.</p>
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
                    <h3>Partner for impact.</h3>
                    <p class="partner-subtext">We're crafting an ecosystem for brokers, agents, and digital distributors
                        to redefine protection reach across India.</p>

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

                    <div class="who-can-partner">
                        <h4>Who can partner</h4>
                        <p>Brokers | Agents | Digital Dist | Fintech | Affinity</p>
                    </div>
                </div>

                <div class="partner-right">
                    <video src="assets/videos/build_what.mp4" autoplay loop muted playsinline disablepictureinpicture
                        controlslist="nodownload" oncontextmenu="return false;" class="floating-icon icon-pill"></video>
                    <p class="email-contact">Reach out: <a href="mailto:Partner@protecins.com">Partner@protecins.com</a>
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
                        <div class="logo-mark">P</div>
                        <div>
                            <strong>ProTec General Insurance</strong>
                            <span>Simple. Digital. Responsible.</span>
                        </div>
                    </div>
                    <p>Building customer-first general insurance experiences with responsible protection, digital
                        journeys
                        and trusted service support.</p>
                    <div class="cta-row">
                        <a class="btn btn-primary" href="stay_tuned.php">Stay Tuned</a>
                        <a class="btn btn-secondary"
                            href="https://www.linkedin.com/company/protec-general-insurance-limited/" target="_blank"
                            rel="noopener">Follow on LinkedIn</a>
                    </div>
                </div>

                <nav class="footer-col" aria-label="Services">
                    <h3>Services</h3>
                    <ul class="footer-links">
                        <li><a href="fraud_awareness.php">Fraud Awareness</a></li>
                        <li><a href="stay_tuned.php">Contact Us</a></li>
                        <li><a href="stay_tuned.php">Stay Tuned</a></li>
                    </ul>
                </nav>

                <nav class="footer-col" aria-label="Legal">
                    <h3>Legal</h3>
                    <ul class="footer-links">
                        <li><a href="legal.php">Advertising Policy</a></li>
                        <li><a href="legal.php">Corporate Governance</a></li>
                        <li><a href="legal.php">Procurement / Vendor Registration</a></li>
                        <li><a href="fraud_awareness.php">Section 41 & Rebate Prohibition</a></li>
                    </ul>
                </nav>

                <nav class="footer-col" aria-label="About Us">
                    <h3>About Us</h3>
                    <ul class="footer-links">
                        <li><a href="aboutus.php">Board of Directors</a></li>
                        <li><a href="aboutus.php">Company Overview</a></li>
                        <li><a href="legal.php">Governance Documents</a></li>
                    </ul>
                </nav>

                <nav class="footer-col" aria-label="Others">
                    <h3>Others</h3>
                    <ul class="footer-links">
                        <li><a href="https://www.linkedin.com/company/protec-general-insurance-limited/" target="_blank"
                                rel="noopener">LinkedIn</a></li>
                        <li><a href="fraud_awareness.php">Cyber Crime Reporting</a></li>
                        <li><a href="legal.php">Downloads</a></li>
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
                    Town Hall (Mumbai), Mumbai – 400001, Maharashtra
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
    <script src="assets/js/script.js"></script>
</body>

</html>
