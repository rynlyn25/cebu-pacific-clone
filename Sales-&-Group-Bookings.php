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
    <title>Group Bookings & Sales - Cebu Pacific</title>
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
           DESTINATION CIRCLES
           ========================================= */
        .destination-circles {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 40px;
            margin: 0 auto 50px auto;
            max-width: 1000px;
        }

        .circle-item {
            text-align: center;
            width: 110px;
        }

        .circle-img-wrapper {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            border: 3px solid #00a4e4;
            padding: 3px; 
            margin: 0 auto 15px auto;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
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
        }

        /* =========================================
           SUB-NAVIGATION MENU
           ========================================= */
        .sub-nav-container {
            max-width: 1000px;
            margin: 0 auto 50px auto;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            overflow-x: auto;
            padding: 0 20px;
        }

        .sub-nav-container a {
            text-decoration: none;
            color: #888;
            font-weight: bold;
            font-size: 15px;
            padding: 10px 15px;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
            transition: all 0.3s;
        }

        .sub-nav-container a:hover,
        .sub-nav-container a.active {
            color: #005eb8;
            border-bottom: 3px solid #00a4e4;
        }

        /* =========================================
           MAIN CONTENT SECTIONS
           ========================================= */
        .content-section {
            max-width: 1000px;
            margin: 0 auto 60px auto;
            padding: 0 20px;
            scroll-margin-top: 100px;
        }

        .content-section h2 {
            font-size: 24px;
            color: #222;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .content-section p {
            font-size: 15px;
            line-height: 1.6;
            color: #444;
            margin-bottom: 20px;
        }

        .content-section img.hero-img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
            object-fit: cover;
        }

        .content-section ul {
            margin-left: 40px;
            margin-bottom: 20px;
            line-height: 1.8;
            font-size: 15px;
            color: #444;
        }

        .bold-link {
            color: #000;
            font-weight: bold;
            text-decoration: none;
        }

        .bold-link:hover {
            text-decoration: underline;
        }

        .btn-primary {
            display: inline-block;
            background-color: #0088ce;
            color: white;
            text-align: center;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
            font-size: 15px;
            margin-bottom: 20px;
        }

        .btn-primary:hover {
            background-color: #006eb3;
        }

        /* CEB Biz Partners Specific Layout */
        .biz-intro {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .biz-intro img {
            width: 120px;
            flex-shrink: 0;
        }

        .biz-intro-text {
            flex: 1;
        }

        .questions-box {
            background-color: #f0f9ff;
            border: 1px solid #d0ebff;
            border-radius: 8px;
            padding: 25px;
            margin-top: 30px;
        }

        .questions-box h4 {
            margin-bottom: 20px;
            color: #222;
        }

        .questions-box p {
            margin: 0;
            font-size: 14px;
        }

        /* =========================================
           ACCORDION STRUCTURE (Sales Offices)
           ========================================= */
        .accordion-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            padding: 10px 30px;
            margin-bottom: 20px;
        }

        .accordion-item {
            border-bottom: 1px solid #eaeaea;
        }

        .accordion-item:last-child {
            border-bottom: none;
        }

        .accordion-header {
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            gap: 20px;
        }

        .pr-title {
            font-size: 18px;
            color: #111;
            font-weight: 500;
        }

        .accordion-header i {
            color: #005eb8;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .accordion-item.active .accordion-header i {
            transform: rotate(180deg);
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out;
        }

        .accordion-inner {
            padding-bottom: 30px;
            font-size: 14px;
            line-height: 1.7;
            color: #444;
        }

        .sales-office-group {
            margin-bottom: 25px;
        }

        .sales-office-group h5 {
            font-size: 15px;
            color: #222;
            margin-bottom: 10px;
        }

        .sales-office-group ul {
            margin-left: 25px;
            margin-bottom: 0;
            list-style-type: disc;
        }

        .agent-item {
            margin-bottom: 20px;
        }

        .agent-item strong {
            display: block;
            margin-bottom: 5px;
            color: #111;
            font-size: 15px;
        }

        .agent-item ul {
            margin-left: 20px;
            margin-bottom: 0;
            list-style-type: disc;
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
            max-width: 1150px;
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
            .biz-intro {
                flex-direction: column;
                align-items: flex-start;
            }
            .footer-right-sidebar { 
                border-left: none; 
                padding-left: 0; 
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
                </a>
            </div>
        </div>
    </header>

    <div class="breadcrumbs-container">
        <div class="breadcrumbs">
            <a href="index.php">Home</a> &rsaquo; 
            <a href="#">Book</a> &rsaquo; 
            <span>Group Bookings & Sales</span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- YELLOW HERO BANNER -->
    <!-- ========================================== -->
    <header class="top-header">
        <div class="header-banner-content">
            <h1>Group Bookings & Sales</h1>
        </div>
    </header>

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

    <!-- Sub Navigation Menu -->
    <div class="sub-nav-container">
        <a href="#charter-flights" class="active">Charter Flights</a>
        <a href="#group-bookings">Group Bookings</a>
        <a href="#ceb-biz-partners">CEB Biz Partners</a>
        <a href="#offline-agencies">Offline International Travel Agencies</a>
        <a href="#sales-offices">Sales Offices</a>
    </div>

    <!-- ========================================== -->
    <!-- CONTENT SECTIONS -->
    <!-- ========================================== -->

    <!-- Section: Charter Flights -->
    <section id="charter-flights" class="content-section">
        <h2>Charter Flights</h2>
        <p>Cebu Pacific offers chartered airline services utilizing ATR, Airbus A320, A321N, and A330 aircraft.</p>
        <img src="images/A321CEO-arrival-air-3204x2236.jpg" alt="Charter Flights Plane" class="hero-img">
    </section>

    <!-- Section: Group Bookings -->
    <section id="group-bookings" class="content-section">
        <h2>Group Bookings</h2>
        <img src="images/friends-swimming-group_bookings&sales-1056x277.png" alt="Group Bookings Floating" class="hero-img">
        <p>If you would like to get a quote for your group:</p>
        <ul>
            <li>Domestic: 20 passengers or more</li>
            <li>International: 10 passengers or more</li>
        </ul>
        <p>Please email us at <a href="mailto:groupbookings@cebupacificair.com" class="bold-link">groupbookings@cebupacificair.com</a>, with below information:</p>
        
        <div class="questions-box" style="margin-top: 15px;">
            <ul style="margin-bottom: 0;">
                <li>Contact Person's Name</li>
                <li>Company Name</li>
                <li>Address</li>
                <li>Contact Number/s</li>
                <li>Destination</li>
            </ul>
            <p style="margin-left: 40px; margin-bottom: 20px;"><a href="#" class="bold-link">Where we fly</a></p>
            
            <ul style="margin-bottom: 0;">
                <li>Travel Date/s</li>
                <li>Preferred Flight Schedule</li>
                <li>Total number of passengers (Adult/ Children/ Infant/ PWD/ Senior)</li>
                <li>Other Inclusions (Baggage allowance, meals, etc.)</li>
            </ul>
            <p style="margin-left: 40px;"><a href="#" class="bold-link">Our products</a></p>
        </div>
    </section>

    <!-- Section: CEB Biz Partners -->
    <section id="ceb-biz-partners" class="content-section">
        <h2>CEB Biz Partners</h2>
        <div class="biz-intro">
            <img src="images/CEBBizLogo.png" alt="CEB Biz Logo">
            <div class="biz-intro-text">
                <p style="margin-bottom: 10px;">Launched in April 2008, Cebu Pacific's Corporate Sales Team (CEB BIZ) lets you maximize your company's travel budget with CEB's low fares and extensive network.</p>
            </div>
        </div>

        <h3 style="margin-bottom: 15px; font-size: 18px; color: #222;">Benefits of becoming a CEB BIZ partner:</h3>
        <img src="images/male-reading-CEBBiz-1056x531.png" alt="Benefits of becoming a CEB BIZ partner" class="hero-img">
        
        <strong style="display:block; margin-bottom: 10px;">Booking convenience and flexibility</strong>
        <ul>
            <li>Exclusive access to <a href="#" class="bold-link">SkyPartner</a> online booking facility</li>
            <li>Reserve now, pay later options for up to 8 hours</li>
            <li>Ability to create a single account for affiliates/sister companies</li>
            <li>Customer support through our CEB BIZ Account Management Team</li>
        </ul>

        <strong style="display:block; margin-bottom: 10px;">Better value</strong>
        <ul>
            <li>Corporate Rewards Program</li>
        </ul>

        <strong style="display:block; margin-bottom: 10px;">Transparency</strong>
        <ul>
            <li>Access to CEB's all-in lowest fares</li>
            <li>Access to an online sales monitoring tool</li>
        </ul>

        <strong style="display:block; margin-bottom: 10px;">Questions?</strong>
        <div class="questions-box">
            <h4>CEB BIZ Team</h4>
            <p><strong>Email:</strong> <a href="mailto:corpsales@cebupacificair.com" class="bold-link">corpsales@cebupacificair.com</a></p>
        </div>
    </section>

    <!-- Section: Offline International Travel Agencies -->
    <section id="offline-agencies" class="content-section">
        <h2>Offline International Travel Agencies</h2>
        <img src="images/GroupBookings&Sales-TravelAgents-1056x283.png" alt="Offline International Travel Agencies Office" class="hero-img">
        <p>Interested Travel Agencies, located outside the Philippines and outside the Cebu Pacific Network, may apply as Offline Preffered Sales Agents.</p>
        <p><strong>Note:</strong> For TAs located in CEB's regional routes, interested parties may apply directly to CEB's appointed <a href="#" class="bold-link">Regional GSA/Wholesalers.</a></p>
    </section>

    <!-- Section: Sales Offices -->
    <section id="sales-offices" class="content-section">
        <h2>Sales Offices</h2>
        <p>In the interest of public safety and to lessen physical contact, all transactions can be done via <a href="#" class="bold-link">Manage Booking</a> online or by messaging us on <a href="#" class="bold-link">Facebook Messenger</a>.</p>
        <p>For refund requests of bookings paid in cash, please fill out the <a href="#" class="bold-link">Cash Refund Application</a>. We will send further instructions to your email once we've validated your request.</p>

        <!-- Accordions for Sales Offices & Agents -->
        <div class="accordion-card">
            
            <!-- Accordion 1: International Sales Office -->
            <div class="accordion-item">
                <div class="accordion-header">
                    <span class="pr-title">International Sales Office</span>
                    <i class="fa-solid fa-chevron-up"></i>
                </div>
                <div class="accordion-content">
                    <div class="accordion-inner">
                        <p>To avoid inconvenience of travelling to our location, you may search, book, or manage your future flights through our <a href="#" class="bold-link">website</a> or inquire via <a href="#" class="bold-link">Chat with Charlie</a></p>
                        
                        <div class="sales-office-group">
                            <h5>South Korea Sales Office</h5>
                            <ul>
                                <li>RM 907 of President Hotel, 16, Euljiro, Joong-Gu, Seoul, South Korea</li>
                                <li>Korea Call Center Hotline: (822) 6105-2037</li>
                            </ul>
                        </div>

                        <div class="sales-office-group">
                            <h5>Japan Sales Office</h5>
                            <ul>
                                <li>Nihonbashi Ohedo Building, 7F 2-5-6 Hihonbashi Kayobacho, Chou-Ku Tokyo, Japan 103-0025</li>
                                <li>Japan Call Center Hotline: (813) 45781447</li>
                            </ul>
                        </div>

                        <div class="sales-office-group">
                            <h5>Hong Kong Sales Office</h5>
                            <ul>
                                <li>Room 408-9, 4th Floor, Wing On Plaza, 62 Mody Road, Tsimshatsui East, Kowloon, Hong Kong</li>
                                <li>Hong Kong Call Center Hotline: (852) 5803-3088</li>
                            </ul>
                        </div>

                        <div class="sales-office-group">
                            <h5>Shanghai Sales Office</h5>
                            <ul>
                                <li>Room 1401, No. 2-8 Huai Hai Zhong Road, Huangpu District Shanghai, China</li>
                                <li>China Call Center Hotline: +86-400-670-0780</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Accordion 2: International Sales Agent -->
            <div class="accordion-item">
                <div class="accordion-header">
                    <span class="pr-title">International Sales Agent</span>
                    <i class="fa-solid fa-chevron-up"></i>
                </div>
                <div class="accordion-content">
                    <div class="accordion-inner">
                        
                        <div class="agent-item">
                            <strong>Air System Inc.</strong>
                            <ul>
                                <li>Hommachi Hua Tong Bldg., 5F 5-16, 4-Chome, Hommachi Chuo-Ku, Osaka, Japan 541-0053</li>
                                <li>Shimbashi Frontier Building, 7F 3-4-5 Shimbashi Minato-Ku, Tokyo, Japan 105-0004</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Allied Express Travel Ltd</strong>
                            <ul>
                                <li>2F World-Wide House Shop 201, 19 Des Voeux Road Central, Hong Kong</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Al Rais Travel & Shipping Agencies LLC</strong>
                            <ul>
                                <li>Ground Floor, Al Rais Centre, Al Mankhool Street, Bur Dubai</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Anthony Tours And Travel Agency Sdn Bhd</strong>
                            <ul>
                                <li>No1 Lot 20171 Jalan Laksamana Abdul Razak Km2 Jalan Tutong Bandar Seri Begawan, Brunei Darussalam</li>
                                <li>Unit 04-31B, 3Rd Floor Of Seria Plaza, Jalan Sultan Omar Ali, Seria Town, Brunei Darussalam</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Ashal Al Hadeeth Company for Travel and Tourism (Air Promotion Group APG KSA)</strong>
                            <ul>
                                <li>B3567, Prince Sultan Adulaziz Al Sulaimaniyah Dist. Riyadh, Kingdom of Saudi Arabia 12232</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Asiana Holidays Limited</strong>
                            <ul>
                                <li>4/F., Glory Centre, 8 Hillwood Rd., T.S.T., Kowloon, Hong Kong</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Aviareps (Thailand) Company Limited</strong>
                            <ul>
                                <li>54 B.B. Building 17F Room 1715 , Sukhumvit 21, Asok Montri Road, Wattana, Bangkok, Thailand 10110</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Aviation (Thailand) Co. Ltd,</strong>
                            <ul>
                                <li>140/13 Itf 10Th Flr. Silom Road, Suriyawongse, Bangrak, Bangkok, Thailand 10500</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Beijing Meiya International Air Service Co., Ltd</strong>
                            <ul>
                                <li>Rm. 202, Build B, Lian Xin Da Sha, #2 Chen Jia Lin, Ba Li Zhuang, Chaoyang District Beijing, China 100025</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>CAAC Holidays</strong>
                            <ul>
                                <li>2/F., Tung Fai Building, 27 Carmeron Road, Tsimshatsui, Kowloon, Hongkong</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Caesars International Travel Co. W.L.L</strong>
                            <ul>
                                <li>Al Jawhara Tower , Ground Floor, Al Salhiya , Ali Al-Salem Street, Pb # 28229 Safat Code 13056 Kuwait.</li>
                                <li>Al-Annaz Commercial Complex, Bldg 270, Shop- 78+79, Farwaniya Main St, ( Behind Crown Plaza )Pb # 28229, Safat 13056 , Kuwait.</li>
                                <li>Office No: B6, Sharifa Complex, Behind Muthanna Complex, Salhiya, Fahad Al Salem Street Pb # 28229,Safat 13056 , Kuwait</li>
                                <li>Building No.5, Shop No.1, Ground Floor, Block No.111, Street No.18, Hawalli ,Pb # 28229, Safat 13056 , Kuwait</li>
                                <li>5Th Ring Road-Riggae , Block No.13, Street No.1, Bldg No. 2,Pb # 28229, Safat 13056 , Kuwait</li>
                                <li>Al-Nafisi Tower, Ground Floor, Abdullah Al-Mubarak Street, Opp. Science Museum, Mirqab, Kuwait,Pb # 28229, Safat 13056 , Kuwait</li>
                                <li>Office No.3 Ground Floor, Block No.7, Khalifa Daeej Al Dabbous Building, Dabbous Street, Fahaheel ,Pb # 28229, Safat 13056 , Kuwait</li>
                                <li>Office No.60 Ground Floor, Block No.14, Naif Hemed Al-Dabbous Complex, Dabbous Street, Fahaheel,Pb # 28229, Safat 13056 , Kuwait</li>
                                <li>Fm3 Building No. 108, Ground Floor Block No.4, Street No.17 - Mangaf,Pb # 28229, Safat 13056 , Kuwait</li>
                                <li>Block No.3, Building# 252, Ground Floor, Mahboula. Pb # 28229, Safat 13056, Kuwait</li>
                                <li>Bldg 29, Block No.10, Amman Street Salmiya, Pb # 28229, Safat 13056 , Kuwait</li>
                                <li>Yousef Al Bader St, Block No.10, Building No 25, Salmiya, Pb # 28229, Safat 13056 , Kuwait</li>
                                <li>Khalifa Mafraz, Alkhalifa Bldg. No.27, Ofice Nos. 17/18/19/20 Mezzanine Floor, Block No 93, Jahra Pb # 28229, Safat 13056 , Kuwait</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>EZ International Travel Service Ltd., Xiamen Branch Office</strong>
                            <ul>
                                <li>10F, Ocean Tower, No 26B Lujiang Road, Siming District, Xiamen, China</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Flight Travel JSC</strong>
                            <ul>
                                <li>83 Le Quoc Hung, Ward 12, District 4, Ho Chi Minh City, Vietnam</li>
                                <li>Etown 1 Lobby, 364 Cong Hoa, Tan Binh District, Ho Chi Minh City, Vietnam</li>
                                <li>03rd Floor, Lasi Building, 345 Kim Ma, Ba Dinh District, Hanoi, Vietnam</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Golden Deluxe Travel Service Agency Sdn. Bhd.</strong>
                            <ul>
                                <li>10-1 Jalan Khoo Teik Ee, Off Jalan Imbi, 55100 Kuala Lumpur, Malaysia</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>GSA Express Travel Services Co., Ltd.</strong>
                            <ul>
                                <li>7-2 F. No. 220 SongJiang Road, Zhongshan District, 104422, Taipei, Taiwan</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Guangdong Meiya Tourism Technology Group Corporation Limited</strong>
                            <ul>
                                <li>Room 525, No2, Tengfei Frist Street, China-Singapore Guangzhou Knowledge City, Huangpu district, Guangzhou, China</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Holiday World Tours</strong>
                            <ul>
                                <li>Flat/Rm 513, 5/F Peninsula Centre, 67 Mody Road, Tsim Sha Tsui East, Kowloon, Hong Kong</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>International Aviation Services (China) Limited</strong>
                            <ul>
                                <li>Rm 1508A, No. 1501, Main Tower, G.D International Building, No 339 Huanshindong Road, Guangzhou, China</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Kathy Travels (HK) Limited</strong>
                            <ul>
                                <li>RM01, 18/F, Yue Shing Commercial Bldg., #15 Queen Victoria St, Central, Hong Kong</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Kaotours Ltd</strong>
                            <ul>
                                <li>No. 60 Group 1, Kim Bai Town, Thanh Oai District, Hanoi City, Vietnam</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Leticia Travel Pty Ltd</strong>
                            <ul>
                                <li>Level 2, 57 Queen St., St. Marys, Sydney, Australia</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Metro Tours Singapore Pte. Ltd.</strong>
                            <ul>
                                <li>51 Cuppage Road #01-14 Singapore 229469</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Nam Thanh Travel</strong>
                            <ul>
                                <li>Room 905, 9Th Floor,172-174 Ky Con Street, Nguyen Thai Binh District, Ho Chi Minh City, Vietnam</li>
                                <li>No 51 Dao Duy Tu Str, Hoan Kiem Dist, Hanoi, Vietnam</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Nova Sintra Agencia de Viagens, Limitada</strong>
                            <ul>
                                <li>Avn, D Joao IV, No 4A, R/C (5 & T) Edif. China Plaza, Macau, China</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Pacific Aviation Marketing (Beijing) Ltd</strong>
                            <ul>
                                <li>The Spaces International Center, No. 602, 6/F, The Spaces International Center, No. 8 Dongdaqiao Road, Chao Yang District, Beijing, China 100020</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Pan Bright Travel Services</strong>
                            <ul>
                                <li>Suite 101-102, Bangunan Hj Ahmad Laksamana, 38-39 Jalan Sultan Bandar Seri Begawan Negara, Brunei Darussalam</li>
                                <li>37 Jalan Pretty, Kuala Belait Ka1131 P.O Box 218, Kuala Belait Ka 1189&Nbsp; Negara, Brunei Darussalam</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Patterson & Company Limited</strong>
                            <ul>
                                <li>Room 606, 6/F, Tower 1, Harbour Centre, 1 Hok Cheung Street, Hung Hom, Kowloon, Hong Kong</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>PT. Andalan Usaha Cemerlang</strong>
                            <ul>
                                <li>Sarinah Office Bldg., 9Th Flr. Jl. Mh Thamrin No 11 Jakarta Pusat, Indonesia 10350</li>
                                <li>Kompleks Tuban Plaza No. 42 Jl. Bypass Ngurah Rai - Tuban, Bali, Indonesia</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>PT. Avs Indonesia</strong>
                            <ul>
                                <li>Pelni Building 2Nd Flr., Room #7 Hln Raya Kuta No 299, Denpasar Bali, Indonesia</li>
                                <li>Allianz Tower, 27Th Floor, Unit C, Jl. Hr Rasuna Said Superblok 2, Kawasan Kuningan Persada, South Jakarta, Indonesia 12980</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Shanghai E-Fly International Travel Service Co. Ltd. (上海易飞国际旅行社有限公司)</strong>
                            <ul>
                                <li>Room 703, 187 Jiangning Road, Xincheng Mansion Jing’An District, Shanghai, China 200041</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Shanghai Xiangjin Ticket Agency Co. Ltd.</strong>
                            <ul>
                                <li>Room 601. Metrobank Plaza, No. 1160 West Yan' An Road, Changning District, Shanghai, China 200052</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Skyzone Tours & Travel Sdn. Bhd.</strong>
                            <ul>
                                <li>No 7.71, 7Th Floor Berjaya Times Square, No. 1 Jalan Imbi 55100 Kuala Lumpur, Malaysia</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Straits Central Agencies (B) Sdn. Bhd.</strong>
                            <ul>
                                <li>Unit F9, Block F, Complex Setia Kenangan 2, Spg.150-17-20, Kg Kiulap, Be1518, Mukim Gadong, Bandar Seri Begawan, Brunei Darussalam</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Wan Tung Wan Kau Travel Co Ltd</strong>
                            <ul>
                                <li>Rua Dios Do Bairro Lao Hon No. 22 Loa B064 R/C Macau, China</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Worldwide Aviation Sales Pte. Ltd.</strong>
                            <ul>
                                <li>Orchard Towers, Singapore 238875</li>
                            </ul>
                        </div>

                        <div class="agent-item">
                            <strong>Xiamen Huayou Travel International Agency Co Ltd</strong>
                            <ul>
                                <li>Rm708 Jiuzhou Building No62 LIanhuaxiangxiu Lane Siming District Xiamen, China 361001</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>


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

    <!-- Scripts -->
    <script>
        // Smooth Scrolling with Header Offset for Sub Nav Links
        document.querySelectorAll('.sub-nav-container a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    // Adjust 120 based on the exact height of your top sticky headers
                    const headerOffset = 120; 
                    const elementPosition = targetSection.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }
            });
        });

        // Tab Activation Logic based on Scroll Position (Scroll Spy)
        const sections = document.querySelectorAll(".content-section");
        const navLinks = document.querySelectorAll(".sub-nav-container a");

        window.addEventListener("scroll", () => {
            let current = "";
            
            sections.forEach((section) => {
                const sectionTop = section.offsetTop;
                // Check if we have scrolled past the section (with some buffer for the header)
                if (window.scrollY >= (sectionTop - 150)) {
                    current = section.getAttribute("id");
                }
            });

            navLinks.forEach((link) => {
                link.classList.remove("active");
                // Only add the active class if 'current' is not empty and matches the href
                if (current && link.getAttribute("href") === `#${current}`) {
                    link.classList.add("active");
                }
            });
        });

        // Accordion Logic
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                const content = header.nextElementSibling;
                
                // Toggle active class
                item.classList.toggle('active');

                // Smooth scroll logic for accordion content
                if (item.classList.contains('active')) {
                    content.style.maxHeight = content.scrollHeight + "px";
                } else {
                    content.style.maxHeight = null;
                }
            });
        });
    </script>
</body>
</html>