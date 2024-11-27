<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $faculty_name = $_POST['faculty_name'];

    $checkQuery = "SELECT * FROM faculies WHERE faculty_name = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $faculty_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $deleteQuery = "DELETE FROM faculies WHERE faculty_name = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("s", $faculty_name);

        if ($deleteStmt->execute()) {
            $message = "Faculty has been removed successfully!";
            $status = "success";
        } else {
            $message = "Error occurred while removing the faculty.";
            $status = "error";
        }
        $deleteStmt->close();
    } else {
        $message = "Faculty name not found in the database.";
        $status = "error";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Faculty</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        /* Body Styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #1f1f1f, #292929);
            color: #f0f0f0;
            overflow: hidden;
            animation: fadeIn 1s ease-out;
        }

        /* Form Container */
        .form-container {
            background: #242424;
            padding: 40px 30px;
            border-radius: 15px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
            text-align: center;
            position: relative;
            overflow: hidden;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeIn 1.5s ease-out, slideUp 1s ease-out forwards;
        }

        .form-container h2 {
            font-size: 24px;
            color: #ffd700;
            margin-bottom: 20px;
        }

        .form-container input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            margin: 15px 0;
            font-size: 16px;
            color: #f0f0f0;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-container input[type="text"]::placeholder {
            color: #bbb;
        }

        .form-container input[type="text"]:focus {
            outline: none;
            border-color: #ffd700;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            transform: scale(1.05);
        }

        .form-container button {
            width: 100%;
            padding: 12px 15px;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            color: #242424;
            background: #ffd700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-container button:hover {
            background: #e6c200;
            transform: translateY(-2px);
        }

        .form-container button:active {
            transform: translateY(0);
        }

        /* Glow Effect */
        .glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.2), transparent);
            border-radius: 50%;
            animation: glow 5s infinite ease-in-out alternate;
            pointer-events: none;
        }

        .glow:nth-child(1) {
            top: -150px;
            left: -150px;
        }

        .glow:nth-child(2) {
            bottom: -150px;
            right: -150px;
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            0% {
                transform: translateY(20px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes glow {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1.5);
                opacity: 0.5;
            }
        }

        /* Message Styling */
        .message {
            font-size: 16px;
            padding: 12px;
            margin-top: 20px;
            border-radius: 8px;
            width: 100%;
            text-align: center;
            color: #f0f0f0;
        }

        .success { background-color: #4CAF50; }
        .error { background-color: #f44336; }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="glow"></div>
        <div class="glow"></div>
        <h2>Remove Faculty</h2>
        <form action="remove_faculty.php" method="POST">
            <input type="text" id="faculty_name" name="faculty_name" placeholder="Enter Faculty Name" required>
            <button type="submit">Remove Faculty</button>
        </form>

        <?php if (isset($message)): ?>
            <p class="message <?php echo $status; ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>
    </div>
</body>
</html>
