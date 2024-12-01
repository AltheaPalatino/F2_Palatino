<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

// Redirect if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>
    
    <style>
    	
    	th{
    		background-color: #d6cbd3;
    	}
    </style>

</head>
<body>
    <?php include 'navbar.php'; ?>
    <h2>Activity Logs</h2>
    <table style="width:100%; margin-top: 30px; text-align: center; background-color: #E6E6FA;">
        <tr>
            <th>Applicant ID</th>
            <th>Operation</th>
            <th>Branch ID</th>
            <th>Manager</th>
            <th>Contact Number</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Job Position</th>
            <th>Application Status</th>
            <th>Username</th>
            <th>Date Added</th>
        </tr>
        <?php 
        // Fetch all activity logs
        $getAllLogs = getAllActivityLogs($pdo); 
        ?>
        <?php foreach ($getAllLogs as $log) { ?>
            <tr>
                <td><?php echo $log['Applicant_id']; ?></td>
                <td><?php echo $log['operation']; ?></td>
                <td><?php echo $log['branch_id']; ?></td>
                <td><?php echo $log['Manager']; ?></td>
                <td><?php echo $log['contact_number']; ?></td>
                <td><?php echo $log['first_name']; ?></td>
                <td><?php echo $log['last_name']; ?></td>
                <td><?php echo $log['email']; ?></td>
                <td><?php echo $log['gender']; ?></td>
                <td><?php echo $log['address']; ?></td>
                <td><?php echo $log['job_position']; ?></td>
                <td><?php echo $log['application_status']; ?></td>
                <td><?php echo $log['username']; ?></td>
                <td><?php echo $log['date_added']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
