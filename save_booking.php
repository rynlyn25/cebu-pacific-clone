<?php
header('Content-Type: application/json');

// 1. Connect to SQLite Database
try {
    $pdo = new PDO('sqlite:cebupacific.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'DB Connection Failed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'No data received']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Generate a random 6-character PNR (Letters and Numbers)
    $pnr = strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6));
    
    $guestName = $input['guestName'] ?? 'Guest';
    $dob = $input['dob'] ?? '2000-01-01'; // Catch the DOB
    $totalPrice = floatval($input['totalPrice'] ?? 0);
    $paymentMethod = $input['paymentMethod'] ?? 'Credit Card';

    // Insert into Bookings Table[cite: 6]
    $stmt1 = $pdo->prepare("INSERT INTO Bookings (pnr, booking_status, total_price, currency) VALUES (?, 'Confirmed', ?, 'PHP')");
    $stmt1->execute([$pnr, $totalPrice]);

    // Insert into Passengers Table[cite: 6]
    $stmt2 = $pdo->prepare("INSERT INTO Passengers (pnr, passenger_type, full_name, dob) VALUES (?, 'Adult', ?, '2000-01-01')");
    $stmt2->execute([$pnr, $guestName]);

    // Insert into Payments Table[cite: 6]
    $transactionId = 'TXN' . strtoupper(uniqid());
    $stmt3 = $pdo->prepare("INSERT INTO Payments (transaction_id, pnr, payment_method, amount_paid, currency, payment_status) VALUES (?, ?, ?, ?, 'PHP', 'Success')");
    $stmt3->execute([$transactionId, $pnr, $paymentMethod, $totalPrice]);

    $pdo->commit();

    // Return the generated PNR back to the frontend!
    echo json_encode(['success' => true, 'pnr' => $pnr]);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>