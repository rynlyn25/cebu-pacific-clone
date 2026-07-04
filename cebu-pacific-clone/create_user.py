import sqlite3
import hashlib

def create_test_user():
    # Connect to your existing database
    conn = sqlite3.connect('users.db')
    cursor = conn.cursor()
    
    email = "test@example.com"
    first_name = "Juan"
    last_name = "Dela Cruz"
    password = "password123"
    
    # Encrypt the password exactly how the server expects it
    password_hash = hashlib.sha256(password.encode()).hexdigest()
    
    try:
        cursor.execute(
            "INSERT INTO users (email, first_name, last_name, password_hash) VALUES (?, ?, ?, ?)",
            (email, first_name, last_name, password_hash)
        )
        conn.commit()
        print(f"Success! Test account created.")
        print(f"Email: {email}")
        print(f"Password: {password}")
    except sqlite3.IntegrityError:
        print("That user already exists in the database.")
        
    conn.close()

if __name__ == '__main__':
    create_test_user()