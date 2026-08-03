<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/protec_favicon.png?v=<?= @filemtime('assets/images/protec_favicon.png') ?: time() ?>">
    <title>Protec General Insurance | Fraud Awareness</title>
    <meta name="description" content="Fraud Awareness - Important Customer Advisory by Protec General Insurance">

    <!-- Open Graph / Social Media Meta Tags -->
    <?php
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $baseUrl = $protocol . ($_SERVER['HTTP_HOST'] ?? 'protecins.com') . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        $ogImage = $baseUrl . "assets/images/protec_logo.png";
    ?>
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $baseUrl . 'fraudawareness.php' ?>">
    <meta property="og:title" content="Protec General Insurance | Fraud Awareness">
    <meta property="og:description" content="Fraud Awareness - Important Customer Advisory by Protec General Insurance">
    <meta property="og:image" content="<?= $ogImage ?>">
    <meta property="og:image:secure_url" content="<?= $ogImage ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:site_name" content="Protec General Insurance">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Protec General Insurance | Fraud Awareness">
    <meta name="twitter:description" content="Fraud Awareness - Important Customer Advisory by Protec General Insurance">
    <meta name="twitter:image" content="<?= $ogImage ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=TASA+Orbiter:wght@400..800&family=Inter:wght@300;400;600;800&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/MotionPathPlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=<?= @filemtime('assets/css/style.css') ?: '3' ?>">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <img src="assets/images/protec_logo.png" alt="Protec General Insurance" class="logo-img">
            </a>
            <ul class="nav-links">
                <li><a href="index.php#our-edge">Our Promise</a></li>
                <li><a href="index.php#designed-different">What's Coming?</a></li>
                <li><a href="index.php#about-us">About Us</a></li>
                <li><a href="index.php#join-us">Join Us</a></li>
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

    <!-- Main Content -->
    <main style="padding-top: 30px;">
        <section class="content-section" id="fraud-awareness">
            <div class="fraud-awareness-container">
                <!-- Header Advisory Banner -->
                <article class="fraud-hero-card">
                    <div class="fraud-hero-header">
                        <p class="fraud-hero-eyebrow">Fraud Awareness</p>
                        <h2>Important Customer Advisory</h2>
                    </div>

                    <div class="fraud-caution-box">
                        <strong>IRDAI Caution</strong>
                        IRDAI is not involved in activities like selling insurance policies, announcing bonus or
                        investment of premiums. Public receiving such phone calls are requested to lodge a police
                        complaint.
                    </div>
                </article>

                <!-- Topic Advisory Cards Grid -->
                <div class="fraud-cards-grid">
                    <article class="fraud-topic-card">
                        <h3>Prohibition of Rebates</h3>
                        <p><strong>SECTION 41 OF INSURANCE ACT, 1938, amended as per the Insurance Laws (Amendment) Act,
                                2015</strong></p>
                        <p>No person shall allow or offer to allow either directly or indirectly as an inducement to any
                            person to take out or renew or continue insurance in respect of any kind of risk relating to
                            lives or property in India any rebate of the whole or part of the commission payable or any
                            rebate of the premium shown on the policy nor shall any person taking out or renewing or
                            continuing a policy accept any rebate except such rebate as may be allowed in accordance with
                            the prospectus or tables of the Insurers.</p>
                        <p>Any person making default in complying with the provisions of this section shall be liable for a
                            penalty which may extend to ten lakh rupees.</p>
                    </article>

                    <article class="fraud-topic-card">
                        <h3>Prohibition on Unsolicited Calls</h3>
                        <p>In compliance with TRAI's Do Not Disturb (DND) Registry and IRDAI guidelines, the Company shall
                            not make unsolicited commercial communications to registered DND subscribers. If you receive any
                            unsolicited communication purportedly from the Company, please report it to the Grievance
                            Officer immediately.</p>
                    </article>

                    <article class="fraud-topic-card">
                        <h3>Reporting Cyber Crimes</h3>
                        <p><strong>Helpline 155260</strong> – National Helpline and reporting platform by Ministry of Home
                            Affairs (MHA).</p>
                        <ul>
                            <li>Helps in preventing financial loss.</li>
                            <li>Operated by concerned State Police.</li>
                            <li>Uses new-age technologies to take action against digital fraud in real-time.</li>
                            <li>Supports integrated response with Law Enforcement Agencies and Financial Intermediaries.
                            </li>
                            <li>More information: <a href="https://cybercrime.gov.in/Webform/Helpline.aspx" target="_blank"
                                    rel="noopener">cybercrime.gov.in</a></li>
                        </ul>
                    </article>

                    <article class="fraud-topic-card">
                        <h3>Digital Police Portal</h3>
                        <p><a href="https://digitalpolice.gov.in/Default.aspx" target="_blank"
                                rel="noopener">digitalpolice.gov.in</a> is a platform for citizens to file crime-related
                            complaints online and seek antecedent verification of prospective employees, including domestic
                            help, drivers, tenants or for any other purpose. Citizens can also seek certification of their
                            own antecedents.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

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
                        <a class="btn btn-primary" href="index.php#designed-different">Stay Tuned</a>
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
                        <li><a href="index.php#designed-different">Stay Tuned</a></li>
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
                    <strong>ProTec</strong><br />
                    REGISTERED ADDRESS:<br />
                    14 FLR-2, 44 DADY SHETH H, CAWASJI PATEL RD HC FORT,<br />
                    Town Hall, Mumbai – 400001, Maharashtra
                </p>
            </div>
        </div>

        <div class="footer-bottom">
            <div>© <span id="footerYear"></span> ProTec. All rights reserved.</div>
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
                        complaint. &nbsp;&nbsp;|&nbsp;&nbsp; This is a corporate website for information purpose only. It does not constitute an advertisement or solicitation of general insurance business.</span>
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
