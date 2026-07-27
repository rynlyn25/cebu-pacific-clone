from datetime import datetime
from flask import Flask, jsonify, request

app = Flask(__name__)

# --- FLIGHT DATASET ---
FLIGHT_DATA = {
    "international": {
        "Australia": ["Melbourne", "Sydney"],
        "Brunei": ["Bandar Seri Begawan"],
        "China": ["Guangzhou", "Shanghai"],
        "Hong Kong (SAR)": ["Hong Kong"],
        "Macau (SAR)": ["Macau"],
        "Indonesia": ["Bali (Denpasar)", "Jakarta"],
        "Japan": [
            "Fukuoka",
            "Nagoya",
            "Osaka (Kansai)",
            "Sapporo",
            "Tokyo (Narita)",
        ],
        "Malaysia": ["Kuala Lumpur"],
        "Saudi Arabia": ["Riyadh"],
        "Singapore": ["Singapore"],
        "South Korea": ["Incheon (Seoul)"],
        "Taiwan": ["Kaohsiung", "Taipei"],
        "Thailand": ["Bangkok (Suvarnabhumi)", "Bangkok (Don Mueang)"],
        "United Arab Emirates": ["Dubai"],
        "Vietnam": ["Da Nang", "Hanoi", "Ho Chi Minh City"],
    },
    "local": [
        {"destination": "Bacolod", "airport": "Bacolod-Silay International Airport"},
        {"destination": "Bohol (Panglao)",
         "airport": "Bohol-Panglao International Airport"},
        {"destination": "Butuan", "airport": "Bancasi Airport"},
        {"destination": "Cagayan de Oro", "airport": "Laguingan Airport"},
        {"destination": "Calbayog", "airport": "Calbayog Airport"},
        {"destination": "Camiguin", "airport": "Camiguin Airport"},
        {"destination": "Cauayan (Isabela)", "airport": "Cauayan Airport"},
        {"destination": "Clark (Pampanga)",
         "airport": "Clark International Airport"},
        {"destination": "Coron (Busuanga)",
         "airport": "Francisco B. Reyes Airport"},
        {"destination": "Cotabato", "airport": "Cotabato Airport"},
        {"destination": "Davao", "airport": "Davao International Airport"},
        {"destination": "Dipolog", "airport": "Dipolog Airport"},
        {"destination": "Dumaguete", "airport": "Sibulan Airport"},
        {"destination": "El Nido", "airport": "Lio Airport"},
        {"destination": "General Santos",
            "airport": "General Santos International Airport"},
        {"destination": "Iloilo", "airport": "Iloilo International Airport"},
        {"destination": "Kalibo", "airport": "Kalibo International Airport"},
        {"destination": "Laoag", "airport": "Laoag International Airport"},
        {"destination": "Legazpi", "airport": "Bicol International Airport"},
        {"destination": "Manila",
            "airport": "Ninoy Aquino International Airport (NAIA)"},
        {"destination": "Masbate", "airport": "Moises R. Espinosa Airport"},
        {"destination": "Naga", "airport": "Naga Airport"},
        {"destination": "Ozamiz", "airport": "Labo Airport"},
        {"destination": "Pagadian", "airport": "Pagadian Airport"},
        {"destination": "Puerto Princesa",
            "airport": "Puerto Princesa International Airport"},
        {"destination": "Roxas", "airport": "Roxas Airport"},
        {"destination": "San Jose (Mindoro)", "airport": "San Jose Airport"},
        {"destination": "Siargao", "airport": "Siargao Airport"},
        {"destination": "Surigao", "airport": "Surigao Airport"},
        {"destination": "Tacloban", "airport": "Daniel Z. Romualdez Airport"},
        {"destination": "Sanga-Sanga", "airport": "Sanga-Sanga Airport"},
        {"destination": "Tuguegarao", "airport": "Tuguegarao Airport"},
        {"destination": "Virac", "airport": "Virac Airport"},
        {"destination": "Zamboanga", "airport": "Zamboanga International Airport"},
    ],
}


def check_location(location_name):
    if not location_name or "select" in location_name.lower():
        return False, None
    for loc in FLIGHT_DATA["local"]:
        if (
            location_name.lower() in loc["destination"].lower()
            or location_name.lower() in loc["airport"].lower()
        ):
            return True, "Local"
    for country, cities in FLIGHT_DATA["international"].items():
        for city in cities:
            if location_name.lower() in city.lower():
                return True, f"International ({country})"
    return False, None


