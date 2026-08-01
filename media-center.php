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
    <title>Press Releases - Cebu Pacific</title>
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
           MAIN PAGE LAYOUT (SIDEBAR + CONTENT)
           ========================================= */
        .page-container {
            max-width: 1150px;
            margin: 0 auto 80px auto;
            padding: 0 20px;
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }

        /* Left Sidebar */
        .sidebar {
            width: 220px;
            flex-shrink: 0;
        }

        .sidebar h4 {
            color: #005eb8;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }

        .sidebar ul {
            list-style: none;
            border-top: 1px solid #eaeaea;
        }

        .sidebar li {
            border-bottom: 1px solid #eaeaea;
        }

        .sidebar a {
            display: block;
            padding: 12px 0;
            color: #333;
            text-decoration: none;
            font-size: 15px;
            transition: color 0.2s;
        }

        .sidebar a:hover, .sidebar a.active {
            color: #000;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            min-width: 0;
        }

        .content-header-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .main-content h2 {
            font-size: 28px;
            color: #222;
            font-weight: 800;
            margin: 0;
        }

        .year-filter {
            font-size: 15px;
            font-weight: 700;
            color: #005eb8;
        }

        .year-filter span {
            color: #111;
            margin-right: 5px;
        }

        .year-filter a {
            color: #005eb8;
            text-decoration: none;
            margin: 0 4px;
        }

        .year-filter a:hover {
            text-decoration: underline;
        }

        /* Accordion (Press Releases) */
        .accordion-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            padding: 10px 30px;
        }

        .accordion-item {
            border-bottom: 1px solid #eaeaea;
        }

        .accordion-item:last-child {
            border-bottom: none;
        }

        .accordion-header {
            padding: 25px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            gap: 20px;
        }

        .accordion-header-text {
            display: flex;
            flex-direction: column;
        }

        .pr-date {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .pr-title {
            font-size: 18px;
            color: #111;
            font-weight: 500;
            line-height: 1.4;
            transition: color 0.2s;
        }

        .accordion-header:hover .pr-title {
            color: #005eb8;
        }

        .accordion-header i {
            color: #005eb8;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .accordion-item.active .accordion-header i {
            transform: rotate(90deg);
        }

        /* Expandable Content */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out;
        }

        .accordion-inner {
            padding-bottom: 30px;
            font-size: 15px;
            line-height: 1.7;
            color: #444;
        }

        .accordion-inner img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .accordion-inner p {
            margin-bottom: 15px;
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
            .page-container {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                margin-bottom: 30px;
            }
            .footer-right-sidebar { 
                border-left: none; 
                padding-left: 0; 
            }
            .destination-circles {
                gap: 20px;
            }
            .circle-item {
                width: 80px;
            }
            .circle-img-wrapper {
                width: 80px;
                height: 80px;
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
                <a href="login.html" class="login-link" style="color: #005eb8; text-decoration: none; font-weight: 700; font-size: 15px; display: flex; align-items: center;">
                </a>
            </div>
        </div>
    </header>

    <div class="breadcrumbs-container">
        <div class="breadcrumbs">
            <a href="index.html">Home</a> &rsaquo; 
            <a href="#">About</a> &rsaquo; 
            <span>Press Releases</span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- YELLOW HERO BANNER -->
    <!-- ========================================== -->
    <header class="top-header">
        <div class="header-banner-content">
            <h1 class="header-title">Press Releases</h1>
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

    <!-- ========================================== -->
    <!-- MAIN PAGE CONTENT (SIDEBAR + PRESS RELEASES) -->
    <!-- ========================================== -->
    <div class="page-container">
        
        <!-- Left Sidebar -->
        <aside class="sidebar">
            <h4>Media Center</h4>
            <ul>
                <li><a href="#" class="active">Press Releases</a></li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <div class="content-header-row">
                <h2>Press Releases</h2>
                <div class="year-filter">
                    <span>2026</span>
                </div>
            </div>

            <!-- Accordion List -->
            <div class="accordion-card">
                
                <!-- Article 1 -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-header-text">
                            <span class="pr-date">17 July 2026</span>
                            <span class="pr-title">Cebu Pacific Ties Up with Department of Tourism for ‘Discover More to Love’ Campaign</span>
                        </div>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            <!-- Image Holder -->
                            <img src="images/CEB DOT.jpg" alt="Cebu Pacific and DOT Partnership" onerror="this.style.display='none'">
                            
                            <p>Cebu Pacific (PSE: CEB), the Philippines' leading carrier, is making every Juan's domestic travels even more accessible and meaningful as it partners with the Department of Tourism for its latest campaign “Discover More to Love,” reinforcing their shared commitment to encouraging more Filipinos to explore destinations across the country.</p>
                            
                            <p>The DOT's latest domestic campaign, spearheaded by newly appointed Tourism Secretary Dita Angara-Mathay, aligns with CEB's own domestic initiative “Discover Juan by Juan”, showcasing the diverse cultures, heritage, and experiences that define destinations across the Philippines. It reflects the department's renewed focus on inspiring Filipinos to rediscover the country through authentic and meaningful journeys.</p>

                            <p>CEB supports the DOT's vision by making domestic travel more accessible through its year-round low fares, regular seat sales, and extensive domestic network. Beyond making flights more affordable, the airline also enhances the travel experience through partnerships with hotels, cafés, wellness brands, and other local businesses, encouraging travelers to discover more of what each destination has to offer.</p>

                            <p>As part of this commitment, CEB is rolling out a special seat sale allowing passengers to book flights to select domestic destinations from Manila and Clark for as low as PHP 188 one-way base fare, exclusive of fees and surcharges until July 17. The seat sale covers travel until November 30, 2026.</p>

                            <p>“Cebu Pacific has been a steadfast partner of the Department of Tourism in opening more destinations across the Philippines and making travel more accessible for every Filipino. We are proud to support the ‘Discover More to Love’ campaign by making it easier and more affordable to explore the destinations that make the Philippines truly unique,” said Candice Iyog, CEB Chief Marketing and Customer Experience Officer.</p>

                            <p>“As we continue to expand connectivity and bring more travelers to both established and emerging destinations, we hope to create greater opportunities for local communities, tourism businesses, and the many Filipinos whose livelihoods depend on a thriving tourism industry,” she added.</p>

                            <p>For the past three decades, CEB has been a key partner in advancing Philippine tourism by making destinations across the country more accessible through affordable fares and its extensive domestic network. From Siargao to Coron and El Nido, the airline has helped bring more travelers to local communities, supporting jobs, livelihoods, and the government's vision of a stronger domestic tourism industry.</p>

                            <p>With flights to 35 domestic destinations spanning Luzon, Visayas, and Mindanao, CEB continues to connect every Juan to more places, opening more opportunities to discover what makes the Philippines worth exploring.</p>
                        </div>
                    </div>
                </div>

                <!-- Article 2 -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-header-text">
                            <span class="pr-date">16 July 2026</span>
                            <span class="pr-title">Cebu Pacific, Vietnam Airlines Sign Wet Lease Deal</span>
                        </div>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            <!-- Image Holder -->
                            <img src="images/CEB VNA ACMI.jpg" alt="Cebu Pacific, Vietnam Airlines Sign Wet Lease Deal" onerror="this.style.display='none'">
                            
                            <p>Cebu Pacific (PSE: CEB), the Philippines’ leading carrier, has entered into an agreement to provide wet lease services to Vietnam Airlines, the flag carrier of Vietnam.</p>
                            
                            <p>The agreement covers the deployment of one Airbus A320neo aircraft powered by Pratt & Whitney engines which Vietnam Airlines will utilize for its flight operations between July 15 and September 7, 2026.</p>
                            
                            <p>The aircraft will be based in Ho Chi Minh City and will be operated by Cebu Pacific pilots and cabin crew. The operation will cover domestic routes from Ho Chi Minh City to Cam Ranh, Phu Quoc, Vinh, Da Nang, and vice versa.</p>
                            
                            <p>“Vietnam and the broader Southeast Asian market continue to see strong growth in air travel, creating opportunities for airlines to collaborate more closely in meeting demand. As Cebu Pacific’s fleet continues to expand, we are well positioned to deploy our capacity where it is needed most, including through strategic wet lease partnerships during periods of lower demand in the Philippines,” said Mark Cezar, Cebu Pacific Chief Financial Officer.</p>
                            
                            <p>“This collaboration with Vietnam Airlines enables Cebu Pacific to broaden its role beyond passenger operations by providing operational support to airlines across the region. It also creates new opportunities to diversify our revenue streams while expanding our presence in one of the world’s fastest-growing aviation markets,” he added.</p>
                            
                            <p>This agreement further demonstrates Cebu Pacific’s strong capability to enter wet lease arrangements with other airlines, both as a lessor and a lessee. In 2023, Cebu Pacific signed a damp lease agreement with Bulgaria Air for two A320ceo aircraft to meet the growing travel demand in the Philippines amid the post-pandemic travel recovery.</p>
                            
                            <p>Cebu Pacific also successfully provided wet lease services to Saudi Arabian low-cost carrier flyadeal, which utilized two A320 aircraft to strengthen the Middle Eastern airline’s fleet during its peak summer flying season in 2025.</p>
                        </div>
                    </div>
                </div>

                <!-- Article 3 -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-header-text">
                            <span class="pr-date">14 July 2026</span>
                            <span class="pr-title">Cebu Pacific to Become Southeast Asia’s First Low-Cost Airline to Introduce Starlink, The Fastest Wi-Fi in the Sky</span>
                        </div>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            <p>Cebu Pacific (PSE: CEB), the Philippines' leading carrier, today announced it will introduce Starlink, the world’s most advanced satellite constellation engineered by SpaceX, bringing the fastest Wi-Fi in the sky to its passengers. The rollout is expected to begin in 2027.</p>
                            
                            <p>Starlink delivers an unparalleled broadband experience inflight, with high-speed, low-latency Wi-Fi capable of HD streaming, online gaming, productivity and more. Beyond enhancing the passenger experience, Starlink will also support improved operational connectivity for Cebu Pacific's flight crews and operational teams, enabling greater operational efficiency.</p>
                            
                            <p>The collaboration marks a significant milestone for Philippine aviation and positions Cebu Pacific as the first low-cost airline in Southeast Asia to bring Starlink onboard. The rollout forms part of Cebu Pacific's continued investment in customer experience and digital innovation as it expands into one of the youngest and largest fleet in the region.</p>
                            
                            <p>Cebu Pacific and fellow Indigo Partners portfolio airlines Frontier (United States), Wizz Air (Europe), Volaris (Mexico), and JetSMART (South America) expect to install Starlink on over 1,000 aircraft. The deployment represents one of the largest global commitments to next-generation inflight connectivity, with airlines bringing low fares and access to reliable Wi-Fi provided through a new system managed directly by Starlink.</p>
                            
                            <p>“Starlink will provide our portfolio airlines with reliable, high-speed connectivity, further enhancing the customer experience of flying on Wizz, Frontier, Volaris, JetSMART and Cebu Pacific,” said Bill Franke, Managing Partner of Indigo Partners.</p>
                            
                            <p>"Introducing Starlink marks another important step in delivering a better travel experience for every Juan," said Xander Lao, President and Chief Commercial Officer of Cebu Pacific.</p>
                            
                            <p>"Reliable, high-speed connectivity has become an expectation for today's travelers, and we're excited to bring that experience to our guests. Whether they're staying in touch with loved ones, catching up on work, or enjoying their favorite content, Starlink will allow them to stay connected throughout their journey while Cebu Pacific remains true to our commitment to making air travel accessible and affordable." (END)</p>
                        </div>
                    </div>
                </div>

                <!-- Article 4 -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-header-text">
                            <span class="pr-date">10 July 2026</span>
                            <span class="pr-title">Cebu Pacific Lauded for Gender Equality, Workplace Inclusion Practices</span>
                        </div>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            <!-- Image Holder -->
                            <img src="images/Photo 2_2.jpg" alt="Cebu Pacific Lauded for Gender Equality" onerror="this.style.display='none'">
                            
                            <p>Cebu Pacific (PSE: CEB) has been recognized by the Philippine Business Coalition for Women Empowerment (PBCWE) for advancing diversity and inclusion, making it the first and only local carrier to be assessed for its gender equality and workplace inclusion efforts.</p>

                            <p>The award, conferred on June 30, follows the successful completion of 17 initiatives under the Gender Equality Assessment, Results and Strategies (GEARS) framework, spanning leadership accountability, flexible work arrangements, workplace safety, and LGBTQIA+ inclusion.</p>

                            <p>“We take pride in being the first and only local carrier to have our workplace practices independently assessed under the GEARS framework, but we don't aspire to simply be first. Our focus is on building a workplace where everyone can grow and succeed. That means continuing to strengthen our programs, listening to our people, and sustaining the progress we've made so inclusion remains part of how we work every day,” said Felix Lopez, CEB Chief Human Resources Officer.</p>

                            <p>Among CEB's diversity, equality, and inclusion (DEI) initiatives are the extension of healthcare benefits for employees' same-sex and common-law partners, along with mandatory DEI training for leaders and new hires. Backing these efforts is the Juan CEB Community (JCC), the airline's employee resource group championing inclusion for women, LGBTQIA+ employees, solo parents, and persons with disabilities.</p>

                            <p>This commitment extends beyond CEB's own workforce. In June 2026, the airline welcomed three Deaf student interns from De La Salle–College of Saint Benilde's School of Deaf Education and Applied Studies (SDEAS) through its FLY Internship Program, with employees first taking part in a Deaf Awareness Session to build understanding of Deaf culture and inclusive communication ahead of their arrival.</p>

                            <p>CEB also highlighted progress in gender representation, with women now making up 54% of its management workforce -- a growth trend that extends to technical and operational roles as well, including among pilots.</p>

                            <p>PBCWE is an independent business coalition that helps organizations strengthen gender equality and workplace inclusion by benchmarking their policies and practices against international standards through the GEARS framework.</p>
                        </div>
                    </div>
                </div>

                <!-- Article 5 -->
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-header-text">
                            <span class="pr-date">28 June 2026</span>
                            <span class="pr-title">Cebu Pacific Celebrates 25 Years in Hong Kong by Honoring Outstanding OFWs</span>
                        </div>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            <!-- Image Holder -->
                            <img src="images/HKG OFW Event.jpg" alt="Cebu Pacific Celebrates 25 Years in Hong Kong" onerror="this.style.display='none'">
                            
                            <p>HONG KONG – Cebu Pacific (PSE: CEB) marked 25 years of serving Hong Kong by honoring five outstanding Overseas Filipino Workers (OFWs), whose contributions have made a meaningful impact on the Filipino community abroad.</p>

                            <p>The airline presented the CEB Values Awards during the Philippine Tourism Festival organized by the OFW group Philippine Alliance. The awards honor individuals who embody the airline’s core values of Trust, Integrity, Courage, Service, and Best of Filipino Spirit.</p>

                            <p>“Over the past 25 years, Hong Kong has been an important part of Cebu Pacific’s international network and story. More importantly, it has been home to generations of OFWs whose hard work and dedication continue to inspire us,” said Candice Iyog, CEB Chief Marketing and Customer Experience Officer. “Through the CEB Values Awards, we recognize individuals who embody the values we aspire to live by as an airline.”</p>

                            <p>This is the second time the carrier has held the awards in Hong Kong. Each awardee received a roundtrip international ticket with a 20kg baggage allowance, while three additional roundtrip international tickets were raffled off to OFWs attending the festival, giving more overseas Filipinos the opportunity to reunite with loved ones or explore the airline’s international network.</p>

                            <p>Hong Kong has been part of CEB’s network since 2001 and remains one of its key international destinations, serving OFWs alongside a growing number of leisure and business travelers.</p>

                            <p>CEB flies to 35 domestic and 26 international destinations across Asia, Australia, and the Middle East, continuing to make air travel more accessible while connecting Filipinos wherever they are in the world.</p>
                        </div>
                    </div>
                </div>

            </div>
        </main>
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

    <!-- Accordion Script -->
    <script>
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                const content = header.nextElementSibling;
                
                // Toggle active class
                item.classList.toggle('active');

                // Smooth scroll logic
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