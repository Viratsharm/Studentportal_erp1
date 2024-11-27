<?php
// login.php
session_start();

$host = "sql206.infinityfree.com";          // Usually 'localhost'
$username = "if0_37798701";   // Database username
$password = "210611s014333";   // Database password
$database = "if0_37798701_Student_system";   // Database name
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_success = false;
$user_key = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $r_id = $_POST['r_id'];
    $password = $_POST['password'];

    // Query to fetch student details, including suspension information
    $sql = "SELECT * FROM students WHERE r_id = '$r_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the student is suspended
        if ($row['suspension_end_date'] && strtotime($row['suspension_end_date']) >= strtotime(date('Y-m-d'))) {
            // If suspended, redirect with a message
            $_SESSION['suspension_end_date'] = $row['suspension_end_date'];
            header("Location: suspended.php");
            exit();
        }

        // Validate password
        if (password_verify($password, $row['password'])) {
            $_SESSION['student_name'] = $row['name']; // Store the student's name
            $_SESSION['is_logged_in'] = true; // Store the login status
            
            // Generate a unique key for the user
            $user_key = bin2hex(random_bytes(16));
            $_SESSION['user_key'] = $user_key;
            
            $login_success = true;
        } else {
            header("Location: error.html"); // Redirect on invalid password
            exit();
        }
    } else {
        header("Location: error.html"); // Redirect if no user found
        exit();
    }
}

$conn->close();

if ($login_success) {
    // Instead of redirecting immediately, we'll render some JavaScript
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Logging in...</title>
    </head>
    <body>
        <script>
            // Set the key in local storage
            localStorage.setItem('user_key', '<?php echo $user_key; ?>');
            // Redirect to dashboard
            window.location.href = 'deshboard.php';
        </script>
    </body>
    </html>
    <?php
    exit();
}
?>
