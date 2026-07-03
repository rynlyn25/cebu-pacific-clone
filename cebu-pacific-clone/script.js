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
        image: "url('https://images.squarespace-cdn.com/content/v1/6507df2246905b20c408b2bc/3e789b02-0269-4dd8-aef9-f12accafab8d/website-04.jpg')"
    },
    {
        title: "DAVAO",
        image: "url('https://images.pexels.com/photos/31451558/pexels-photo-31451558.jpeg?_gl=1*v5xa37*_ga*MTQ4ODc1NjQ0MC4xNzgyOTcyNzE4*_ga_8JE65Q40S6*czE3ODI5NzI3MTckbzEkZzEkdDE3ODI5NzMxNjAkajU3JGwwJGgw')"
    },
    {
        title: "ILOILO",
        image: "url('https://media-cdn.tripadvisor.com/media/photo-c/1280x250/0f/1b/f1/8c/simply-breathtaking.jpg')"
    },
    {
        title: "KAOHSIUNG",
        image: "url('https://cdn.media.amplience.net/i/cebupacificair/KHH-Kaohsiung-DragonTigerTower-5362x3582?fmt=auto&maxW=1920&maxH=1920&w=1920&qlt=60&fmt.options=interlaced')"
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