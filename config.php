<?php

// Database connection details and consultant data retrieval
        $servername = "localhost";
        $username = "refectli_TestPhp";
        $password = "TestPhp#123";
        $dbname = "refectli_testphp";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        
?>