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

// --- 5. LOGIN MODAL & DATABASE CONNECTION LOGIC ---

// Get Modal Elements
const navLoginBtn = document.querySelector('.login-btn'); // The nav bar button
const loginModal = document.getElementById('loginModal');
const closeModalBtn = document.getElementById('closeModal');
const loginForm = document.getElementById('loginForm');

// Open Modal
if(navLoginBtn && loginModal) {
    navLoginBtn.addEventListener('click', (e) => {
        e.preventDefault();
        loginModal.style.display = 'flex';
    });
}

// Close Modal (Clicking 'X')
if(closeModalBtn && loginModal) {
    closeModalBtn.addEventListener('click', () => {
        loginModal.style.display = 'none';
    });
}

// Close Modal (Clicking outside the white box)
window.addEventListener('click', (e) => {
    if (e.target === loginModal) {
        loginModal.style.display = 'none';
    }
});

// Handle the Login Submit
if(loginForm) {
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault(); 

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const submitBtn = document.querySelector('.modal-submit-btn');
        
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
            submitBtn.innerText = "Login"; 
        }
    });
}
// --- SIGNUP MODAL & DATABASE CONNECTION ---

const navSignupBtn = document.querySelector('.signup-btn'); // Make sure this matches your nav button class
const signupModal = document.getElementById('signupModal');
const closeSignupModalBtn = document.getElementById('closeSignupModal');
const signupForm = document.getElementById('signupForm');

// Open Signup Modal
if(navSignupBtn && signupModal) {
    navSignupBtn.addEventListener('click', (e) => {
        e.preventDefault();
        signupModal.style.display = 'flex';
    });
}

// Close Signup Modal
if(closeSignupModalBtn && signupModal) {
    closeSignupModalBtn.addEventListener('click', () => {
        signupModal.style.display = 'none';
    });
}

// Close if clicking outside
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
