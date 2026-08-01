<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Itinerary Receipt - Cebu Pacific</title>
    <!-- Include HTML2PDF Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; margin: 0; padding: 0; padding-bottom: 40px; }
        
        /* ---------- TOP NAVBAR ---------- */
        .top-navbar {
            background: #ffffff;
            padding: 15px 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
            display: flex;
            align-items: center;
        }
        .brand-logo {
            height: 38px;
            object-fit: contain;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .brand-logo:hover {
            opacity: 0.8;
        }

        /* ---------- RECEIPT CONTAINER ---------- */
        .receipt-container { max-width: 800px; margin: 0 auto; background: #fff; padding: 40px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        
        .header { border-bottom: 2px solid #FFD200; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { color: #0072CE; margin: 0 0 5px 0; }
        .header .status { color: #2e7d32; font-weight: bold; font-size: 18px; }
        
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .box { background: #f8f9fa; padding: 15px; border-radius: 6px; border: 1px solid #e0e0e0; }
        .box h3 { margin: 0 0 10px 0; font-size: 14px; color: #12395B; text-transform: uppercase; }
        
        .route-header { font-size: 20px; font-weight: bold; color: #12395B; margin-bottom: 10px; }
        .detail-row { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding: 8px 0; font-size: 14px; }
        .detail-row:last-child { border-bottom: none; }
        
        .download-btn { display: block; width: 250px; margin: 0 auto 30px; padding: 15px; background: #FFD200; color: #12395B; text-align: center; font-weight: bold; text-transform: uppercase; border: none; border-radius: 24px; cursor: pointer; }
        .download-btn:hover { background: #e6bd00; }
        
        @media print {
            .download-btn, .top-navbar { display: none !important; }
        }
    </style>
</head>
<body>

    <!-- TOP NAVBAR WITH BACK LINK -->
    <div class="top-navbar" data-html2canvas-ignore="true">
        <a href="index.php">
            <!-- Tries to load the logo from the images folder, falls back to AO-1.webp if missing -->
            <img src="images/CEB_logo_LFEJ_in_Noto_Sans_Linear.webp" alt="Cebu Pacific Logo" class="brand-logo" onerror="this.src='AO-1.webp'">
        </a>
    </div>

    <!-- Download button moved above the receipt so it's easier to access -->
    <button class="download-btn" data-html2canvas-ignore="true" onclick="downloadPDF()">Download PDF Itinerary</button>

    <div class="receipt-container" id="ticket-pdf">
        <div class="header">
            <h1>Cebu Pacific</h1>
            <div class="status">Confirmed</div>
            <p style="margin: 5px 0 0 0; color: #555;">Thank you. Your transaction was successful.</p>
        </div>

        <div class="grid-2">
            <div class="box">
                <h3>Booking Reference No.</h3>
                <div style="font-size: 24px; font-weight: bold; color: #0072CE;" id="display-pnr">
                    <?php 
                        // Pull PNR from URL or generate a fallback if missing
                        $pnr = isset($_GET['pnr']) && !empty($_GET['pnr']) ? htmlspecialchars($_GET['pnr']) : '';
                        if (empty($pnr)) {
                            $pnr = strtoupper(substr(md5(mt_rand()), 0, 6));
                        }
                        echo $pnr;
                    ?>
                </div>
                <div style="font-size: 12px; margin-top: 5px;">Booking Date: <span id="booking-date"></span></div>
            </div>
            <div class="box">
                <h3>Guest Details</h3>
                <div style="font-weight: bold; font-size: 16px;" id="display-name">
                    <?php
                        // PHP Fallback: Try to fetch the latest guest name directly from the SQLite database if localStorage fails!
                        $dbName = "Valued Guest";
                        try {
                            $pdo = new PDO('sqlite:cebupacific.db');
                            $stmt = $pdo->query("SELECT full_name FROM Passengers ORDER BY rowid DESC LIMIT 1");
                            $res = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($res && !empty($res['full_name'])) {
                                $dbName = htmlspecialchars($res['full_name']);
                            }
                        } catch (Exception $e) {
                            // Database table might be empty or missing, fallback gracefully
                        }
                        echo $dbName;
                    ?>
                </div>
                <div style="font-size: 13px; color: #666;">Adult</div>
            </div>
        </div>

        <!-- FLIGHT DETAILS -->
        <div class="box" style="margin-bottom: 20px;">
            <h3>Flight Details</h3>
            
            <div class="route-header" id="display-route">Manila to Cebu</div>
            <div class="detail-row">
                <span style="color: #666;">Departure:</span>
                <span id="display-depart-date" style="font-weight: bold;">29 Jul 2026</span>
            </div>

            <div id="return-flight-container" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #ccc;">
                <div class="route-header" id="display-return-route">Cebu to Manila</div>
                <div class="detail-row">
                    <span style="color: #666;">Return:</span>
                    <span id="display-return-date" style="font-weight: bold;">30 Jul 2026</span>
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="box">
                <h3>Add-Ons</h3>
                <div class="detail-row"><span>Fare Bundle</span> <span>GO Basic</span></div>
                <div class="detail-row"><span>Baggage</span> <span id="display-baggage">None</span></div>
                <div class="detail-row"><span>Insurance</span> <span id="display-insurance">None</span></div>
            </div>
            <div class="box">
                <h3>Payment Details</h3>
                <div class="detail-row"><span>Status</span> <span style="color: green; font-weight: bold;">Approved</span></div>
                <div class="detail-row"><span>Method</span> <span>Online Payment</span></div>
                <div class="detail-row" style="font-weight: bold; font-size: 16px;">
                    <span>Total Paid</span> 
                    <span id="display-total" style="color: #0072CE;">PHP 9,873.40</span>
                </div>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 30px; font-size: 12px; color: #888;">
            Carriage of passenger and baggage is subject to the Terms and Conditions of Carriage.
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const booking = JSON.parse(localStorage.getItem('cebuBooking')) || {};
            const addons = JSON.parse(localStorage.getItem('cebuAddons')) || {};

            // Set Current Date
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('booking-date').innerText = new Date().toLocaleDateString('en-US', options);

            // Populate LocalStorage Guest Name if available, otherwise PHP fallback handles it
            if (booking && booking.guestName && booking.guestName !== 'Valued Guest') {
                document.getElementById('display-name').innerText = booking.guestName;
            }

            // Populate Departure Route & Date
            if (booking && booking.depart && booking.depart.routeLabel) {
                document.getElementById('display-route').innerText = booking.depart.routeLabel;
                document.getElementById('display-depart-date').innerText = booking.depart.dateLabel;
            } else {
                document.getElementById('display-route').innerText = "Manila to Cebu";
                document.getElementById('display-depart-date').innerText = "29 Jul 2026";
            }

            // Populate Return Route (Explicitly forces it to show if roundtrip data exists)
            if (booking && booking.return && booking.return.routeLabel) {
                document.getElementById('return-flight-container').style.display = 'block';
                document.getElementById('display-return-route').innerText = booking.return.routeLabel;
                document.getElementById('display-return-date').innerText = booking.return.dateLabel;
            } else {
                document.getElementById('return-flight-container').style.display = 'none';
            }

            // Populate Addons
            if (addons.baggage > 0) document.getElementById('display-baggage').innerText = "1pc checked baggage (20kg)";
            if (addons.travelsure > 0) document.getElementById('display-insurance').innerText = "CEB TravelSure";

            // Calculate and Display Total
            const flightTotal = (booking.depart ? booking.depart.subtotal : 0) + (booking.return ? booking.return.subtotal : 0);
            if (flightTotal > 0) {
                const addonTotal = (addons.baggage || 0) + (addons.seat || 0) + (addons.travelsure || 0) + (addons.meals || 0);
                const grandTotal = flightTotal + addonTotal + 2869.52; 
                document.getElementById('display-total').innerText = 'PHP ' + grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        });

        // The PDF Generation Function
        function downloadPDF() {
            const element = document.getElementById('ticket-pdf');
            const pnr = document.getElementById('display-pnr').innerText.trim();
            
            const opt = {
                margin:       0.5,
                filename:     `CebuPacific_Itinerary_${pnr}.pdf`,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>