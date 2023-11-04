<?php
session_start();

if (!isset($_SESSION['consultant_id'])) {
    // If the consultant is not logged in, redirect to the login page
    header("Location: consultant_login.php");
    exit;
}

// Retrieve consultant information based on the logged-in email
$loggedinConsultantEmail = $_SESSION['consultant_id'];

// Database connection details and consultant data retrieval (Same as before)
 $servername = "localhost";
    $username = "refectli_TestPhp";
    $password = "TestPhp#123";
    $dbname = "refectli_testphp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM consultant_registration WHERE email='$loggedinConsultantEmail'";
$result = $conn->query($sql);
$consultant = $result->fetch_assoc();

$conn->close();
?>