<?php
// Include the database configuration file
require_once 'db.php';

// If the form is submitted
if (isset($_POST['submit'])) {
    // Get editor content
    $clientName = $_POST['client_name'];
    $clientNIC = $_POST['nic'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $editorContent = $_POST['issues'];
    $editorContent2 = $_POST['requirments'];
    $editorContent3 = $_POST['recommendation_action'];
    $editorContent4 = $_POST['notes_to_admin'];

    // Check whether the editor content is empty

    // Retrieve consultant information based on the logged-in email
    session_start();

    if (!isset($_SESSION['consultant_id'])) {
        // If the consultant is not logged in, handle this scenario accordingly
        $consultantName = "Unknown Consultant";
    } else {
        $loggedinConsultantEmail = $_SESSION['consultant_id'];

        require_once 'config.php';

        $sql = "SELECT first_name, last_name FROM consultant_registration WHERE email='$loggedinConsultantEmail'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $consultant = $result->fetch_assoc();
            $consultantFirstName = $consultant['first_name'];
            $consultantLastName = $consultant['last_name'];
            $consultantName = $consultantFirstName . ' ' . $consultantLastName;
        } else {
            // Consultant not found in the database; handle this scenario accordingly
            $consultantName = "Unknown Consultant";
        }

        $conn->close();
    }

    // Insert editor content in the database along with consultant name
    $insert = $db->query("INSERT INTO editor (consultant_name, client_name, client_nic, email, phone_number, issues, requirments,recommendation_action, notes_to_admin,created) VALUES ('".$consultantName."', '".$clientName."','".$clientNIC."','".$email."','".$phoneNumber."','".$editorContent."','".$editorContent2."','".$editorContent3."','".$editorContent4."', NOW())");

    // Check if the insert was successful
    if ($insert) {
        // Set a success message
        $successMessage = "Session Data inserted successfully!";
        // Redirect to consult_session.php with the success message
        header("Location: consult_session.php?success=" . urlencode($successMessage));
        exit(); // Make sure to stop the script execution after redirecting
    } else {
        // If the insert failed, handle this scenario accordingly
        // You can set an error message and handle it on consult_session.php if needed
    }
}
?>
