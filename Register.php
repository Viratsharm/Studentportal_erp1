<?php
// register.php
$host = "sql206.infinityfree.com";          // Database host
$username = "if0_37798701";                 // Database username
$password = "210611s014333";                // Database password
$database = "if0_37798701_Student_system";  // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $r_id = $_POST['r_id'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash password before storing it

    // Prepare SQL query using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO students (r_id, name, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $r_id, $name, $password);  // "sss" means 3 strings

    if ($stmt->execute()) {
        header("Location: loginsuccessfully2.html");
        exit();  // Make sure to exit after redirect to avoid further script execution
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>