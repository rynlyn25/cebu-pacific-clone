// Function to handle tab switching logic
function setupTabs(tabContainerSelector) {
    // 1. Find all buttons inside the specific tab group
    const tabs = document.querySelectorAll(`${tabContainerSelector} button`);

    // 2. Loop through each button
    tabs.forEach(tab => {
        // 3. Listen for a 'click' event on the button
        tab.addEventListener('click', () => {
            
            // Step A: Remove the 'active' class from ALL buttons in this group
            tabs.forEach(t => t.classList.remove('active'));
            
            // Step B: Add the 'active' class ONLY to the button that was just clicked
            tab.classList.add('active');
        });
    });
}

// 4. Initialize the function for the Booking Widget Tabs (Flights, Hotels, etc.)
setupTabs('.widget-tabs');

// 5. Initialize the function for the Flight Deals Tabs (Manila, Cebu, etc.)
setupTabs('.deal-tabs');

// --- HERO BACKGROUND SLIDER LOGIC (AUTOMATIC + MANUAL) ---
const destinations = [
    {
        title: "SIARGAO",
        image: "url('images/siargao.webp')"
    },
    {
        title: "DAVAO",
        image: "url('images/davao.jpg')"
    },
    {
        title: "ILOILO",
        image: "url('images/iloilo1.webp')"
    },
    {
        title: "KAOHSIUNG",
        image: "url('images/KAOHSIUNG.webp')"
    }
];

const sliderContainer = document.getElementById('slider-container');
const sliderTitle = document.getElementById('slider-title');
const dots = document.querySelectorAll('.dot');

let currentIndex = 0;
let slideTimer; // Variable to hold our countdown timer

// 1. Function to update the screen
function updateSlide(index) {
    currentIndex = index; // Keep track of where we are
    
    // Change image and text
    sliderContainer.style.backgroundImage = destinations[currentIndex].image;
    sliderTitle.textContent = destinations[currentIndex].title;

    // Update the white dots
    dots.forEach(dot => dot.classList.remove('active'));
    dots[currentIndex].classList.add('active');
}

// 2. Function to calculate the next slide automatically
function nextSlide() {
    // Math trick: this goes 0 -> 1 -> 2 -> 3 -> back to 0
    let nextIndex = (currentIndex + 1) % destinations.length; 
    updateSlide(nextIndex);
}

// 3. Function to start (or restart) the 7-second timer
function startTimer() {
    clearInterval(slideTimer); // Stop any existing timer first
    slideTimer = setInterval(nextSlide, 7000); // Start a fresh 7-second countdown
}

// 4. Attach click listeners to the dots for MANUAL control
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        updateSlide(index); // Instantly change the picture
        startTimer();       // Restart the timer so it waits 7 full seconds before auto-changing again
    });
});

// 5. Initialize everything when the page loads
if (sliderContainer) {
    updateSlide(0); // Load Siargao first
    startTimer();   // Start the automatic clock
}

// --- 2. STICKY HEADER SCROLL LOGIC ---
const topBar = document.querySelector('.top-advisory-bar');
const header = document.querySelector('.hero-header');

window.addEventListener('scroll', () => {
    // If the user scrolls down more than 50 pixels...
    if (window.scrollY > 50) {
        topBar.classList.add('scrolled');
        header.classList.add('scrolled');
    } else {
        // If they scroll back to the very top...
        topBar.classList.remove('scrolled');
        header.classList.remove('scrolled');
    }
});
// --- SERVICE CARDS CLICK LOGIC ---
const serviceCards = document.querySelectorAll('.service-card');

serviceCards.forEach(card => {
    card.addEventListener('click', () => {
        // 1. Remove the yellow 'active' class from ALL cards first
        serviceCards.forEach(c => c.classList.remove('active'));
        
        // 2. Add the yellow 'active' class ONLY to the card you just clicked
        card.classList.add('active');
    });
});