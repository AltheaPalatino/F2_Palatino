<?php  

require_once 'dbConfig.php';

function checkIfUserExists($pdo, $username) {
    $response = array();
    $sql = "SELECT * FROM user_accounts WHERE username = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$username])) {
        $userInfoArray = $stmt->fetch();

        if ($stmt->rowCount() > 0) {
            $response = array(
                "result" => true,
                "status" => "200",
                "userInfoArray" => $userInfoArray
            );
        } else {
            $response = array(
                "result" => false,
                "status" => "400",
                "message" => "User doesn't exist from the database"
            );
        }
    }

    return $response;
}

// Insert new user into the database
function insertNewUser($pdo, $username, $password) {
    try {
        $sql = "INSERT INTO user_accounts (username, password, date_added) VALUES (:username, :password, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => $password // Assuming password is hashed before passing to this function
        ]);
        return true;
    } catch (PDOException $e) {
        echo "Error inserting new user: " . $e->getMessage();
        return false;
    }
}

// User login validation
function loginUser($pdo, $username, $password) {
    try {
        $sql = "SELECT * FROM user_accounts WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        return false;
    } catch (PDOException $e) {
        echo "Error logging in: " . $e->getMessage();
        return false;
    }
}


function getAllUsers($pdo) {
    $sql = "SELECT * FROM user_accounts";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getAllBranches($pdo) {
    $sql = "SELECT * FROM branches";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getBranchesBySearch($pdo, $search_query) {
    $sql = "SELECT * FROM branches WHERE 
            CONCAT(Manager, contact_number, date_added, added_by, last_updated, last_updated_by) 
            LIKE ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%" . $search_query . "%"]);
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getBranchByID($pdo, $branch_id) {
    $sql = "SELECT * FROM branches WHERE branch_id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$branch_id])) {
        return $stmt->fetch();
    }
}

function insertAnActivityLog($pdo, $operation, $branch_id, $Manager, $contact_number, $first_name, $last_name, $email, $gender, $address, $job_position, $application_status, $username) {
    try {
        $sql = "INSERT INTO activity_logs (
                    operation, branch_id, Manager, contact_number, 
                    first_name, last_name, email, gender, address, 
                    job_position, application_status, username, date_added
                ) VALUES (
                    :operation, :branch_id, :Manager, :contact_number, 
                    :first_name, :last_name, :email, :gender, :address, 
                    :job_position, :application_status, :username, NOW()
                )";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':operation' => $operation,
            ':branch_id' => $branch_id,
            ':Manager' => $Manager,
            ':contact_number' => $contact_number,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':gender' => $gender,
            ':address' => $address,
            ':job_position' => $job_position,
            ':application_status' => $application_status,
            ':username' => $username
        ]);
    } catch (PDOException $e) {
        throw $e; // Re-throw the error for debugging
    }
}



function getAllActivityLogs($pdo) {
    $sql = "SELECT * FROM activity_logs";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        return $stmt->fetchAll();
    }
}

function insertABranch($pdo, $branch_id, $Manager, $contact_number, $first_name, $last_name, $email, $gender, $address, $job_position, $application_status, $added_by) {
    try {
        // Add the 'added_by' and 'last_updated_by' logic here
        $sql = "INSERT INTO branches (Manager, contact_number, first_name, last_name, email, gender, address, job_position, application_status, added_by, last_updated_by)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([
            $Manager, $contact_number, $first_name, 
            $last_name, $email, $gender, 
            $address, $job_position, $application_status, 
            $added_by, $added_by
        ]);

        if ($executeQuery) {
            // Fetch the latest inserted record from the branches table
            $findInsertedItemSQL = "SELECT * FROM branches ORDER BY date_added DESC LIMIT 1";
            $stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
            $stmtfindInsertedItemSQL->execute();
            $getBranchData = $stmtfindInsertedItemSQL->fetch();

            // Insert an activity log for this insertion
            $insertAnActivityLog = insertAnActivityLog($pdo, 
                "INSERT",
                $getBranchData['branch_id'], 
                $getBranchData['Manager'], 
                $getBranchData['contact_number'], 
                $getBranchData['first_name'], 
                $getBranchData['last_name'], 
                $getBranchData['email'], 
                $getBranchData['gender'], 
                $getBranchData['address'], 
                $getBranchData['job_position'], 
                $getBranchData['application_status'], 
                $_SESSION['username']
            );

            if ($insertAnActivityLog) {
                return array(
                    "status" => "200",
                    "message" => "Branch added successfully and activity log created!"
                );
            } else {
                return array(
                    "status" => "200",
                    "message" => "Branch added successfully, but failed to create activity log."
                );
            }
        } else {
            return array(
                "status" => "400",
                "message" => "Error adding branch."
            );
        }
    } catch (Exception $e) {
        return array(
            "status" => "400",
            "message" => "Error adding branch: " . $e->getMessage()
        );
    }
} // Closing bracket for the function




