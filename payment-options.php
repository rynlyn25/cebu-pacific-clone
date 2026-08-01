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
    <title>Payment Methods - Cebu Pacific</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* =========================================
           GLOBAL RESET & TYPOGRAPHY
           ========================================= */
        :root {
            --ceb-yellow: #FFC000;
            --ceb-blue: #005eb8;
            --ceb-light-blue: #0088ce;
            --primary-color: #0098e1;
            --text-dark: #333333;
            --text-light: #444444;
            --border-color: #e2e8f0;
            --sidebar-line: #d2e4f0;
            --yellow-accent: #ffdb00;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        html { scroll-behavior: smooth; }

        body {
            background-color: #ffffff;
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
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
            height: 100%;
        }

        .advisory-left { display: flex; align-items: center; font-size: 13px; }
        .advisory-right { display: flex; align-items: center; gap: 40px; }
        .advisory-right a { color: white; text-decoration: none; font-size: 13px; font-weight: bold; display: flex; align-items: center; cursor: pointer; }
        .advisory-right a:hover { opacity: 0.8; }
        .disabled-text { color: white; font-size: 13px; font-weight: bold; display: flex; align-items: center; opacity: 0.6; pointer-events: none; cursor: default; }

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

        /* BULLETPROOF CENTERED HEADER */
        .hero-header .header-content-wrapper {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center;
            width: 100%;
            height: 100%; 
        }

        .hero-header .header-content-wrapper > a:first-child { flex: 1; display: flex; justify-content: flex-start; }
        .hero-header .nav-links { flex: none; display: flex; gap: 30px; justify-content: center; align-items: center; margin: 0; padding: 0; height: 100%; }
        .hero-header .header-right { flex: 1; display: flex; justify-content: flex-end; align-items: center; gap: 20px; height: 100%; }

        .nav-item { position: static; display: flex; align-items: center; height: 100%; }
        .main-link { color: var(--ceb-blue); text-decoration: none; font-weight: 700; font-size: 15px; height: 100%; display: flex; align-items: center; transition: color 0.2s; }
        .nav-item:hover .main-link { color: #00a1e4; }
        .nav-item:hover::after { content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 4px; background: #00a1e4; }

        .mega-menu {
            position: absolute; top: 70px; left: 50%; transform: translateX(-50%); width: 950px;          
            background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 0 0 8px 8px;
            padding: 35px 50px; z-index: 2000; opacity: 0; visibility: hidden; transition: all 0.3s ease;
        }
        .nav-item:hover .mega-menu { opacity: 1; visibility: visible; }

        .mega-top { display: flex; gap: 60px; margin-bottom: 25px; }
        .mega-icon-link { display: flex; flex-direction: column; align-items: center; text-decoration: none; transition: all 0.2s ease; }
        .mega-icon-link span { color: #005eb8 !important; font-weight: bold; font-size: 15px; margin-top: 12px; }
        .mega-icon-link:hover span { color: #00a1e4 !important; }
        .mega-icon { background-color: transparent; display: flex; justify-content: center; align-items: center; transition: transform 0.2s ease; }
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

        /* Login Dropdown */
        .login-dropdown-wrapper { position: relative !important; display: flex; align-items: center; height: 100%; }
        .login-btn { background: transparent; color: var(--ceb-blue); border: none; font-size: 16px; font-weight: 800; cursor: pointer; display: flex; align-items: center; height: 100%; padding: 0; margin: 0; }
        .login-dropdown-wrapper:hover .login-btn { border-bottom: none !important; padding-bottom: 0 !important; }
        .login-dropdown-wrapper::after { display: none !important; }

        .login-mega-menu {
            position: absolute !important; top: 100% !important; left: auto !important; right: -10px !important; 
            transform: none !important; width: 850px !important; background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 0 0 12px 12px; padding: 35px 50px; z-index: 2000; opacity: 0; visibility: hidden; transition: all 0.3s ease; margin-top: 0; 
        }

        .login-dropdown-wrapper:hover .login-mega-menu { opacity: 1; visibility: visible; }
        .login-mega-top { display: flex; flex-direction: row; justify-content: space-between; align-items: center; padding-bottom: 25px; width: 100%; }
        .login-icons { display: flex; flex-direction: row; gap: 40px; }
        .login-action-area { width: 260px; display: flex; flex-direction: column; align-items: center; }
        .mega-login-btn { background-color: #0088CE; color: white; border: none; border-radius: 6px; padding: 14px 0; width: 100%; font-size: 16px; font-weight: 800; cursor: pointer; margin-bottom: 12px; transition: background 0.3s ease; }
        .mega-login-btn:hover { background-color: #005eb8; }
        .signup-prompt { font-size: 14px; color: #333; margin: 0; }
        .signup-prompt a { color: #005eb8; font-weight: bold; text-decoration: none; }

        .header-search-icon { color: var(--ceb-blue); font-size: 18px; text-decoration: none; cursor: pointer; padding-left: 10px; }
        .header-search-icon:hover { color: #00a1e4; }

        /* =========================================
           PAYMENT PAGE STYLES
           ========================================= */

        /* Yellow Top Header Banner - Fixed size and curve */
        .page-header {
            background-color: var(--yellow-accent);
            width: 100%;
            margin-top: 105px; 
            padding: 50px 20px 60px 20px; 
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            position: relative;
            z-index: 100;
            border-bottom-left-radius: 50% 25px;
            border-bottom-right-radius: 50% 25px;
        }

        .page-header h1 {
            color: #0054A6; 
            font-size: 44px; 
            font-weight: 800;
            margin: 0;
            width: 100%;
            max-width: 1200px; 
            padding-left: 25px; 
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            background-color: #ffffff;
            position: relative;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 260px;
            padding: 40px 25px;
            background-color: #ffffff;
            flex-shrink: 0;
        }

        .sidebar-title {
            font-size: 13px;
            font-weight: 700;
            color: #005691;
            padding: 0 0 15px 5px;
            letter-spacing: 0.5px;
        }

        .nav-links-sidebar {
            display: flex;
            flex-direction: column;
        }

        .sidebar .nav-item-sidebar {
            padding: 16px 5px;
            text-decoration: none;
            color: var(--text-light);
            font-size: 16px;
            border-bottom: 1px solid var(--sidebar-line);
            transition: color 0.1s ease-in-out;
            display: block;
        }

        .sidebar .nav-item-sidebar:hover { color: var(--primary-color); }
        .sidebar .nav-item-sidebar.active { color: var(--primary-color); font-weight: 600; }
        .sidebar .nav-item-sidebar:hover::after { display: none; }

        /* Content Area layout */
        .content {
            flex: 1;
            padding: 40px 50px;
        }

        .payment-section {
            padding: 10px 0;
            margin-bottom: 60px;
            scroll-margin-top: 120px; 
        }

        .section-header {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 20px;
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .section-icon-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .content h2 {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1a1a1a;
        }

        .subtitle {
            font-size: 18px;
            color: #444444;
            line-height: 1.6;
        }

        .logo-group {
            display: flex;
            gap: 15px;
            margin: 25px 0;
            flex-wrap: wrap;
            align-items: center;
        }

        .credit-card-image, .ewallet-image {
            max-height: 90px;
            width: auto;
            display: block;
        }

        .notice {
            font-size: 16px;
            color: #555555;
            margin-bottom: 16px;
            line-height: 1.6;
        }

        .link {
            font-size: 16px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .alert-box {
            margin: 30px 0;
        }

        .alert-box h3 {
            font-size: 19px;
            color: #e53e3e;
            margin-bottom: 6px;
        }

        .alert-box p {
            font-size: 17px;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .alert-box .small {
            color: #555555;
            margin-top: 6px;
        }

        .subsection-title {
            font-size: 19px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .accordion-container {
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }

        .accordion-item {
            border-bottom: 1px solid var(--border-color);
        }

        .accordion-item:last-child { border-bottom: none; }

        .accordion-header {
            width: 100%;
            background: #ffffff;
            border: none;
            padding: 18px 24px;
            text-align: left;
            font-size: 17px;
            color: var(--text-dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 500;
        }

        .accordion-header:hover {
            background-color: #f8fafc;
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
            background-color: #fdfdfd;
        }

        .payment-instructions {
            padding: 25px 30px;
            color: #333333;
        }

        .accordion-brand-logo-711 { display: block; max-width: 65px; height: auto; margin-bottom: 20px; }
        .accordion-brand-logo-ecpay { display: block; max-width: 120px; height: auto; margin-bottom: 20px; }
        .accordion-brand-logo-rbank { display: block; max-width: 190px; height: auto; margin-bottom: 20px; }
        .accordion-brand-logo-rds { display: block; max-width: 110px; height: auto; margin-bottom: 20px; }

        .instructions-title { font-size: 16px; font-weight: bold; margin-bottom: 16px; color: #222222; }
        .instructions-subtitle { font-size: 16px; margin-top: 15px; margin-bottom: 10px; color: #333333; }

        .payment-instructions ol { padding-left: 20px; margin-bottom: 20px; }
        .payment-instructions ol li { font-size: 16px; line-height: 1.7; margin-bottom: 10px; }
        .payment-instructions ul { padding-left: 25px; margin-top: 8px; margin-bottom: 8px; list-style-type: disc; }
        .payment-instructions ul li { font-size: 15.5px; margin-bottom: 4px; }
        .instructions-note { font-size: 15px; line-height: 1.6; color: #444444; margin-top: 15px; }

        .arrow { font-size: 12px; color: #a0aec0; transition: transform 0.2s; }
        .accordion-item.open .arrow { transform: rotate(180deg); }

        .take-note-box {
            margin-top: 35px;
            border-top: 1px solid var(--border-color);
            padding-top: 25px;
        }

        .take-note-box h3 { font-size: 18px; margin-bottom: 12px; }
        .take-note-box ul { padding-left: 20px; font-size: 16px; color: #555555; }
        .take-note-box li { margin-bottom: 8px; line-height: 1.6; }

        /* =========================================
           FOOTER STYLES (PERFECTED ALIGNMENT)
           ========================================= */
        .site-footer { 
            background-color: #ffffff; 
            padding: 60px 20px 40px 20px; 
            border-top: 1px solid #eaeaea; 
            width: 100%; 
            margin-top: 50px;
        }
        
        .footer-container { 
            max-width: 1150px; 
            margin: 0 auto; 
            display: flex; 
            gap: 60px; 
            justify-content: space-between; 
        }
        
        /* Forces exactly 4 columns for the left navigation links */
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

        @media (max-width: 900px) {
            .container { flex-direction: column; }
            .sidebar { width: 100%; padding: 20px; }
            .footer-container { flex-direction: column; }
            .footer-grid-left { grid-template-columns: repeat(2, 1fr); }
            .footer-right-sidebar { border-left: none; padding-left: 0; border-top: 1px solid #e0e0e0; padding-top: 30px; }
        }
    </style>
</head>

<body>
    <!-- TOP ADVISORY BAR -->
    <div class="top-advisory-bar">
        <div class="header-content-wrapper">
            <div class="advisory-left">
            </div>
            <div class="advisory-right">
                <a href="#">
                </a>
                <a href="#" style="color: rgba(255, 255, 255, 0.7); font-weight: 700; text-decoration: none; font-size: 13px; display: flex; align-items: center;">
                    <i class="fa-solid fa-circle-dollar-to-slot" style="margin-right: 6px; font-size: 14px;"></i> PHP <i class="fa-solid fa-caret-down" style="margin-left: 5px; font-size: 11px;"></i>
                </a>
                <a href="#" style="color: rgba(255, 255, 255, 0.7); font-weight: 700; text-decoration: none; font-size: 13px; display: flex; align-items: center; margin-left: 10px; margin-right: 15px;">
                    <i class="fa-solid fa-globe" style="margin-right: 6px; font-size: 14px;"></i> English <i class="fa-solid fa-caret-down" style="margin-left: 5px; font-size: 11px;"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN HEADER -->
    <header class="hero-header">
        <div class="header-content-wrapper">
            <a href="index.php">
                <img class="logo-colored" src="images/CEB_logo_LFEJ_in_Noto_Sans_Linear.webp" alt="Cebu Pacific">
            </a>
            
            <nav class="nav-links">
                <!-- Navigation items removed as requested -->
            </nav>
                
            <div class="header-right">
                <div class="login-dropdown-wrapper">
                    </button>
                </div>

                <a href="#" class="header-search-icon">
                </a>
            </div>
        </div>
    </header>

    <!-- Yellow Top Header Banner -->
    <header class="page-header">
        <h1>Payment Options</h1>
    </header>

    <!-- Unified single frame container without extra outer page partitions -->
    <div class="container">

        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <p class="sidebar-title">PAYMENT METHODS</p>
            <nav class="nav-links-sidebar">
                <a href="#credit-cards" class="nav-item-sidebar active">Credit/Debit Cards</a>
                <a href="#e-wallets" class="nav-item-sidebar">e-Wallets</a>
                <a href="#payment-centers" class="nav-item-sidebar">Payment Centers</a>
                <a href="#travel-fund" class="nav-item-sidebar">Travel Fund</a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="content">

            <!-- Section: Credit Cards -->
            <section id="credit-cards" class="payment-section">
                <div class="section-header">
                    <div class="icon-circle">
                        <img src="images/Credit-Card.jpg" alt="Credit Card Icon" class="section-icon-img">
                    </div>
                    <div>
                        <h2>Credit Cards and Debit Cards</h2>
                        <p class="subtitle">Booking flights just got easier with these online payment options!</p>
                    </div>
                </div>
                <!-- Updated to look for creditcardcombined_1.jpg in the same folder -->
                <div class="logo-group">
                    <img src="images/creditcardcombined_1.jpg" alt="Credit Card Logos" class="credit-card-image">
                </div>
                <p class="notice">We accept Visa, MasterCard, JCB, and American Express (AMEX) credit/debit cards only.
                </p>
                <a href="#" class="link">&gt; Japan Payment Terms</a>
            </section>

            <!-- Section: e-Wallets -->
            <section id="e-wallets" class="payment-section">
                <div class="section-header">
                    <div class="icon-circle">
                        <img src="images/e-Wallet.jpg" alt="e-Wallet Icon" class="section-icon-img">
                    </div>
                    <div>
                        <h2>e-Wallets</h2>
                        <p class="subtitle">Pay for your booking in a few clicks with our cashless payment options. Make
                            sure you have an existing and verified account to use these!</p>
                    </div>
                </div>
                <!-- Updated to use your provided e-Wallets image -->
                <div class="logo-group">
                    <img src="images/Ewallet-New.jpg" alt="e-Wallet Logos" class="ewallet-image">
                </div>
                <p class="notice">GCash, Maya, and GrabPay only accept payments in PHP. Your booking total will be
                    converted to PHP, and you will be charged with the converted amount.</p>
            </section>

            <!-- Section: Payment Centers -->
            <section id="payment-centers" class="payment-section">
                <div class="section-header">
                    <div class="icon-circle">
                        <img src="images/Payment Center.jpg" alt="Payment Center Icon" class="section-icon-img">
                    </div>
                    <div>
                        <h2>Payment Centers</h2>
                        <p class="subtitle">Prefer to pay in cash? Pay over the counter at partner establishments, for
                            bookings you made through our website.</p>
                    </div>
                </div>

                <div class="alert-box">
                    <h3>Within 8 Hours</h3>
                    <p>Pay within 8 hours after booking your flight, and get your confirmed ticket immediately!</p>
                    <p class="small"><strong>Note:</strong> A hold fee will be included in your booking total to secure
                        the price you booked.</p>
                </div>

                <h3 class="subsection-title">Payment Centers in the Philippines</h3>

                <!-- Accordion Component -->
                <div class="accordion-container">
                    <div class="accordion-item">
                        <button class="accordion-header">7-Eleven <span class="arrow">▼</span></button>
                        <div class="accordion-content">
                            <div class="payment-instructions">
                                <img src="images/7eleven.jpg" alt="7-Eleven Logo" class="accordion-brand-logo-711">
                                <p class="instructions-title">PAYMENT INSTRUCTIONS :</p>
                                <ol>
                                    <li>Go to a CLIQQ Kiosk Machine at a 7-eleven near you, or use the CliQQ Mobile App
                                    </li>
                                    <li>Select 'Bills Payment' or 'Pay Bills'</li>
                                    <li>Use the Search tab in the upper right part of the screen and enter:
                                        <strong>CEBUPACIFIC</strong>
                                    </li>
                                    <li>You can also select <strong>CEBUPACIFIC</strong> under the Airline category</li>
                                    <li>Fill out the required fields:
                                        <ul>
                                            <li>12-digit reference number</li>
                                            <li>Full name</li>
                                            <li>Total amount due</li>
                                        </ul>
                                    </li>
                                    <li>Bring the bar-coded payment slip to the cashier for payment</li>
                                    <li>Once payment is successful, the cashier will issue an acknowledgment receipt
                                    </li>
                                </ol>
                                <p class="instructions-note"><em>Note that 7 Eleven can only accept payment if the total
                                        amount to be paid is PHP 10,000 or below. If the total amount is more than this,
                                        payment must be made via credit/debit cards or e-wallets.</em></p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header">ECPay <span class="arrow">▼</span></button>
                        <div class="accordion-content">
                            <div class="payment-instructions">
                                <img src="images/ECPay.jpg" alt="ECPay Logo" class="accordion-brand-logo-ecpay">
                                <p class="instructions-title">PAYMENT INSTRUCTIONS :</p>
                                <ol>
                                    <li>Go to a CLIQQ Kiosk Machine at a EC near you, or use the CliQQ Mobile App</li>
                                    <li>Select 'Bills Payment' or 'Pay Bills'</li>
                                    <li>Use the Search tab in the upper right part of the screen and enter:
                                        <strong>CEBUPACIFIC</strong>
                                    </li>
                                    <li>You can also select <strong>CEBUPACIFIC</strong> under the Airline category</li>
                                    <li>Fill out the required fileds:
                                        <ul>
                                            <li>12-digit reference number</li>
                                            <li>Full name</li>
                                            <li>Total amount due</li>
                                        </ul>
                                    </li>
                                    <li>Bring the bar-coded payment slip to the cashier for payment</li>
                                    <li>Once payment is successful, the cashier will issue an acknowledgment receipt
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header">Robinsons Bank <span class="arrow">▼</span></button>
                        <div class="accordion-content">
                            <div class="payment-instructions">
                                <img src="images/Rbank.jpg" alt="Robinsons Bank Logo" class="accordion-brand-logo-rbank">
                                <p class="instructions-title">PAYMENT INSTRUCTIONS :</p>

                                <p class="instructions-subtitle"><strong>Over-the-counter</strong></p>
                                <ol>
                                    <li>Go to any Robinsons Bank Branch</li>
                                    <li>Fill out the Robinsons Bank Payment Slip and indicate the following details:
                                        <ul>
                                            <li>Biller account name: Cebu Pacific</li>
                                            <li>12-digit reference number</li>
                                            <li>Contact number</li>
                                            <li>Full name</li>
                                        </ul>
                                    </li>
                                    <li>Submit your accomplished payment form at the counter for payment.</li>
                                </ol>

                                <p class="instructions-subtitle"><strong>Personal Online Banking</strong></p>
                                <ol>
                                    <li>Log in to your Robinsons Bank account</li>
                                    <li>Go to the menu and select 'Transfer & Pay'</li>
                                    <li>Select source account</li>
                                    <li>Select 'Biller' as the Payee Type</li>
                                    <li>Select 'Pay This Company/Biller' and choose Cebu Pacific</li>
                                    <li>Enter your 12-digit reference number in the Subscriber Number field</li>
                                    <li>Enter your full name in the Subscriber Name field</li>
                                    <li>Enter the total amount due in the Amount field</li>
                                    <li>Select 'Continue' and confirm payment</li>
                                    <li>After a successful payment, a payment confirmation with your transaction
                                        reference number will be shown. You will also receive an email about the status
                                        of your transaction</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header">Robinsons Department Store <span
                                class="arrow">▼</span></button>
                        <div class="accordion-content">
                            <div class="payment-instructions">
                                <img src="images/RobinsonsDept.jpg" alt="Robinsons Department Store Logo"
                                    class="accordion-brand-logo-rds">
                                <p class="instructions-title">PAYMENT INSTRUCTIONS :</p>
                                <ol>
                                    <li>Go to any Robinsons Department Store</li>
                                    <li>Fill out the payment form and indicate the following details:
                                        <ul>
                                            <li>12-digit reference number</li>
                                            <li>Total amount due</li>
                                        </ul>
                                    </li>
                                    <li>Submit your accomplished payment form at the counter for payment</li>
                                    <li>Check your receipt for confirmation of your payment details</li>
                                    <li>A copy of your Itinerary Receipt will be sent to your email</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section: Travel Fund -->
            <section id="travel-fund" class="payment-section">
                <div class="section-header">
                    <div class="icon-circle">
                        <img src="images/Travel-Fund-icon.jpg" alt="Travel Fund Icon" class="section-icon-img">
                    </div>
                    <div>
                        <h2>Travel Fund</h2>
                        <p class="subtitle">Travel Fund is a virtual wallet used to store the total amount you've paid
                            for an existing booking. This can be used as a form of payment when booking a new flight, as
                            well as when purchasing add-ons in the future.</p>
                    </div>
                </div>
                <p class="notice text-muted">It is offered for canceled flights or for flights with schedule changes of
                    more than sixty (60)
                    minutes. For added flexibility, guests who purchased CEB Flexi during their initial booking may
                    also opt to convert their booking to Travel Fund for Voluntary Change/Cancellation purposes.</p>
                <p class="notice text-muted">While Travel Fund remains to be non-transferable, the owner may now use it
                    to book for their
                    family and friends as long as they have a MyCebuPacific account.</p>

                <div class="take-note-box">
                    <h3>Take Note!</h3>
                    <ul>
                        <li>If you have a MyCebuPacific Account, you must log in to use the Travel Fund.</li>
                        <li>Non-members must provide their 6-digit booking reference number which contains the Travel
                            Fund.</li>
                        <li>You can combine your Travel Fund with other payment methods if points are not enough</li>
                    </ul>
                </div>
            </section>

        </main>
    </div>
    
    <!-- FOOTER SECTION -->
    <footer class="site-footer">
        <div class="footer-container">
            
            <div class="footer-grid-left">
                <div class="footer-col">
                    <div class="footer-group">
                        <h4>BOOK</h4>
                        <a href="index.php">Flights</a>
                        <a href="seatsale.php">Seat Sale</a>
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
                        <a href="check-in.html">Check in</a>
                        <a href="manage-booking.html">Manage Booking</a>
                        <a href="flight-status.html">Flight Status</a>
                        <a href="CEB-Add-ons.html">Add-ons</a>
                        <a href="Special-Assistance.html">Special Assistance</a>
                    </div>
                </div>

                <div class="footer-col">
                    <div class="footer-group">
                        <h4>TRAVEL INFO</h4>
                        <a href="baggage_info.html">Baggage Information</a>
                        <a href="payment-options.html">Payment Options</a>
                        <a href="Travel-Advisories.html">Travel Advisories</a>
                        <a href="BookingCheckinandBoarding.html">Booking & Check-in</a>
                        <a href="TravelDocuments.html">Travel Documents</a>
                        <a href="Service-Fees.html">Service Fees</a>
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
                        <a href="CityGuides.html">Philippine Destinations</a>
                        <a href="CityGuides.html">International Destinations</a>
                        <a href="where-we-fly.html">Where We Fly</a>
                        <a href="CityGuides.html">City Guides</a>
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
    
    <!-- BOTTOM YELLOW BAR -->
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const accordionHeaders = document.querySelectorAll('.accordion-header');

            accordionHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const item = header.parentElement;
                    const content = header.nextElementSibling;
                    const isOpen = item.classList.contains('open');

                    // Close all others
                    document.querySelectorAll('.accordion-item').forEach(otherItem => {
                        otherItem.classList.remove('open');
                        otherItem.querySelector('.accordion-content').style.maxHeight = null;
                    });

                    // If it was not open, open it
                    if (!isOpen) {
                        item.classList.add('open');
                        content.style.maxHeight = content.scrollHeight + "px";
                    }
                });
            });
            
            // Optional: Smooth scroll for sidebar links
            const navLinks = document.querySelectorAll('.sidebar .nav-item-sidebar');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>