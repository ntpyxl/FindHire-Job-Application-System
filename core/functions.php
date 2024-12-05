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

function editProfile($pdo, $first_name, $last_name, $age, $birthdate, $email_address, $phone_number, $home_address, $user_id) {
	$query = "UPDATE users
            SET first_name = ?,
                last_name = ?,
                age = ?,
                birthdate = ?,
                email_address = ?,
                phone_number = ?,
                home_address = ?
            WHERE user_id = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$first_name, $last_name, $age, $birthdate, $email_address, $phone_number, $home_address, $user_id]);

    if ($executeQuery) {
		$response = array(
            "statusCode" => "200",
            "message" => "Successfully edited profile!"
        );
	} else {
        $response = array(
            "statusCode" => "400",
            "message" => "Something went wrong in editing the profile!"
        );
    }
    return $response;
}

function loginUser($pdo, $username, $password) {
    if(!checkUsernameExistence($pdo, $username)) {
		$response = array(
            "statusCode" => "400",
            "message" => "Username does not exist!"
        );
        return $response;
	}

	$applicantAccountData = getUserByUsername($pdo, $username);
    if($applicantAccountData['statusCode'] == "400") {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get user " . $username . "!"
        );
        return $response;
    } else {
        $applicantAccountData = $applicantAccountData['querySet'];
    }

	if(password_verify($password, $applicantAccountData['user_password'])) {
		$_SESSION['user_id'] = $applicantAccountData['user_id'];
        $_SESSION['user_role'] = getUserByID($pdo, $applicantAccountData['user_id'])['querySet']['user_role'];
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
            "message" => "Failed to get user #" . $user_id . "!"
        );
    }
    return $response;
}

function getUserByUsername($pdo, $username) {
    $query = "SELECT * FROM user_accounts WHERE username = ?";

	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$username]);
	
    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetch()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get user " . $username . "!"
        );
    }
    return $response;
}

function addJobPost($pdo, $job_title, $job_desc) {
    $query = "INSERT INTO job_posts (poster_id, job_title, job_desc) VALUES (?, ?, ?)";
    $statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$_SESSION['user_id'], $job_title, $job_desc]);
    
    if ($executeQuery) {
		$response = array(
            "statusCode" => "200",
            "message" => "Successfully posted job!"
        );
	} else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to post job!"
        );
    }
    return $response;
}

function editJobPost($pdo, $job_title, $job_desc, $post_id) {
    $query = "UPDATE job_posts
            SET job_title = ?,
                job_desc = ?
            WHERE post_id = ?";
    $statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$job_title, $job_desc, $post_id]);
    
    if ($executeQuery) {
		$response = array(
            "statusCode" => "200",
            "message" => "Successfully edited job post!"
        );
	} else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to edit job post!"
        );
    }
    return $response;
}

function deleteJobPost($pdo, $post_id) {
    $query = "DELETE FROM job_posts WHERE post_id = ?";
    $statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$post_id]);
    
    if ($executeQuery) {
		$response = array(
            "statusCode" => "200",
            "message" => "Successfully deleted job post!"
        );
	} else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to delete job post!"
        );
    }
    return $response;
}

function getAllJobPosts($pdo) {
    $query = "SELECT * FROM job_posts";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute();

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetchAll()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get all job posts!"
        );
    }
    return $response;
}

function getAllJobPostsByRecruiterID($pdo, $recruiter_id) {
    $query = "SELECT * FROM job_posts WHERE poster_id = ?";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$recruiter_id]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetchAll()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get all job posts by recruiter #" . $recruiter_id . "!"
        );
    }
    return $response;
}

function getJobPostByID($pdo, $post_id) {
    $query = "SELECT * FROM job_posts WHERE post_id = ?";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$post_id]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetch()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get job post #" . $post_id . "!"
        );
    }
    return $response;
}

function addApplication($pdo, $post_id, $cover_letter, $attachment) {
    $query = "INSERT INTO applications (applicant_id, post_id, cover_letter, attachment, application_status) VALUES (?, ?, ?, ?, ?)";
    $statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$_SESSION['user_id'], $post_id, $cover_letter, $attachment, "Pending"]);
    
    if ($executeQuery) {
		$response = array(
            "statusCode" => "200",
            "message" => "Successfully sent application!"
        );
	} else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to send application!"
        );
    }
    return $response;
}

function editApplicationByID($pdo, $application_status, $application_id) {
    $query = "UPDATE applications
            SET application_status = ?
            WHERE application_id = ?";
    $statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$application_status, $application_id]);
    
    if ($executeQuery) {
		$response = array(
            "statusCode" => "200",
            "message" => "Successfully edited application!"
        );
	} else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to edit application!"
        );
    }
    return $response;
}

function getApplicationByID($pdo, $application_id) {
    $query = "SELECT * FROM applications WHERE application_id = ?";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$application_id]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetch()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get application #" . $applicant_id . "!"
        );
    }
    return $response;
}

function getApplicationsByPostID($pdo, $post_id) {
    $query = "SELECT * FROM applications WHERE post_id = ?";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$post_id]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetchAll()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get all applications from job post #" . $post_id . "!"
        );
    }
    return $response;
}

function countApplicationsByPostID($pdo, $post_id) {
    $query = "SELECT COUNT(*) AS applicationCount FROM applications WHERE post_id = ?";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$post_id]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetch()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get application count from job post #" . $post_id . "!"
        );
    }
    return $response;
}

function getApplicationsByApplicantID($pdo, $applicant_id) {
    $query = "SELECT * FROM applications WHERE applicant_id = ?";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$applicant_id]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetchAll()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get all applications from applicant #" . $applicant_id . "!"
        );
    }
    return $response;
}

function sendMessage($pdo, $application_id, $sender_id, $message_content) {
    $query = "INSERT INTO messages (application_id, sender_id, message_content) VALUES (?, ?, ?)";
    $statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$application_id, $sender_id, $message_content]);
    
    if ($executeQuery) {
		$response = array(
            "statusCode" => "200",
            "message" => "Message sent succesfully!"
        );
	} else {
        $response = array(
            "statusCode" => "400",
            "message" => "Message failed to send!"
        );
    }
    return $response;
}

function getMessagesByApplicationID($pdo, $application_id) {
    $query = "SELECT * FROM messages WHERE application_id = ?";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$application_id]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetchAll()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get all messages from application #" . $application_id . "!"
        );
    }
    return $response;
}

function countMessagesByApplicationID($pdo, $application_id) {
    $query = "SELECT COUNT(*) AS messageCount FROM messages WHERE application_id = ?";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$application_id]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetch()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get messages count from application #" . $application_id . "!"
        );
    }
    return $response;
}

function getAcceptedApplicationsByPostID($pdo, $post_id) {
    $query = "SELECT * FROM applications WHERE post_id = ? AND application_status = 'Accepted'";

    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$post_id]);

    if($executeQuery) {
        $response = array(
            "statusCode" => "200",
            "querySet" => $statement -> fetchAll()
        );
    } else {
        $response = array(
            "statusCode" => "400",
            "message" => "Failed to get all accepted applications from job post #" . $post_id . "!"
        );
    }
    return $response;
}

?>