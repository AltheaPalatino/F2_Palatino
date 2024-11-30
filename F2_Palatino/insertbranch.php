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
	<title>Add Branch</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<?php include 'navbar.php'; ?>

	<form action="core/handleForms.php" method="POST">
		<p>
            <label for="manager">Manager:</label> 
            <input type="text" name="manager" required>
        </p>
        <p>
            <label for="contact_number">Contact Number:</label> 
            <input type="text" name="contact_number" required>
        </p>

        <p>
		    <label for="first_name">First Name:</label> 
            <input type="text" name="first_name" required>
        </p>
        <p>
            <label for="last_name">Last Name:</label> 
            <input type="text" name="last_name" required>
        </p>
        <p>
            <label for="email">Email:</label> 
            <input type="email" name="email" required>
        </p>
        <p>
            <label for="gender">Gender:</label> 
            <input type="text" name="gender" required>
        </p>
        <p>
            <label for="address">Address:</label> 
            <input type="text" name="address" required>
        </p>
        <p>
            <label for="job_position">Job Position:</label> 
            <input type="text" name="job_position" required>
        </p>
        <p>
            <label for="application_status">Application Status:</label> 
            <select name="application_status" required>
                <option value="Pending">Pending</option>
                <option value="Reviewed">Reviewed</option>
                <option value="Accepted">Accepted</option>
                <option value="Rejected">Rejected</option>
            </select>
        </p>
        <!-- Added Manager and Contact Number fields -->
        
		<p>
			<input type="submit" name="insertNewBranchBtn" value="Insert Branch">
		</p>
	</form>
</body>
</html>
