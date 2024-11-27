<?php
$conn = new mysqli("sql206.infinityfree.com", "if0_37798701", "210611s014333", "if0_37798701_Student_system");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complain = $_POST['complain'];

    $sql = "INSERT INTO complaints (complain_text) VALUES ('$complain')";

    if ($conn->query($sql) === TRUE) {
        echo "Complaint submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
