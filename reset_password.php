<html>
<head>
    <title>Reset Password</title>
    <?php include "inc/header.php" ?>
</head>
<body>
    <div class="account-pages"></div>
		<div class="clearfix"></div>
		<div class="wrapper-page">
			<div class=" card-box">
				<div class="panel-heading">
				   
					<h3 class="text-center"> Reset Password</strong></h3>
				</div>
				
					<div class="panel-body">
    
    <?php
    if (isset($_GET['email']) && isset($_GET['token'])) {
        $email = $_GET['email'];
        $token = $_GET['token'];

        // Perform validation, such as checking if the email and token are valid and not expired.
        // ...

        if (isset($_POST['submit'])) {
            $password = $_POST['password'];

            // Perform validation for the new password.
            if (strlen($password) < 6 ||
                !preg_match("/[A-Z]/", $password) ||
                !preg_match("/[a-z]/", $password) ||
                !preg_match("/[0-9]/", $password)
            ) {
                $vsm = "Password must be at least 6 characters long and contain uppercase, lowercase, and digits.";
               
            }else{

            // Update the new password in the database.
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            require_once 'config.php';

            // Update the password in the table (assuming the table name is "users" and the email field is "email")
            $sql = "UPDATE consultant_registration SET password = '$hashedPassword' WHERE email = '$email'";

            if ($conn->query($sql) === TRUE) {
                $resetok = "Password reset successful. You can now log in with your new password.";
            } else {
                echo "Error updating password: " . $conn->error;
            }

            $conn->close();
        }} else {
            // If the reset token is valid, show the password reset form.
            ?>
            <form action="reset_password.php?email=<?php echo urlencode($email); ?>&token=<?php echo urlencode($token); ?>" method="post">
                
                <div class="form-group m-b-0">
                	<div class="input-group" style="padding:0px 0px 15px 0px;">
							   
								<input type="password" id="password" name="password"  class="form-control" placeholder="Enter New Password" required>
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary w-sm waves-effect waves-light" name="submit">
										Reset Password
									</button> 
								</span>
							</div>
					</div>		
			</form>				
                
              
            <?php
        }
    } else {
        $ipw = "Invalid password reset link.";
    }
    ?>
    
                                    <?php
                                    // Display error message (if any)
                                    if (isset($vsm)) {
                                    echo ' <div class="alert alert-danger"><strong>Error: </strong>'. $vsm .'<br><button class="btn btn-primary type="button" onclick="goBack()">Try Again</button></div>';
                                    }
                                    
                                     if (isset($resetok)) {
                                    echo ' <div class="alert alert-success">'. $resetok .'<br><button class="btn btn-primary type="button" onclick="goToConsultantLogin()">Log In</button></div>';
                                    }
                                    
                                    if (isset($ipw)) {
                                    echo ' <div class="alert alert-danger"><strong>Error: </strong>'. $ipw .'</div>';
                                    }
                                        
                             ?>
                             
                             
                             
                             <script>
                function goBack() {
                    history.back();
                }
            </script>
            
            <script>
                function goToConsultantLogin() {
                    window.location.href = "consultant_login.php";
                }
            </script>
    
                </div>
			</div>
			
		</div>
		
    <?php include "inc/footer.php" ?>  
</body>
</html>
