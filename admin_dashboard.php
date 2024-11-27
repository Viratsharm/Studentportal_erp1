<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Student Portal</title>
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
            height: 100vh;
            background: radial-gradient(circle, #1e1e2f, #0d0d14);
            color: #f5d372; /* Gold highlight */
        }

        /* Sidebar */
        .sidebar {
            width: 300px;
            background: linear-gradient(145deg, #212136, #181824);
            color: #f5d372;
            display: flex;
            flex-direction: column;
            padding: 30px 15px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.7), -5px -5px 15px rgba(255, 255, 255, 0.05);
            border-radius: 12px;
        }

        .sidebar h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #f5d372;
            text-shadow: 0 4px 10px rgba(255, 223, 90, 0.3);
        }

        .sidebar a {
            padding: 15px 20px;
            color: #f5d372;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 20px;
            display: block;
            background: linear-gradient(145deg, #29293e, #1c1c29);
            border-radius: 8px;
            box-shadow: inset 3px 3px 5px rgba(0, 0, 0, 0.4), inset -3px -3px 5px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .sidebar a:hover {
            background: linear-gradient(145deg, #f5d372, #e0b965);
            color: #111;
            transform: translateX(10px);
            box-shadow: 3px 3px 10px rgba(245, 211, 114, 0.5), -3px -3px 10px rgba(255, 255, 255, 0.1);
        }

        .sidebar a.logout {
            background: linear-gradient(145deg, #d9534f, #c9302c);
            margin-top: auto;
            text-align: center;
        }

        .sidebar a.logout:hover {
            background: linear-gradient(145deg, #f76c6b, #e04544);
        }

        /* Main content area */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            background: linear-gradient(145deg, #2c2c42, #1c1c29);
            border-radius: 20px;
            margin: 20px;
            box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.6), -10px -10px 30px rgba(255, 255, 255, 0.05);
        }

        .main-content h1 {
            font-size: 40px;
            font-weight: 700;
            color: #f5d372;
            margin-bottom: 30px;
            text-shadow: 0 5px 15px rgba(255, 223, 90, 0.3);
        }

        .welcome-message {
            background: linear-gradient(145deg, #242434, #1b1b28);
            padding: 20px 30px;
            border-radius: 16px;
            box-shadow: 8px 8px 20px rgba(0, 0, 0, 0.6), -8px -8px 20px rgba(255, 255, 255, 0.05);
            margin-bottom: 40px;
        }

        .welcome-message h2 {
            font-size: 28px;
            color: #f5d372;
            margin-bottom: 15px;
        }

        .welcome-message p {
            font-size: 16px;
            color: #dcdcdc;
            line-height: 1.6;
        }

        .option-guide {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .option {
            background: linear-gradient(145deg, #2b2b3f, #1f1f2c);
            flex: 1;
            min-width: 240px;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 8px 8px 20px rgba(0, 0, 0, 0.6), -8px -8px 20px rgba(255, 255, 255, 0.05);
            text-align: center;
            transition: all 0.4s ease;
        }

        .option:hover {
            background: linear-gradient(145deg, #f5d372, #e0b965);
            color: #111;
            transform: scale(1.1) translateY(-5px);
            box-shadow: 10px 10px 30px rgba(245, 211, 114, 0.5), -10px -10px 30px rgba(255, 255, 255, 0.1);
        }

        .option h3 {
            font-size: 22px;
            color: #f5d372;
            margin-bottom: 10px;
            text-shadow: 0 5px 10px rgba(255, 223, 90, 0.3);
        }

        .option p {
            font-size: 14px;
            color: #dcdcdc;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                flex-direction: row;
                padding: 15px;
            }

            .sidebar h2 {
                display: none;
            }

            .main-content {
                margin: 10px;
                padding: 20px;
            }

            .option {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="#student-details">Student Details</a>
        <a href="studentadminfeedback.php">Students Feedback</a>
        <a href="edit_student.php">Edit Student Details</a>
        <a href="suspendaccess.php">Suspend Access</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1>Welcome, Admin</h1>

        <div class="welcome-message">
            <h2>Welcome to the Student Portal</h2>
            <p>This is your dashboard, where you can manage student details, review student feedback, and edit student information as needed. Use the options in the sidebar to navigate between different sections. Each section serves a specific purpose, detailed below:</p>
        </div>

        <div class="option-guide">
            <div class="option" id="student-details">
                <h3>Student Details</h3>
                <p>View and access a complete list of students enrolled in the system, along with their academic and personal details. This section helps you monitor and keep track of all student records.</p>
            </div>
            
            <div class="option" id="students-feedback">
                <h3>Students Feedback</h3>
                <p>Review feedback submitted by students about their academic experience. Use this section to gain insights into student satisfaction and address any issues they report.</p>
            </div>

            <div class="option" id="edit-student-details">
                <h3>Edit Student Details</h3>
                <p>Update student information when necessary. This section allows you to make corrections to students' data to ensure accuracy across the portal.</p>
            </div>
            
            <div class="option" id="Suspend Access">
                <h3>Suspend Access</h3>
                <p>Update student information when necessary. This section allows you to make corrections to students' data to ensure accuracy across the portal.</p>
            </div>

            <div class="option">
                <h3>Logout</h3>
                <p>Use this option to securely log out of the admin dashboard once you are done managing the portal.</p>
            </div>
        </div>
    </div>


</body>
</html>
