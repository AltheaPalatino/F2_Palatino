<?php  
require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['insertNewUserBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($username) && !empty($password) && !empty($confirm_password)) {
        if ($password == $confirm_password) {
            // Insert new user into user_accounts table
            $insertQuery = insertNewUser($pdo, $username, password_hash($password, PASSWORD_DEFAULT));
            $_SESSION['message'] = $insertQuery['message'];

            if ($insertQuery['status'] == '200') {
                $_SESSION['status'] = $insertQuery['status'];
                header("Location: ../login.php");
            } else {
                $_SESSION['status'] = $insertQuery['status'];
                header("Location: ../register.php");
            }
        } else {
            $_SESSION['message'] = "Passwords do not match!";
            $_SESSION['status'] = '400';
            header("Location: ../register.php");
        }
    } else {
        $_SESSION['message'] = "All fields must be filled!";
        $_SESSION['status'] = '400';
        header("Location: ../register.php");
    }
}



if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {
		// Check if the user exists in the user_accounts table
		$loginQuery = checkIfUserExists($pdo, $username);
		$userIDFromDB = $loginQuery['userInfoArray']['user_id'];
		$passwordFromDB = $loginQuery['userInfoArray']['password'];

		if (password_verify($password, $passwordFromDB)) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $username;
			header("Location: ../index.php");
		} else {
			$_SESSION['message'] = "Invalid username or password";
			$_SESSION['status'] = '400';
			header("Location: ../login.php");
		}
	} else {
		$_SESSION['message'] = "Please fill out both username and password!";
		$_SESSION['status'] = '400';
		header("Location: ../login.php");
	}
}

if (isset($_POST['insertNewBranchBtn'])) {
	$address = trim($_POST['address']);
	$head_manager = trim($_POST['head_manager']);
	$contact_number = trim($_POST['contact_number']);

	if (!empty($address) && !empty($head_manager) && !empty($contact_number)) {
		// Insert new branch into the branches table
		$insertBranch = insertBranch($pdo, $address, $head_manager, $contact_number, $_SESSION['username']);
		$_SESSION['status'] = $insertBranch['status'];
		$_SESSION['message'] = $insertBranch['message'];
		header("Location: ../index.php");
	} else {
		$_SESSION['message'] = "Please ensure no fields are empty!";
		$_SESSION['status'] = '400';
		header("Location: ../insertbranch.php");
	}
}

if (isset($_POST['updateBranchBtn'])) {
	$address = trim($_POST['address']);
	$head_manager = trim($_POST['head_manager']);
	$contact_number = trim($_POST['contact_number']);
	$date = date('Y-m-d H:i:s');

	if (!empty($address) && !empty($head_manager) && !empty($contact_number)) {
		// Update branch in the branches table
		$updateBranch = updateBranch($pdo, $address, $head_manager, $contact_number, $date, $_SESSION['username'], $_GET['branch_id']);
		$_SESSION['message'] = $updateBranch['message'];
		$_SESSION['status'] = $updateBranch['status'];
		header("Location: ../index.php");
	} else {
		$_SESSION['message'] = "Please ensure no fields are empty!";
		$_SESSION['status'] = '400';
		header("Location: ../updatebranch.php?branch_id=" . $_GET['branch_id']);
	}
}

if (isset($_POST['deleteBranchBtn'])) {
	$branch_id = $_GET['branch_id'];

	if (!empty($branch_id)) {
		// Delete branch from branches table
		$deleteBranch = deleteBranch($pdo, $branch_id);
		$_SESSION['message'] = $deleteBranch['message'];
		$_SESSION['status'] = $deleteBranch['status'];
		header("Location: ../index.php");
	}
}

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['username']);
	header("Location: ../login.php");
}
?>
