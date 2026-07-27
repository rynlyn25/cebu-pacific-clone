<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$initials = $isLoggedIn ? strtoupper(substr($_SESSION['first_name'], 0, 1) . substr($_SESSION['last_name'], 0, 1)) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Agent Login - Cebu Pacific</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* =========================================
           PARTNER AGENT LOGIN PAGE
           ========================================= */

        .partner-login-body {
            margin: 0;
            padding: 0;
            height: 100vh; 
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Noto Sans", Arial, sans-serif;
            position: relative;
            overflow: hidden; 
        }

        .partner-login-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            z-index: -1;
        }

        .partner-logo-container {
            position: absolute;
            top: 35px;
            left: 5%;
        }

        .partner-login-card {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15); 
            width: 100%;
            max-width: 400px; 
            box-sizing: border-box;
        }

        .partner-login-card h2 {
            margin: 0 0 10px 0;
            font-size: 22px;
            color: #222;
            font-weight: 800;
        }

        .partner-login-card p {
            margin: 0 0 25px 0;
            font-size: 14px;
            color: #444;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .input-group label {
            font-size: 12px;
            color: #888;
            margin-bottom: 8px;
        }

        .input-group input {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
            width: 100%;
            box-sizing: border-box;
        }

        .input-group input:focus {
            border-color: #0088ce;
        }

        .password-group .view-password-icon {
            position: absolute;
            right: 15px;
            top: 36px;
            color: #aaa;
            cursor: pointer;
            font-size: 14px;
            transition: color 0.2s;
        }

        .password-group .view-password-icon:hover {
            color: #0088ce;
        }

        .forgot-password {
            display: block;
            font-size: 12px;
            color: #005eb8;
            text-decoration: none;
            margin-bottom: 25px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .partner-login-btn {
            background: #0088ce;
            color: white;
            border: none;
            width: 100%;
            padding: 14px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .partner-login-btn:hover {
            background: #006eb3;
        }
        
        .partner-signup-prompt {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #444;
        }

        .partner-signup-prompt a {
            color: #005eb8;
            font-weight: 800;
            text-decoration: none;
        }

        .partner-signup-prompt a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #c8102e; 
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 20px;
            display: flex; 
            align-items: flex-start;
            gap: 8px;
        }

        /* =========================================
           FORGOT PASSWORD PAGE OF PARTNER LOGIN
           ========================================= */
        .forgot-pwd-body {
            margin: 0;
            padding: 0;
            background-color: #f4f5f7; 
            font-family: "Noto Sans", Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
        }

        .forgot-hero {
            background-color: #ffd800; 
            padding: 40px 5%;
            border-bottom-left-radius: 50% 12px;
            border-bottom-right-radius: 50% 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .forgot-hero-content {
            max-width: 1150px;
            margin: 0 auto;
        }

        .forgot-hero h1 {
            color: #005eb8; 
            font-size: 28px;
            font-weight: 800;
            margin: 0;
        }

        .forgot-main {
            flex: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .forgot-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06); 
            width: 100%;
            max-width: 520px; 
            padding: 45px 50px;
            box-sizing: border-box;
            text-align: center;
        }

        .forgot-instructions {
            color: #444;
            font-size: 14px;
            line-height: 1.6;
            margin: 0 0 30px 0;
        }

        .forgot-input-group {
            text-align: left;
            margin-bottom: 25px;
        }

        .forgot-input-group label {
            display: block;
            font-size: 13px;
            color: #777;
            margin-bottom: 8px;
        }

        .required-star {
            color: #c8102e; 
            font-weight: bold;
        }

        .forgot-input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .forgot-input-group input:focus {
            border-color: #0088ce;
        }

        .reset-btn {
            background-color: #c4e0eb; 
            color: white;
            border: none;
            width: 100%;
            padding: 14px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 700;
            cursor: default; 
            margin-bottom: 25px;
        }

        .cancel-link {
            display: inline-block;
            color: #005eb8;
            text-decoration: none;
            font-weight: 800;
            font-size: 14px;
        }

        .cancel-link:hover {
            text-decoration: underline;
        }

        .forgot-footer {
            background-color: #ffd800;
            color: #005eb8;
            text-align: center;
            padding: 15px;
            font-size: 13px;
            font-weight: 600;
        }

        .reset-btn.active {
            background-color: #0088ce !important; 
            cursor: pointer !important;
            transition: background-color 0.2s ease;
        }

        .reset-btn.active:hover {
            background-color: #006eb3 !important; 
        }
    </style>
</head>
<body class="partner-login-body">
    
    <!-- Encoded spaces in URL for broader browser compatibility -->
    <div class="partner-login-bg" style="background-image: url('images/CGY%20Hub%20(6%20of%2013).jpg');"></div>

    <div class="partner-logo-container">
        <a href="index.html">
            <img src="images/CEB_logo_LFEJ_in_Noto_Sans_Linear.webp" alt="Cebu Pacific" style="height: 45px; filter: brightness(0) invert(1);">
        </a>
    </div>

    <div class="partner-login-card">
        <h2>Login</h2>
        <p>Enter your CEB partner account</p>

        <!-- Converted to a form element to support native "Enter" key submission -->
        <form id="partner-login-form">
            <div class="input-group">
                <label>Agent ID</label>
                <input type="text" id="agent-id" placeholder="Enter ID" autocomplete="username">
            </div>

            <div class="input-group password-group">
                <label>Password</label>
                <input type="password" id="agent-password" placeholder="Enter Password" autocomplete="current-password">
                <i class="fa-regular fa-eye view-password-icon" id="toggle-password" title="Show password"></i>
            </div>

            <a href="forgot-password.html" class="forgot-password">Forgot your password?</a>

            <div id="login-error-msg" class="error-message" style="display: none;">
                <i class="fa-solid fa-circle-exclamation" style="margin-top: 3px;"></i> 
                <span>The ID and password you entered does not match our records. Please try again or click "Forgot your password?"</span>
            </div>

            <button type="submit" id="login-btn" class="partner-login-btn">Log in</button>
            
            <!-- NEW SIGN UP PROMPT -->
            <div class="partner-signup-prompt">
                Not yet a partner agent? <a href="partner-signup.html">Apply here</a>
            </div>
        </form>
    </div>
    
    <!-- ========================================== -->
    <!-- INTERACTIVE SCRIPTS -->
    <!-- ========================================== -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loginForm = document.getElementById('partner-login-form');
            const agentIdInput = document.getElementById('agent-id');
            const passwordInput = document.getElementById('agent-password');
            const errorMsg = document.getElementById('login-error-msg');
            const togglePassword = document.getElementById('toggle-password');

            // Interactive Password Visibility Toggle
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            // Form Validation and Submission
            if (loginForm) {
                loginForm.addEventListener('submit', function(event) {
                    event.preventDefault(); 

                    // Utilizing Regex for strict empty-state validation
                    const isBlankRegex = /^\s*$/;

                    if (isBlankRegex.test(agentIdInput.value) || isBlankRegex.test(passwordInput.value)) {
                        errorMsg.style.display = 'flex';
                    } else {
                        errorMsg.style.display = 'none';
                        alert("Credentials accepted! (This is a clone)");
                    }
                });
            }
        });
    </script>
</body>
</html>