<?php 
require_once 'core/models.php'; 
require_once 'core/dbConfig.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch branch details
$branch_id = $_GET['branch_id'] ?? null;
$getBranchByID = null; // Initialize variable

if ($branch_id) {
    $getBranchByID = getBranchByID($pdo, $branch_id); // Get branch details
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Branch</title>
    <style>
        body {
            font-family: "Arial";
        }
        input {
            font-size: 1.5em;
            height: 50px;
            width: 200px;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Are you sure you want to delete this branch?</h1>

    <?php if ($getBranchByID && is_array($getBranchByID)): ?>
        <div class="container" style="border-style: solid; border-color: red; background-color: #ffcbd1; height: 550px; padding: 20px;">
            <h2>Manager: <?php echo $getBranchByID['Manager']; ?></h2>
            <h2>Contact Number: <?php echo $getBranchByID['contact_number']; ?></h2>
            <h2>First Name: <?php echo $getBranchByID['first_name']; ?></h2>
            <h2>Last Name: <?php echo $getBranchByID['last_name']; ?></h2>
            <h2>Email: <?php echo $getBranchByID['email']; ?></h2>
            <h2>Gender: <?php echo $getBranchByID['gender']; ?></h2>
            <h2>Address: <?php echo $getBranchByID['address']; ?></h2>
            <h2>Job Position: <?php echo $getBranchByID['job_position']; ?></h2>
            <h2>Application Status: <?php echo $getBranchByID['application_status']; ?></h2>

            <div class="deleteBtn" style="float: right; margin-right: 10px;">
                <form action="core/handleForms.php" method="POST">
                    <?php if ($branch_id): ?>
                        <input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>" />
                    <?php else: ?>
                        <p>Invalid branch ID.</p>
                    <?php endif; ?>
                    <input type="submit" name="deleteBranchBtn" value="Delete" style="background-color: #f69697; border-style: solid;">
                </form>          
            </div>
        </div>
    <?php else: ?>
        <p>Branch not found or invalid branch ID.</p>
    <?php endif; ?>

</body>
</html>
