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
    <title>Booking, Check-in, and Boarding Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            /* Using standard, clean system fonts uniformly for complete consistency */
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333333;
        }

        /* Smooth scrolling to anchors */
        html {
            scroll-behavior: smooth;
        }

        /* 
           Cebu Pacific Authentic Header Design 
           Title Case (Normal capitalization) with matching sizing
        */
        /* =========================================
           TOP BAR & HEADER STYLES
           ========================================= */
        .force-blue-bar {
            background-color: #00a4e4; 
            padding: 8px 0;
        }

        .header-content-wrapper {
            max-width: 1150px;
            margin: 0 auto;
            padding: 0 20px;
        }
      .page-header {
            background-color: #FFD200; 
            color: #0054A6; 
            /* Keeps the text block visually grounded */
            text-align: left; 
            /* The 250px value moves the text away from the left edge */
            padding: 30px 20px 50px 250px; 
            font-size: 32px;
            font-weight: 700;
    
            /* Maintains the scoop effect */
            border-bottom-left-radius: 50% 30px;
            border-bottom-right-radius: 50% 30px;
}

        /* Main Container Layout */
        .container {
            display: flex;
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            gap: 50px;
        }

        /* Left Side: Navigation Sidebar */
        .sidebar {
            flex: 1;
            position: sticky;
            top: 30px;
            height: fit-content;
            max-width: 260px;
        }

        .sidebar-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #0054A6;
            font-weight: 700;
            margin-bottom: 12px;
            padding-bottom: 5px;
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
            margin-bottom: 0;
        }

        .sidebar-link {
            font-size: 14px; /* Uniform typography sizing matching main structure layout */
            color: #555555;
            text-decoration: none;
            display: block;
            line-height: 1.4;
            transition: color 0.15s ease;
        }

        .sidebar-link:hover {
            color: #0054A6;
        }

        .sidebar-link.active {
            color: #0054A6;
            font-weight: 700;
        }

        /* Right Side: Content Area */
        .content-area {
            flex: 3;
        }

        section {
            margin-bottom: 50px;
            scroll-margin-top: 30px;
        }

        h1, h2, h3 {
            color: #111111;
            margin-bottom: 15px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        h1 { font-size: 26px; margin-top: 0; }
        h2 { font-size: 22px; margin-top: 30px; }
        h3 { font-size: 18px; margin-top: 25px; }

        p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
            color: #444444;
        }

        a {
            color: #009cdb;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        ul {
            margin-left: 20px;
            margin-bottom: 25px;
        }

        li {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 12px;
            color: #444444;
        }

        /* Image Display Handling */
        .banner-img {
            width: 100%;
            height: auto;
            margin: 25px 0;
            border-radius: 6px;
            display: block;
        }

        .kiosk-steps-img {
            width: 100%;
            max-width: 750px;
            height: auto;
            margin: 20px 0;
            display: block;
        }

        /* Take Note Box Layout */
        .take-note-box {
            background-color: #f4fafd;
            border: 1px solid #d0e8f4;
            border-radius: 6px;
            padding: 22px;
            margin: 30px 0;
        }

        .take-note-box h4 {
            color: #0054A6;
            font-size: 14px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .take-note-box ul {
            list-style: none;
            margin-left: 0;
            margin-bottom: 0;
        }

        .take-note-box li {
            position: relative;
            padding-left: 18px;
            margin-bottom: 15px;
            font-size: 13px;
            color: #444444;
        }

        .take-note-box li:last-child {
            margin-bottom: 0;
        }

        .take-note-box li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #555555;
            font-size: 16px;
            top: -2px;
        }
        /* =========================================
           FOOTER STYLES (UPDATED)
           ========================================= */
        .site-footer {
            background-color: #ffffff;
            padding: 50px 20px;
            border-top: 1px solid #eaeaea;
            margin-top: 50px;
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
            min-width: 160px;
            display: flex;
            flex-direction: column;
        }

        /* Set headers to black */
        .footer-links-grid h4, .footer-right-sidebar h4 {
            font-size: 13px;
            color: #111111; 
            margin-bottom: 15px;
            font-weight: 800;
        }

        /* Set main links to light blue */
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
            border-left: 1px solid #dcdcdc; /* Added vertical separator */
            padding-left: 35px;
        }

        .app-buttons img, .payment-grid img, .accreditations img {
            max-width: 120px;
            margin-right: 10px;
            margin-bottom: 10px;
            height: auto;
        }

        .country-selector {
            margin-top: 20px;
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
        }
        
        .country-box i {
            margin-right: 8px;
            color: #111;
        }

        /* BOTTOM YELLOW BAR */
        .footer-bottom {
            background-color: #ffcc00; /* Yellow background */
            padding: 20px;
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

        /* Dark blue bold links */
        .footer-legal-links a {
            color: #0054A6; 
            text-decoration: none;
            font-size: 14px;
            margin-right: 20px;
            font-weight: 700;
        }
        
        .footer-legal-links a:hover {
            text-decoration: underline;
        }

        /* Dark blue bold text */
        .copyright-text {
            font-size: 14px;
            color: #0054A6; 
            font-weight: 700;
        }
    </style>
</head>
<body>
    <!-- TOP ADVISORY BAR -->
    <div class="top-advisory-bar force-blue-bar">
        <div class="header-content-wrapper right-align-wrapper">
            <div class="advisory-right" style="display: flex; align-items: center; margin-left: auto; justify-content: flex-end;">
                <a href="#" style="color: rgba(255, 255, 255, 0.7); font-weight: 700; text-decoration: none; font-size: 13px; display: flex; align-items: center;">
                    <i class="fa-solid fa-circle-dollar-to-slot" style="color: rgba(255, 255, 255, 0.7); margin-right: 6px; font-size: 14px;"></i> PHP
                </a>
                <a href="#" style="color: rgba(255, 255, 255, 0.7); font-weight: 700; text-decoration: none; font-size: 13px; display: flex; align-items: center; margin-left: 25px; margin-right: 25px;">
                    <i class="fa-solid fa-globe" style="color: rgba(255, 255, 255, 0.7); margin-right: 6px; font-size: 14px;"></i> English
                </a>
            </div>
        </div>
    </div>

    <!-- WHITE NAVIGATION HEADER -->
    <header class="hero-header" style="background: white; border-bottom: 1px solid #eaeaea; position: relative; z-index: 999;">
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

    <!-- Header Area featuring user capitalization style directly -->
    <div class="page-header">
        Booking, Check-in, and Boarding Information
    </div>

    <div class="container">
        
        <!-- Left Side: Interactive Sidebar Menu -->
        <div class="sidebar">
            <div class="sidebar-title">Select an Option</div>
            <ul class="sidebar-menu">
                <li><a href="#booking-guidelines" class="sidebar-link active">Booking Guidelines</a></li>
                <li><a href="#checkin-boarding-guidelines" class="sidebar-link">Check-in and Boarding Guidelines</a></li>
                <li><a href="#checkin-options-web-mobile" class="sidebar-link">Check-in Options: Web / Mobile</a></li>
                <li><a href="#checkin-options-airport" class="sidebar-link">Check-in Options: Airport</a></li>
            </ul>
        </div>

        <!-- Right Side: Content Area Panels -->
        <div class="content-area">
            
            <!-- Booking Guidelines Section -->
            <section id="booking-guidelines">
                <h1>Booking Guidelines</h1>
                <p>Booking a flight less than 59 minutes before its scheduled time of departure? Internet bookings will no longer be allowed during this period, and bookings can only be done through our <a href="#">sales offices</a>. You may contact us <a href="#">here</a> to check the availability of your preferred flight.</p>
            </section>

            <!-- Check-In and Boarding Guidelines Section -->
            <section id="checkin-boarding-guidelines">
                <h2>Check-In and Boarding Guidelines</h2>
                <ul>
                    <li>Check in <a href="#">online</a> before going to the airport to avoid queuing. Read more about fast check-in options <a href="#">here</a>.</li>
                    <li>Check-in counters for domestic flights strictly close 45 mins before the scheduled time of departure. Meanwhile, check-in counters for international flights close one (1) hour before the scheduled time of departure.</li>
                    <li>Wear a face mask.</li>
                </ul>
            </section>

            <!-- Web / Mobile Check-In Section -->
            <section id="checkin-options-web-mobile">
                <h2>Online Check-in</h2>
                
                <!-- Online Check-In Hero Illustration -->
                <img src="images/image_84bbde.jpg" alt="Online Check-in Banner" class="banner-img">

                <ul>
                    <li>For international flights - available from 2 days up to 2 hours before your flight</li>
                    <li>For domestic flights - available from 2 days up to 1 hour before your flight</li>
                </ul>

                <h3>Online Check-in is not allowed for:</h3>
                <ul>
                    <li>Unaccompanied Minors</li>
                    <li>Guests who must submit a medical certificate</li>
                    <li>Guests requiring special assistance and bag service</li>
                    <li>Guests on group bookings with more than 20 passengers</li>
                    <li>Guests with outstanding balance</li>
                    <li>Guests with tax exemptions (i.e., OFWs)</li>
                </ul>

                <p>For more information on CEB's Online Check-in Procedures, you may check out <a href="#">this page</a>.</p>

                <div class="take-note-box">
                    <h4>Take Note!</h4>
                    <ul>
                        <li>Go to the Bag Drop Counter before counter closure to check-in your bags. In certain cases, guests flying international may have to get their travel documents verified at the airport counters.</li>
                        <li>Cebu Pacific web and mobile boarding passes are accepted in all airports across the Philippines for domestic travel. On international flights, they are accepted when departing from these airports: Bangkok, Denpasar, Fukuoka, Hong Kong, Jakarta, Kota Kinabalu, Kuala Lumpur, Nagoya, Osaka-Kansai, Singapore, Sydney, Taipei, Tokyo-Narita and Dubai.</li>
                        <li>Be at your assigned Boarding Gate at least 45 minutes before the flight.</li>
                        <li>Seats are automatically assigned, but you can change and choose your seat for a fee.</li>
                        <li>Have last-minute changes? You can still <a href="#">manage your booking</a> even after checking in.</li>
                    </ul>
                </div>
            </section>

            <!-- Airport Check-In Section -->
            <section id="checkin-options-airport">
                <h2>Airport Check-in</h2>
                <h3>Check-In Kiosk</h3>
                <ul>
                    <li>Available as early as 8 hours before your flight. You will need your booking reference number to use the check-in kiosk.</li>
                    <li>You can use the kiosk to print your bag tag. Here's how:</li>
                </ul>

                <!-- Full visual display of steps layout displaying step panel graphic -->
                <img src="images/image_84bec3.png" alt="Kiosk Step Guidelines Diagram" class="kiosk-steps-img">

                <div class="take-note-box">
                    <h4>Take Note!</h4>
                    <ul>
                        <li>Go to the Bag Drop Counter before counter closure to check-in your bags. If you're flying internationally, you have to get your travel documents verified in the check-in counter first.</li>
                        <li>Be at your assigned Boarding Gate at least 45 minutes before the flight</li>
                        <li>Seats are automatically assigned, but you can change and choose your seat for a fee</li>
                    </ul>
                </div>
            </section>

        </div>

    </div>
<!-- FOOTER SECTION -->
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
                    <div class="country-box"><i class="fa-solid fa-earth-asia"></i> Philippines</div>
                </div>
            </div>

            <!-- RIGHT SIDEBAR (Separator line added in CSS) -->
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

    <!-- Active Navigation Highlight Control Logic -->
    <script>
        const links = document.querySelectorAll('.sidebar-link');
        const sections = document.querySelectorAll('section');

        links.forEach(link => {
            link.addEventListener('click', function() {
                links.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        window.addEventListener('scroll', () => {
            let currentSelection = "";
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (window.pageYOffset >= sectionTop - 60) {
                    currentSelection = section.getAttribute('id');
                }
            });

            if(currentSelection) {
                links.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${currentSelection}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    </script>
</body>
</html>