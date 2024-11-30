<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$branchId = $_GET['branch_id'];
$branchDetails = getBranchByID($pdo, $branchId); // Correct function name

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

        <!-- Adding first_name, last_name, email, gender, address, job_position, application_status -->
        <p>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" value="<?php echo $branchDetails['first_name']; ?>" required>
        </p>

        <p>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" value="<?php echo $branchDetails['last_name']; ?>" required>
        </p>

        <p>
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $branchDetails['email']; ?>" required>
        </p>

        <p>
            <label for="gender">Gender</label>
            <input type="text" name="gender" value="<?php echo $branchDetails['gender']; ?>" required>
        </p>

        <p>
            <label for="address">Address</label>
            <input type="text" name="address" value="<?php echo $branchDetails['address']; ?>" required>
        </p>

        <p>
            <label for="job_position">Job Position</label>
            <input type="text" name="job_position" value="<?php echo $branchDetails['job_position']; ?>" required>
        </p>

        <p>
            <label for="application_status">Application Status</label>
            <select name="application_status" required>
                <option value="Pending" <?php echo ($branchDetails['application_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Reviewed" <?php echo ($branchDetails['application_status'] == 'Reviewed') ? 'selected' : ''; ?>>Reviewed</option>
                <option value="Accepted" <?php echo ($branchDetails['application_status'] == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                <option value="Rejected" <?php echo ($branchDetails['application_status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
            </select>
        </p>

        <p>
            <input type="submit" name="updateBranchBtn" value="Update Branch">
        </p>
    </form>
</body>
</html>
