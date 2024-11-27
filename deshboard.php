<?php
session_start();
require_once 'db_connection.php'; // Include your database connection file

// Check if student is logged in
if (!isset($_SESSION['student_name'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve student data
$studentName = $_SESSION['student_name'];
$query = "SELECT profile_photo FROM students WHERE name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $studentName);
$stmt->execute();
$stmt->bind_result($profilePhoto);
$stmt->fetch();
$stmt->close();

// Set a default profile photo if none is uploaded
$profilePhoto = $profilePhoto ?: 'default_profile.png'; // Path to a default profile image if none is uploaded
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard">
        <header>
        <div class="container">
        <!-- Profile Photo and Welcome Message -->
        <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="Profile Photo" class="profile-pic">
        <h3>Welcome, <?php echo htmlspecialchars($studentName); ?></h3>
            </div>
            <nav>
                <ul>
                    <li><a href="add_faculty.html">Add Faculty</a></li>
                    <li><a href="remove_faculty.php">Remove Faculty</a></li>
                    <li><a href="give_feedback.php">Give Feedback</a></li>
                    <li><a href="complain.html">Complain</a></li>
                    <li><a href="profile.php">Your Profile</a></li>
                    <li><a href="logout.php" id="logout">Log Out</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <h1>Welcome to student feedback portal</h1>
            <p>Here you can manage your academic interactions, provide feedback, and more.</p>
            <!-- Additional dashboard components can be added here -->
        </main>
    </div>
    <script src="style.js"></script>
</body>
</html>
