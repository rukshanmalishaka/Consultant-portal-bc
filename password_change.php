<?php
// Include the database configuration file
require_once 'db.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['consultant_id'])) {
    // Redirect to login page or show an error message
    header("Location: consultant_login.php");
    exit();
}

// Retrieve the logged-in consultant's email
$loggedinConsultantEmail = $_SESSION['consultant_id'];

require_once 'config.php';

// Fetch the form data for the logged-in consultant
$sql = "SELECT password FROM consultant_registration WHERE email='$loggedinConsultantEmail'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
  
    $password = $row['password'];
    
}

if (isset($_POST['submit'])) {
    // Get updated form data
    $password = $_POST['password'];
    $confirm_password = $_POST["confirm_password"];
    
    if ($password === $confirm_password) {
        if (strlen($password) < 6 ||
            !preg_match("/[A-Z]/", $password) ||
            !preg_match("/[a-z]/", $password) ||
            !preg_match("/[0-9]/", $password)
        ) {
            $vsm = "Password must be at least 6 characters long and contain uppercase, lowercase, and digits.";
        } else {
            // Hash the password using password_hash
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Update the database with the new data
            require_once 'config.php';
            $updateSql = "UPDATE consultant_registration SET password='$hashed_password' WHERE email='$loggedinConsultantEmail'";

            if ($conn->query($updateSql) === TRUE) {
                $successMsg = "Password updated successfully.";
            } else {
                $errorMsg = "Error updating Password: " . $conn->error;
            }
        }
    } else {
        // Passwords don't match, display an error message
        $pw = "Passwords do not match. Please try again.";
    }

    // Close the connection
    $conn->close();
}

// Get Consultant Name
    $sqlName = "SELECT first_name,last_name FROM consultant_registration WHERE email='$loggedinConsultantEmail'";
    $resultName = $conn->query($sqlName);
    $consultant = $resultName->fetch_assoc();

?>

<?php include "inc/header.php" ?>

<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

     <?php include "inc/topbar.php" ?>

          <?php include "inc/layout.php" ?> 
          
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                    
                        <h4 class="page-title">Change your Password</h4>
                        <ol class="breadcrumb">
                            <li>
                                <a href="index.php">Dashboard</a>
                            </li>
                            <li>
                                <a href="consultant_profile.php">Profile</a>
                            </li>
                            <li class="active">
                                Change Password
                            </li>
                        </ol>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card-box table-responsive">

                            <h4 class="m-t-0 header-title"><b>Create New Password</b></h4><br>
                           
                               <form method="post" action="" enctype="multipart/form-data">
   
                                    <div>
                                        <div class="form-group">
                                            <label for="password">New Password:</label>
                                            <input type="password" class="form-control" name="password" id="password" required><br>
                                    
                                            <label for="confirm_password">Confirm New Password:</label>
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required><br>
                                            
                                            
                                            <button class="btn btn-primary waves-effect waves-light" type="submit" name="submit">
                                                    Update Password
                                            </button><br><br>
                                            
                                             <!-- Error message display -->
                                            
                                            <?php
                                            if (isset($pw)) {
                                                echo ' <div class="alert alert-danger"><strong>Error: </strong>'. $pw .'</div>';
                                               
                                            }
                                            
                                            if (isset($vsm)) {
                                                echo ' <div class="alert alert-danger"><strong>Error: </strong>'. $vsm .'</div>';
                                               
                                            }
                                            
                                            if (isset($errorMsg)) {
                                                echo ' <div class="alert alert-danger"><strong>Error: </strong>'. $errorMsg .'</div>';
                                               
                                            }
                                           
                                            if (isset($successMsg)) {
                                                echo ' <div class="alert alert-success"><strong>Well done! </strong>'. $successMsg .'</div>';
                                               
                                            }
                                           
                                            
                                            ?>
                             
                                        </div>
                                    </div>
                                    


                                    <div class="form-group text-right m-b-0">
                                        
                                    </div>
                                </form>

                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
      <?php include "inc/footer.php" ?>
</body>
</html>
