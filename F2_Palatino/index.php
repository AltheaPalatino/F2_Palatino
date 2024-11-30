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
	<title>Branches</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<?php include 'navbar.php'; ?>
	<div class="searchForm">
		<form action="index.php" method="GET">
			<p>
				<input type="text" name="searchQuery" placeholder="Search here">
				<input type="submit" name="searchBtn" value="Search">
				<h3><a href="index.php">Search Again</a></h3>	
			</p>
		</form>
	</div>

	<?php  
	if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
		$statusColor = $_SESSION['status'] == "200" ? 'green' : 'red';
		echo "<h1 style='color: {$statusColor};'>{$_SESSION['message']}</h1>";
		unset($_SESSION['message'], $_SESSION['status']);
	}
	?>

	<div class="tableClass">
		<table style="width: 100%;" cellpadding="20"> 
			<tr>
				<th>Manager</th>
				<th>Contact Number</th>
				<th>First Name</th>
			    <th>Last Name</th>
			    <th>Email</th>
			    <th>Gender</th>
			    <th>Address</th>
			    <th>Job Position</th>
			    <th>Application Status</th>
				<th>Date Added</th>
				<th>Added By</th>
				<th>Last Updated</th>
				<th>Last Updated By</th>
				<th>Action</th>
			</tr>
		
			<?php 
			// Check if the search button was pressed
			if (isset($_GET['searchBtn'])) {
				// Perform search logic here and get the branches based on the search query
				$branches = getBranchesBySearch($pdo, $_GET['searchQuery']); 
			} else {
				// Fetch all branches if no search is done
				$branches = getAllBranches($pdo); 
			}
			
			// Loop through each branch record and display it in the table
			foreach ($branches as $row) { ?>
				<tr>
					<td><?php echo $row['Manager']; ?></td>
					<td><?php echo $row['contact_number']; ?></td>
					<td><?php echo $row['first_name']; ?></td>
					<td><?php echo $row['last_name']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo $row['gender']; ?></td>
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['job_position']; ?></td>
					<td><?php echo $row['application_status']; ?></td>
					<td><?php echo $row['date_added']; ?></td>
					<td><?php echo $row['added_by']; ?></td>
					<td><?php echo $row['last_updated']; ?></td>
					<td><?php echo $row['last_updated_by']; ?></td>
					<td>
						<a href="updatebranch.php?branch_id=<?php echo $row['branch_id']; ?>">Update</a>
						<a href="Dbranch.php?branch_id=<?php echo $row['branch_id']; ?>">Delete</a>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>
