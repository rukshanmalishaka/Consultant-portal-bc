<!-- consultant_dashboard.php -->
<?php
session_start();

if (!isset($_SESSION['consultant_id'])) {
    // If the consultant is not logged in, redirect to the login page
    header("Location: consultant_login.php");
    exit;
}

// Retrieve consultant information based on the logged-in email
$loggedinConsultantEmail = $_SESSION['consultant_id'];

require_once 'config.php';

$sql = "SELECT * FROM consultant_registration WHERE email='$loggedinConsultantEmail'";
$result = $conn->query($sql);
$consultant = $result->fetch_assoc();

$conn->close();
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
							<div class="col-lg-7">
								<div class="card-box">
									<h1>Welcome, <?php echo $consultant['first_name']; ?>!</h1>
                                        <!-- Add your consultant dashboard content here -->
                                        <!-- Logout button -->
                                        <form action="consultant_logout.php" method="post">
                                            <input type="submit" value="Logout">
                                        </form>

	                            </div>
							</div>
						</div>

            		</div> <!-- container -->
                               
                </div> <!-- content -->
         

              <?php include "inc/footer.php" ?>    
	</body>
    
</html>