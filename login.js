const loginForm = document.getElementById('login');
const loginClose = document.getElementById('login-close');
const userIcon = document.querySelector('#navbar li a[href="#login"]');

// Show the login form with sliding effect
userIcon.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default link behavior
    loginForm.classList.add('active'); // Add the active class to slide in
});

// Hide the login form with sliding effect
loginClose.addEventListener('click', function() {
    loginForm.classList.remove('active'); // Remove the active class to slide out
});

