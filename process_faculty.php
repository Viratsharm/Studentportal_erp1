<?php
session_start();
require_once 'db_connection.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $faculty_name = $_POST['faculty_name'];
    $faculty_department = $_POST['faculty_department'];
    $faculty_subject = $_POST['faculty_subject'];
    
    // Set feedback to an empty string initially (can be updated later with feedback from students)
    $feedback = "";

    // Check if the faculty member already exists
    $checkQuery = "SELECT id FROM faculies WHERE faculty_name = ? AND faculty_department = ? AND faculty_subject = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("sss", $faculty_name, $faculty_department, $faculty_subject);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "This faculty member already exists in the database.";
    } else {
        // Insert new faculty member into the database
        $insertQuery = "INSERT INTO faculies (faculty_name, faculty_department, faculty_subject, feedback) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ssss", $faculty_name, $faculty_department, $faculty_subject, $feedback);

        if ($insertStmt->execute()) {
            //echo "Faculty member added successfully!";
            header("Location: loginsuccesfully.html");
        } else {
            echo "Error: " . $insertStmt->error;
        }

        $insertStmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>
