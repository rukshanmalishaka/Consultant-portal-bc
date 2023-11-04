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

// Get the ID from the URL parameter (created date)
$id = $_GET['id'];

// Fetch data from the database based on the ID (created date)
$sql = "SELECT * FROM editor WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


// Get Consultant Name
    $sqlName = "SELECT first_name,last_name FROM consultant_registration WHERE email='$loggedinConsultantEmail'";
    $resultName = $conn->query($sqlName);
    $consultant = $resultName->fetch_assoc();
    

// Close the connection
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
                                
                                <h2 class="page-title">Collected Data During Session</h2>
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Dashboard</a></li>
                                    <li><a href="consult_session_history.php">Session History</a></li>
                                    <li class="active">Session Data Page</li>
                                </ol>
                            </div>
                        </div>
                        
                     
						<div class="row">
							<div class="col-lg-12">
								<div class="card-box">
									<h4 class="m-t-0 header-title">Session Data with <?php echo $row['consultant_name']; ?> on <?php echo $row['created']; ?></h4><br>
					
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div>
                                            <ul class="taskList list-unstyled"> 
                                                <li class="task-success">
                                                    <h5><b>Session Date : </b> <?php echo $row['created']; ?></h5>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div>
                                            <ul class="taskList list-unstyled">
                                                 <li class="task-success">
                                                    <h5><b>Client Name : </b> <?php echo $row['client_name']; ?></h5>
                                                 </li>
                                            </ul>
                                        
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div>
                                            <ul class="taskList list-unstyled">
                                                 <li class="task-success">
                                                    <h5><b>Client NIC : </b> <?php echo $row['client_nic']; ?></h5>
                                                 </li>
                                            </ul>
                                        
                                        </div>
                                    </div>
                                    
                                     <div class="col-lg-4">
                                        <div>
                                            <ul class="taskList list-unstyled">
                                                 <li class="task-success">
                                                    <h5><b>Client Email : </b> <?php echo $row['email']; ?></h5>
                                                 </li>
                                            </ul>
                                        
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div>
                                            <ul class="taskList list-unstyled">
                                                 <li class="task-success">
                                                    <h5><b>Phone Number : </b> <?php echo $row['phone_number']; ?></h5>
                                                 </li>
                                            </ul>
                                        
                                        </div>
                                    </div>
                                </div>
                           <div> 
                           
                                <ul class="nav nav-tabs tabs hidden-xs">
                                    <li class="active tab">
                                        <a href="#home-2" data-toggle="tab" aria-expanded="false"> 
                                           <span class="hidden-xs portlet-title">Issues</span> 
                                        </a> 
                                    </li> 
                                    <li class="tab"> 
                                        <a href="#profile-2" data-toggle="tab" aria-expanded="false"> 
                                          <span class="hidden-xs">Requirements</span> 
                                        </a> 
                                    </li> 
                                    <li class="tab"> 
                                        <a href="#messages-2" data-toggle="tab" aria-expanded="true"> 
                                           <span class="hidden-xs">Recommendation / Action</span> 
                                        </a> 
                                    </li> 
                                    <li class="tab"> 
                                        <a href="#messages-3" data-toggle="tab" aria-expanded="true"> 
                                           <span class="hidden-xs">Notes To Admin</span> 
                                        </a> 
                                    </li> 
                                   
                                </ul> 
                                <div class="tab-content hidden-xs"> 
                                    <div class="tab-pane active" id="home-2"> 
                                        <?php echo $row['issues']; ?>
                                    </div> 
                                    <div class="tab-pane" id="profile-2">
                                         <?php echo $row['requirments']; ?>
                                    </div> 
                                    <div class="tab-pane" id="messages-2">
                                        <?php echo $row['recommendation_action']; ?>
                                    </div> 
                                    <div class="tab-pane" id="messages-3">
                                        <?php echo $row['notes_to_admin']; ?>
                                    </div> 
                                
                                    
                                </div> 
                                
                                
                          <!-- mobile view accordian -->
                             
                        <div class="row">
                            
                            
                          
                            <div class="col-lg-12 visible-xs"> 
                                <div class="panel-group" id="accordion-test-2"> 
                                    <div class="panel panel-default"> 
                                        <div class="panel-heading"> 
                                            <h4 class="panel-title"> 
                                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="false" class="collapsed">
                                                    Issues
                                                </a> 
                                            </h4> 
                                        </div> 
                                        <div id="collapseOne-2" class="panel-collapse collapse"> 
                                            <div class="panel-body">
                                                 <p><?php echo $row['issues']; ?></p>
                                            </div> 
                                        </div> 
                                    </div>
                                    <div class="panel panel-default"> 
                                        <div class="panel-heading"> 
                                            <h4 class="panel-title"> 
                                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseTwo-2" class="collapsed" aria-expanded="false">
                                                    Requirements
                                                </a> 
                                            </h4> 
                                        </div> 
                                        <div id="collapseTwo-2" class="panel-collapse collapse"> 
                                            <div class="panel-body">
                                                <p><?php echo $row['requirments']; ?></p>
                                            </div> 
                                        </div> 
                                    </div> 
                                    <div class="panel panel-default"> 
                                        <div class="panel-heading"> 
                                            <h4 class="panel-title"> 
                                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseThree-2" class="collapsed" aria-expanded="false">
                                                    Recommendation / Action
                                                </a> 
                                            </h4> 
                                        </div> 
                                        <div id="collapseThree-2" class="panel-collapse collapse"> 
                                            <div class="panel-body">
                                               <p><?php echo $row['recommendation_action']; ?></p>
                                            </div> 
                                        </div> 
                                    </div> 
                                    
                                    <div class="panel panel-default"> 
                                        <div class="panel-heading"> 
                                            <h4 class="panel-title"> 
                                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseFour-2" class="collapsed" aria-expanded="false">
                                                    Notes To Admin
                                                </a> 
                                            </h4> 
                                        </div> 
                                        <div id="collapseFour-2" class="panel-collapse collapse"> 
                                            <div class="panel-body">
                                               <p><?php echo $row['notes_to_admin']; ?></p>
                                            </div> 
                                        </div> 
                                    </div> 
                                    
                                </div> 
                            </div>
                        </div>
                        
                               
                        
                            </div> 

                	            </div>
							</div>
						</div>
						
						
						
						
						
						

            		</div> <!-- container -->
                               
                </div> <!-- content -->
         

              <?php include "inc/footer.php" ?>    
	</body>
</html>