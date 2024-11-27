<?php
// login.php
session_start();

$host = "sql206.infinityfree.com"; // Database host
$username = "if0_37798701";        // Database username
$password = "210611s014333";       // Database password
$database = "if0_37798701_Student_system"; // Database name

// Establishing database connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_success = false;
$user_key = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $r_id = $_POST['r_id'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM students WHERE r_id = ?");
    $stmt->bind_param("s", $r_id); // 's' denotes a string parameter
    $stmt->execute();
    $result = $stmt->get_result();

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
            // Redirect on invalid password
            header("Location: error.html");
            exit();
        }
    } else {
        // Redirect if no user found
        header("Location: error.html");
        exit();
    }

    $stmt->close(); // Close prepared statement
}

$conn->close(); // Close database connection

if ($login_success) {
    // Instead of redirecting immediately, render JavaScript to handle redirection and local storage
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Logging in...</title>
    </head>
    <body>
        <script>
            // Set the user key in local storage
            localStorage.setItem('user_key', '<?php echo $user_key; ?>');
            // Redirect to the dashboard page
            window.location.href = 'dashboard.php'; // Corrected the typo in "deshboard.php"
        </script>
    </body>
    </html>
    <?php
    exit();
}
?>
