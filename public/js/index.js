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

document.addEventListener('DOMContentLoaded', function() {
    const advancedCheckbox = document.getElementById('advanced');
    const advancedForm = document.getElementById('advanced-form');
    const urlInput = document.querySelector('.url-input');
    const shortenButton = document.querySelector('.btn-action');

    const checkbox = document.getElementById('custom-link-checkbox');
    const lengthGroup = document.getElementById('link-length-group');
    const customGroup = document.getElementById('custom-link-group');

    const isLoggedIn = document.querySelector('.dashboard-btn') !== null;

    // Listen for changes on the advanced options checkbox
    advancedCheckbox.addEventListener('change', function() {
        if (!isLoggedIn) {
            alert('Advanced options are available for logged-in users.');
            return;
        }

        if (this.checked) {
            advancedForm.classList.add('active');
        } else {
            advancedForm.classList.remove('active');
        }
    });

    // Listen for clicks on the main shorten button
    if (shortenButton) {
        shortenButton.addEventListener('click', function(event) {
            event.preventDefault();

            if (advancedForm && advancedForm.classList.contains('active')) {
                const advancedUrlInput = document.getElementById('advanced-url-input');
                if (advancedUrlInput) {
                    advancedUrlInput.value = urlInput.value;
                }

                const advancedLinkform = document.getElementById('advanced-link-form');
                if (advancedLinkform) {
                    advancedLinkform.submit();
                }
            } else {
                console.log('Performing simple URL shortening for:', urlInput.value);
            }
        });
    }

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            lengthGroup.style.display = 'none';
            customGroup.style.display = 'block';
        } else {
            lengthGroup.style.display = 'block';
            customGroup.style.display = 'none';
        }
    });
});
