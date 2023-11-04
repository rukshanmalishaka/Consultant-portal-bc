<!-- consultant_login.php -->
<?php
session_start();

if (isset($_SESSION['consultant_id'])) {
    // If the consultant is already logged in, redirect to the dashboard
    header("Location: consultant_dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once 'config.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate login credentials against the consult_users table
    $query = "SELECT * FROM consultant_registration WHERE email='$email' AND status='approved'";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $consultant = $result->fetch_assoc();
        if (password_verify($password, $consultant['password'])) {
            // Login successful, set up a session for the consultant
            $_SESSION['consultant_id'] = $email;
            header("Location: consultant_dashboard.php");
            exit;
        } else {
            $loginError = "Invalid email or password. Please try again.";
        }
    } else {
        $loginError = "Invalid email or password. Please try again.";
    }

    $conn->close();
}
?>

<?php include "inc/header.php" ?>
    <body>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class=" card-box">
            <div class="panel-heading"> 
                <h3 class="text-center"> Log In as a Consultant to <br><strong class="text-custom">BusinessClinic.LK</strong> </h3> 
            </div> 
            
         
            <div class="panel-body">
                
                <?php
                    if (isset($loginError)) {
                        echo ' <div class="alert alert-danger"><strong>Error: </strong>'. $loginError .'</div>';
                       
                    }
                    ?>
                    
            <form action="consultant_login.php" class="form-horizontal m-t-20" method="post">
                
                <div class="form-group ">
                    
                    <div class="col-xs-12">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
        
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-signup" type="checkbox" name="remember" <?php echo isset($_COOKIE['remember_email']) ? 'checked' : ''; ?>>
                            <label for="checkbox-signup">
                                Remember me
                            </label>
                            
                          <?php  if (isset($_POST['remember']) && $_POST['remember'] === 'on') {
                                // Set a cookie to remember the email for 30 days (time() + 30 days)
                                setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60));
                            } else {
                                // If "Remember me" is unchecked, remove the cookie (set it to a past time)
                                setcookie('remember_email', '', time() - 3600);
                            }
                          ?>

                        </div>
                    </div>
                </div>

                
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="forgot_password.php" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                    </div>
                </div>
            </form> 
            
            </div>   
            </div> 
        </div>
        
    	<script>
            var resizefunc = [];
        </script>

   <?php include "inc/footer.php" ?>
	</body>
</html>