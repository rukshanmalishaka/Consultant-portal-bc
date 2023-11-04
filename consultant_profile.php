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
$sql = "SELECT first_name, last_name, date_of_birth, email, phone_number, marital_status, permanent_address, current_address, are_you_currently_employed, areas_of_expertise, preferred_mode_of_payment, nic FROM consultant_registration WHERE email='$loggedinConsultantEmail'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row['first_name'];
    $lastName = $row['last_name'];
    $dateOfBirth = $row['date_of_birth'];
    $email = $row['email'];
    $phoneNumber = $row['phone_number'];
    $maritalStatus = $row['marital_status'];
    $permanentAddress = $row['permanent_address'];
    $currentAddress = $row['current_address'];
    $currentlyEmployed = $row['are_you_currently_employed'];
    $areasOfExpertise = $row['areas_of_expertise'];
    $preferredModeOfPayment = $row['preferred_mode_of_payment'];
    $nic = $row['nic'];
    
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get updated form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $dateOfBirth = $_POST['date_of_birth'];
    $phoneNumber = $_POST['phone_number'];
    $maritalStatus = $_POST['marital_status'];
    $permanentAddress = $_POST['permanent_address'];
    $currentAddress = $_POST['current_address'];
    $currentlyEmployed = $_POST['currently_employed'];
    $areasOfExpertise = $_POST['areas_of_expertise'];
    $preferredModeOfPayment = $_POST['preferred_mode_of_payment'];

    // Update the database with the new data
    require_once 'config.php';
    $updateSql = "UPDATE consultant_registration SET first_name='$firstName', last_name='$lastName', date_of_birth='$dateOfBirth', phone_number='$phoneNumber', marital_status='$maritalStatus', permanent_address='$permanentAddress', current_address='$currentAddress', are_you_currently_employed='$currentlyEmployed', areas_of_expertise='$areasOfExpertise', preferred_mode_of_payment='$preferredModeOfPayment' WHERE email='$loggedinConsultantEmail'";

    if ($conn->query($updateSql) === TRUE) {
        $success = "Profile updated successfully.";
    } else {
        $error = "Error updating profile: " . $conn->error;
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
                    
                        <h4 class="page-title">Consultant Personal Profile</h4>
                        <ol class="breadcrumb">
                            <li>
                                <a href="index.php">Dashboard</a>
                            </li>
                            <li>
                                <a href="consultant_profile.php">Profile</a>
                            </li>
                            <li class="active">
                                Profile Information
                            </li>
                        </ol>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-sm-9">
                        <div class="card-box table-responsive">

                            <h4 class="m-t-0 header-title"><b>View or Update Profile Information</b></h4><br>
                           
                               <form method="post" action="consultant_profile.php" enctype="multipart/form-data">
                                   
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $firstName; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $lastName; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="nic">NIC (Can't Change)</label>
                                            <input type="text" class="form-control" name="nic" id="nic" value="<?php echo $nic; ?>" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="date_of_birth">Date of Birth</label>
                                            <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="<?php echo $dateOfBirth; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email">Email (Can't Change)</label>
                                            <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="tel" class="form-control" name="phone_number" id="phone_number" value="<?php echo $phoneNumber; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="marital_status">Marital Status</label>
                                            <select class="form-control" name="marital_status" id="marital_status" required>
                                                <option value="single" <?php if ($maritalStatus === 'single') echo 'selected'; ?>>Single</option>
                                                <option value="married" <?php if ($maritalStatus === 'married') echo 'selected'; ?>>Married</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="permanent_address">Permanent Address</label>
                                            <input type="text" class="form-control" name="permanent_address" id="permanent_address" value="<?php echo $permanentAddress; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="current_address">Current Address</label>
                                            <input type="text" class="form-control" name="current_address" id="current_address" value="<?php echo $currentAddress; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="currently_employed">Currently Employed</label>
                                            <select class="form-control" name="currently_employed" id="currently_employed" required>
                                                <option value="yes" <?php if ($currentlyEmployed === 'yes') echo 'selected'; ?>>Yes</option>
                                                <option value="no" <?php if ($currentlyEmployed === 'no') echo 'selected'; ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="areas_of_expertise">Areas of Expertise</label>
                                            <input type="text" class="form-control" name="areas_of_expertise" id="areas_of_expertise" value="<?php echo $areasOfExpertise; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="preferred_mode_of_payment">Preferred Mode of Payment</label>
                                            <input type="text" class="form-control" name="preferred_mode_of_payment" id="preferred_mode_of_payment" value="<?php echo $preferredModeOfPayment; ?>" required>
                                        </div>
                                    </div>
                                    
                                    
                                
                                    <div class="form-group text-right m-b-0">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit" name="submit">
                                            Update Your Profile
                                        </button>
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
