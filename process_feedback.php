<?php
session_start();
require_once 'db_connection.php'; // Include your database connection file

// Check if student is logged in
if (!isset($_SESSION['student_name'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Capture form data
$studentRID = $_POST['student_rid'];
$studentName = $_POST['student_name'];
$facultyName = $_POST['faculty_name'];
$facultyDepartment = $_POST['faculty_department'];
$facultySubject = $_POST['faculty_subject'];
$feedback = $_POST['feedback'];

// Prepare and execute insert query to save feedback
$query = "INSERT INTO feedbacks (student_rid, student_name, faculty_name, faculty_department, faculty_subject, feedback) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssss", $studentRID, $studentName, $facultyName, $facultyDepartment, $facultySubject, $feedback);

if ($stmt->execute()) {
    //echo "Feedback submitted successfully!";
    header("Location: successfully_index.html");
} else {
    echo "Error: Could not submit feedback.";
}

$stmt->close();
$conn->close();
?>
