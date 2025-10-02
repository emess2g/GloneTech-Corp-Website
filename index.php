<?php
session_start();

// Function to generate a CSRF token
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Check for POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // CSRF Token Validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // CSRF token is invalid, log and fail
        error_log('CSRF token mismatch.');
        echo "Error: Invalid request.";
        exit;
    }

    // Input Validation
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
        echo "Error: All fields are required.";
        exit;
    }

    // Input Sanitization to prevent XSS and injection attacks
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Further validation (e.g., email format)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email format.";
        exit;
    }

    // Build the email content
    $to = "your-email@example.com"; // Change to your company email
    $headers = "From: " . $name . " <" . $email . ">";
    $email_body = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";

    // Send the email
    if (mail($to, $subject, $email_body, $headers)) {
        echo "Success: Your message has been sent.";
    } else {
        echo "Error: There was a problem sending your message. Please try again later.";
    }

} else {
    // If not a POST request, redirect or show an error
    echo "Error: Invalid request method.";
}

// Regenerate CSRF token for the next request
generateCsrfToken();
?>