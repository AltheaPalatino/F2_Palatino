<?php
require_once 'dbConfig.php';
require_once 'models.php';

// Handle user registration
if (isset($_POST['registerUserBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if (!empty($username) && !empty($password) && !empty($confirmPassword)) {
        if ($password === $confirmPassword) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $result = insertNewUser($pdo, $username, $hashedPassword);

            if ($result) {
                $_SESSION['message'] = "Registration successful! You can now log in.";
                $_SESSION['status'] = '200';
                header("Location: ../login.php");
                exit();
            } else {
                $_SESSION['message'] = "Error during registration. Please try again.";
            }
        } else {
            $_SESSION['message'] = "Passwords do not match!";
        }
    } else {
        $_SESSION['message'] = "All fields are required!";
    }
    $_SESSION['status'] = '400';
    header("Location: ../register.php");
    exit();
}

// Handle user login
if (isset($_POST['loginUserBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $loginQuery = checkIfUserExists($pdo, $username);

        if ($loginQuery['result']) {
            if (password_verify($password, $loginQuery['userInfoArray']['password'])) {
                $_SESSION['user_id'] = $loginQuery['userInfoArray']['user_id'];
                $_SESSION['username'] = $username;
                header("Location: ../index.php");
                exit();
            } else {
                $_SESSION['message'] = "Invalid username or password!";
            }
        } else {
            $_SESSION['message'] = $loginQuery['message'];
        }
    } else {
        $_SESSION['message'] = "Please fill out both username and password!";
    }
    $_SESSION['status'] = '400';
    header("Location: ../login.php");
    exit();
}

// Handle branch insertion
if (isset($_POST['insertNewBranchBtn'])) {
    // Corrected to use 'manager' instead of 'Manager'
    $Manager = trim($_POST['manager']);
    $contact_number = trim($_POST['contact_number']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $address = trim($_POST['address']);
    $job_position = trim($_POST['job_position']);
    $application_status = trim($_POST['application_status']);

    // Ensure both fields are not empty before attempting to insert
    if (!empty($Manager) && !empty($contact_number)) {
        $insertBranch = insertABranch($pdo, null, $Manager, $contact_number, $first_name, $last_name, $email, $gender, $address, $job_position, $application_status, $_SESSION['username']);
        
        $_SESSION['message'] = $insertBranch['message'];
        $_SESSION['status'] = $insertBranch['status'];

        // Check if the insertion was successful
        if ($insertBranch['status'] == '200') {
            header("Location: ../index.php"); // Redirect to index.php on successful insert
            exit();
        } else {
            // Stay on the current page if there was an error
            header("Location: ../insertbranch.php"); 
            exit();
        }
    }
}


// Handle branch update
if (isset($_POST['updateBranchBtn'])) {
    // Get the values from the form
    $branch_id = $_POST['branch_id'];  // The branch ID passed through the form
    $Manager = trim($_POST['Manager']);
    $contact_number = trim($_POST['contact_number']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $address = trim($_POST['address']);
    $job_position = trim($_POST['job_position']);
    $application_status = trim($_POST['application_status']);
    $date = date('Y-m-d H:i:s');  // Current timestamp for updates

    // Check if the required fields are not empty
    if (!empty($Manager) && !empty($contact_number)) {
        // Call the updateBranch function with all the necessary fields
        $updateBranch = updateBranch(
            $pdo, 
            $Manager, 
            $contact_number, 
            $first_name, 
            $last_name, 
            $email, 
            $gender, 
            $address, 
            $job_position, 
            $application_status, 
            $date, 
            $_SESSION['username'], 
            $branch_id
        );
        
        // Set the session message for success or failure
        $_SESSION['message'] = $updateBranch['message'];
        $_SESSION['status'] = $updateBranch['status'];
        
        // Redirect to the home page after updating the branch
        header("Location: ../index.php");
        exit();
    } else {
        // Set an error message if required fields are missing
        $_SESSION['message'] = "Please make sure all fields are filled in!";
        $_SESSION['status'] = '400';
        
        // Redirect back to the branch edit page with the branch ID
        header("Location: ../updatebranch.php?branch_id=" . $branch_id); 
        exit();
    }
}


if (isset($_POST['deleteBranchBtn'])) {
    $branch_id = $_POST['branch_id'] ?? null;

    if ($branch_id) {
        $result = deleteBranch($pdo, $branch_id);

        if ($result['status'] === '200') {
            $_SESSION['message'] = "Branch deleted successfully!";
            $_SESSION['status'] = '200';
        } else {
            $_SESSION['message'] = "Error deleting branch: " . $result['message'];
            $_SESSION['status'] = '400';
        }
    } else {
        $_SESSION['message'] = "Invalid branch ID!";
        $_SESSION['status'] = '400';
    }

    header("Location: ../index.php");
    exit();
}

?>
