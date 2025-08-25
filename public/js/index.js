document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    const navItems = document.querySelectorAll('.nav-links a'); // Select all nav links
    const loginButton = document.querySelector('#login-btn');

    if (loginButton) {
        loginButton.addEventListener('click', function() {
            window.location.href = '/admin';
        });
    }

    if (menuToggle && navLinks && navItems) {
        // Toggle menu on hamburger icon click
        menuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });

        // Hide menu when a nav link is clicked (for mobile)
        navItems.forEach(link => {
            link.addEventListener('click', function() {
                if (navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                }
            });
        });
    }
});
