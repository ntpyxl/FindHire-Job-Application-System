<?php
require_once "dbConfig.php";
require_once "functions.php";

// niche functions that are only called within the functions.php

function checkUsernameExistence($pdo, $username) {
	$query = "SELECT * FROM user_accounts WHERE username = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$username]);

	if($statement -> rowCount() > 0) {
		return true;
	}
    return false;
}

function validatePassword($password) {
	if(strlen($password) >= 8) {
		$hasLower = false;
		$hasUpper = false;
		$hasNumber = false;

		for($i = 0; $i < strlen($password); $i++) {
			if(ctype_lower($password[$i])) {
				$hasLower = true;
			}
			if(ctype_upper($password[$i])) {
				$hasUpper = true;
			}
			if(ctype_digit($password[$i])) {
				$hasNumber = true;
			}

			if($hasLower && $hasUpper && $hasNumber) {
				return true;
			}
		}
	}
	return false;
}

function deleteApplicationsByPostID($pdo, $post_id) {
    $query = "DELETE FROM applications WHERE post_id = ?";
    $statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$post_id]);
    
    if ($executeQuery) {
		$response = array(
            "statusCode" => "200",
            "message" => "Successfully deleted applications in job post!"
        );
	} else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to delete applications in job post!"
        );
    }
    return $response;
}

function deleteMessagesByPostID($pdo, $post_id) {
	$ApplicationArray = getApplicationsByPostID($pdo, $post_id)['querySet'];
	
	foreach($ApplicationArray as $application) {
		$query = "DELETE FROM messages WHERE application_id = ?";
		$statement = $pdo -> prepare($query);
		$executeQuery = $statement -> execute([$application['application_id']]);
		
		if ($executeQuery) {
			$response = array(
				"statusCode" => "200",
				"message" => "Successfully deleted all messages in application!"
			);
		} else {
			$response = array(
				"statusCode" => "400",
				"message" => "Has failed to delete a message in application!"
			);
		}
	}
	return $response;
}

?>