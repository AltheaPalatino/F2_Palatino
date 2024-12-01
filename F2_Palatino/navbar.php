
<div class="greeting">
	<h1>Hello there! Welcome to QA Applicant System, <span style="color: blue; text-align: center;"><?php echo $_SESSION['username'] ;  ?></span></h1>
</div>

<div class="navbar" style="text-align: center;" >

	<h3>
		<a href="index.php" style="border-style: inset;">Home</a>
		<a href="insertbranch.php"style="border-style: inset;">Add New Branch</a>
		<a href="allusers.php" style="border-style: inset;">All Users</a>
		<a href="activitylogs.php" style="border-style: inset;">Activity Logs</a>
		<a href="searchHistory.php" style="border-style: inset;">Search History</a>
		<a href="core/handleForms.php?logoutUserBtn=1" style="border-style: inset;">Logout</a>	

	</h3>	
</div>
