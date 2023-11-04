<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "refectli_TestPhp";
$dbPassword = "TestPhp#123";
$dbName     = "refectli_testphp";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}