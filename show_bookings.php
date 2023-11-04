<?php
// Assuming you have already started the session and stored the user ID after successful login
session_start();

// Check if the user is logged in
if (!isset($_SESSION['consultant_id'])) {
    // Redirect to login page or show an error message
    header("Location: consultant_login.php");
    exit();
}

require_once 'config.php';

// Get the logged-in user ID from the session and protect against SQL injection
$loggedinConsultantEmail = $_SESSION['consultant_id'];
$loggedinConsultantEmail = $conn->real_escape_string($loggedinConsultantEmail);

// Fetch the user ID from the database based on the email
$sqlUserId = "SELECT id FROM consultant_registration WHERE email='$loggedinConsultantEmail'";
$resultUserId = $conn->query($sqlUserId);

if ($resultUserId->num_rows === 1) {
    $rowUserId = $resultUserId->fetch_assoc();
    $userId = $rowUserId["id"];

    // Fetch the bookings related to the logged-in user from the booking_table
    $sql = "SELECT b.id, c.email AS client_email, c.first_name AS client_first_name, c.last_name AS client_last_name, 
               b.scheduled_date, b.payment_amount, b.payment_status, b.booking_reference_code
        FROM booking_table b
        INNER JOIN user_registration c ON b.client_id = c.id
        WHERE b.consultant_id = $userId";

    $result = $conn->query($sql);
    
     // Get Consultant Name
    $sqlName = "SELECT first_name,last_name FROM consultant_registration WHERE email='$loggedinConsultantEmail'";
    $resultName = $conn->query($sqlName);
    $consultant = $resultName->fetch_assoc();

    // Display the bookings
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
                    
                        <h4 class="page-title">Consultation Session History</h4>
                        <ol class="breadcrumb">
                            <li>
                                <a href="index.php">Dashboard</a>
                            </li>
                            <li>
                                <a href="consult_session_history.php">Session History</a>
                            </li>
                            <li class="active">
                                All Sessions List
                            </li>
                        </ol>
                    </div>
                </div>


            
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">

                            <h4 class="m-t-0 header-title"><b>All Sessions List</b></h4><br>
                           

                            <table id="datatable-responsive"
                                   class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Reference Code</th>
                                    <th>Client Name</th>
                                    <th>Client Email</th>
                                    <th>Scheduled Date</th>
                                    <th>Session Status</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                
                                 <?php
                                 
                                 $counter = 1; // Initialize the row counter
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $counter . "</td>"; // Display the row number
                                         echo "<td>" . $row["booking_reference_code"] . "</td>";
                                        echo "<td>" . $row["client_first_name"] . " " . $row["client_last_name"] . "</td>";
                                         echo "<td>" . $row["client_email"] . "</td>";
                                        echo "<td>" . $row["scheduled_date"] . "</td>";
                                       
                                        // Get the current date in the same format as the scheduled date
                                        $currentDate = date("Y-m-d");
                            
                                        // Check if the session date is in the future or not
                                        if ($row["scheduled_date"] < $currentDate) {
                                            echo "<td>Expired Session</td>";
                                        } else {
                                            echo "<td style='color: green;'><b>Upcoming Session</b></td>";
                                        }
                                        
                                         
                                        echo "</tr>";
                                        $counter++; // Increment the row counter
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


      
                <!-- end row -->


            </div> <!-- container -->

        </div> <!-- content -->

      <?php include "inc/footer.php" ?>


<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-colvid').DataTable({
            "dom": 'C<"clear">lfrtip',
            "colVis": {
                "buttonText": "Change columns"
            }
        });
        $('#datatable-scroller').DataTable({
            ajax: "assets/plugins/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
        var table = $('#datatable-fixed-col').DataTable({
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            }
        });
    });
    TableManageButtons.init();

</script>

</body>
</html>

<?php
} else {
    echo "<p>Error: User not found.</p>";
}

