-- Enable Foreign Key constraints in SQLite
PRAGMA foreign_keys = ON;

-- 1. Customers (User Accounts)
CREATE TABLE Customers (
    account_id TEXT PRIMARY KEY, -- UUID
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    dob DATE,
    gender TEXT,
    email TEXT UNIQUE NOT NULL,
    phone_number TEXT,
    go_rewards_number TEXT,
    saved_passengers TEXT, -- Stored as JSON string in SQLite
    account_status TEXT DEFAULT 'Active' CHECK(account_status IN ('Active', 'Suspended', 'Inactive'))
);

-- 2. Airports & Routes
CREATE TABLE Airports (
    airport_code TEXT PRIMARY KEY CHECK(length(airport_code) = 3), -- 3-letter IATA
    city_country TEXT NOT NULL,
    timezone TEXT NOT NULL,
    active_route INTEGER DEFAULT 1 -- Boolean: 1 for True, 0 for False
);

-- 3. Flights (Schedules & Inventory)
CREATE TABLE Flights (
    flight_id TEXT PRIMARY KEY,
    flight_number TEXT NOT NULL,
    origin_code TEXT NOT NULL,
    destination_code TEXT NOT NULL,
    departure_datetime DATETIME NOT NULL, -- UTC
    arrival_datetime DATETIME NOT NULL, -- UTC
    aircraft_type TEXT NOT NULL,
    base_fare REAL NOT NULL,
    seat_capacity INTEGER NOT NULL,
    seats_booked INTEGER DEFAULT 0,
    FOREIGN KEY (origin_code) REFERENCES Airports(airport_code),
    FOREIGN KEY (destination_code) REFERENCES Airports(airport_code)
);

-- 4. Bookings (The PNR)
CREATE TABLE Bookings (
    pnr TEXT PRIMARY KEY CHECK(length(pnr) = 6), -- Strict 6-character PNR constraint
    account_id TEXT,
    booking_status TEXT DEFAULT 'Pending Payment' CHECK(booking_status IN ('Confirmed', 'Cancelled', 'Pending Payment')),
    creation_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_price REAL NOT NULL,
    currency TEXT DEFAULT 'PHP',
    FOREIGN KEY (account_id) REFERENCES Customers(account_id)
);

-- 5. Passengers
CREATE TABLE Passengers (
    passenger_id INTEGER PRIMARY KEY AUTOINCREMENT,
    pnr TEXT NOT NULL,
    passenger_type TEXT CHECK(passenger_type IN ('Adult', 'Child', 'Infant')),
    full_name TEXT NOT NULL,
    dob DATE NOT NULL,
    nationality TEXT,
    passport_details TEXT,
    FOREIGN KEY (pnr) REFERENCES Bookings(pnr)
);

-- 6. Ancillaries (The Add-ons)
CREATE TABLE Ancillaries (
    addon_id INTEGER PRIMARY KEY AUTOINCREMENT,
    passenger_id INTEGER NOT NULL,
    flight_id TEXT NOT NULL,
    fare_bundle TEXT CHECK(fare_bundle IN ('Go Basic', 'Go Easy', 'Go Flexi')),
    baggage_allowance TEXT,
    seat_code TEXT,
    seat_type TEXT CHECK(seat_type IN ('Standard', 'Premium', 'Exit Row')),
    pre_ordered_meals TEXT,
    insurance_opt_in INTEGER DEFAULT 0, -- Boolean
    FOREIGN KEY (passenger_id) REFERENCES Passengers(passenger_id),
    FOREIGN KEY (flight_id) REFERENCES Flights(flight_id)
);

-- 7. Payments & Travel Funds
CREATE TABLE Payments (
    transaction_id TEXT PRIMARY KEY,
    pnr TEXT NOT NULL,
    payment_method TEXT CHECK(payment_method IN ('Credit Card', 'GCash', 'Maya', 'Travel Fund')),
    amount_paid REAL NOT NULL,
    currency TEXT DEFAULT 'PHP',
    payment_status TEXT CHECK(payment_status IN ('Success', 'Failed', 'Refunded')),
    travel_fund_balance REAL DEFAULT 0.0,
    FOREIGN KEY (pnr) REFERENCES Bookings(pnr)
);

