<?php
session_start();

// Retrieve the suspension end date and reason from the session
$suspension_end_date = isset($_SESSION['suspension_end_date']) ? $_SESSION['suspension_end_date'] : null;
$suspension_reason = isset($_SESSION['suspension_reason']) ? $_SESSION['suspension_reason'] : 'No reason provided';

if (!$suspension_end_date) {
    // If there's no suspension data, redirect to login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspended</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle, #1e1e2f, #0d0d14);
            color: #f5d372;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #212136;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
            text-align: center;
            width: 100%;
            max-width: 600px;
        }

        h1 {
            font-size: 30px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .highlight {
            color: #d9534f;
            font-weight: bold;
        }

        .reason {
            background: #343a40;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 16px;
            color: #f5d372;
        }

        .contact {
            font-size: 16px;
            color: #d9534f;
            font-weight: bold;
        }

        button {
            background-color: #f5d372;
            color: #212136;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #d9534f;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Account is Suspended</h1>
        <p>Your account has been suspended until <strong class="highlight"><?php echo htmlspecialchars($suspension_end_date); ?></strong>.</p>
        
        <div class="reason">
            <h2>Reason for Suspension:</h2>
            <p><?php echo htmlspecialchars($suspension_reason); ?></p>
        </div>

        <p class="contact">Please contact the admin for further assistance.</p>
        <button onclick="window.location.href='contact_admin.php'">Contact Admin</button>
    </div>
</body>
</html>
