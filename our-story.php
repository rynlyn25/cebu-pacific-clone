<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<!-- The rest of your HTML goes here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Story - Cebu Pacific</title>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Universal Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            overflow-x: hidden;
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #ffffff;
        }

        /* =========================================
           TOP ADVISORY BAR & HEADER STYLES
           ========================================= */
        .top-advisory-bar {
            width: 100%;
            background-color: #00a4e4; 
            padding: 8px 0;
        }

        .header-content-wrapper {
            max-width: 1150px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-header {
            width: 100%; 
            background: white; 
            border-bottom: 1px solid #eaeaea;
        }

        /* =========================================
           BREADCRUMBS
           ========================================= */
        .breadcrumbs-container {
            max-width: 1000px;
            margin: 20px auto 20px auto;
            padding: 0 20px;
            font-size: 13px;
            color: #666;
        }

        .breadcrumbs a {
            color: #005eb8;
            text-decoration: none;
        }

        .breadcrumbs a:hover {
            text-decoration: underline;
        }

        /* =========================================
           YELLOW HERO BANNER
           ========================================= */
        .top-header {
            background-color: #FFD400;
            padding: 45px 0 55px 0;
            position: relative;
            text-align: left;
            border-bottom-left-radius: 50% 40px; 
            border-bottom-right-radius: 50% 40px;
            width: 100%;
            margin-bottom: 40px;
        }

        .header-banner-content {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .top-header h1 {
            color: #0054a6;
            font-weight: bold;
            font-size: 38px;
            margin: 0;
        }

        /* =========================================
           OUR STORY PAGE STYLES
           ========================================= */
        .story-container {
            max-width: 1000px;
            margin: 0 auto 100px auto;
            padding: 0 20px;
        }

        /* Destination Circles */
        .destination-circles {
            display: flex;
            justify-content: space-between;
            margin-bottom: 50px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .circle-item {
            text-align: center;
            width: 120px;
        }

        .circle-img-wrapper {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            border: 3px solid #0088ce;
            padding: 3px; 
            margin: 0 auto 15px auto;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circle-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .circle-item span {
            color: #005eb8;
            font-size: 14px;
            font-weight: bold;
        }

        /* Story Text */
        .story-text-section p {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #444;
        }

        /* Moments Banner */
        .moments-banner {
            background-color: #7bc4f4; 
            padding: 60px 20px 40px;
            border-radius: 12px;
            text-align: center;
            margin: 40px 0;
            position: relative;
            overflow: hidden;
        }

        .moments-title-img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        /* Crew Image */
        .crew-image-wrapper {
            margin: 50px 0;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .crew-image-wrapper img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Vision, Purpose, Values Centered Layout */
        .core-values-section {
            max-width: 700px;
            margin: 50px auto 60px auto; 
        }

        .core-values-section h2 {
            color: #111;
            font-size: 26px;
            font-weight: 800;
            margin: 35px 0 15px 0;
        }

        .core-values-section p {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 25px;
            color: #333;
        }

        .value-item {
            margin-bottom: 20px;
        }

        .value-item strong {
            display: block;
            font-size: 16px;
            color: #111;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .value-item p {
            margin: 0;
        }

        /* Split Sections (Fleet & Awards) */
        .split-section {
            display: flex;
            align-items: stretch;
            gap: 40px;
            margin-bottom: 50px;
        }

        .split-section.reverse {
            flex-direction: row-reverse;
        }

        .split-image {
            flex: 1;
            background: #eee;
            border-radius: 12px;
            overflow: hidden;
            min-height: 250px;
        }

        .split-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .split-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .split-content h2 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 15px;
            margin-top: 0;
        }

        .split-content p {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .btn-blue-outline {
            background-color: #0088ce;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-blue-outline:hover {
            background-color: #006eb3;
        }

        /* =========================================
           FOOTER STYLES
           ========================================= */
        .site-footer {
            background-color: #ffffff;
            padding: 50px 20px;
            border-top: 1px solid #eaeaea;
            width: 100%; 
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            justify-content: space-between;
        }

        .footer-links-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            flex: 2;
        }

        .footer-links-grid .col {
            flex: 1;
            min-width: 120px; 
            display: flex;
            flex-direction: column;
        }

        .footer-links-grid h4, .footer-right-sidebar h4 {
            font-size: 13px;
            color: #111111; 
            margin-bottom: 15px;
            font-weight: 800;
        }

        .footer-links-grid a {
            color: #009cdb; 
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 12px;
            transition: color 0.2s;
        }

        .footer-links-grid a:hover {
            text-decoration: underline;
        }

        .footer-right-sidebar {
            flex: 1;
            min-width: 280px;
            border-left: 1px solid #dcdcdc; 
            padding-left: 35px;
        }

        .app-buttons img {
            height: 38px;
            width: auto;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .payment-grid img {
            height: 30px; 
            width: auto;
            margin-right: 15px;
            margin-bottom: 15px;
            vertical-align: middle;
        }

        .accreditations img {
            height: 60px;
            width: auto;
            margin-right: 15px;
        }

        .country-selector {
            flex-basis: 100%;
            margin-top: 15px;
        }

        .country-box {
            display: inline-flex;
            align-items: center;
            border: 1px solid #ccc;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 14px;
            color: #111;
            font-weight: 600;
            cursor: pointer;
            width: fit-content; 
        }
        
        .country-box i {
            margin-right: 8px;
            color: #111;
        }

        .footer-bottom {
            background-color: #ffcc00; 
            padding: 20px;
            width: 100%; 
        }

        .footer-bottom-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .footer-legal-links {
            display: flex;
            flex-wrap: wrap;
            gap: 25px; 
        }

        .footer-legal-links a {
            color: #0054A6; 
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
        }
        
        .footer-legal-links a:hover {
            text-decoration: underline;
        }

        .copyright-text {
            font-size: 14px;
            color: #0054A6; 
            font-weight: 700;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .split-section, .split-section.reverse {
                flex-direction: column;
            }
            .destination-circles {
                justify-content: center;
            }
            .footer-right-sidebar { border-left: none; padding-left: 0; }
        }
    </style>
</head>
<body>

    <!-- ========================================== -->
    <!-- TOP ADVISORY & NAVIGATION -->
    <!-- ========================================== -->
    <div class="top-advisory-bar force-blue-bar">
        <div class="header-content-wrapper right-align-wrapper" style="display: flex; justify-content: space-between;">
            <div class="advisory-left" style="display: flex; align-items: center; color: white; font-size: 13px;">
            </div>
            <div class="advisory-right" style="display: flex; align-items: center;">
            </div>
        </div>
    </div>

    <header class="hero-header">
        <div style="max-width: 1150px; margin: 0 auto; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
            <a href="index.php" class="header-logo-link">
                <img src="images/CEB_logo_LFEJ_in_Noto_Sans_Linear.webp" alt="Cebu Pacific" style="height: 45px;">
            </a>
            <div class="header-action-right" style="display: flex; align-items: center;">
                <a href="partner-login.html" class="login-link" style="color: #005eb8; text-decoration: none; font-weight: 700; font-size: 15px; display: flex; align-items: center;">
                </a>
            </div>
        </div>
    </header>

    <div class="breadcrumbs-container">
        <div class="breadcrumbs">
            <a href="index.php">Home</a> &rsaquo; 
            <a href="#">About</a> &rsaquo; 
            <span>Our Story</span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- YELLOW HERO BANNER -->
    <!-- ========================================== -->
    <header class="top-header">
        <div class="header-banner-content">
            <h1 class="header-title">Our Story</h1>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- MAIN STORY CONTENT -->
    <!-- ========================================== -->
    <div class="story-container">
        
        <!-- Destination Circles -->
        <div class="destination-circles">
            <div class="circle-item">
                <div class="circle-img-wrapper"><img src="images/clark.jpg" alt="Clark"></div>
                <span>Clark</span>
            </div>
            <div class="circle-item">
                <div class="circle-img-wrapper"><img src="images/cebu.jpg" alt="Cebu"></div>
                <span>Cebu</span>
            </div>
            <div class="circle-item">
                <div class="circle-img-wrapper"><img src="images/iloilo.jpg" alt="Iloilo"></div>
                <span>Iloilo</span>
            </div>
            <div class="circle-item">
                <div class="circle-img-wrapper"><img src="images/davao.jpg" alt="Davao"></div>
                <span>Davao</span>
            </div>
            <div class="circle-item">
                <div class="circle-img-wrapper"><img src="images/InStory Cover-1772421524.webp" alt="Fly Here Next"></div>
                <span>Fly Here Next</span>
            </div>
        </div>

        <!-- History Text -->
        <div class="story-text-section">
            <p>Cebu Pacific first took to the skies on March 8, 1996, flying from Manila to its hometown Cebu. It has since been committed to flying where Filipinos are - from its first international flight to Hong Kong back in 2001 to its first low-cost long-haul flight to Dubai in 2013.</p>
            <p>In 2008, CEB received its first ATR 72-500, boosting inter-island connections and expanding to have the widest network in the Philippines. The airline also consistently made flying accessible for everyjuan through promo fares and its trademark Piso Sale, which it pioneered back in 2004.</p>
            <p>The airline also took part in numerous passenger events, including the surprise announcement of its 200 millionth passenger in Cebu last March 2022 and the milestone of reaching USD 1 million in donations for UNICEF's Change for Good program in 2019. The collected amount supported children in marginalized communities in the Philippines.</p>
            <p>In line with its sustainability and eco-friendly initiatives, CEB took delivery of its first Airbus A321neo in 2019, and A330neo in 2021. This shift to a more fuel-efficient neo engine aircraft paves the way to having an all neo fleet by 2027 and supports the airline's commitment to ensure environmental and social sustainability while making air travel reliable and accessible for all.</p>
        </div>

        <!-- Making Moments Banner -->
        <div class="moments-banner">
            <img src="images/OurStory-Milestones-2480x3508.jpg" alt="Making moments happen" class="moments-title-img">
        </div>

        <!-- Crew Hero Image -->
        <div class="crew-image-wrapper">
            <img src="images/OurStory-A330Neo-1394x930.jpg" alt="Cebu Pacific Crew">
        </div>

        <!-- Vision, Purpose, Values -->
        <div class="core-values-section">
            <h2>Our Vision</h2>
            <p>We envision stronger nations where cultures and communities are connected, meaningful relationships are built, and lives are enriched by opportunities and experiences we make possible</p>

            <h2>Our Purpose</h2>
            <p>Our purpose for existence is to COMMIT as a sustainable low-cost carrier, to CONNECT people and communities, and to CREATE value for all stakeholders.</p>

            <h2>Our Values</h2>
            
            <div class="value-item">
                <strong>SERVICE</strong>
                <p>We put people at the heart of service.</p>
            </div>
            <div class="value-item">
                <strong>INTEGRITY</strong>
                <p>We do what is right.</p>
            </div>
            <div class="value-item">
                <strong>TRUST</strong>
                <p>We cultivate trust and commit to collaboration.</p>
            </div>
            <div class="value-item">
                <strong>COURAGE</strong>
                <p>We relentlessly pursue new ideas and better solutions.</p>
            </div>
            <div class="value-item">
                <strong>BEST OF FILIPINO SPIRIT</strong>
                <p>We live the best of Filipino spirit at all times.</p>
            </div>
        </div>

        <!-- Split Section: Fleet -->
        <div class="split-section">
            <div class="split-image">
                <img src="images/Our-Story-About.png" alt="Our Fleet">
            </div>
            <div class="split-content">
                <h2>Our Fleet</h2>
                <p>Our Fleet, no small feat! 5J HOORAY! CEB's 76-strong fleet is comprised of 55 Airbus (six A321neo, seven A321ceo, five A320neo, 29 A320, and eight A330) and 21 ATR (seven ATR 72-500, 13 ATR 72-600 and one ATR freighter) aircraft, one of the most modern aircraft fleets in the world. Between 2020 and 2026, Cebu Pacific will take delivery of 26 more Airbus A321neos, three more ATR 72-600, 16 A330neos, and 15 aircraft orders from the A320neo family.</p>
            </div>
        </div>

        <!-- Split Section: Awards -->
        <div class="split-section reverse">
            <div class="split-content">
                <h2>Our Awards</h2>
                <p>Cebu Pacific: The airline with flying colors While we consider our passengers the best judges of our service, we're proud to say that we've been recognized and awarded by a number of travel institutions and groups, affirming our unyielding commitment to excellence.</p>
            </div>
            <div class="split-image">
                <img src="images/about-our_story-our_awards.jpg" alt="Our Awards">
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- FOOTER SECTION -->
    <!-- ========================================== -->
    <footer class="site-footer">
        <div class="footer-container">
            
            <div class="footer-links-grid">
                <div class="col">
                    <h4>BOOK</h4>
                    <a href="#">Flights</a>
                    <a href="#">Seat Sale</a>
                </div>
                <div class="col">
                    <h4>MANAGE</h4>
                    <a href="#">Check in</a>
                    <a href="#">Manage Booking</a>
                    <a href="#">Flight Status</a>
                    <a href="#">Add-ons</a>
                    <a href="#">Special Assistance</a>
                </div>
                <div class="col">
                    <h4>TRAVEL INFO</h4>
                    <a href="#">Baggage Information</a>
                    <a href="#">Payment Options</a>
                    <a href="#">Travel Advisories</a>
                    <a href="#">Booking & Check-in</a>
                    <a href="#">Travel Documents</a>
                    <a href="#">Service Fees</a>
                </div>
                <div class="col">
                    <h4>EXPLORE</h4>
                    <a href="#">Explore</a>
                    <a href="#">Philippine Destinations</a>
                    <a href="#">International Destinations</a>
                    <a href="#">Where We Fly</a>
                    <a href="#">City Guides</a>
                </div>
                <div class="col">
                    <h4>ABOUT</h4>
                    <a href="#">About</a>
                    <a href="#">Our Story</a>
                    <a href="#">Media Center</a>
                    <a href="#">Talk to Us</a>
                    <a href="#">Careers</a>
                </div>
                
                <div class="col country-selector">
                    <h4>SELECT COUNTRY</h4>
                    <div class="country-box"><i class="fa-solid fa-globe"></i> Philippines</div>
                </div>
            </div>

            <!-- RIGHT SIDEBAR -->
            <div class="footer-right-sidebar">
                <h4>DOWNLOAD THE CEBU PACIFIC APP</h4>
                <div class="app-buttons">
                    <img src="images/AppStore-4800x1424.webp" alt="App Store">
                    <img src="images/GooglePlay-4800x1416.webp" alt="Google Play">
                </div>

                <h4>PAYMENT PARTNERS</h4>
                <div class="payment-grid">
                    <img src="images/Visa-logo.webp" alt="Visa">
                    <img src="images/Mastercard_logo-128x80.webp" alt="Mastercard">
                    <img src="images/GCash-276x96.webp" alt="GCash">
                </div>

                <h4>MEMBERSHIPS AND ACCREDITATIONS</h4>
                <div class="accreditations">
                    <img src="images/CEB-7Star-Emblem.webp" alt="Badge 1">
                    <img src="images/New_NPC_Logo.webp" alt="Badge 2">
                </div>
            </div>

        </div>
    </footer>
    
    <!-- ========================================== -->
    <!-- BOTTOM YELLOW BAR -->
    <!-- ========================================== -->
    <div class="footer-bottom">
        <div class="footer-bottom-container">
            <div class="footer-legal-links">
                <a href="#">Privacy and Cookie Policy</a>
                <a href="#">Website Terms of Use</a>
                <a href="#">Security</a>
                <a href="#">Accessibility</a>
                <a href="#">Site Map</a>
            </div>
            
            <div class="copyright-text">
                © Copyright 2026 Cebu Pacific: SE GROUP 7
            </div>
        </div>
    </div>

</body>
</html>