-- 8. Check-In & Boarding
CREATE TABLE Check_In (
    checkin_id INTEGER PRIMARY KEY AUTOINCREMENT,
    passenger_id INTEGER NOT NULL,
    flight_id TEXT NOT NULL,
    checkin_method TEXT CHECK(checkin_method IN ('Web', 'Mobile App', 'Kiosk', 'Counter')),
    checkin_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    sequence_number TEXT,
    document_verified INTEGER DEFAULT 0, -- Boolean
    boarding_status TEXT CHECK(boarding_status IN ('Checked-in', 'Boarded', 'No-Show')),
    FOREIGN KEY (passenger_id) REFERENCES Passengers(passenger_id),
    FOREIGN KEY (flight_id) REFERENCES Flights(flight_id)
);

-- 9. Booking Modifications (Manage Booking)
CREATE TABLE Booking_Modifications (
    modification_id INTEGER PRIMARY KEY AUTOINCREMENT,
    pnr TEXT NOT NULL,
    modification_type TEXT CHECK(modification_type IN ('Flight Change', 'Name Correction', 'Cancellation', 'Add-on Purchase')),
    previous_flight_id TEXT,
    new_flight_id TEXT,
    change_fee REAL DEFAULT 0.0,
    fare_difference REAL DEFAULT 0.0,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_id TEXT,
    FOREIGN KEY (pnr) REFERENCES Bookings(pnr)
);

-- 10. Itineraries & Communications
CREATE TABLE Communications (
    communication_id INTEGER PRIMARY KEY AUTOINCREMENT,
    pnr TEXT NOT NULL,
    document_type TEXT CHECK(document_type IN ('Itinerary Receipt', 'Boarding Pass', 'Flight Disruption Notice')),
    delivery_channel TEXT CHECK(delivery_channel IN ('Email', 'SMS', 'Push Notification')),
    recipient_address TEXT NOT NULL,
    delivery_status TEXT CHECK(delivery_status IN ('Sent', 'Delivered', 'Failed', 'Bounced')),
    document_storage_url TEXT,
    FOREIGN KEY (pnr) REFERENCES Bookings(pnr)
);

-- 11. Taxes & Fees Breakdown
CREATE TABLE Taxes_Fees (
    fee_breakdown_id INTEGER PRIMARY KEY AUTOINCREMENT,
    passenger_id INTEGER NOT NULL,
    flight_id TEXT NOT NULL,
    base_fare REAL NOT NULL,
    fuel_surcharge REAL DEFAULT 0.0,
    aviation_security_fee REAL DEFAULT 0.0,
    passenger_service_charge REAL DEFAULT 0.0,
    travel_tax REAL DEFAULT 0.0,
    FOREIGN KEY (passenger_id) REFERENCES Passengers(passenger_id),
    FOREIGN KEY (flight_id) REFERENCES Flights(flight_id)
);

-- 12. Promotions & Vouchers (The "Piso Fare" Engine)
CREATE TABLE Promotions (
    promo_id INTEGER PRIMARY KEY AUTOINCREMENT,
    promo_code TEXT UNIQUE NOT NULL,
    discount_logic TEXT CHECK(discount_logic IN ('Fixed Amount', 'Percentage', 'Flat Base Fare')),
    discount_value REAL NOT NULL,
    booking_window_start DATETIME NOT NULL,
    booking_window_end DATETIME NOT NULL,
    travel_period_start DATE NOT NULL,
    travel_period_end DATE NOT NULL,
    route_restrictions TEXT -- Stored as JSON array of airport codes
);

-- 13. Audit & Concurrency Logs (Seat Locks)
CREATE TABLE Inventory_Locks (
    lock_id INTEGER PRIMARY KEY AUTOINCREMENT,
    flight_id TEXT NOT NULL,
    seat_code TEXT NOT NULL,
    locked_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NOT NULL,
    lock_status TEXT DEFAULT 'Active' CHECK(lock_status IN ('Active', 'Released', 'Converted to Booking')),
    FOREIGN KEY (flight_id) REFERENCES Flights(flight_id)
);