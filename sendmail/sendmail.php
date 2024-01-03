<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $name = $data['name'];
    $email = $data['email'];
    $message = $data['message'];
    $user_email = $data['user_email'];

    // Read user email template from file
    $userTemplate = file_get_contents('user_template.html');

    // Replace placeholders with actual data
    $userTemplate = str_replace('[USER_NAME]', $name, $userTemplate);
    $userTemplate = str_replace('[USER_EMAIL]', $email, $userTemplate);
    $userTemplate = str_replace('[USER_MESSAGE]', $message, $userTemplate);

    $userSubject = 'Thanks for Contacting Us!';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: manish.sagar@vitrelabs.com' . "\r\n"; // Replace with your admin's email address

    $userSuccess = mail($email, $userSubject, $userTemplate, $headers);

    // Send email to admin
    $adminEmail = 'manish.sagar@vitrelabs.com'; // Replace with your admin's email address
    $adminSubject = 'New Contact Form Submission';
    $adminMessageBody = "User informations: \nName: $name\nEmail: $email\nMessage: $message";

    $adminSuccess = mail($adminEmail, $adminSubject, $adminMessageBody);

    if ($userSuccess && $adminSuccess) {
        echo json_encode(['message' => 'Emails sent successfully!']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to send emails.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
