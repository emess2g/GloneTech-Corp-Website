document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactForm');
    const emailField = document.getElementById('email');
    const messageField = document.getElementById('message');
    const formMessage = document.getElementById('formMessage');

    form.addEventListener('submit', function(event) {
        let valid = true;
        formMessage.textContent = ''; // Clear previous messages

        // Basic check for required fields (already handled by 'required' attribute, but good for custom messages)
        if (!form.checkValidity()) {
            valid = false;
        }

        // Custom email format check
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value)) {
            formMessage.textContent = 'Please enter a valid email address.';
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); // Stop form submission
        }
    });
});