@app.route("/api/destinations", methods=["GET"])
def get_destinations():
    return jsonify(FLIGHT_DATA), 200


@app.route("/api/search-flights", methods=["POST"])
def search_flights():
    data = request.json
    if not data:
        return jsonify({"error": "Invalid request payload"}), 400

    # Normalizing trip type check to lowercase for error prevention
    trip_type = data.get("trip_type", "round-trip").strip().lower()
    promo_code = data.get("promo_code", "").strip()

    adults = int(data.get("adults", 1))
    children = int(data.get("children", 0))
    infants = int(data.get("infant", 0))

    if adults < 1:
        return jsonify({"error": "At least 1 adult passenger must be present to book."}), 400

    processed_legs = []

    # --- MULTI-CITY HANDLING ---
    if trip_type == "multi-city":
        legs = data.get("flights", [])
        if not legs or len(legs) < 2:
            return jsonify({"error": "Multi-city routes require at least 2 flight sections."}), 400

        last_date = None
        for index, leg in enumerate(legs):
            origin = leg.get("from", "").strip()
            destination = leg.get("to", "").strip()
            depart_date_str = leg.get("depart_date", "").strip()

            if not origin or "select" in origin.lower():
                return jsonify({"error": f"Please select a valid origin for Flight Leg {index + 1}."}), 400
            if not destination or "select" in destination.lower():
                return jsonify({"error": f"Please select a valid destination for Flight Leg {index + 1}."}), 400
            if not depart_date_str:
                return jsonify({"error": f"Departure date missing for Flight Leg {index + 1}."}), 400

            valid_dest, classification = check_location(destination)
            if not valid_dest:
                return jsonify({"error": f"Destination '{destination}' on leg {index + 1} is not serviced."}), 400

            try:
                current_date = datetime.strptime(depart_date_str, "%Y-%m-%d")
                if last_date and current_date < last_date:
                    return jsonify({"error": f"Flight Leg {index + 1} cannot depart before Leg {index}."}), 400
                last_date = current_date
            except ValueError:
                return jsonify({"error": f"Invalid date format on leg {index + 1}. Use YYYY-MM-DD."}), 400

            processed_legs.append({
                "leg": index + 1,
                "from": origin,
                "to": destination,
                "classification": classification,
                "depart_date": depart_date_str
            })

    # --- ONE-WAY / ROUND-TRIP HANDLING ---
    else:
        origin = data.get("from", "").strip()
        destination = data.get("to", "").strip()
        depart_date_str = data.get("depart_date", "").strip()
        return_date_str = data.get("return_date", "").strip()

        if not origin or not depart_date_str:
            return jsonify({"error": "Origin and Departure date are required fields."}), 400
        if not destination or "select" in destination.lower():
            return jsonify({"error": "Please select a valid destination."}), 400

        valid_dest, classification = check_location(destination)
        if not valid_dest:
            return jsonify({"error": f"Destination '{destination}' is not serviced."}), 400

        try:
            depart_date = datetime.strptime(depart_date_str, "%Y-%m-%d")
            if trip_type == "round-trip":
                if not return_date_str:
                    return jsonify({"error": "A return date is required for round-trip configurations."}), 400
                return_date = datetime.strptime(return_date_str, "%Y-%m-%d")
                if return_date < depart_date:
                    return jsonify({"error": "Return date cannot occur before departure date."}), 400
            else:
                return_date_str = None
        except ValueError:
            return jsonify({"error": "Invalid date format parsed. Use YYYY-MM-DD."}), 400

        processed_legs.append({
            "from": origin,
            "to": destination,
            "classification": classification,
            "depart_date": depart_date_str,
            "return_date": return_date_str
        })

    return jsonify({
        "status": "success",
        "trip_configuration": data.get("trip_type"),
        "manifest": {
            "total_passengers": adults + children + infants,
            "breakdown": {"adults": adults, "children": children, "infants": infants}
        },
        "promo_applied": promo_code if promo_code else "None",
        "itinerary_legs": processed_legs,
        "mock_results": [
            {
                "flight_no": f"AIR-LEG-{i+1}",
                "departure": "10:00",
                "arrival": "13:30",
                "currency": "PHP"
            } for i in range(len(processed_legs))
        ]
    }), 200


if __name__ == "__main__":
    app.run(debug=True, port=5000)
