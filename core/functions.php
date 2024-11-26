<?php 
require_once "dbConfig.php";
require_once "abstractFunctions.php";

function sanitizeInput($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

function addUser($pdo, $username, $password, $confirm_passwrd, $hashed_password, $first_name, $last_name, $age, $birthdate, $email_address, $phone_number, $home_address) {
    $response = array();
    if(checkUsernameExistence($pdo, $username)) {
        $response = array(
            "statusCode" => "400",
            "message" => "Username already exists!"
        );
        return $response;
    }
    if($password != $confirm_passwrd) {
        $response = array(
            "statusCode" => "400",
            "message" => "Password does not match!"
        );
        return $response;
    }
    if(!validatePassword($password)) {
        $response = array(
            "statusCode" => "400",
            "message" => "Password is invalid! Make sure it is 8 characters long, has both upper and lowercase letters, and has a number!"
        );
        return $response;
    }

	$query1 = "INSERT INTO user_accounts (username, user_password) VALUES (?, ?)";
	$statement1 = $pdo -> prepare($query1);
	$executeQuery1 = $statement1 -> execute([$username, $hashed_password]);

    $query2 = "INSERT INTO users (first_name, last_name, age, birthdate, email_address, phone_number, home_address, user_role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $statement2 = $pdo -> prepare($query2);
	$executeQuery2 = $statement2 -> execute([$first_name, $last_name, $age, $birthdate, $email_address, $phone_number, $home_address, "Applicant"]);
    
    if ($executeQuery1 && $executeQuery2) {
		$response = array(
            "statusCode" => "200",
            "message" => "Successfully registered applicant!"
        );
	} else {
        $response = array(
            "statusCode" => "400",
            "message" => "Something else went wrong.."
        );
    }
    return $response;
}

function loginUser($pdo, $username, $password) {
    $response = array();
    if(!checkUsernameExistence($pdo, $username)) {
		$response = array(
            "statusCode" => "400",
            "message" => "Username does not exist!"
        );
        return $response;
	}

	$query = "SELECT * FROM user_accounts WHERE username = ?";
	$statement = $pdo -> prepare($query);
	$statement -> execute([$username]);
	$applicantAccountData = $statement -> fetch();

	if(password_verify($password, $applicantAccountData['user_password'])) {
		$_SESSION['user_id'] = $applicantAccountData['user_id'];
		$response = array(
            "statusCode" => "200",
            "message" => "Successfully logged in!"
        );
        return $response;
	} else {
		$response = array(
            "statusCode" => "400",
            "message" => "Incorrect password"
        );
        return $response;
	}
}

function getUserByID($pdo, $user_id) {
    $query = "SELECT * FROM users WHERE user_id = ?";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$user_id]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetch()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get user# " . $user_id . "!"
        );
    }
    return $response;
}

?>