<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suspend Access</title>
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
        form {
            background: #212136;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.6), -5px -5px 15px rgba(255, 255, 255, 0.05);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, select, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            background-color: #d9534f;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #e04544;
        }
    </style>
</head>
<body>
    <?php
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "student_system");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch students
    $sql = "SELECT id, r_id, name FROM students";
    $result = $conn->query($sql);
    ?>
    <form action="process_suspension.php" method="POST">
        <h1>Suspend Student Access</h1>
        <label for="student_id">Select Student:</label>
        <select name="student_id" id="student_id" required>
            <option value="" disabled selected>Select a student</option>
            <?php
            if ($result->num_rows > 0) {
                // Fetch each student and add to the dropdown
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['r_id'] . "'>" . $row['name'] . " (r_id: " . $row['r_id'] . ")</option>";
                }
            } else {
                echo "<option value='' disabled>No students found</option>";
            }
            ?>
        </select>

        <label for="suspension_end_date">Suspension Until:</label>
        <input type="date" name="suspension_end_date" id="suspension_end_date" required>

        <label for="suspension_reason">Reason for Suspension:</label>
        <textarea name="suspension_reason" id="suspension_reason" rows="4" placeholder="Enter the reason (optional)"></textarea>

        <button type="submit">Suspend Student</button>
    </form>
    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
