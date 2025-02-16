<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

function generatePassword($length = 10) {
    return bin2hex(random_bytes($length / 2));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];

    $username = strtolower(explode(" ", $full_name)[0]) . rand(100, 999);
    $password = generatePassword();

    $query = "INSERT INTO employees (full_name, username, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $full_name, $username, $email, $password);

    if ($stmt->execute()) {
        echo "<p>Employee Registered! Username: $username, Password: $password</p>";
    } else {
        echo "<p>Error creating employee!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: darkgreen;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <h3>Create New Employee</h3>
        <form action="admin_dashboard.php" method="POST">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Create Employee</button>
        </form>
        <a href="admin_logout.php" style="display:block; margin-top:20px; color:red;">Logout</a>
    </div>
</body>
</html>