function updateBranch($pdo, $Manager, $contact_number, 
    $first_name, $last_name, $email, $gender, $address, $job_position, 
    $application_status, $last_updated, $last_updated_by, $branch_id) {

    $response = array();
    $sql = "UPDATE branches
            SET Manager = ?,
                contact_number = ?, 
                first_name = ?, 
                last_name = ?,
                email = ?,
                gender = ?, 
                address = ?, 
                job_position = ?, 
                application_status = ?,
                last_updated = ?, 
                last_updated_by = ? 
            WHERE branch_id = ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([
        $Manager, $contact_number, $first_name, 
        $last_name, $email, $gender, 
        $address, $job_position, $application_status, 
        $last_updated, $last_updated_by, $branch_id // Added missing branch_id
    ]);

    if ($executeQuery) {
        // Fetch the latest updated record from the branches table
        $findInsertedItemSQL = "SELECT * FROM branches WHERE branch_id = ?";
        $stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
        $stmtfindInsertedItemSQL->execute([$branch_id]); // Pass branch_id here
        $getBranchData = $stmtfindInsertedItemSQL->fetch();

        // Insert an activity log for this update
        $insertAnActivityLog = insertAnActivityLog($pdo, 
            "UPDATE",
            $getBranchData['branch_id'], 
            $getBranchData['Manager'], 
            $getBranchData['contact_number'], 
            $getBranchData['first_name'], 
            $getBranchData['last_name'], 
            $getBranchData['email'], 
            $getBranchData['gender'], 
            $getBranchData['address'], 
            $getBranchData['job_position'], 
            $getBranchData['application_status'], 
            $_SESSION['username']
        );

        if ($insertAnActivityLog) {
            $response = array(
                "status" => "200",
                "message" => "Updated the branch successfully!"
            );
        } 
    } else {
        $response = array(
            "status" => "400",
            "message" => "An error has occurred with the query!"
        );
    }

    return $response;
}


function deleteBranch($pdo, $branch_id) {
    $response = array();

    // Fetch the branch details for activity logging
    $sql = "SELECT * FROM branches WHERE branch_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$branch_id]);
    $getBranch = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($getBranch) {
        // Insert into activity log before deletion
        $insertAnActivityLog = insertAnActivityLog(
            $pdo, 
            "DELETE", 
            $getBranch['branch_id'], 
            $getBranch['Manager'], 
            $getBranch['contact_number'], 
            $getBranch['first_name'], 
            $getBranch['last_name'], 
            $getBranch['email'], 
            $getBranch['gender'], 
            $getBranch['address'], 
            $getBranch['job_position'], 
            $getBranch['application_status'], 
            $_SESSION['username']
        );

        if ($insertAnActivityLog === false) { 
            $response = array(
                "status" => "400",
                "message" => "Error logging activity."
            );
            return $response;  
        }

        // Proceed to delete the branch
        $deleteSql = "DELETE FROM branches WHERE branch_id = ?";
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteQuery = $deleteStmt->execute([$branch_id]);

        if ($deleteQuery) {
            $response = array(
                "status" => "200",
                "message" => "Branch successfully deleted!"
            );
        } else {
            $response = array(
                "status" => "400",
                "message" => "Error occurred while deleting the branch."
            );
        }
    } else {
        $response = array(
            "status" => "400",
            "message" => "Branch not found!"
        );
    }

    return $response;
}

function logSearchQuery($pdo, $keyword, $username) {
    $sql = "INSERT INTO search_history (keyword, username) 
            VALUES (?,?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$keyword, $username]);

    if ($executeQuery) {
        return true;
    }
}

function searchbranches($pdo, $keyword, $username) {
    $sql = "SELECT * FROM branches WHERE 
            CONCAT(Manager, contact_number, first_name, last_name, email, gender, address, job_position, application_status) LIKE ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%" . $keyword . "%"]);
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getSearchHistory($pdo) {
    $sql = "SELECT * FROM search_history ORDER BY search_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





?>