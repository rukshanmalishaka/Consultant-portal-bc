<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Perform validation, such as checking if the email is in a valid format (e.g., using filter_var).

    require_once 'config.php';

    // Prepare the SQL query to check if the email exists in the database
    $query = "SELECT * FROM consultant_registration WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // If the email exists in the database, proceed with the password reset logic
        $resetToken = bin2hex(random_bytes(32)); // Generate a random 32-byte token

        // Store the reset token and its expiration time in the database for the user.
        // You can execute another SQL query here to insert the token and its expiration time into the user's record.

        // Send the password reset email.
        $resetLink = "http://testphp.refectline.com/myadmin/consultant/reset_password.php?email=" . urlencode($email) . "&token=" . urlencode($resetToken);
        $subject = "Password Reset Request";
        $message = "Hello,\n\nYou have requested to reset your password. Click on the link below to reset it:\n\n$resetLink\n\nIf you didn't request this, please ignore this email.\n\nBest regards,\nbusinessclinic.lk Team";
        $headers = "From: rukshan@refectline.com";

        if (mail($email, $subject, $message, $headers)) {
            $success =  "An email has been sent with instructions to reset your password. Please Check your mailbox";
        } else {
            $errorfail = "Failed to send the password reset email. Please try again later.";
        }
    } else {
        // If the email does not exist in the database, show an error message.
        $erroremail =  "Email does not exist in our records. Please check the email address and try again.";
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <?php include "inc/header.php" ?>
</head>
<body>
    <div class="account-pages"></div>
		<div class="clearfix"></div>
		<div class="wrapper-page">
			<div class=" card-box">
				<div class="panel-heading">
				   
					<h3 class="text-center"> Forgot Password</strong></h3>
				</div>
				
					<div class="panel-body">
					   
                        <form action="forgot_password.php" method="post">
                            
                            <div class="form-group m-b-0">
                	            <div class="input-group" style="padding:0px 0px 15px 0px;">
							   
								    <input type="email" id="email" name="email"  class="form-control" placeholder="Enter your Email" required>
								    <span class="input-group-btn">
									    <button type="submit" class="btn btn-primary w-sm waves-effect waves-light" name="submit">
									    	Send Reset Link
									    </button> 
								</span>
						    	</div>
					        </div>	
                            
                        </form>
                        
                        <?php
                                    // Display error message (if any)
                                    if (isset($erroremail)) {
                                    echo ' <div class="alert alert-danger"><strong>Error: </strong>'. $erroremail .'</div>';
                                    }
                                    
                                    if (isset($errorfail)) {
                                    echo ' <div class="alert alert-danger"><strong>Error: </strong>'. $errorfail .'</div>';
                                    }
                                    
                                     if (isset($success)) {
                                    echo ' <div class="alert alert-success"><strong>Welldone! </strong>'. $success .'<br><button class="btn btn-primary type="button" onclick="goToConsultantLogin()">Log In Page</button></div>';
                                    }
                                        
                             ?>
                        
        <script>
                function goToConsultantLogin() {
                    window.location.href = "consultant_login.php";
                }
            </script>
                </div>
			</div>
			
		</div>
</body>
</html>
