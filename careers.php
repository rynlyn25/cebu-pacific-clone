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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers - Cebu Pacific</title>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* =========================================
           GLOBAL RESET & TYPOGRAPHY
           ========================================= */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333333;
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
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #005eb8;
            font-weight: 700;
            font-size: 15px;
        }

        /* =========================================
           BREADCRUMBS
           ========================================= */
        .breadcrumbs-container {
            max-width: 1150px;
            margin: 15px auto;
            padding: 0 20px;
            font-size: 13px;
            color: #666;
        }

        .breadcrumbs a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumbs a:hover {
            color: #005eb8;
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
            max-width: 1150px;
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
           MAIN CONTENT
           ========================================= */
        .content-container {
            max-width: 1150px;
            margin: 0 auto 80px auto;
            padding: 0 20px;
        }

        .intro-text {
            font-size: 15px;
            line-height: 1.7;
            color: #333;
            margin-bottom: 20px;
        }

        .intro-text p {
            margin-bottom: 15px;
        }

        /* Hiring Card Specifics */
        .hiring-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-top: 40px;
            max-width: 900px;
        }

        .hiring-banner {
            width: 100%;
            display: block;
        }

        .hiring-card-content {
            padding: 40px;
            display: flex;
            gap: 25px;
            align-items: flex-start;
        }

        .hiring-icon-circle {
            width: 70px;
            height: 70px;
            background-color: #FFD400;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .hiring-icon-circle i {
            font-size: 35px;
            color: #005eb8;
        }

        .hiring-text-content h3 {
            color: #00a4e4;
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .hiring-text-content p {
            font-size: 15px;
            color: #444;
            line-height: 1.6;
        }

        /* =========================================
           FOOTER STYLES
           ========================================= */
        .site-footer {
            background-color: #ffffff;
            padding: 50px 20px 40px 20px;
            border-top: 1px solid #eaeaea;
            width: 100%;
        }

        .footer-container {
            max-width: 1150px;
            margin: 0 auto;
            display: flex;
            gap: 40px;
            justify-content: space-between;
        }

        .footer-grid-left {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            flex: 2.2;
        }

        .footer-col {
            display: flex;
            flex-direction: column;
        }

        .footer-group {
            display: flex;
            flex-direction: column;
        }

        .footer-group h4, 
        .footer-right-sidebar h4 {
            font-size: 13px;
            color: #000000;
            margin-bottom: 16px;
            font-weight: 800;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .footer-group a {
            color: #009cdb;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 12px;
            transition: color 0.2s;
        }

        .footer-group a:hover {
            text-decoration: underline;
        }

        .country-box {
            display: inline-flex;
            align-items: center;
            border: 1px solid #ccc;
            padding: 8px 14px;
            border-radius: 4px;
            font-size: 14px;
            color: #111;
            font-weight: 600;
            cursor: pointer;
            width: fit-content;
            background: #fff;
        }

        .country-box i {
            margin-right: 8px;
            color: #111;
        }

        .footer-right-sidebar {
            flex: 1;
            min-width: 280px;
            border-left: 1px solid #e0e0e0;
            padding-left: 35px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .app-buttons {
            display: flex;
            gap: 10px;
        }

        .app-buttons img {
            height: 38px;
            width: auto;
        }

        .payment-grid {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-grid img {
            height: 28px;
            width: auto;
        }

        .accreditations {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .accreditations img {
            height: 55px;
            width: auto;
        }

        .footer-bottom {
            background-color: #ffd400;
            padding: 16px 20px;
            width: 100%;
        }

        .footer-bottom-container {
            max-width: 1150px;
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
            font-size: 13.5px;
            font-weight: 700;
        }

        .footer-legal-links a:hover {
            text-decoration: underline;
        }

        .copyright-text {
            font-size: 13.5px;
            color: #0054A6;
            font-weight: 700;
        }

        /* Mobile Responsiveness */
        @media (max-width: 900px) {
            .footer-container {
                flex-direction: column;
            }
            .footer-grid-left {
                grid-template-columns: repeat(2, 1fr);
            }
            .footer-right-sidebar {
                border-left: none;
                padding-left: 0;
                border-top: 1px solid #e0e0e0;
                padding-top: 30px;
            }
        }
        @media (max-width: 768px) {
            .hiring-card-content {
                flex-direction: column;
            }
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
                <a href="#" style="color: rgba(255, 255, 255, 0.7); font-weight: 700; text-decoration: none; font-size: 13px; display: flex; align-items: center;">
                </a>
                <a href="#" style="color: rgba(255, 255, 255, 0.7); font-weight: 700; text-decoration: none; font-size: 13px; display: flex; align-items: center; margin-left: 25px;">
                    <i class="fa-solid fa-circle-dollar-to-slot" style="margin-right: 6px;"></i> PHP
                </a>
                <a href="#" style="color: rgba(255, 255, 255, 0.7); font-weight: 700; text-decoration: none; font-size: 13px; display: flex; align-items: center; margin-left: 25px; margin-right: 25px;">
                    <i class="fa-solid fa-globe" style="margin-right: 6px;"></i> English
                </a>
            </div>
        </div>
    </div>

    <header class="hero-header">
        <div style="max-width: 1150px; margin: 0 auto; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
            <a href="index.php" class="header-logo-link">
                <img src="images/CEB_logo_LFEJ_in_Noto_Sans_Linear.webp" alt="Cebu Pacific" style="height: 45px;">
            </a>
            <div class="header-action-right" style="display: flex; align-items: center;">
                <a href="login.html" class="login-link" style="color: #005eb8; text-decoration: none; font-weight: 700; font-size: 15px; display: flex; align-items: center;">
                </a>
            </div>
        </div>
    </header>

    <div class="breadcrumbs-container">
        <div class="breadcrumbs">
            <a href="index.php">Home</a> &rsaquo; 
            <a href="index.php">About</a> &rsaquo; 
            <span>Careers</span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- YELLOW HERO BANNER -->
    <!-- ========================================== -->
    <header class="top-header">
        <div class="header-banner-content">
            <h1>Careers</h1>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- MAIN CONTENT AREA -->
    <!-- ========================================== -->
    <main class="content-container">
        
        <div class="intro-text">
            <p>At Cebu Pacific, our hiring process is inclusive, seamless, and straightforward.</p>
            <p>We take pride in providing a safe and welcoming space where every Juan can thrive. Our approach celebrates diversity, streamlines the candidate experience through digital tools, and ensures a fair, skills-based evaluation. Joining Cebu Pacific isn't just about landing a job—it's about starting a journey to create moments that matter.</p>
        </div>

        <div class="hiring-card">
            <!-- Ensure you have an image saved as 'how-we-hire-banner.jpg' or update the path below -->
            <img src="images/WB_CEB-01_EB_Web-Infographic-04.jpg" alt="How We Hire" class="hiring-banner">
            
            <div class="hiring-card-content">
                <div class="hiring-icon-circle">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <div class="hiring-text-content">
                    <h3>Celebrating every Juan</h3>
                    <p>No matter where you come from, we celebrate every Juan from diverse backgrounds being an equal opportunity provider. CEB does not discriminate based on sex, gender, religion, social status, etc. We want people to feel safe to express themselves, and we foster an #IncluCEB space where people feel valued and respected.</p>
                </div>
            </div>
        </div>

    </main>

    <!-- ========================================== -->
    <!-- FOOTER SECTION -->
    <!-- ========================================== -->
    <footer class="site-footer">
        <div class="footer-container">
            
            <!-- Left 4-Column Grid -->
            <div class="footer-grid-left">
                
                <!-- Column 1: BOOK & ABOUT -->
                <div class="footer-col">
                    <div class="footer-group">
                        <h4>BOOK</h4>
                        <a href="#">Flights</a>
                        <a href="#">Seat Sale</a>
                    </div>
                    <div class="footer-group" style="margin-top: 75px;">
                        <h4>ABOUT</h4>
                        <a href="#">About</a>
                        <a href="#">Our Story</a>
                        <a href="#">Media Center</a>
                        <a href="#">Talk to Us</a>
                        <a href="#">Careers</a>
                    </div>
                </div>

                <!-- Column 2: MANAGE -->
                <div class="footer-col">
                    <div class="footer-group">
                        <h4>MANAGE</h4>
                        <a href="#">Check in</a>
                        <a href="#">Manage Booking</a>
                        <a href="#">Flight Status</a>
                        <a href="#">Add-ons</a>
                        <a href="#">Special Assistance</a>
                    </div>
                </div>

                <!-- Column 3: TRAVEL INFO & SELECT COUNTRY -->
                <div class="footer-col">
                    <div class="footer-group">
                        <h4>TRAVEL INFO</h4>
                        <a href="#">Baggage Information</a>
                        <a href="#">Payment Options</a>
                        <a href="#">Travel Advisories</a>
                        <a href="#">Booking & Check-in</a>
                        <a href="#">Travel Documents</a>
                        <a href="#">Service Fees</a>
                    </div>
                    <div class="footer-group" style="margin-top: 30px;">
                        <h4>SELECT COUNTRY</h4>
                        <div class="country-box">
                            <i class="fa-solid fa-globe"></i> Philippines
                        </div>
                    </div>
                </div>

                <!-- Column 4: EXPLORE -->
                <div class="footer-col">
                    <div class="footer-group">
                        <h4>EXPLORE</h4>
                        <a href="#">Explore</a>
                        <a href="#">Philippine Destinations</a>
                        <a href="#">International Destinations</a>
                        <a href="#">Where We Fly</a>
                        <a href="#">City Guides</a>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar -->
            <div class="footer-right-sidebar">
                <div class="sidebar-group">
                    <h4>DOWNLOAD THE CEBU PACIFIC APP</h4>
                    <div class="app-buttons">
                        <img src="images/AppStore-4800x1424.webp" alt="App Store">
                        <img src="images/GooglePlay-4800x1416.webp" alt="Google Play">
                    </div>
                </div>

                <div class="sidebar-group">
                    <h4>PAYMENT PARTNERS</h4>
                    <div class="payment-grid">
                        <img src="images/Visa-logo.webp" alt="Visa">
                        <img src="images/Mastercard_logo-128x80.webp" alt="Mastercard">
                        <img src="images/GCash-276x96.webp" alt="GCash">
                    </div>
                </div>

                <div class="sidebar-group">
                    <h4>MEMBERSHIPS AND ACCREDITATIONS</h4>
                    <div class="accreditations">
                        <img src="images/CEB-7Star-Emblem.webp" alt="Seven Star Compliance">
                        <img src="images/New_NPC_Logo.webp" alt="DPO/DPS Compliance">
                    </div>
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