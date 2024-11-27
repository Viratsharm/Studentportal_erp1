<?php
session_start();

// Connect to the database
$conn = new mysqli("sql206.infinityfree.com", "if0_37798701", "210611s014333", "if0_37798701_Student_system");


// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch data from the form
    $student_id = $_POST['student_id'];  // This is the student's ID (r_id)
    $suspension_end_date = $_POST['suspension_end_date'];
    $suspension_reason = $_POST['suspension_reason'] ?? 'No reason provided';  // Default if reason is empty

    // Update the database with suspension details
    $stmt = $conn->prepare("UPDATE students SET suspension_end_date = ?, suspension_reason = ? WHERE r_id = ?");
    $stmt->bind_param("sss", $suspension_end_date, $suspension_reason, $student_id);

    if ($stmt->execute()) {
        // Store the suspension data in session to display on the suspended page
        $_SESSION['suspension_end_date'] = $suspension_end_date;
        $_SESSION['suspension_reason'] = $suspension_reason;

        // Redirect to suspended account page
        header("Location: succsuspend.html");
        exit();
    } else {
        echo "Error updating suspension: " . $stmt->error;  // Debugging message
    }

    // Close the statement and connection
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
