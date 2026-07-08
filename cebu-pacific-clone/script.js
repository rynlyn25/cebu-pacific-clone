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

// --- 2. HERO BACKGROUND SLIDER LOGIC ---
const destinations = [
    { title: "SIARGAO", image: "url('images/siargao.webp')" },
    { title: "DAVAO", image: "url('images/davao.jpg')" },
    { title: "ILOILO", image: "url('images/iloilo1.webp')" },
    { title: "KAOHSIUNG", image: "url('images/KAOHSIUNG.webp')" }
];

const sliderContainer = document.getElementById('slider-container');
const sliderTitle = document.getElementById('slider-title');
const dots = document.querySelectorAll('.dot');

let currentIndex = 0;
let slideTimer;

function updateSlide(index) {
    currentIndex = index; 
    sliderContainer.style.backgroundImage = destinations[currentIndex].image;
    sliderTitle.textContent = destinations[currentIndex].title;

    dots.forEach(dot => dot.classList.remove('active'));
    if(dots[currentIndex]) {
        dots[currentIndex].classList.add('active');
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

dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        updateSlide(index); 
        startTimer();       
    });
});

if (sliderContainer) {
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

// --- 5. FULL-SCREEN LOGIN LOGIC & DATABASE CONNECTION ---

// Get Modal Elements
const headerLoginBtn = document.querySelector('.login-btn'); // Main nav bar button
const megaLoginBtn = document.querySelector('.mega-login-btn'); // Button inside the dropdown
const loginModal = document.getElementById('loginModal'); // The new full-screen container
const closeLoginBtn = document.getElementById('closeModal');
const loginForm = document.getElementById('newLoginForm'); // Updated to the new form ID

// Function to open the full-screen login
function openLoginModal(e) {
    e.preventDefault();
    loginModal.style.display = 'flex'; // Uses 'flex' to keep the white column centered
}

// Attach click events to BOTH login buttons
if (headerLoginBtn) headerLoginBtn.addEventListener('click', openLoginModal);
if (megaLoginBtn) megaLoginBtn.addEventListener('click', openLoginModal);

// Close Modal (Clicking 'X')
if(closeLoginBtn && loginModal) {
    closeLoginBtn.addEventListener('click', () => {
        loginModal.style.display = 'none';
    });
}

// Handle the Login Submit (Preserved Backend Connection)
if(loginForm) {
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault(); 

        const email = document.getElementById('emailInput').value; // Matches new HTML ID
        
        // Note: The visual replica only had an email field. If your backend requires a password, 
        // ensure you have added a password input with id="passwordInput" to your HTML form!
        const passwordField = document.getElementById('passwordInput');
        const password = passwordField ? passwordField.value : ""; 
        
        const submitBtn = loginForm.querySelector('.next-btn');
        
        // UI Feedback
        submitBtn.innerText = "Checking..."; 

        try {
            // Send data to the Flask Backend
            const response = await fetch('http://127.0.0.1:5000/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email: email, password: password })
            });

            const result = await response.json();

            if (response.ok) {
                alert("Success: " + result.message); 
                loginModal.style.display = 'none'; // Close the popup on success
                loginForm.reset(); // Clear the inputs
            } else {
                alert("Error: " + result.error);
            }
        } catch (error) {
            console.error('Error:', error);
            alert("Cannot connect to the server. Is app.py running?");
        } finally {
            // Reset button text
            submitBtn.innerText = "Next"; 
        }
    });
}


// --- 6. SIGNUP MODAL & DATABASE CONNECTION ---

const signupModal = document.getElementById('signupModal');
const closeSignupModalBtn = document.getElementById('closeSignupModal');
const signupForm = document.getElementById('signupForm');
const switchToSignupLink = document.getElementById('switchToSignup'); // Link inside the login page

// Open Signup Modal from the Login Page
if(switchToSignupLink && signupModal) {
    switchToSignupLink.addEventListener('click', (e) => {
        e.preventDefault();
        loginModal.style.display = 'none'; // Close login screen
        signupModal.style.display = 'flex'; // Open signup popup
    });
}

// Close Signup Modal
if(closeSignupModalBtn && signupModal) {
    closeSignupModalBtn.addEventListener('click', () => {
        signupModal.style.display = 'none';
    });
}

// Close if clicking outside the signup modal
window.addEventListener('click', (e) => {
    if (e.target === signupModal) {
        signupModal.style.display = 'none';
    }
});

// Handle the Signup Submit
if(signupForm) {
    signupForm.addEventListener('submit', async function(e) {
        e.preventDefault(); 

        const email = document.getElementById('signupEmail').value;
        const firstName = document.getElementById('signupFirstName').value;
        const lastName = document.getElementById('signupLastName').value;
        const password = document.getElementById('signupPassword').value;
        const submitBtn = signupForm.querySelector('.modal-submit-btn');
        
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
                signupModal.style.display = 'none'; 
                signupForm.reset(); 
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