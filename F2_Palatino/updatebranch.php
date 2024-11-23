<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}

$branchId = $_GET['branch_id'];
$branchDetails = getBranchById($pdo, $branchId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Update Branch</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<?php include 'navbar.php'; ?>

	<form action="core/handleForms.php" method="POST">
		<input type="hidden" name="branch_id" value="<?php echo $branchDetails['branch_id']; ?>">
		<p>
			<label for="Manager">Manager</label>
			<input type="text" name="Manager" value="<?php echo $branchDetails['Manager']; ?>" required>
		</p>
		<p>
			<label for="contact_number">Contact Number</label>
			<input type="text" name="contact_number" value="<?php echo $branchDetails['contact_number']; ?>" required>
		</p>
		<p>
			<input type="submit" name="updateBranchBtn" value="Update Branch">
		</p>
	</form>
</body>
</html>
