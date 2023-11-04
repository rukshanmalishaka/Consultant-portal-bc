<!-- consult_session.php -->
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

$sql = "SELECT first_name, last_name FROM consultant_registration WHERE email='$loggedinConsultantEmail'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $consultant = $result->fetch_assoc();
    $consultantFirstName = $consultant['first_name'];
    $consultantLastName = $consultant['last_name'];
} else {
    // Consultant not found in the database; handle this scenario accordingly
    $consultantFirstName = "Unknown";
    $consultantLastName = "Consultant";
}

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
                            <div class="col-sm-12">
                                
                                <h2 class="page-title">Data Collection During Session</h2>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Dashboard</a></li>
                                    <li><a href="consult_session.php">Add New Session</a></li>
                                    <li class="active">Session Data Submission</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="row">
							<div class="col-lg-7">
								<div class="card-box">
									<h4 class="m-t-0 header-title"><b>Session Data Submission</b></h4><br>
									
									<?php
                                    // Check if a success message exists in the query parameters
                                    if (isset($_GET['success'])) {
                                        // Display the success message
                                        echo "<p class='alert alert-success'>" . htmlspecialchars($_GET['success']) . "</p>";
                                    }
                                    ?>
                                    
                                   
							
								<form method="post" action="SubmitConsult_session.php">
								    
								    <div class="col-lg-6">
										<div class="form-group">
										    
										     <label for="nic">Client NIC</label>
				                             <input type="text" class="form-control" name="nic" id="nic" placeholder="Client NIC in your session" required>
				                             
										</div>
										
										<div class="form-group">
											
											 <label for="email">Email</label>
				                             <input type="email" class="form-control" name="email" id="email" placeholder="Client email address" required>
				                             
										</div>
										
									</div>
									
									<div class="col-lg-6">
										
										<div class="form-group">
										    
										      <label for="client_name">Client Name</label>
                            				  <input type="text" class="form-control" name="client_name" id="client_name" placeholder="Client Name in your session" required>
									
										</div>
										<div class="form-group">
										    
											<label for="phone_number">Phone Number</label>
                            				  <input type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="Client phone number" required>
										</div>
										
									</div>
									
										<div class="form-group">
										    
											<label for="issues">Issues</label>
				                            <textarea name="issues" class="form-control" id="issues"></textarea>
				                            
										</div>
										<div class="form-group">
										    
											<label for="requirments">Requirments</label>
				                            <textarea name="requirments" class="form-control" id="requirments"></textarea>
				                            
										</div>
										
										<div class="form-group">
										    
											<label for="recommendation_action">Recommendation / Action (To Client)</label>
				                            <textarea name="recommendation_action" class="form-control" id="recommendation_action"></textarea>
				                            
										</div>
										
										<div class="form-group">
										    
											<label for="notes_to_admin">Notes to Admin (BusinessClinic.lk)</label>
				                            <textarea name="notes_to_admin" class="form-control" id="notes_to_admin"></textarea>
				                            
										</div>
										
										
							
										<div class="form-group text-right m-b-0">
											<button class="btn btn-primary waves-effect waves-light" type="submit" name="submit">
												Submit
											</button>
											<button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
												Clear Form
											</button>
											
										</div>
										
									</form>
								</div>
							</div>
						</div>

            		</div> <!-- container -->
                               
                </div> <!-- content -->
                <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
              
                <script>
			 ClassicEditor
				.create(document.querySelector('#issues'))
				.catch(error => {
				  console.error(error);
				});
				
				ClassicEditor
				.create(document.querySelector('#requirments'))
				.catch(error => {
				  console.error(error);
				});
				
				ClassicEditor
				.create(document.querySelector('#recommendation_action'))
				.catch(error => {
				  console.error(error);
				});
				
				ClassicEditor
				.create(document.querySelector('#notes_to_admin'))
				.catch(error => {
				  console.error(error);
				});
			</script>
                
              <?php include "inc/footer.php" ?>    
	</body>
</html>