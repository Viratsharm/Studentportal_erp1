<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .dashboard-container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 10px;
            color: #bb86fc;
        }

        p {
            margin-bottom: 20px;
            font-size: 1.1em;
            color: #a0a0a0;
        }

        .filter-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .filter-form input[type="text"] {
            padding: 8px;
            border: none;
            border-radius: 5px;
            width: 200px;
        }

        .filter-form button {
            padding: 8px 16px;
            background-color: #bb86fc;
            color: #1e1e1e;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .filter-form button:hover {
            background-color: #a560e8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        th {
            background-color: #333;
            color: #bb86fc;
        }

        tr:hover {
            background-color: #292929;
        }

        .logout-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #bb86fc;
            color: #1e1e1e;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background-color: #a560e8;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <p>Viewing all student feedback submissions.</p>

        <!-- Filter Form -->
        <form method="GET" class="filter-form">
            <input type="text" name="student_name" placeholder="Enter Student Name" value="<?php echo isset($_GET['student_name']) ? htmlspecialchars($_GET['student_name']) : ''; ?>">
            <button type="submit">Filter</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Student R_ID</th>
                    <th>Student Name</th>
                    <th>Faculty Name</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();
                if (!isset($_SESSION['admin_logged_in'])) {
                    header("Location: admin_portal.php");
                    exit();
                }
                require_once 'db_connection.php';

                // Get the filtered student name from the GET request
                $student_name_filter = isset($_GET['student_name']) ? trim($_GET['student_name']) : '';

                // Modify the query based on the filter
                if (!empty($student_name_filter)) {
                    $query = "SELECT student_rid, student_name, faculty_name, feedback FROM feedbacks WHERE student_name LIKE ?";
                    $stmt = $conn->prepare($query);
                    $like_param = "%{$student_name_filter}%";
                    $stmt->bind_param("s", $like_param);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    $query = "SELECT student_rid, student_name, faculty_name, feedback FROM feedbacks";
                    $result = $conn->query($query);
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['student_rid']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['faculty_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['feedback']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No feedback found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <form action="adminlogout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
