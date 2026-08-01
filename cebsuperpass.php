<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$initials = $isLoggedIn ? strtoupper(substr($_SESSION['first_name'], 0, 1) . substr($_SESSION['last_name'], 0, 1)) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEB Super Pass - Cebu Pacific</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* =========================================
           GLOBAL RESET & TYPOGRAPHY
           ========================================= */
        :root {
            --ceb-yellow: #FFD800;
            --ceb-blue: #005eb8;
            --ceb-light-blue: #0088ce;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        html, body {
            overflow-x: hidden;
            scroll-behavior: smooth;
            background-color: #fdfdfd;
            color: #333333;
        }

        /* =========================================
           TOP ADVISORY BAR (Always Blue)
           ========================================= */
        .top-advisory-bar {
            width: 100%;
            background-color: #00a4e4; 
            padding: 10px 0;
            color: white;
            font-size: 12px;
            display: flex;
            align-items: center;
            z-index: 1000;
            position: fixed;
            top: 0;
            height: 35px;
        }

        .header-content-wrapper {
            max-width: 1150px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between;
        }

        .advisory-left {
            display: flex;
            align-items: center;
            font-size: 13px;
        }

        .advisory-right {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .advisory-right a {
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .advisory-right a:hover {
            opacity: 0.8;
        }

        .disabled-text {
            color: white;
            font-size: 13px;
            font-weight: bold;
            display: flex;
            align-items: center;
            opacity: 0.6; 
            pointer-events: none; 
            cursor: default; 
        }

        /* =========================================
           SOLID WHITE HEADER & MEGA MENUS
           ========================================= */
        .hero-header {
            width: 100%; 
            background: white; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: fixed;
            top: 35px;
            z-index: 999;
            height: 70px;
            display: flex;
            align-items: center;
        }

        .logo-colored { display: block; height: 45px; width: auto; }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
            height: 100%;
        }

        .nav-links a.main-link {
            text-decoration: none;
            color: var(--ceb-blue);
            font-weight: 700;
            font-size: 15px;
            transition: color 0.2s;
        }
        
        .nav-links a.main-link:hover { color: #00a1e4; }

        .header-action-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Login Dropdown & Button Fix */
        .login-dropdown-wrapper { 
            position: relative !important; 
            padding: 25px 0; 
            display: flex;
            align-items: center;
        }

        .login-btn {
            background: transparent;
            color: var(--ceb-blue);
            border: none;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 0; 
            margin: 0;
        }

        .login-dropdown-wrapper:hover::after {
            content: ''; 
            position: absolute; 
            bottom: 0; 
            left: 0;
            width: 100%; 
            height: 4px; 
            background: #00a1e4;
        }

        .login-dropdown-wrapper:hover .login-btn { 
            border-bottom: none; 
            padding-bottom: 0; 
        }

        .login-dropdown-wrapper:hover .login-mega-menu { 
            opacity: 1; 
            visibility: visible; 
        }

        .header-search-icon {
            display: inline-block !important; 
            opacity: 1 !important; 
            color: #005eb8;
            font-size: 18px;
            cursor: pointer;
            margin-left: 10px;
        }
        .header-search-icon:hover { color: #00a1e4; }

        .nav-item { position: static; padding: 25px 0; }
        
        .nav-item:hover .main-link { color: #00a1e4; }
    
        .mega-menu {
            position: absolute;
            top: 70px; 
            left: 50%;              
            transform: translateX(-50%); 
            width: 950px;          
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 0 0 8px 8px;
            padding: 35px 50px;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .nav-item:hover .mega-menu { opacity: 1; visibility: visible; }

        .mega-top { display: flex; gap: 60px; margin-bottom: 25px; }

        .mega-icon-link {
            display: flex; flex-direction: column; align-items: center;
            text-decoration: none; transition: all 0.2s ease;
        }
        
        .mega-icon-link span { color: #005eb8 !important; font-weight: bold; font-size: 15px; margin-top: 12px; }
        .mega-icon-link:hover span { color: #00a1e4 !important; }

        .mega-icon {
            background-color: transparent; 
            display: flex; justify-content: center; align-items: center;
            transition: transform 0.2s ease;
        }
        .mega-icon-link:hover .mega-icon { transform: scale(1.05); }

        .custom-mega-img { width: 60px; height: auto; display: block; }
        .mega-divider { border: 0; height: 1px; background: #e5e5e5; margin: 30px 0; }
        .mega-heading { color: #555; font-size: 11px; margin-bottom: 20px; font-weight: bold; letter-spacing: 1px; }

        .business-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; align-items: start; }
        .business-item a { color: #00a1e4 !important; font-size: 14px; font-weight: bold; text-decoration: none; display: block; margin-bottom: 8px; }
        .business-item a:hover { text-decoration: underline; color: #007bb5 !important; }
        .business-item p { color: #666; font-size: 13px; line-height: 1.4; margin: 0; }

        .manage-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 40px; align-items: start; }
        .manage-item a { color: #00a1e4 !important; font-size: 14px; font-weight: bold; text-decoration: none; display: block; margin-bottom: 8px; }
        .manage-item a:hover { text-decoration: underline; color: #007bb5 !important; }
        .manage-item p { color: #666; font-size: 13px; line-height: 1.4; margin: 0; }
        .manage-item p .inline-link { display: inline !important; font-weight: normal; font-size: 13px; margin-bottom: 0; color: #00a1e4; text-decoration: none; }

        .travel-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .travel-item a { color: #005eb8; font-size: 14px; font-weight: bold; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .travel-item a:hover { color: #00a1e4; text-decoration: underline; }

        .explore-top-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
        .explore-heading { font-size: 16px; font-weight: 800; color: #005eb8; margin-bottom: 15px; display: block; text-decoration: none; }
        .destination-cards { display: flex; gap: 15px; }
        .dest-card { flex: 1; height: 100px; border-radius: 8px; background-size: cover; background-position: center; display: flex; align-items: flex-end; padding: 10px; text-decoration: none; color: white; font-weight: bold; font-size: 14px; transition: transform 0.2s; }
        .dest-card:hover { transform: scale(1.05); }

        .explore-bottom-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
        .explore-item a { color: #005eb8; font-size: 15px; font-weight: bold; text-decoration: none; display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
        .explore-item a:hover { color: #00a1e4; text-decoration: underline; }
        .explore-item p { color: #666; font-size: 13px; line-height: 1.4; margin: 0; }

        .about-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; }
        .about-item a { color: #00a1e4 !important; font-size: 14px; font-weight: bold; text-decoration: none; display: block; margin-bottom: 8px; }
        .about-item a:hover { text-decoration: underline; color: #007bb5 !important; }
        .about-item p { color: #666; font-size: 13px; line-height: 1.4; margin: 0; }

        .login-mega-menu {
            position: absolute; 
            top: 100%; 
            left: auto !important; 
            right: -45px !important; 
            transform: none !important; 
            width: 850px !important; 
            background: white; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            border-radius: 0 0 8px 8px; 
            padding: 35px 50px;
            z-index: 2000; 
            opacity: 0; 
            visibility: hidden; 
            transition: all 0.3s ease; 
            margin-top: 0; 
        }

        .login-mega-top { display: flex; flex-direction: row; justify-content: space-between; align-items: center; padding-bottom: 25px; width: 100%; }
        .login-icons { display: flex; flex-direction: row; gap: 40px; }
        .login-action-area { width: 260px; display: flex; flex-direction: column; align-items: center; }
        .mega-login-btn { background-color: #0088CE; color: white; border: none; border-radius: 6px; padding: 14px 0; width: 100%; font-size: 16px; font-weight: 800; cursor: pointer; margin-bottom: 12px; transition: background 0.3s ease; }
        .mega-login-btn:hover { background-color: #005eb8; }
        .signup-prompt { font-size: 14px; color: #333; margin: 0; }
        .signup-prompt a { color: #005eb8; font-weight: bold; text-decoration: none; }

        /* =========================================
           CEB SUPER PASS HERO BANNER
           ========================================= */
        .ceb-super-pass-hero {
            background-color: var(--ceb-yellow); 
            margin-top: 105px; /* Clears the fixed header */
            padding: 100px 0 180px 0; 
            border-bottom-left-radius: 50% 8%; 
            border-bottom-right-radius: 50% 8%;
        }

        .hero-content {
            max-width: 1050px; 
            margin: 0 auto;
            padding: 0 20px;
            text-align: left; 
        }

        .hero-content h1 { 
            font-size: 38px; 
            font-weight: 800; 
            color: #0060A7; 
            margin-top: 0; 
            margin-bottom: 10px; 
            text-shadow: none !important; 
            letter-spacing: 0.5px;
        }

        .hero-content p { 
            font-size: 20px; 
            font-weight: 500; 
            color: #0062bd; 
            margin: 0; 
            text-shadow: none !important; 
        }

        /* =========================================
           CEB SUPER PASS MAIN CONTENT & CARDS
           ========================================= */
        .csp-main-container {
            display: flex;
            gap: 25px; 
            max-width: 1050px; 
            margin: -120px auto 50px auto; 
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        .csp-card { 
            flex: 2.3; 
            background: white;
            border-radius: 12px; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.08); 
            overflow: hidden;
        } 

        .csp-sidebar { 
            flex: 1; 
            padding: 30px; 
            background: white;
            border-radius: 12px; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.08); 
            overflow: hidden;
        }

        .csp-tabs { display: flex; }
        .tab-btn { 
            flex: 1; 
            padding: 20px 20px; 
            font-weight: 700; 
            font-size: 16px; 
            border: none; 
            cursor: pointer; 
        }
        .tab-btn.active { background: white; border-top: 5px solid #4bc2e8; color: #333; }
        .tab-btn.inactive { background: #f3f3f3; color: #999; border-top: 5px solid transparent; }

        .csp-content { 
            display: flex; 
            padding: 35px 40px; 
            min-height: auto; 
            justify-content: space-between; 
            align-items: center; 
        }

        .csp-text { max-width: 60%; }
        .csp-text h2 { color: #555; font-size: 24px; margin-bottom: 10px; }
        .csp-text p { color: #555; margin-bottom: 15px; line-height: 1.5; }
        .cheap-flights-link { color: #0088CE; font-weight: 800; text-decoration: none; }

        .csp-search-btn {
            background-color: #0088ce; 
            color: white; 
            border: none; 
            padding: 14px 25px;
            border-radius: 6px; 
            font-size: 16px; 
            font-weight: 700; 
            margin-top: 15px;
            cursor: pointer; 
            width: 320px; 
        }

        .csp-image-wrapper { text-align: center; }
        .csp-character { max-width: 160px; object-fit: contain; }

        .steps-list { list-style: none; padding: 0; margin: 0; }
        .steps-list li { margin-bottom: 20px; display: flex; align-items: flex-start; gap: 15px; } 
        .step-num { 
            background: #6dc6f2; color: white; min-width: 25px; height: 25px; 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px; 
        }
        .step-text { font-size: 14px; color: #333; line-height: 1.4; }
        .step-text small { display: block; color: #888; margin-top: 4px; font-size: 11px; }

        /* =========================================
           UPDATED FOOTER STYLES
           ========================================= */
        .site-footer { 
            background-color: #ffffff; 
            padding: 60px 20px 40px 20px; 
            border-top: 1px solid #eaeaea; 
            width: 100%; 
        }
        
        .footer-container { 
            max-width: 1150px; 
            margin: 0 auto; 
            display: flex; 
            gap: 60px; 
            justify-content: space-between; 
        }
        
        .footer-grid-left { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 40px; 
            flex: 2.5; 
        }
        
        .footer-col { display: flex; flex-direction: column; }
        .footer-group { display: flex; flex-direction: column; }
        
        .footer-group h4, .footer-right-sidebar h4 { 
            font-size: 14px; 
            color: #000000; 
            margin-bottom: 20px; 
            font-weight: 900; 
            letter-spacing: 0.5px; 
            text-transform: uppercase; 
        }
        
        .footer-group a { 
            color: #00a4e4; 
            text-decoration: none; 
            font-size: 15px; 
            margin-bottom: 16px; 
            transition: color 0.2s; 
        }
        
        .footer-group a:hover { 
            text-decoration: underline; 
            color: #007bb5; 
        }
        
        .country-box { 
            display: flex; 
            align-items: center; 
            border: 1px solid #ccc; 
            padding: 12px 15px; 
            border-radius: 4px; 
            font-size: 15px; 
            color: #000; 
            font-weight: 700; 
            cursor: pointer; 
            width: 100%; 
            background: #fff; 
            gap: 10px; 
            box-sizing: border-box;
        }
        
        .country-box i { font-size: 16px; }
        
        .footer-right-sidebar { 
            flex: 1; 
            min-width: 300px; 
            border-left: 1px solid #e0e0e0; 
            padding-left: 40px; 
            display: flex; 
            flex-direction: column; 
            gap: 30px; 
        }
        
        .app-buttons { display: flex; gap: 12px; }
        .app-buttons img { height: 40px; width: auto; }
        
        .payment-logos { 
            display: flex; 
            flex-direction: column; 
            gap: 15px; 
        }
        
        .payment-row-1 { 
            display: flex; 
            gap: 20px; 
            align-items: center; 
        }
        
        .payment-row-1 img { 
            height: 45px; 
            width: auto; 
        }
        
        .payment-row-2 img { 
            height: 30px; 
            width: auto; 
        }
        
        .accreditations { display: flex; align-items: center; gap: 15px; }
        .accreditations img { height: 70px; width: auto; }
        
        .footer-bottom { 
            background-color: var(--ceb-yellow); 
            padding: 25px 20px; 
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
        
        .footer-legal-links { display: flex; flex-wrap: wrap; gap: 30px; }
        
        .footer-legal-links a { 
            color: var(--ceb-blue); 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 800; 
        }
        
        .footer-legal-links a:hover { text-decoration: underline; }
        
        .copyright-text { 
            font-size: 14px; 
            color: var(--ceb-blue); 
            font-weight: 800; 
        }
        .user-initials-icon {
            background-color: var(--ceb-blue);
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            margin-right: 10px; /* This creates the space before "My Account" */
            letter-spacing: 1px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 900px) {
            .csp-main-container { flex-direction: column; }
            .footer-container { flex-direction: column; }
            .footer-grid-left { grid-template-columns: repeat(2, 1fr); }
            .footer-right-sidebar { border-left: none; padding-left: 0; border-top: 1px solid #e0e0e0; padding-top: 30px; }
        }
    </style>
</head>
<body>

    <!-- ========================================== -->
    <!-- TOP ADVISORY -->
    <!-- ========================================== -->
    <div class="top-advisory-bar">
        <div class="header-content-wrapper">
            <div class="advisory-left">
            </div>
            <div class="advisory-right">
                <a href="#">
                </a>
                <span class="disabled-text"><i class="fa-solid fa-circle-dollar-to-slot" style="margin-right: 6px;"></i> PHP</span>
                <span class="disabled-text"><i class="fa-solid fa-globe" style="margin-right: 6px;"></i> English</span>
            </div>
        </div>
    </div>

     <!-- ========================================== -->
    <!-- MAIN HEADER WITH MEGA MENUS -->
    <!-- ========================================== -->
    <header class="hero-header">
        <div class="header-content-wrapper">
            <a href="index.php">
                <img class="logo-colored" src="images/CEB_logo_LFEJ_in_Noto_Sans_Linear.webp" alt="Cebu Pacific">
            </a>
            
            <nav class="nav-links">
                <!-- 1. BOOK -->
                <div class="nav-item">
                    <a href="#" class="nav-link main-link">Book</a>
                    <div class="mega-menu">
                        <div class="mega-top">
                            <a href="index.php" class="mega-icon-link">
                                <div class="mega-icon"><img src="images/flight-status-default.png" alt="Flights" class="custom-mega-img"></div>
                                <span>Flights</span>
                            </a>
                            <a href="seatsale.php" class="mega-icon-link">
                                <div class="mega-icon"><img src="images/your-seatsale-icon.webp" alt="Seat Sale" class="custom-mega-img"></div>
                                <span>Seat Sale</span>
                            </a>
                            <a href="cebsuperpass.php" class="mega-icon-link">
                                <div class="mega-icon"><img src="images/super-pass-default.png" alt="CEB Super Pass" class="custom-mega-img"></div>
                                <span>CEB Super Pass</span>
                            </a>
                        </div>
                        <hr class="mega-divider">
                        <div class="mega-bottom">
                            <h4 class="mega-heading">FOR BUSINESS</h4>
                            <div class="business-grid">
                                <div class="business-item">
                                    <a href="partner-login.html">Partner Agents</a>
                                    <p>Log in with your agent ID</p>
                                </div>
                                <div class="business-item">
                                    <a href="cargo.php">Cargo</a>
                                    <p>Know more about our fast and flexible air cargo service</p>
                                </div>
                                <div class="business-item">
                                    <a href="Sales-&-Group-Bookings.php">Sales & Group Bookings</a>
                                    <p>Be a partner and maximize your business' travel budget</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 2. MANAGE -->
                <div class="nav-item">
                    <a href="#" class="nav-link main-link">Manage</a>
                    <div class="mega-menu">
                        <div class="mega-top">
                            <a href="check-in.php" class="mega-icon-link">
                                <div class="mega-icon"><img src="images/check-in-default1.png" alt="Check in" class="custom-mega-img"></div>
                                <span>Check in</span>
                            </a>
                            <a href="manage-booking.php" class="mega-icon-link">
                                <div class="mega-icon"><img src="images/manage-booking-default.png" alt="Manage Booking" class="custom-mega-img"></div>
                                <span>Manage Booking</span>
                            </a>
                            <a href="flight-status.php" class="mega-icon-link">
                                <div class="mega-icon"><img src="images/FlightStatusIcon.webp" alt="Flight Status" class="custom-mega-img"></div>
                                <span>Flight Status</span>
                            </a>
                        </div>
                        <hr class="mega-divider">
                        <div class="mega-bottom">
                            <div class="manage-grid">
                                <div class="manage-item">
                                    <a href="CEB-Add-ons.php"><i class="fa-solid fa-chair" style="font-size: 13px; margin-right: 6px;"></i> Add-ons</a>
                                    <p>Learn how to upgrade your trip with <a href="#" class="inline-link">baggage, meals, seats,</a> and other services</p>
                                </div>
                                <div class="manage-item">
                                    <a href="Special-Assistance.php"><i class="fa-solid fa-wheelchair" style="font-size: 13px; margin-right: 6px;"></i> Special Assistance</a>
                                    <p>Request services for guests needing special assistance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 3. TRAVEL INFO -->
                <div class="nav-item">
                    <a href="#" class="nav-link main-link">Travel Info</a>
                    <div class="mega-menu">
                        <h4 class="mega-heading">BEFORE THE FLIGHT</h4>
                        <div class="travel-grid">
                            <div class="travel-item"><a href="baggage_info.php"><i class="fa-solid fa-suitcase"></i> Baggage Information</a></div>
                            <div class="travel-item"><a href="payment-options.php"><i class="fa-solid fa-credit-card"></i> Payment Options</a></div>
                            <div class="travel-item"><a href="Travel-Advisories.php"><i class="fa-solid fa-circle-info"></i> Travel Advisories</a></div>
                            <div class="travel-item"><a href="BookingCheckinandBoarding.php"><i class="fa-solid fa-location-dot"></i> Booking & Check-in</a></div>
                            <div class="travel-item"><a href="TravelDocuments.php"><i class="fa-solid fa-file-lines"></i> Travel Documents</a></div>
                            <div class="travel-item"><a href="Special-Assistance.php"><i class="fa-solid fa-wheelchair"></i> Special Assistance</a></div>
                        </div>
                        <hr class="mega-divider">
                        <h4 class="mega-heading">FLYING WITH US</h4>
                        <div class="travel-grid">
                            <div class="travel-item"><a href="FAQs.php"><i class="fa-solid fa-circle-question"></i> FAQs</a></div>
                            <div class="travel-item"><a href="Service-Fees.php"><i class="fa-solid fa-tag"></i> Service Fees</a></div>
                            <div class="travel-item"><a href="CEB-Add-ons.php"><i class="fa-solid fa-chair"></i> Add-Ons</a></div>
                            <div class="travel-item"><a href="flight-status.php"><i class="fa-solid fa-plane-departure"></i> Flight Status</a></div>
                            <div class="travel-item"><a href="AirlinePolicies.php"><i class="fa-solid fa-passport"></i> Airline Policies</a></div>
                        </div>
                    </div>
                </div>
                
                <!-- 4. EXPLORE -->
                <div class="nav-item">
                    <a href="#" class="nav-link main-link">Explore</a>
                    <div class="mega-menu">
                        <div class="explore-top-grid">
                            <div class="explore-dest-col">
                                <a href="CityGuides.php" class="explore-heading"><i class="fa-solid fa-map-location-dot"></i> Philippine Destinations</a>
                                <div class="destination-cards">
                                    <a href="#" class="dest-card" style="background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0)), url('images/Boracay_1_sabw7m.jpg');"><span>Boracay</span></a>
                                    <a href="#" class="dest-card" style="background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0)), url('images/images (2).jpg');"><span>Siargao</span></a>
                                    <a href="#" class="dest-card" style="background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0)), url('images/cebu.jpg');"><span>Cebu</span></a>
                                </div>
                            </div>
                            <div class="explore-dest-col">
                                <a href="CityGuides.php" class="explore-heading"><i class="fa-solid fa-globe"></i> International Destinations</a>
                                <div class="destination-cards">
                                    <a href="#" class="dest-card" style="background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0)), url('images/dubai.jpg');"><span>Dubai</span></a>
                                    <a href="#" class="dest-card" style="background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0)), url('images/hongkong.jpg');"><span>Hong Kong</span></a>
                                    <a href="#" class="dest-card" style="background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0)), url('images/singapore.jpg');"><span>Singapore</span></a>
                                </div>
                            </div>
                        </div>
                        <hr class="mega-divider">
                        <div class="explore-bottom-grid">
                            <div class="explore-item">
                                <a href="DiscoverwithSmile.php"><i class="fa-solid fa-lightbulb"></i> Discover with Smile</a>
                                <p>Simple tips to make you a better and smarter traveler</p>
                            </div>
                            <div class="explore-item">
                                <a href="where-we-fly.php"><i class="fa-solid fa-map"></i> Where We Fly</a>
                                <p>See our full list of destinations and choose where to go for your next trip</p>
                            </div>
                            <div class="explore-item">
                                <a href="CityGuides.php"><i class="fa-solid fa-location-dot"></i> City Guides</a>
                                <p>Know the basics and discover hidden gems in your next destination</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 5. ABOUT -->
                <div class="nav-item">
                    <a href="#" class="nav-link main-link">About</a>
                    <div class="mega-menu">
                        <div class="about-grid">
                            <div class="about-item">
                                <a href="our-story.php">Our Story</a>
                                <p>See how we made moments happen for everyjuan from 1996 up to present</p>
                            </div>
                            <div class="about-item">
                                <a href="media-center.php">Media Center</a>
                                <p>Be updated on the latest airline news through our press releases and media galleries</p>
                            </div>
                            <div class="about-item">
                                <a href="Talk-to-Us.php">Talk to Us</a>
                                <p>Get answers to your questions or send feedback</a> to our customer support team</p>
                            </div>
                            <div class="about-item">
                                <a href="Campaigns-&-Partners.php">Campaigns & Partners</a>
                                <p>Read up on our campaigns and partnership initiatives</p>
                            </div>
                            <div class="about-item">
                                <a href="corporate-information.php">Company Information</a>
                                <p>Read more information about Cebu Pacific for shareholders, potential investors, and financial analysts</p>
                            </div>
                            <div class="about-item">
                                <a href="careers.php">Careers <img src="images/OpenNewTab.webp" alt="Careers" style="width: 16px; height: 16px; margin-left: 5px; vertical-align: middle;"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
                
<div class="header-right">
    <div class="login-dropdown-wrapper">
        <?php if ($isLoggedIn): ?>
            <!-- LOGGED IN STATE -->
            <button class="login-btn" onclick="window.location.href='my-account.php'">
                <div class="user-initials-icon"><?php echo htmlspecialchars($initials); ?></div>
                <span>My Account</span>
            </button>
            
            <!-- LOGGED-IN MEGA MENU DROPDOWN -->
            <div class="mega-menu login-mega-menu">
                <div class="login-mega-top" style="position: relative;">
                    <div class="login-icons">
                        <a href="manage-booking.php" class="mega-icon-link">
                            <div class="mega-icon"><img src="images/BookingsBoarding.webp" alt="My Bookings" class="custom-mega-img"></div>
                            <span>My Bookings</span>
                        </a>
                        <a href="coming-soon.php" class="mega-icon-link">
                            <div class="mega-icon"><img src="images/Wallet.webp" alt="Wallet" class="custom-mega-img"></div>
                            <span>Wallet</span>
                        </a>
                        <a href="coming-soon.php" class="mega-icon-link">
                            <div class="mega-icon"><img src="images/Guests_1.webp" alt="Guests" class="custom-mega-img"></div>
                            <span>Guests</span>
                        </a>
                        <a href="coming-soon.php" class="mega-icon-link">
                            <div class="mega-icon"><img src="images/Inbox.webp" alt="Inbox" class="custom-mega-img"></div>
                            <span>Inbox</span>
                        </a>
                    </div>
                    <div style="position: absolute; top: 0; right: 0;">
                        <a href="logout.php" style="color: #0088CE; font-weight: bold; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-right-from-bracket"></i> Log out
                        </a>
                    </div>
                </div>

                <hr class="mega-divider">

                <div class="mega-bottom">
                    <div class="business-grid" style="grid-template-columns: repeat(2, 1fr);">
                        <div class="business-item">
                            <a href="my-account.php">Travel Fund</a>
                            <p>View your available Travel Fund and use it to book flights or add-ons</p>
                        </div>
                        <div class="business-item">
                            <a href="#">My Vouchers</a>
                            <p>Redeem your travel vouchers before they expire</p>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- LOGGED OUT STATE -->
            <a href="login.html" class="login-btn">
                <i class="fa-regular fa-circle-user" style="margin-right: 6px;"></i> Log in
            </a>

            <!-- LOGGED-OUT MEGA MENU DROPDOWN -->
            <div class="mega-menu login-mega-menu">
                <div class="login-mega-top">
                    <div class="login-icons">
                        <a href="manage-booking.php" class="mega-icon-link">
                            <div class="mega-icon"><img src="images/BookingsBoarding.webp" alt="My Bookings" class="custom-mega-img"></div>
                            <span>My Bookings</span>
                        </a>
                        <a href="wallet.php" class="mega-icon-link">
                            <div class="mega-icon"><img src="images/Wallet.webp" alt="Wallet" class="custom-mega-img"></div>
                            <span>Wallet</span>
                        </a>
                        <a href="coming-soon.php" class="mega-icon-link">
                            <div class="mega-icon"><img src="images/Guests_1.webp" alt="Guests" class="custom-mega-img"></div>
                            <span>Guests</span>
                        </a>
                        <a href="coming-soon.php" class="mega-icon-link">
                            <div class="mega-icon"><img src="images/Inbox.webp" alt="Inbox" class="custom-mega-img"></div>
                            <span>Inbox</span>
                        </a>
                    </div>
                    <div class="login-action-area">
                        <button class="mega-login-btn" onclick="window.location.href='login.html'">Log in</button>
                        <p class="signup-prompt">Not yet a member? <a href="signup.html">Sign up</a></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- HERO BANNER -->
    <!-- ========================================== -->
    <div class="ceb-super-pass-hero">
        <div class="hero-content">
            <h1>CEB Super Pass</h1>
            <p>Flexible, affordable one-way vouchers for any of our domestic destinations</p>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MAIN CARDS CONTAINER -->
    <!-- ========================================== -->
    <div class="csp-main-container">
        
        <!-- Left Card: Buy/Redeem -->
        <div class="csp-card">
            <div class="csp-tabs">
                <button class="tab-btn active">Buy</button>
                <button class="tab-btn inactive">Redeem</button>
            </div>
            
            <div class="csp-content">
                <div class="csp-text">
                    <h2>We're all sold out</h2>
                    <p>Thank you for choosing Cebu Pacific.</p>
                    <p>In case you weren't able to grab a CEB Super Pass, you can <br>
                    <a href="#" class="cheap-flights-link">check out our other cheap flights</a>!</p>
                    <button class="csp-search-btn">Search Flights</button>
                </div>
                <div class="csp-image-wrapper">
                    <img src="images/csp-girl-illustration.webp" alt="Character" class="csp-character">
                </div>
            </div>
        </div>

        <!-- Right Sidebar: How to buy -->
        <div class="csp-sidebar">
            <h3 style="margin-bottom: 20px; display: flex; align-items: center;">
                How to buy 
                <img src="images/plane-icon.webp" alt="" style="height: 24px; margin-left: 8px;">
            </h3>
            
            <ul class="steps-list">
                <li>
                    <span class="step-num">1</span> 
                    <div class="step-text">Sign up or log in to your MyCebuPacific account to purchase</div>
                </li>
                <li>
                    <span class="step-num">2</span> 
                    <div class="step-text">Buy up to 10 vouchers per transaction <br><small>Tip: You can transact as many times as you want</small></div>
                </li>
                <li>
                    <span class="step-num">3</span> 
                    <div class="step-text">Enter the names of the voucher holders, then pay for the amount due</div>
                </li>
            </ul>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- FOOTER SECTION -->
    <!-- ========================================== -->
    <footer class="site-footer">
        <div class="footer-container">
            
            <div class="footer-grid-left">
                <div class="footer-col">
                    <div class="footer-group">
                        <h4>BOOK</h4>
                        <a href="index.html">Flights</a>
                        <a href="seatsale.html">Seat Sale</a>
                    </div>
                    <div class="footer-group" style="margin-top: 60px;">
                        <h4>ABOUT</h4>
                        <a href="#">About</a>
                        <a href="#">Our Story</a>
                        <a href="#">Media Center</a>
                        <a href="#">Talk to Us</a>
                        <a href="#">Careers</a>
                    </div>
                </div>

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
                    <div class="footer-group" style="margin-top: 60px;">
                        <h4>SELECT COUNTRY</h4>
                        <div class="country-box">
                            <i class="fa-solid fa-earth-asia"></i> Philippines
                        </div>
                    </div>
                </div>

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
                    <div class="payment-logos">
                        <div class="payment-row-1">
                            <img src="images/Visa-logo.webp" alt="Visa">
                            <img src="images/Mastercard_logo-128x80.webp" alt="Mastercard">
                        </div>
                        <div class="payment-row-2">
                            <img src="images/GCash-276x96.webp" alt="GCash">
                        </div>
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