document.addEventListener('DOMContentLoaded', () => {

    const navItems = document.querySelectorAll('.nav-item');
    const sections = document.querySelectorAll('.payment-section');

    // --- 1. Scroll-Spy Logic for Active Highlight ---
    window.addEventListener('scroll', () => {
        let currentSectionId = "";
        const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

        // Check if user has scrolled close to or past the bottom of the page
        if ((window.innerHeight + scrollPosition) >= document.documentElement.scrollHeight - 60) {
            currentSectionId = sections[sections.length - 1].getAttribute('id');
        } else {
            sections.forEach(section => {
                const sectionTop = section.getBoundingClientRect().top + scrollPosition;
                if (scrollPosition >= sectionTop - 150) {
                    currentSectionId = section.getAttribute('id');
                }
            });
        }

        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href').substring(1) === currentSectionId) {
                item.classList.add('active');
            }
        });
    });

    // --- 2. Interactive Accordions ---
    const accordionHeaders = document.querySelectorAll('.accordion-header');

    accordionHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const item = header.parentElement;
            const content = header.nextElementSibling;
            const isOpen = item.classList.contains('open');

            document.querySelectorAll('.accordion-item').forEach(i => {
                i.classList.remove('open');
                i.querySelector('.accordion-content').style.maxHeight = null;
            });

            if (!isOpen) {
                item.classList.add('open');
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    });
});