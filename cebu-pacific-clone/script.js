// --- 1. TAB SWITCHING LOGIC ---
function setupTabs(tabContainerSelector) {
    const tabs = document.querySelectorAll(`${tabContainerSelector} button`);
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });
}
setupTabs('.widget-tabs');
setupTabs('.deal-tabs');

// --- 2. HERO BACKGROUND SLIDER LOGIC (HOME PAGE) ---
const sliderContainer = document.getElementById('slider-container');

if (sliderContainer) { // Only run this if we are on the Home Page
    const destinations = [
        { title: "SIARGAO", image: "url('images/siargao.webp')" },
        { title: "DAVAO", image: "url('images/davao.jpg')" },
        { title: "ILOILO", image: "url('images/iloilo1.webp')" },
        { title: "KAOHSIUNG", image: "url('images/KAOHSIUNG.webp')" }
    ];

    const sliderTitle = document.getElementById('slider-title');
    const homeDots = document.querySelectorAll('.dot');

    let currentIndex = 0;
    let slideTimer;

    function updateSlide(index) {
        currentIndex = index; 
        sliderContainer.style.backgroundImage = destinations[currentIndex].image;
        sliderTitle.textContent = destinations[currentIndex].title;

        homeDots.forEach(dot => dot.classList.remove('active'));
        if(homeDots[currentIndex]) {
            homeDots[currentIndex].classList.add('active');
        }
    }

    function nextSlide() {
        let nextIndex = (currentIndex + 1) % destinations.length; 
        updateSlide(nextIndex);
    }

    function startTimer() {
        clearInterval(slideTimer); 
        slideTimer = setInterval(nextSlide, 7000); 
    }

    homeDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            updateSlide(index); 
            startTimer();       
        });
    });

    updateSlide(0); 
    startTimer();   
}

// --- 3. STICKY HEADER SCROLL LOGIC ---
const topBar = document.querySelector('.top-advisory-bar');
const header = document.querySelector('.hero-header');

window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        topBar.classList.add('scrolled');
        header.classList.add('scrolled');
    } else {
        topBar.classList.remove('scrolled');
        header.classList.remove('scrolled');
    }
});

// --- 4. SERVICE CARDS CLICK LOGIC ---
const serviceCards = document.querySelectorAll('.service-card');

serviceCards.forEach(card => {
    card.addEventListener('click', () => {
        serviceCards.forEach(c => c.classList.remove('active'));
        card.classList.add('active');
    });
});


// --- 5. HEADER LOGIN BUTTONS (REDIRECT TO PAGE) ---

const headerLoginBtn = document.querySelector('.login-btn'); 
const megaLoginBtn = document.querySelector('.mega-login-btn'); 

function goToLoginPage(e) {
    e.preventDefault();
    window.location.href = 'login.html';
}

if (headerLoginBtn) headerLoginBtn.addEventListener('click', goToLoginPage);
if (megaLoginBtn) megaLoginBtn.addEventListener('click', goToLoginPage);


// --- 6. MULTI-STEP LOGIN ROUTER & DATABASE CONNECTION (login.html) ---

let userEmail = "";

// Helper: Switch visible steps
function goToStep(targetStepId) {
    document.querySelectorAll('.auth-step').forEach(step => step.classList.remove('active'));
    const target = document.getElementById(targetStepId);
    if(target) target.classList.add('active');
}

// Helper: Reset red error states
function resetErrors() {
    document.querySelectorAll('.error-box').forEach(box => box.style.display = 'none');
    document.querySelectorAll('.inline-error-text').forEach(text => text.style.display = 'none');
    document.querySelectorAll('input').forEach(input => input.classList.remove('input-error'));
}

// A. Initial Form: Capture Email and go to Method Selection
const initialForm = document.getElementById('initialLoginForm');
if(initialForm) {
    initialForm.addEventListener('submit', (e) => {
        e.preventDefault();
        userEmail = document.getElementById('emailInput').value;
        
        // Update all badges with the typed email
        document.querySelectorAll('.display-email').forEach(span => {
            span.textContent = userEmail;
        });

        goToStep('step-2-method');
    });
}

// B. Hook up all routing links/buttons
document.querySelectorAll('[data-target]').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        goToStep(btn.getAttribute('data-target'));
        resetErrors();
    });
});

// C. Password Verification: REAL DATABASE CONNECTION
const passwordForm = document.getElementById('verifyPasswordForm');
if(passwordForm) {
    passwordForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const passwordInput = document.getElementById('loginPassword');
        const password = passwordInput.value;
        const submitBtn = passwordForm.querySelector('.next-btn');
        
        submitBtn.innerText = "Verifying..."; 

        try {
            // Send data to the Flask Backend using the email captured in Step 1
            const response = await fetch('http://127.0.0.1:5000/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: userEmail, password: password })
            });

            const result = await response.json();

            if (response.ok) {
                // Success: Redirect back to the home page!
                alert("Success: " + result.message); 
                window.location.href = 'index.html'; 
            } else {
                // Error: Show the red error box and outline
                document.getElementById('passwordErrorBox').style.display = 'flex';
                passwordInput.classList.add('input-error');
            }
        } catch (error) {
            console.error('Error:', error);
            alert("Cannot connect to the server. Is app.py running?");
        } finally {
            submitBtn.innerText = "Verify"; 
        }
    });
}

