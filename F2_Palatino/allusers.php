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
	<title>All Users</title>
	<style>
		th{
    		background-color: #d6cbd3;
    		text-align: center;
    	}

    	td{
    		text-align: center;
    	}

    	th, td {
			padding: 12px;
			border: px double; #ddd;
			text-align: center;
			
		}

		tr{
			border: solid;
		}

	</style>
</head>
<body>
	<?php include 'navbar.php'; ?>
	<h2>All Users</h2>
	<table>
		<tr>
			<th>User ID</th>
			<th>Username</th>
			<th>Date Added</th>
		</tr>
		<?php $getAllUsers = getAllUsers($pdo); ?>
		<?php foreach ($getAllUsers as $row) { ?>
			<tr>
				<td><?php echo $row['user_id']; ?></td>
				<td><?php echo $row['username']; ?></td>
				<td><?php echo $row['date_added']; ?></td>
			</tr>
		<?php } ?>
	</table>
</body>
</html>
