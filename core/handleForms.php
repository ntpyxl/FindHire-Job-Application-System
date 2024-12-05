<?php 
require_once "dbConfig.php";
require_once "functions.php";

if(isset($_POST['registerButton'])) {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $age = $_POST['age']
    $birthdate = $_POST['birthdate']
    $email_address = $_POST['email_address']
    $phone_number = $_POST['phone_number']
    $home_address = $_POST['home_address']

    $function = addUser($pdo, $username, $password, $confirm_password, $hashed_password, $first_name, $last_name, $age, $birthdate, $email_address, $phone_number, $home_address);
    if($function['statusCode'] == "200") {
        $_SESSION['message'] = $function['message'];
        header('Location: ../login.php');
    } elseif($function['statusCode'] == "400") {
        $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../register.php');
    }
}

if(isset($_POST['editProfileButton'])) {
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $age = $_POST['age'];
    $birthdate = $_POST['birthdate'];
    $email_address = $_POST['email_address'];
    $phone_number = $_POST['phone_number'];
    $home_address = $_POST['home_address'];
    $user_id = $_SESSION['user_id'];

    $function = editProfile($pdo, $first_name, $last_name, $age, $birthdate, $email_address, $phone_number, $home_address, $user_id);
    if($function['statusCode'] == "200") {
        $_SESSION['message'] = $function['message'];
        header('Location: ../viewProfile.php');
    } elseif($function['statusCode'] == "400") {
        $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../editProfile.php');
    }
}

if(isset($_POST['loginButton'])) {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    $function = loginUser($pdo, $username, $password);
    if($function['statusCode'] == "200"){
        $_SESSION['message'] = $function['message'];
        header("Location: ../index.php");
    } elseif($function['statusCode'] == "400") {
        $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../login.php');
    }
}

if(isset($_POST['addJobPostButton'])) {
    $job_title = sanitizeInput($_POST['job_title']);
    $job_desc = sanitizeInput($_POST['job_desc']);

    $function = addJobPost($pdo, $job_title, $job_desc);
    if($function['statusCode'] == "200"){
        $_SESSION['message'] = $function['message'];
        header("Location: ../index.php");
    } elseif($function['statusCode'] == "400") {
        $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../addJobPost.php');
    }
}

if(isset($_POST['editJobPostButton'])) {
    $job_title = sanitizeInput($_POST['job_title']);
    $job_desc = sanitizeInput($_POST['job_desc']);

    $function = editJobPost($pdo, $job_title, $job_desc, $_GET['post_id']);
    if($function['statusCode'] == "200"){
        $_SESSION['message'] = $function['message'];
        header("Location: ../index.php");
    } elseif($function['statusCode'] == "400") {
        $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../editJobPost.php?post_id=' . $post_id);
    }
}

if(isset($_POST['deleteJobPostButton'])) {
    $function = deleteJobPost($pdo, $_GET['post_id']);
    if($function['statusCode'] == "200"){
        $_SESSION['message'] = $function['message'];
        header("Location: ../index.php");
    } elseif($function['statusCode'] == "400") {
        $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../addJobPost.php?post_id=' . $post_id);
    }
}

if(isset($_POST['sendApplicationButton'])) {
    $cover_letter = sanitizeInput($_POST['cover_letter']);
    $attachment = $_FILES['attachment'];
    $post_id = $_POST['post_id'];

    $unique_id = sha1(md5(rand(1,9999999))) . "." . pathinfo($attachment['name'], PATHINFO_EXTENSION);
    $target_directory = "../resumes/job_post_" . $post_id;
    $target_file = $target_directory . "/" . $unique_id;

    $function = addApplication($pdo, $post_id, $cover_letter, $unique_id);
    if($function['statusCode'] == "200"){
        $_SESSION['message'] = $function['message'];
        header("Location: ../index.php");
    } elseif($function['statusCode'] == "400") {
        $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../sendApplication.php?post_id=' . $post_id);
    }

    if(!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true);
    }

    if(move_uploaded_file($attachment['tmp_name'], $target_file)) {
        header("Location: ../viewJobPost.php?post_id=" . $post_id);
    } else {
        $_SESSION['message'] = "FILE UPLOAD FAILED";
    }
}

if(isset($_POST['sendMessageButton'])) {
    $post_id = $_POST['post_id'];
    $application_id = $_POST['application_id'];
    $return_to = $_POST['return_to'];
    $sender_id = $_POST['sender_id'];
    $message_content = sanitizeInput($_POST['message']);

    $function = sendMessage($pdo, $application_id, $sender_id, $message_content);
    if($function['statusCode'] == "200") {
        $_SESSION['message'] = $function['message'];
        header('Location: ../viewApplicationMessages.php?post_id=' . $post_id . '&application_id=' . $application_id . '&return_to=' . $return_to);
    } elseif($function['statusCode'] == "400") {
        $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../viewApplicationMessages.php?post_id=' . $post_id . '&application_id=' . $application_id . '&return_to=' . $return_to);
    }
}

if(isset($_POST['downloadAttachmentButton'])) {
    $filename = getApplicationByID($pdo, $_GET['application_id'])['querySet']['attachment'];
    $filepath = "../resumes/job_post_" . $_GET['post_id'] . "/" . $filename;

    if(file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        
        ob_clean();
        flush();

        readfile($filepath);
        exit;
    } else {
        echo "File not found";
    }
}

?>