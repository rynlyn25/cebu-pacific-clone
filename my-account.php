<?php
// Start session to access the logged-in user's data
session_start();

// Check if the user is actually logged in. If not, kick them back to login.
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: partner-login.html");
    exit();
}

// Get the user's data from the session
$firstName = $_SESSION['first_name'];
$lastName = $_SESSION['last_name'];

// Dynamically generate the initials (First letter of first name + First letter of last name)
$initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));

// Dynamically format the display name (e.g., "REYNALYN M.")
$displayName = strtoupper($firstName . ' ' . substr($lastName, 0, 1) . '.');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Cebu Pacific</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* =========================================
            GLOBAL RESET & TYPOGRAPHY
            ========================================= */
        :root {
            --ceb-yellow: #FFC000;
            --ceb-blue: #0033A0;
            --text-dark: #333333;
            --bg-light: #F8F9FA;
            --yellow-accent: #ffdb00;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        html { scroll-behavior: smooth; }
        body { background-color: #f4f5f7; color: var(--text-dark); display: flex; flex-direction: column; min-height: 100vh; }

        /* =========================================
            TOP ADVISORY BAR
            ========================================= */
        .top-advisory-bar {
            position: fixed; top: 0; width: 100%; height: 35px; z-index: 1000; 
            background-color: #00a1e4; color: white; font-size: 12px; display: flex; align-items: center; 
        }

        .header-content-wrapper {
            display: flex; width: 100%; max-width: 1150px; margin: 0 auto; padding: 0 20px; 
            align-items: center; justify-content: space-between; height: 100%;
        }

        .advisory-left { display: flex; align-items: center; font-size: 13px; }
        .advisory-right { display: flex; align-items: center; gap: 40px; margin-left: auto; justify-content: flex-end; }
        .advisory-right a, .disabled-text { color: white; text-decoration: none; font-size: 13px; font-weight: bold; display: flex; align-items: center; cursor: pointer; }
        .advisory-right a:hover { opacity: 0.8; }
        .disabled-text { opacity: 0.6; pointer-events: none; cursor: default; }

        /* =========================================
            MAIN LOGGED-IN HEADER & MEGA MENUS
            ========================================= */
        .hero-header {
            position: fixed; top: 35px; width: 100%; height: 70px; z-index: 999; 
            background-color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-bottom: 1px solid #eaeaea;
        }

        .hero-header .header-content-wrapper { display: flex; justify-content: space-between; align-items: center; width: 100%; height: 100%; }
        .hero-header .header-content-wrapper > a:first-child { flex: 1; display: flex; justify-content: flex-start; }
        .hero-header .nav-links { flex: none; display: flex; gap: 30px; justify-content: center; align-items: center; margin: 0; padding: 0; height: 100%; }
        .hero-header .header-right { flex: 1; display: flex; justify-content: flex-end; align-items: center; gap: 20px; height: 100%; }

        .logo-colored { display: block; height: 45px; width: auto; }

        .nav-item { position: static; padding: 25px 0; height: 100%; display: flex; align-items: center; }
        .main-link { color: #0062a9; text-decoration: none; font-weight: 700; font-size: 15px; transition: color 0.2s; }
        .nav-item:hover .main-link { color: #00a1e4 !important; }

        /* MEGA MENU STYLING */
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

        /* LOGGED IN ACCOUNT BUTTON & DROPDOWN */
        .login-dropdown-wrapper { position: relative; display: flex; align-items: center; height: 100%; }
        .login-btn { background: transparent; color: #0062a9; border: none; font-size: 15px; font-weight: 800; cursor: pointer; display: flex; align-items: center; height: 100%; padding: 0; margin: 0; text-decoration: none; transition: color 0.2s; }
        .login-btn:hover { color: #00a1e4; }
        
        .user-initials-icon {
            display: flex; justify-content: center; align-items: center; width: 26px; height: 26px;
            background-color: var(--ceb-yellow); color: var(--ceb-blue); border-radius: 50%;
            font-weight: 900; font-size: 12px; margin-right: 8px;
        }

        .login-mega-menu {
            position: absolute !important; top: 100% !important; left: auto !important; right: -10px !important; 
            transform: none !important; width: 850px !important; background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 0 0 12px 12px; padding: 35px 50px; z-index: 2000; opacity: 0; visibility: hidden; transition: all 0.3s ease; margin-top: 0; 
        }
        .login-dropdown-wrapper:hover .login-mega-menu { opacity: 1; visibility: visible; }
        .login-mega-top { display: flex; flex-direction: row; justify-content: space-between; align-items: center; width: 100%; }
        .login-icons { display: flex; flex-direction: row; gap: 40px; }

        .header-search-icon { color: #0062a9; font-size: 18px; text-decoration: none; cursor: pointer; padding-left: 10px; transition: color 0.2s;}
        .header-search-icon:hover { color: #00a1e4; }

        /* =========================================
            MY ACCOUNT PAGE SPECIFIC STYLES
            ========================================= */
        .account-header {
            background-color: var(--yellow-accent);
            width: 100%;
            margin-top: 105px; 
            padding: 80px 20px 140px 20px; 
            border-bottom-left-radius: 50% 25px;
            border-bottom-right-radius: 50% 25px;
            position: relative;
            z-index: 1;
        }

        .account-header-content {
            max-width: 1150px;
            margin: 0 auto;
        }

        .account-header h1 {
            color: #005eb8; 
            font-size: 48px; 
            font-weight: 800;
            margin: 0;
            padding-left: 20px;
        }

        .account-card-container {
            max-width: 1150px;
            margin: -90px auto 100px auto; 
            position: relative;
            z-index: 2;
            padding: 0 40px;
            flex-grow: 1;
        }

        .account-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            padding: 40px 50px;
            max-width: 750px;
        }

        .profile-section {
            display: flex;
            align-items: center;
            flex: 1.2;
        }

        .large-initials {
            width: 80px;
            height: 80px;
            background-color: var(--ceb-yellow);
            color: #005eb8;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 32px;
            font-weight: 900;
            margin-right: 25px;
            flex-shrink: 0;
        }

        .profile-name {
            font-size: 22px;
            color: #333;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .card-divider {
            width: 1px;
            height: 70px;
            background-color: #eaeaea;
            margin: 0 40px;
        }

        .balance-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .balance-section:hover {
            background-color: #f8f9fa;
        }

        .balance-info { display: flex; flex-direction: column; }
        .balance-amount { color: #0088ce; font-size: 20px; font-weight: 800; display: flex; align-items: center; gap: 10px; }
        .balance-label { color: #666; font-size: 14px; margin-top: 6px; }
        .balance-chevron { color: #0088ce; font-size: 14px; }

        /* =========================================
            FOOTER STYLES
            ========================================= */
        .site-footer { background-color: #ffffff; padding: 60px 20px 40px 20px; border-top: 1px solid #eaeaea; width: 100%; margin-top: auto;}
        .footer-container { max-width: 1150px; margin: 0 auto; display: flex; gap: 60px; justify-content: space-between; }
        .footer-grid-left { display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px; flex: 2.5; }
        .footer-col { display: flex; flex-direction: column; }
        .footer-group { display: flex; flex-direction: column; }
        
        .footer-group h4, .footer-right-sidebar h4 { font-size: 14px; color: #000000; margin-bottom: 20px; font-weight: 900; letter-spacing: 0.5px; text-transform: uppercase; }
        .footer-group a { color: #00a4e4; text-decoration: none; font-size: 15px; margin-bottom: 16px; transition: color 0.2s; }
        .footer-group a:hover { text-decoration: underline; color: #007bb5; }
        
        .country-box { display: flex; align-items: center; border: 1px solid #ccc; padding: 12px 15px; border-radius: 4px; font-size: 15px; color: #000; font-weight: 700; cursor: pointer; width: 100%; background: #fff; gap: 10px; box-sizing: border-box; }
        .country-box i { font-size: 16px; }
        
        .footer-right-sidebar { flex: 1; min-width: 300px; border-left: 1px solid #e0e0e0; padding-left: 40px; display: flex; flex-direction: column; gap: 30px; }
        .app-buttons { display: flex; gap: 12px; }
        .app-buttons img { height: 40px; width: auto; }
        .payment-logos { display: flex; flex-direction: column; gap: 15px; }
        .payment-row-1 { display: flex; gap: 20px; align-items: center; }
        .payment-row-1 img { height: 45px; width: auto; }
        .payment-row-2 img { height: 30px; width: auto; }
        
        .accreditations { display: flex; align-items: center; gap: 15px; }
        .accreditations img { height: 70px; width: auto; }
        
        .footer-bottom { background-color: var(--ceb-yellow); padding: 25px 20px; width: 100%; }
        .footer-bottom-container { max-width: 1150px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        .footer-legal-links { display: flex; flex-wrap: wrap; gap: 30px; }
        .footer-legal-links a { color: var(--ceb-blue); text-decoration: none; font-size: 14px; font-weight: 800; }
        .footer-legal-links a:hover { text-decoration: underline; }
        .copyright-text { font-size: 14px; color: var(--ceb-blue); font-weight: 800; }

        @media (max-width: 900px) {
            .account-card { flex-direction: column; align-items: flex-start; padding: 30px; }
            .card-divider { width: 100%; height: 1px; margin: 25px 0; }
            .balance-section { width: 100%; }
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
                <i class="fa-solid fa-circle-info" style="margin-right: 8px;"></i>
                <strong>Travel Advisory: </strong> &nbsp;Integration of AirSWIFT into Cebgo Operations 
            </div>
            <div class="advisory-right">
                <a href="#">
                    <i class="fa-solid fa-chevron-left" style="margin-right: 6px; color: rgba(255,255,255,0.7);"></i> 
                    <i class="fa-solid fa-chevron-right" style="margin-right: 6px; color: rgba(255,255,255,0.7);"></i> 
                    <span style="color: rgba(255,255,255,0.7);">View all</span>
                </a>
                <span class="disabled-text"><i class="fa-solid fa-circle-dollar-to-slot" style="margin-right: 6px;"></i> PHP</span>
                <span class="disabled-text"><i class="fa-solid fa-globe" style="margin-right: 6px;"></i> English</span>
                <a href="#">Help</a>
            </div>
        </div>
    </div>

    <!-- MAIN LOGGED-IN HEADER WITH FULL MEGA MENUS -->
    <header class="hero-header">
        <div class="header-content-wrapper">
            <a href="index.php">
                <img class="logo-colored" src="images/CEB_logo_LFEJ_in_Noto_Sans_Linear.webp" alt="Cebu Pacific">
            </a>
            
            <nav class="nav-links">
                <!-- 1. BOOK -->
                <div class="nav-item">
                    <a href="#" class="main-link">Book</a>
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
                                    <a href="partner-login.php">Partner Agents</a>
                                    <p>Log in with your agent ID</p>
                                </div>
                                <div class="business-item">
                                    <a href="cargo.php">Cargo</a>
                                    <p>Know more about our fast and flexible air cargo service</p>
                                </div>
                                <div class="business-item">
                                    <a href="#">Sales & Group Bookings</a>
                                    <p>Be a partner and maximize your business' travel budget</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 2. MANAGE -->
                <div class="nav-item">
                    <a href="#" class="main-link">Manage</a>
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
                    <a href="#" class="main-link">Travel Info</a>
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
                            <div class="travel-item"><a href="seatsale-faq.php"><i class="fa-solid fa-circle-question"></i> FAQs</a></div>
                            <div class="travel-item"><a href="Service-Fees.php"><i class="fa-solid fa-tag"></i> Service Fees</a></div>
                            <div class="travel-item"><a href="CEB-Add-ons.php"><i class="fa-solid fa-chair"></i> Add-Ons</a></div>
                            <div class="travel-item"><a href="flight-status.php"><i class="fa-solid fa-plane-departure"></i> Flight Status</a></div>
                            <div class="travel-item"><a href="AirlinePolicies.php"><i class="fa-solid fa-plane"></i> Flight Timetable</a></div>
                            <div class="travel-item"><a href="AirlinePolicies.php"><i class="fa-solid fa-passport"></i> Airline Policies</a></div>
                        </div>
                    </div>
                </div>
                
                <!-- 4. EXPLORE -->
                <div class="nav-item">
                    <a href="#" class="main-link">Explore</a>
                    <div class="mega-menu">
                        <div class="explore-top-grid">
                            <div class="explore-dest-col">
                                <a href="CityGuides.php" class="explore-heading"><i class="fa-solid fa-map-location-dot"></i> Philippine Destinations</a>
                                <div class="destination-cards">
                                    <a href="#" class="dest-card" style="background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0)), url('images/boracay.jpg');"><span>Boracay</span></a>
                                    <a href="#" class="dest-card" style="background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0)), url('images/siargao.jpg');"><span>Siargao</span></a>
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
                    <a href="#" class="main-link">About</a>
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
                                <p>Get answers to your questions or send feedback to our customer support team</p>
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
                    <!-- DYNAMIC LOGGED IN STATE BUTTON -->
                    <button class="login-btn">
                        <div class="user-initials-icon"><?php echo htmlspecialchars($initials); ?></div>
                        My Account
                    </button>
                    
                    <!-- LOGGED-IN MEGA MENU DROPDOWN WITH LOG OUT -->
                    <div class="mega-menu login-mega-menu">
                        <div class="login-mega-top" style="position: relative;">
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
                                <div class="business-item" style="margin-top: 15px;">
                                    <a href="#">Settings</a>
                                    <p>Manage your notification preferences here</p>
                                </div>
                                <div class="business-item" style="margin-top: 15px;">
                                    <a href="CEB-Add-ons.php">Add-ons Preferences</a>
                                    <p>Set your preferences when you upgrade your trip with baggage, meals, seats, and other services</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#" class="header-search-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- YELLOW CURVED HEADER -->
    <section class="account-header">
        <div class="account-header-content">
            <h1>My Account</h1>
        </div>
    </section>

    <!-- OVERLAPPING PROFILE CARD -->
    <section class="account-card-container">
        <div class="account-card">
            
            <div class="profile-section">
                <!-- DYNAMIC INITIALS -->
                <div class="large-initials"><?php echo htmlspecialchars($initials); ?></div>
                <!-- DYNAMIC DISPLAY NAME -->
                <div class="profile-name"><?php echo htmlspecialchars($displayName); ?></div>
            </div>

            <div class="card-divider"></div>

            <div class="balance-section">
                <div class="balance-info">
                    <div class="balance-amount">
                        <i class="fa-solid fa-wallet"></i> PHP 0.00
                    </div>
                    <div class="balance-label">Travel Fund Balance</div>
                </div>
                <div class="balance-chevron">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
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
                        <a href="our-story.php">Our Story</a>
                        <a href="media-center.php">Media Center</a>
                        <a href="Talk-to-Us.php">Talk to Us</a>
                        <a href="careers.php">Careers</a>
                    </div>
                </div>

                <div class="footer-col">
                    <div class="footer-group">
                        <h4>MANAGE</h4>
                        <a href="check-in.php">Check in</a>
                        <a href="manage-booking.php">Manage Booking</a>
                        <a href="flight-status.php">Flight Status</a>
                        <a href="CEB-Add-ons.php">Add-ons</a>
                        <a href="Special-Assistance.php">Special Assistance</a>
                    </div>
                </div>

                <div class="footer-col">
                    <div class="footer-group">
                        <h4>TRAVEL INFO</h4>
                        <a href="baggage_info.php">Baggage Information</a>
                        <a href="payment-options.php">Payment Options</a>
                        <a href="Travel-Advisories.php">Travel Advisories</a>
                        <a href="BookingCheckinandBoarding.php">Booking & Check-in</a>
                        <a href="TravelDocuments.php">Travel Documents</a>
                        <a href="Service-Fees.php">Service Fees</a>
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
                        <a href="CityGuides.php">Philippine Destinations</a>
                        <a href="CityGuides.php">International Destinations</a>
                        <a href="where-we-fly.php">Where We Fly</a>
                        <a href="CityGuides.php">City Guides</a>
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