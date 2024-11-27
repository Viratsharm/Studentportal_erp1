<?php
session_start();
require_once 'db_connection.php'; // Include your database connection file

// Check if student is logged in
if (!isset($_SESSION['student_name'])) {
    header("Location: login.html");
    exit();
}

// Fetch student data
$studentName = $_SESSION['student_name'];
$query = "SELECT r_id, profile_photo FROM students WHERE name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $studentName);
$stmt->execute();
$stmt->bind_result($rid, $profilePhoto);
$stmt->fetch();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        // Handle profile photo upload
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = basename($_FILES['profile_photo']['name']);
            $uploadFile = $uploadDir . uniqid() . '_' . $fileName;
            $fileType = mime_content_type($_FILES['profile_photo']['tmp_name']);

            if (strpos($fileType, 'image') === 0 && move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadFile)) {
                $profilePhoto = $uploadFile;
            } else {
                $message = "Error: Only image files are allowed.";
            }
        }

        $updateQuery = "UPDATE students SET profile_photo = ? WHERE name = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ss", $profilePhoto, $studentName);

        if ($updateStmt->execute()) {
            $message = "Profile updated successfully!";
        } else {
            $message = "Error updating profile: " . $updateStmt->error;
        }

        $updateStmt->close();
    } elseif (isset($_POST['remove_photo']) && $profilePhoto) {
        // Remove profile photo
        if (file_exists($profilePhoto)) unlink($profilePhoto);

        $profilePhoto = null;
        $removeQuery = "UPDATE students SET profile_photo = NULL WHERE name = ?";
        $removeStmt = $conn->prepare($removeQuery);
        $removeStmt->bind_param("s", $studentName);
        $removeStmt->execute();
        $removeStmt->close();

        $message = "Profile photo removed successfully.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #0d1b2a;
            color: #ffffff;
        }

        .container {
            background: #1b263b;
            padding: 30px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            font-size: 14px;
            color: #a9d6e5;
            display: block;
        }

        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            background-color: #243b55;
            color: #ffffff;
        }

        input[readonly] {
            background-color: #1b263b;
            border-color: #415a77;
        }

        .button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: none;
            border-radius: 5px;
            background: #00a676;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .button:hover {
            background: #008f5a;
        }

        .button.remove {
            background: #d9534f;
        }

        .button.remove:hover {
            background: #c9302c;
        }

        .button.back {
            background: #006494;
        }

        .button.back:hover {
            background: #004d73;
        }

        .message {
            font-size: 14px;
            color: #ffffff;
            margin-top: 15px;
            padding: 10px;
            background-color: #a9d6e5;
            border-radius: 5px;
            color: #0d1b2a;
        }

        .profile-photo {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 15px;
            border: 2px solid #415a77;
        }

        .upload-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>

        <?php if ($profilePhoto): ?>
            <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="Profile Photo" class="profile-photo">
        <?php else: ?>
            <p>No profile photo uploaded.</p>
        <?php endif; ?>

        <?php if (isset($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label for="student_name">Username</label>
                <input type="text" name="student_name" id="student_name" value="<?php echo htmlspecialchars($studentName); ?>" readonly>
            </div>
            <div class="input-group">
                <label for="rid">R ID</label>
                <input type="text" name="rid" id="rid" value="<?php echo htmlspecialchars($rid); ?>" readonly>
            </div>
            <div class="input-group upload-section">
                <label for="profile_photo">Profile Photo</label>
                <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
            </div>
            <button type="submit" name="update" class="button">Update Profile</button>
            <?php if ($profilePhoto): ?>
                <button type="submit" name="remove_photo" class="button remove">Remove Profile Photo</button>
            <?php endif; ?>
        </form>

        <button onclick="history.back()" class="button back" style="margin-top: 15px;">Go Back</button>
    </div>
</body>
</html>
