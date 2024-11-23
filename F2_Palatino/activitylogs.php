<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Activity Logs</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<?php include 'navbar.php'; ?>
	<h2>Activity Logs</h2>
	<table>
		<tr>
			<th>Applicant ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Gender</th>
			<th>Address</th>
			<th>Job Position</th>
			<th>Application Status</th>
			<th>Branch ID</th>
			<th>Date Applied</th>
		</tr>
		<?php $getAllLogs = getAllLogs($pdo); ?>
		<?php foreach ($getAllLogs as $log) { ?>
			<tr>
				<td><?php echo $log['Applicant_id']; ?></td>
				<td><?php echo $log['first_name']; ?></td>
				<td><?php echo $log['last_name']; ?></td>
				<td><?php echo $log['email']; ?></td>
				<td><?php echo $log['gender']; ?></td>
				<td><?php echo $log['address']; ?></td>
				<td><?php echo $log['job_position']; ?></td>
				<td><?php echo $log['application_status']; ?></td>
				<td><?php echo $log['branch_id']; ?></td>
				<td><?php echo $log['date_applied']; ?></td>
			</tr>
		<?php } ?>
	</table>
</body>
</html>
