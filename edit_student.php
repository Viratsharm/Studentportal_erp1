<?php
// Database connection
$host = "sql206.infinityfree.com";          // Usually 'localhost'
$username = "if0_37798701";   // Database username
$password = "210611s014333";   // Database password
$database = "if0_37798701_Student_system";   // Database name

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Update student details
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $r_id = $_POST['r_id'];
    
    // If password is entered, hash it. Otherwise, retain the old password
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $_POST['old_password'];

    $sql = "UPDATE students SET name = :name, r_id = :r_id, password = :password WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => $name, ':r_id' => $r_id, ':password' => $password, ':id' => $id]);

    
}

// Fetch students from database
$sql = "SELECT * FROM students";
$stmt = $pdo->query($sql);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Premium CSS Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #8e44ad, #3498db);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 900px;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .success-message {
            text-align: center;
            color: #27ae60;
            font-weight: bold;
            margin: 10px 0;
            padding: 10px;
            background: #e9f7ef;
            border-radius: 5px;
        }

        .search-bar {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-bar input {
            width: 80%;
            max-width: 600px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            text-align: center;
            padding: 12px;
        }

        th {
            background-color: #f8f9fa;
            color: #555;
        }

        td {
            color: #333;
        }

        .button {
            padding: 8px 15px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .button:hover {
            background-color: #2980b9;
        }

        .edit-form {
            margin-top: 20px;
        }

        .edit-form .input-group {
            margin-bottom: 15px;
        }

        .edit-form label {
            font-size: 14px;
            font-weight: 500;
        }

        .edit-form input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .edit-form button {
            margin-top: 10px;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #27ae60;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-form button:hover {
            background-color: #229954;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Student Details</h2>

        <div class="search-bar">
            <input type="text" id="search" placeholder="Search by R ID..." onkeyup="filterStudents()">
            <p class='success-message'>Student details updated successfully!</p>
        </div>

        <table id="studentTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>R ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td><?php echo htmlspecialchars($student['r_id']); ?></td>
                        <td>
                            <form action="edit_student.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                                <button type="submit" name="edit" class="button">Edit</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (isset($_POST['edit'])): ?>
            <?php
                $id = $_POST['id'];
                $sql = "SELECT * FROM students WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $id]);
                $student = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <?php if ($student): ?>
                <form class="edit-form" action="edit_student.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                    <input type="hidden" name="old_password" value="<?php echo $student['password']; ?>">
                    <div class="input-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="r_id">R ID</label>
                        <input type="text" name="r_id" id="r_id" value="<?php echo htmlspecialchars($student['r_id']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter new password (Leave blank to keep old)">
                    </div>
                    <button type="submit" name="update">Update Details</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script>
        function filterStudents() {
            const searchInput = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll('#studentTable tbody tr');

            rows.forEach(row => {
                const r_id = row.cells[1].textContent.toLowerCase();
                if (r_id.includes(searchInput)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
