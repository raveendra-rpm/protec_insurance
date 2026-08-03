<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/protec_favicon.png?v=<?= @filemtime('assets/images/protec_favicon.png') ?: time() ?>">
    <title>Protec General Insurance | Contact Us</title>
    <meta name="description"
        content="Contact ProTec General Insurance for insurance queries, service support or business interest.">

    <!-- Open Graph / Social Media Meta Tags -->
    <?php
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $baseUrl = $protocol . ($_SERVER['HTTP_HOST'] ?? 'protecins.com') . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
        $ogImage = $baseUrl . "assets/images/protec_logo.png";
    ?>
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $baseUrl . 'staytuned.php' ?>">
    <meta property="og:title" content="Protec General Insurance | Contact Us">
    <meta property="og:description" content="Contact ProTec General Insurance for insurance queries, service support or business interest.">
    <meta property="og:image" content="<?= $ogImage ?>">
    <meta property="og:image:secure_url" content="<?= $ogImage ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:site_name" content="Protec General Insurance">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Protec General Insurance | Contact Us">
    <meta name="twitter:description" content="Contact ProTec General Insurance for insurance queries, service support or business interest.">
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
        <section class="content-section" id="contact-us">
            <div class="content-wrap">
                <article class="section-card">
                    <p class="section-eyebrow">Contact Us</p>
                    <h2>How can we help?</h2>

                    <div class="contact-grid">
                        <div class="contact-card">
                            <h3>Contact ProTec</h3>
                            <p>Connect with us for insurance queries, service support or business interest.</p>
                            <div class="contact-list">
                                <div><strong>Email:</strong> <a
                                        href="mailto:procare@protecins.com">procare@protecins.com</a></div>
                                <div><strong>LinkedIn:</strong> <a
                                        href="https://www.linkedin.com/company/protec-insurance/"
                                        target="_blank" rel="noopener">Visit our LinkedIn page</a></div>
                            </div>
                        </div>

                        <form class="lead-form" id="leadCaptureForm">
                            <div class="field-row">
                                <label>
                                    Full Name
                                    <input type="text" name="fullName" placeholder="Enter your name" required />
                                </label>
                                <label>
                                    Mobile Number
                                    <input type="tel" name="mobile" placeholder="Enter mobile number" pattern="[0-9]{10}" minlength="10" maxlength="10" title="Please enter exactly 10 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required />
                                </label>
                            </div>

                            <div class="field-row">
                                <label>
                                    Email ID
                                    <input type="email" name="email" placeholder="Enter email address" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address (e.g. name@domain.com)" required />
                                </label>
                                <label>
                                    Type of Insurance
                                    <select name="insuranceType" required>
                                        <option value="">Select insurance type</option>
                                        <option>Motor Insurance</option>
                                        <option>Health Insurance</option>
                                        <option>Property / Fire Insurance</option>
                                        <option>Commercial Lines</option>
                                        <option>Marine Insurance</option>
                                        <option>Other</option>
                                    </select>
                                </label>
                            </div>

                            <label>
                                Message / Requirement
                                <textarea name="message" rows="4" placeholder="Tell us how we can help"></textarea>
                            </label>

                            <label class="checkbox-row">
                                <input type="checkbox" name="whatsappConsent" required />
                                <span>I agree to receive WhatsApp communication from ProTec
                                    for my enquiry and service-related communication.</span>
                            </label>

                            <label class="checkbox-row">
                                <input type="checkbox" name="promoConsent" required />
                                <span>I agree to receive promotional and informational communication through calls, SMS,
                                    email, WhatsApp and other channels, subject to applicable laws.</span>
                            </label>

                            <button class="form-submit" type="submit">Submit Interest</button>
                        </form>
                    </div>
                </article>
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

        function showToast(title, msg, type = 'success') {
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'toast-container';
                document.body.appendChild(container);
            }
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            const icon = type === 'success' ? '✅' : '⚠️';
            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-msg">${msg}</div>
                </div>
            `;
            container.appendChild(toast);
            requestAnimationFrame(() => toast.classList.add('show'));
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }

        document.getElementById("leadCaptureForm").addEventListener("submit", async function (event) {
            event.preventDefault();
            const formData = new FormData(this);
            const submitBtn = this.querySelector('.form-submit');
            const originalBtnText = submitBtn.textContent;


            submitBtn.textContent = 'Submitting...';
            submitBtn.disabled = true;

            try {

                const response = await fetch('submitlead.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    showToast('Success!', result.message, 'success');
                    this.reset();
                } else {
                    showToast('Error', result.message || 'Something went wrong. Please try again.', 'error');
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                showToast('Connection Error', 'Failed to connect to the server. Please check your connection.', 'error');
            } finally {
                submitBtn.textContent = originalBtnText;
                submitBtn.disabled = false;
            }
        });
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