// D. Email Code Verification: Simulated Fallback 
const codeForm = document.getElementById('verifyCodeForm');
if(codeForm) {
    codeForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const codeInput = document.getElementById('verificationCode');
        
        // Since standard Flask backends only check passwords, we simulate the email code success with "0000"
        if (codeInput.value === "0000") {
            alert("Email Verified Successfully!");
            window.location.href = 'index.html';
        } else {
            // Show red error states
            document.getElementById('codeErrorBox').style.display = 'flex';
            codeInput.classList.add('input-error');
            document.getElementById('codeErrorText').style.display = 'block';
        }
    });
}


// --- 7. SIGNUP PAGE DATABASE CONNECTION (signup.html) ---

const signupFormPage = document.getElementById('newSignupForm'); 

if(signupFormPage) {
    signupFormPage.addEventListener('submit', async function(e) {
        e.preventDefault(); 
        
        const email = document.getElementById('signupEmail').value;
        const lastName = document.getElementById('signupLastName').value;
        const firstName = document.getElementById('signupFirstName').value;
        const password = document.getElementById('signupPassword').value;
        const submitBtn = signupFormPage.querySelector('.next-btn');
        
        submitBtn.innerText = "Saving..."; 

        try {
            // Send data to the Flask Backend's /signup route
            const response = await fetch('http://127.0.0.1:5000/signup', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    email: email, 
                    first_name: firstName,
                    last_name: lastName,
                    password: password 
                })
            });

            const result = await response.json();

            if (response.ok) {
                alert("Success: " + result.message); 
                // Automatically redirect them back to the login page to sign in!
                window.location.href = 'login.html'; 
            } else {
                alert("Error: " + result.error);
            }
        } catch (error) {
            console.error('Error:', error);
            alert("Cannot connect to the server. Is app.py running?");
        } finally {
            submitBtn.innerText = "Sign Up"; 
        }
    });
}
// --- NEW: 10-SECOND TIMEOUT LOGIC ---

let timeoutTimer;

function startTimeoutWarning(targetStepId) {
    // Clear any existing timer
    clearTimeout(timeoutTimer);
    
    // If we just landed on the "Email Sent" step (step-4-email-sent)
    if (targetStepId === 'step-4-email-sent') {
        timeoutTimer = setTimeout(() => {
            const warningBox = document.getElementById('timeoutWarningBox');
            if(warningBox) {
                warningBox.style.display = 'flex';
                // Optional: Trigger a pulse animation here
            }
        }, 10000); // 10,000 milliseconds = 10 seconds
    }
}

// Update your existing goToStep function to call this:
function goToStep(targetStepId) {
    document.querySelectorAll('.auth-step').forEach(step => step.classList.remove('active'));
    const target = document.getElementById(targetStepId);
    if(target) {
        target.classList.add('active');
        
        // --- ADD THIS LINE ---
        startTimeoutWarning(targetStepId); 
    }
}

// Add the resend logic
const resendLink = document.getElementById('resendEmail');
if(resendLink) {
    resendLink.addEventListener('click', (e) => {
        e.preventDefault();
        alert("Verification email resent!");
        document.getElementById('timeoutWarningBox').style.display = 'none';
        // Restart the 10s timer if they want to click it again later
        startTimeoutWarning('step-4-email-sent'); 
    });
}
// --- 8. SEAT SALE BACKGROUND SLIDER LOGIC ---
const seatSaleHero = document.querySelector('.seat-sale-hero');

if (seatSaleHero) { // Only run this if we are on the Seat Sale page
    
    // Put your 2 image filenames here!
    const seatSaleImages = [
        "url('images/HPB_PH_Domestic_Boracay_MPH_KLO_13.webp')", 
        "url('images/CEB-Cebu-Philippines-Island-3992x2992.webp')"  
    ];

    const seatSaleDots = document.querySelectorAll('.hero-slider-dots .dot');

    let seatSaleIndex = 0;
    let seatSaleTimer;

    function updateSeatSaleSlide(index) {
        seatSaleIndex = index; 
        // Change the background image
        seatSaleHero.style.backgroundImage = seatSaleImages[seatSaleIndex];

        // Update the active dot
        seatSaleDots.forEach(dot => dot.classList.remove('active'));
        if(seatSaleDots[seatSaleIndex]) {
            seatSaleDots[seatSaleIndex].classList.add('active');
        }
    }

    function nextSeatSaleSlide() {
        let nextIndex = (seatSaleIndex + 1) % seatSaleImages.length; 
        updateSeatSaleSlide(nextIndex);
    }

    function startSeatSaleTimer() {
        clearInterval(seatSaleTimer); 
        // 7000 = 7 seconds per slide, just like the home page
        seatSaleTimer = setInterval(nextSeatSaleSlide, 7000); 
    }

    seatSaleDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            updateSeatSaleSlide(index); 
            startSeatSaleTimer();       
        });
    });

    // Start the slider automatically
    updateSeatSaleSlide(0); 
    startSeatSaleTimer();   
}