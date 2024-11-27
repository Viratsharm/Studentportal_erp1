<?php
session_start();
require_once 'db_connection.php';

// Check if student is logged in
if (!isset($_SESSION['student_name'])) {
    header("Location: login.php");
    exit();
}

// Fetch student R_ID and name based on session data
$studentName = $_SESSION['student_name'];
$queryStudent = "SELECT r_id, name FROM students WHERE name = ?";
$stmtStudent = $conn->prepare($queryStudent);
$stmtStudent->bind_param("s", $studentName);
$stmtStudent->execute();
$stmtStudent->bind_result($studentRID, $studentName);
$stmtStudent->fetch();
$stmtStudent->close();

// Fetch faculties data for dropdowns
$queryFaculty = "SELECT DISTINCT faculty_name, faculty_department, faculty_subject FROM faculies";
$resultFaculty = $conn->query($queryFaculty);
$faculties = [];
$departments = [];
$subjects = [];

while ($row = $resultFaculty->fetch_assoc()) {
    $faculties[] = $row['faculty_name'];
    $departments[] = $row['faculty_department'];
    $subjects[] = $row['faculty_subject'];
}
$resultFaculty->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Quicksand', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1d35517, #2a9d8f);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            perspective: 1200px;
            overflow: hidden;
        }

        .form-container {
            background: linear-gradient(135deg, #264653, #457b9d);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            width: 450px;
            padding: 40px;
            color: #ffffff;
            transform: rotateY(0);
            animation: enterForm 1.5s ease forwards;
        }

        /* 3D Animation */
        @keyframes enterForm {
            0% {
                transform: rotateY(90deg);
                opacity: 0;
            }
            100% {
                transform: rotateY(0);
                opacity: 1;
            }
        }

        h2 {
            font-size: 28px;
            font-family: 'Playfair Display', serif;
            color: #e9c46a;
            text-align: center;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
            transform: translateX(-100px);
            opacity: 0;
            animation: slideIn 0.6s ease-out forwards;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.4s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.6s;
        }

        .form-group:nth-child(5) {
            animation-delay: 0.8s;
        }

        .form-group:nth-child(6) {
            animation-delay: 1s;
        }

        /* Slide In Animation */
        @keyframes slideIn {
            0% {
                transform: translateX(-100px);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        label {
            font-weight: 600;
            color: #f4f4f4;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            background-color: #f4f4f4;
            color: #333;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            transform: translateZ(0);
            animation: float 3s infinite alternate ease-in-out;
        }

        /* Floating Fields Animation */
        @keyframes float {
            0% {
                transform: translateZ(0);
            }
            100% {
                transform: translateZ(15px);
            }
        }

        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            border-color: #457b9d;
            box-shadow: 0 0 8px rgba(69, 123, 157, 0.5);
        }

        textarea {
            resize: none;
            min-height: 100px;
        }

        /* Style for read-only fields */
        #student_rid,
        #student_name {
            border: none;
            background-color: #e5e5e5;
            color: #333;
            cursor: not-allowed;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #2a9d8f, #1d3557);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            animation: bounce 1s infinite alternate ease-in-out;
        }

        /* Bouncing Button Animation */
        @keyframes bounce {
            0% {
                transform: translateY(0);
            }
            100% {
                transform: translateY(-10px);
            }
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #e76f51, #f4a261);
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        .form-container .info {
            font-size: 14px;
            color: #ffffff;
            text-align: center;
            margin-top: 15px;
            opacity: 0;
            animation: fadeInInfo 1s ease-out 1.5s forwards;
        }

        @keyframes fadeInInfo {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Profile Picture Placeholder Animation */
        .profile-pic {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            animation: pulse 2s infinite alternate ease-in-out;
        }

        .profile-pic img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ddd;
        }

        .default-pic {
            width: 90px;
            height: 90px;
            background-color: #457b9d;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-size: 38px;
            color: white;
            font-weight: bold;
        }

        /* Pulse Animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.1);
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Provide Your Feedback</h2>
        <form action="process_feedback.php" method="post">
            <div class="form-group">
                <label for="student_rid">R_ID</label>
                <input type="text" name="student_rid" id="student_rid" value="<?php echo htmlspecialchars($studentRID); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="student_name">Name</label>
                <input type="text" name="student_name" id="student_name" value="<?php echo htmlspecialchars($studentName); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="faculty_name">Faculty Name</label>
                <select name="faculty_name" id="faculty_name" required>
                    <option value="" disabled selected>Select Faculty</option>
                    <?php foreach (array_unique($faculties) as $faculty): ?>
                        <option value="<?php echo htmlspecialchars($faculty); ?>"><?php echo htmlspecialchars($faculty); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="faculty_department">Department</label>
                <select name="faculty_department" id="faculty_department" required>
                    <option value="" disabled selected>Select Department</option>
                    <?php foreach (array_unique($departments) as $department): ?>
                        <option value="<?php echo htmlspecialchars($department); ?>"><?php echo htmlspecialchars($department); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="faculty_subject">Subject</label>
                <select name="faculty_subject" id="faculty_subject" required>
                    <option value="" disabled selected>Select Subject</option>
                    <?php foreach (array_unique($subjects) as $subject): ?>
                        <option value="<?php echo htmlspecialchars($subject); ?>"><?php echo htmlspecialchars($subject); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="feedback">Feedback</label>
                <textarea name="feedback" id="feedback" placeholder="Write your feedback here..." required></textarea>
            </div>

            <button type="submit" class="submit-btn">Submit Feedback</button>
        </form>

        <p class="info">Your feedback helps us improve! Thank you.</p>
    </div>
</body>

</html>
