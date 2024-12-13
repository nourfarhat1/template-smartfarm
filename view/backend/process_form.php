<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Output the data to verify
    echo "<h2>Form Submission Successful</h2>";
    echo "<p>Name: $name</p>";
    echo "<p>Email: $email</p>";
    echo "<p>Message: $message</p>";

    // Optionally, save the form data to the database or send an email
}
?>
