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
<title>Where We Fly - Cebu Pacific</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  :root{
    --yellow:#FFD200;
    --blue:#0054A6;
    --blue-btn:#0072CE;
    --blue-btn-hover:#005fa8;
    --text-dark:#1a1a1a;
    --text-body:#333333;
    --border-grey:#e2e2e2;
    --bg-grey:#f5f5f5;
  }

  *{ box-sizing:border-box; margin:0; padding:0; }

  body{
    font-family:'Poppins', Arial, sans-serif;
    color:var(--text-body);
    background:var(--bg-grey);
  }

  /* =========================================
     TOP ADVISORY BAR
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

  /* Header banner */
  .page-header{
    background:var(--yellow);
    padding:36px 20px 46px;
    display:flex;
    justify-content:flex-start;
    border-bottom-left-radius:50% 40px;
    border-bottom-right-radius:50% 40px;
  }
  .page-header h1{
    width:100%;
    max-width:1400px;
    margin:0 auto;
    text-align:left;
    padding-left:40px;
    color:var(--blue);
    font-size:28px;
    font-weight:700;
    letter-spacing:0.3px;
  }

  /* Layout */
  .layout{
    display:flex;
    width:100%;
    margin:0 auto;
    padding:40px 60px;
    gap:56px;
  }

  /* Sidebar */
  .sidebar{
    width:200px;
    flex-shrink:0;
  }
  .sidebar nav ul{
    list-style:none;
  }
  .sidebar nav li{
    border-bottom:1px solid var(--border-grey);
  }
  .sidebar nav a{
    display:block;
    padding:14px 6px;
    color:var(--text-body);
    text-decoration:none;
    font-size:14px;
    line-height:1.4;
    transition:color .15s ease;
  }
  .sidebar nav a:hover{
    color:var(--blue-btn-hover);
  }
  /* Active State for Sidebar */
  .sidebar nav a.active {
    color: var(--blue-btn);
    font-weight: 700;
  }

  /* Main content */
  .content{
    flex:1;
    min-width:0;
  }
  .content h2{
    color:#1a1a1a;
    font-size:24px;
    font-weight:700;
    margin-bottom:20px;
  }
  .content h3{
    color:#1a1a1a;
    font-size:16px;
    font-weight:700;
    margin: 25px 0 15px;
    text-transform: uppercase;
  }

  .content p{
    font-size:14px;
    line-height:1.65;
    color:#1a1a1a;
    margin-bottom:15px;
  }
  .content p a {
    color:var(--blue-btn);
    font-weight:700;
    text-decoration:none;
  }
  .content p a:hover {
    text-decoration:underline;
  }

  /* Table Styles */
  .schedule-table {
      width: 100%;
      max-width: 600px;
      border-collapse: collapse;
      margin-bottom: 25px;
      border: 2px solid #000;
  }

  .schedule-table th, 
  .schedule-table td {
      border: 1px solid #000;
      padding: 6px 12px;
      text-align: left;
      font-size: 14px;
      color: #000;
  }

  .schedule-table th {
      font-weight: 700;
      border-bottom: 2px solid #000;
  }

  .schedule-table tr.group-header td {
      font-weight: 700;
      border-top: 2px solid #000; 
  }

  /* =========================================
             FOOTER STYLES
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
            background-color: #ffcc00; 
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

        .copyright-text {
            font-size: 14px;
            color: #0054A6; 
            font-weight: 700;
        }
  @media (max-width:768px){
    .layout{ flex-direction:column; padding: 20px; }
    .sidebar{ width:100%; }
    .footer-right-sidebar { border-left: none; padding-left: 0; }
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
                <a href="login.php" class="login-link" style="color: #005eb8; text-decoration: none; font-weight: 700; font-size: 15px; display: flex; align-items: center;">
                </a>
            </div>
        </div>
    </header>

  <!-- YELLOW TRAVEL INFORMATION BANNER -->
  <header class="page-header">
    <h1>Where We Fly</h1>
  </header>
  
  <div class="layout">
    <aside class="sidebar">
      <nav>
        <ul>
          <!-- Updated Sidebar Links -->
          <li><a href="where-we-fly.php" class="active">Where We Fly</a></li>
          <li><a href="FAQs.php">Frequently Asked Questions</a></li>
        </ul>
      </nav>
    </aside>

    <main class="content">
      <h2>Where We Fly</h2>
      
      <p><strong>Cebu Pacific Advisory</strong></p>
      <p><strong>Flight Schedule until July 31, 2026</strong></p>
      
      <p>Cebu Pacific and Cebgo intend to operate the following domestic flights until July 31, 2026. All flight schedules are subject to change.</p>

      <!-- DOMESTIC FLIGHTS TABLE -->
      <table class="schedule-table">
        <thead>
            <tr>
                <th>Route</th>
                <th>Frequency</th>
            </tr>
        </thead>
        <tbody>
            <!-- From Manila -->
            <tr class="group-header">
                <td>From Manila</td>
                <td></td>
            </tr>
            <tr><td>Manila - Bacolod - Manila</td><td>8x daily</td></tr>
            <tr><td>Manila - Bohol (Tagbilaran) - Manila</td><td>4x daily</td></tr>
            <tr><td>Manila - Boracay (Caticlan) - Manila</td><td>9x weekly</td></tr>
            <tr><td>Manila - Butuan - Manila</td><td>6x daily</td></tr>
            <tr><td>Manila - Cagayan De Oro - Manila</td><td>9x daily</td></tr>
            <tr><td>Manila - Cauayan - Manila</td><td>Daily</td></tr>
            <tr><td>Manila - Cebu - Manila</td><td>11x daily</td></tr>
            <tr><td>Manila - Davao - Manila</td><td>10x daily</td></tr>
            <tr><td>Manila - Dipolog - Manila</td><td>10x weekly</td></tr>
            <tr><td>Manila - Dumaguete - Manila</td><td>4x daily</td></tr>
            <tr><td>Manila - General Santos - Manila</td><td>3x daily</td></tr>
            <tr><td>Manila - Iloilo - Manila</td><td>6x daily</td></tr>
            <tr><td>Manila - Kalibo - Manila</td><td>5x weekly</td></tr>
            <tr><td>Manila - Laoag - Manila</td><td>7x weekly</td></tr>
            <tr><td>Manila - Legazpi (Daraga) - Manila</td><td>5x daily</td></tr>
            <tr><td>Manila - Ozamiz - Manila</td><td>Daily</td></tr>
            <tr><td>Manila - Pagadian - Manila</td><td>3x daily</td></tr>
            <tr><td>Manila - Puerto Princesa - Manila</td><td>3x daily</td></tr>
            <tr><td>Manila - Roxas City - Manila</td><td>2x daily</td></tr>
            <tr><td>Manila - Tacloban - Manila</td><td>6x daily</td></tr>
            <tr><td>Manila - Tuguegarao - Manila</td><td>3x daily</td></tr>
            <tr><td>Manila - Virac - Manila</td><td>Daily</td></tr>
            <tr><td>Manila - Zamboanga - Manila</td><td>6x daily</td></tr>

            <!-- From Cebu -->
            <tr class="group-header">
                <td>From Cebu</td>
                <td></td>
            </tr>
            <tr><td>Cebu - Bacolod - Cebu</td><td>12x weekly</td></tr>
            <tr><td>Cebu - Boracay (Caticlan) - Cebu</td><td>Daily</td></tr>
            <tr><td>Cebu - Butuan - Cebu</td><td>2x daily</td></tr>
            <tr><td>Cebu - Cagayan De Oro - Cebu</td><td>2x daily</td></tr>
            <tr><td>Cebu - Calbayog - Cebu</td><td>8x weekly</td></tr>
            <tr><td>Cebu - Camiguin - Cebu</td><td>11x weekly</td></tr>
            <tr><td>Cebu - Coron (Busuanga) - Cebu</td><td>13x weekly</td></tr>
            <tr><td>Cebu - Davao - Cebu</td><td>5x daily</td></tr>
            <tr><td>Cebu - Dipolog - Cebu</td><td>11x weekly</td></tr>
            <tr><td>Cebu - Dumaguete - Cebu</td><td>10x weekly</td></tr>
            <tr><td>Cebu - El Nido - Cebu</td><td>2x daily</td></tr>
            <tr><td>Cebu - General Santos - Cebu</td><td>Daily</td></tr>
            <tr><td>Cebu - Iloilo - Cebu</td><td>9x weekly</td></tr>
            <tr><td>Cebu - Legazpi (Daraga) - Cebu</td><td>10x weekly</td></tr>
            <tr><td>Cebu - Masbate - Cebu</td><td>3x weekly</td></tr>
            <tr><td>Cebu - Ozamiz - Cebu</td><td>11x weekly</td></tr>
            <tr><td>Cebu - Pagadian - Cebu</td><td>Daily</td></tr>
            <tr><td>Cebu - Puerto Princesa - Cebu</td><td>Daily</td></tr>
            <tr><td>Cebu - Siargao - Cebu</td><td>4x daily</td></tr>
            <tr><td>Cebu - Surigao - Cebu</td><td>10x weekly</td></tr>
            <tr><td>Cebu - Tacloban - Cebu</td><td>13x weekly</td></tr>
            <tr><td>Cebu - Zamboanga - Cebu</td><td>Daily</td></tr>

            <!-- From Clark -->
            <tr class="group-header">
                <td>From Clark</td>
                <td></td>
            </tr>
            <tr><td>Clark - Bohol (Tagbilaran) - Clark</td><td>2x weekly</td></tr>
            <tr><td>Clark - Boracay (Caticlan) - Clark</td><td>Daily</td></tr>
            <tr><td>Clark - Cebu - Clark</td><td>12x weekly</td></tr>
            <tr><td>Clark - Coron (Busuanga) - Clark</td><td>3x daily</td></tr>
            <tr><td>Clark - Davao - Clark</td><td>3x weekly</td></tr>
            <tr><td>Clark - El Nido - Clark</td><td>5x daily</td></tr>
            <tr><td>Clark - Iloilo - Clark</td><td>2x weekly</td></tr>
            <tr><td>Clark - Masbate - Clark</td><td>3x weekly</td></tr>
            <tr><td>Clark - Naga - Clark</td><td>4x weekly</td></tr>
            <tr><td>Clark - Puerto Princesa - Clark</td><td>2x weekly</td></tr>
            <tr><td>Clark - San Jose - Clark</td><td>4x weekly</td></tr>
            <tr><td>Clark - Siargao - Clark</td><td>Daily</td></tr>

            <!-- From Davao -->
            <tr class="group-header">
                <td>From Davao</td>
                <td></td>
            </tr>
            <tr><td>Davao - Bacolod - Davao</td><td>3x weekly</td></tr>
            <tr><td>Davao - Bohol (Tagbilaran) - Davao</td><td>2x daily</td></tr>
            <tr><td>Davao - Boracay (Caticlan) - Davao</td><td>2x weekly</td></tr>
            <tr><td>Davao - Cagayan De Oro - Davao</td><td>3x weekly</td></tr>
            <tr><td>Davao - Iloilo - Davao</td><td>10x weekly</td></tr>
            <tr><td>Davao - Puerto Princesa - Davao</td><td>3x weekly</td></tr>
            <tr><td>Davao - Siargao - Davao</td><td>6x weekly</td></tr>
            <tr><td>Davao - Tacloban - Davao</td><td>2x weekly</td></tr>
            <tr><td>Davao - Zamboanga - Davao</td><td>Daily</td></tr>

            <!-- From Iloilo -->
            <tr class="group-header">
                <td>From Iloilo</td>
                <td></td>
            </tr>
            <tr><td>Iloilo - Bohol (Tagbilaran) - Iloilo</td><td>3x weekly</td></tr>
            <tr><td>Iloilo - Cagayan De Oro - Iloilo</td><td>9x weekly</td></tr>
            <tr><td>Iloilo - Daraga - Iloilo</td><td>4x weekly</td></tr>
            <tr><td>Iloilo - General Santos - Iloilo</td><td>5x weekly</td></tr>
            <tr><td>Iloilo - Puerto Princesa - Iloilo</td><td>4x weekly</td></tr>
            <tr><td>Iloilo - Tacloban - Iloilo</td><td>3x weekly</td></tr>
            <tr><td>Iloilo - Zamboanga - Iloilo</td><td>4x weekly</td></tr>

            <!-- From Zamboanga -->
            <tr class="group-header">
                <td>From Zamboanga</td>
                <td></td>
            </tr>
            <tr><td>Zamboanga - Tawi-Tawi - Zamboanga</td><td>Daily</td></tr>

            <!-- From El Nido -->
            <tr class="group-header">
                <td>From El Nido</td>
                <td></td>
            </tr>
            <tr><td>El Nido - Bohol (Tagbilaran) - El Nido</td><td>3x weekly</td></tr>
            <tr><td>El Nido - Boracay (Caticlan) - El Nido</td><td>Daily</td></tr>
            <tr><td>El Nido - Coron (Busuanga) - El Nido</td><td>5x weekly</td></tr>
        </tbody>
      </table>

      <h3>INTERNATIONAL FLIGHTS</h3>
      
      <p>Cebu Pacific also intends to operate the following international flights until July 31, 2026, all subject to government approval and subject to flight schedule changes:</p>

      <!-- INTERNATIONAL FLIGHTS TABLE -->
      <table class="schedule-table">
        <thead>
            <tr>
                <th>Route</th>
                <th>Frequency</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Cebu - Bangkok (Don Mueang) - Cebu</td><td>2x weekly</td></tr>
            <tr><td>Cebu - Hong Kong - Cebu</td><td>5x weekly</td></tr>
            <tr><td>Cebu - Incheon - Cebu</td><td>6x weekly</td></tr>
            <tr><td>Cebu - Narita - Cebu</td><td>Daily</td></tr>
            <tr><td>Cebu - Osaka - Cebu</td><td>5x weekly</td></tr>
            <tr><td>Cebu - Singapore - Cebu</td><td>2x weekly</td></tr>
            <tr><td>Clark - Bangkok - Clark</td><td>6x weekly</td></tr>
            <tr><td>Clark - Hong Kong - Clark</td><td>Daily</td></tr>
            <tr><td>Clark - Narita - Clark</td><td>3x weekly</td></tr>
            <tr><td>Clark - Singapore - Clark</td><td>2x weekly</td></tr>
            <tr><td>Davao - Hong Kong - Davao</td><td>3x weekly</td></tr>
            <tr><td>Iloilo - Hong Kong - Iloilo</td><td>2x weekly</td></tr>
            <tr><td>Manila - Bali (Denpasar) - Manila</td><td>10x weekly</td></tr>
            <tr><td>Manila - Bangkok - Manila</td><td>2x daily</td></tr>
            <tr><td>Manila - Bangkok (Don Mueang) - Manila</td><td>5x weekly</td></tr>
            <tr><td>Manila - Brunei - Manila</td><td>2x weekly</td></tr>
            <tr><td>Manila - Da Nang - Manila</td><td>9x weekly</td></tr>
            <tr><td>Manila - Dubai - Manila</td><td>4x weekly</td></tr>
            <tr><td>Manila - Fukuoka - Manila</td><td>3x weekly</td></tr>
            <tr><td>Manila - Guangzhou - Manila</td><td>3x weekly</td></tr>
            <tr><td>Manila - Hanoi - Manila</td><td>9x weekly</td></tr>
            <tr><td>Manila - Ho Chi Minh (Saigon) - Manila</td><td>Daily</td></tr>
            <tr><td>Manila - Hong Kong - Manila</td><td>4x daily</td></tr>
            <tr><td>Manila - Incheon - Manila</td><td>11x weekly</td></tr>
            <tr><td>Manila - Jakarta - Manila</td><td>3x weekly</td></tr>
            <tr><td>Manila - Kaohsiung - Manila</td><td>5x weekly</td></tr>
            <tr><td>Manila - Kuala Lumpur - Manila</td><td>3x weekly</td></tr>
            <tr><td>Manila - Macau - Manila</td><td>4x weekly</td></tr>
            <tr><td>Manila - Melbourne - Manila</td><td>4x weekly</td></tr>
            <tr><td>Manila - Nagoya - Manila</td><td>4x weekly</td></tr>
            <tr><td>Manila - Narita - Manila</td><td>11x weekly</td></tr>
            <tr><td>Manila - Osaka - Manila</td><td>5x weekly</td></tr>
            <tr><td>Manila - Riyadh - Manila</td><td>4x weekly</td></tr>
            <tr><td>Manila - Shanghai - Manila</td><td>Daily</td></tr>
            <tr><td>Manila - Singapore - Manila</td><td>11x weekly</td></tr>
            <tr><td>Manila - Sydney - Manila</td><td>4x weekly</td></tr>
            <tr><td>Manila - Taipei - Manila</td><td>2x daily</td></tr>
        </tbody>
      </table>

      <p>Travel regulations issued by the governments of the Philippines, the United Arab Emirates, Australia, Singapore, Japan, Hong Kong, Indonesia, Malaysia, Taiwan, South Korea, and Vietnam will be implemented as necessary. List of requirements may be found here:<br>
      <a href="https://bit.ly/CebuPacificDomesticTravelGuide" target="_blank" rel="noopener">https://bit.ly/CebuPacificDomesticTravelGuide</a> (for Domestic flights) and <a href="https://bit.ly/CebuPacificInternationalTravelGuide" target="_blank" rel="noopener">https://bit.ly/CebuPacificInternationalTravelGuide</a> (for International flights)</p>

      <p><strong>All other Cebu Pacific and Cebgo flights not mentioned above remain cancelled during this time.</strong></p>
      
      <p><strong>Passengers are required to check-in online to maintain contactless flight procedures, and avoid queuing in the airport check-in counters. Go straight to gate or proceed to our self-bag tag kiosks before dropping bags off. Counters close one (1) hour before the scheduled time of departure.</strong></p>

      <p>For questions or concerns, passengers can send a message via Charlie the Chatbot on the Cebu Pacific website.</p>

    </main>
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
</body>
</html>