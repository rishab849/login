<?php
require 'send_mail.php';
require 'db_connect.php'; // Database connection

function generatePassword($length = 10) {
    return bin2hex(random_bytes($length / 2));
}

function createEmployee($full_name, $email) {
    global $conn;

    $username = strtolower(explode(" ", $full_name)[0]) . rand(100, 999);
    $password = generatePassword(); // No hashing
    // $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Removed hashing

    $query = "INSERT INTO employees (full_name, username, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $full_name, $username, $email, $password); // Storing password as plaintext

    if ($stmt->execute()) {
        sendCredentials($email, $username, $password);
        return true;
    } else {
        return false;
    }
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];

    if (createEmployee($full_name, $email)) {
        echo "Employee registered successfully!";
    } else {
        echo "Error registering employee.";
    }
}
?>
