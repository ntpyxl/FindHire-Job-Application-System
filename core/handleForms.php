<?php 
require_once "dbConfig.php";
require_once "functions.php";

// TODO: ADD SANITIZE INPUT TO INPUTS !!!!!!!!!!!!!!!

if(isset($_POST['registerButton'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $birthdate = $_POST['birthdate'];
    $email_address = $_POST['email_address'];
    $phone_number = $_POST['phone_number'];
    $home_address = $_POST['home_address'];

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
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
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
    $username = $_POST['username'];
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
    $job_title = $_POST['job_title'];
    $job_desc = $_POST['job_desc'];

    $function = addJobPost($pdo, $job_title, $job_desc);
    if($function['statusCode'] == "200"){
        $_SESSION['message'] = $function['message'];
        header("Location: ../index.php");
    } elseif($function['statusCode'] == "400") {
        $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
        header('Location: ../addJobPost.php');
    }
}

if(isset($_POST['sendApplicationButton'])) {
    $cover_letter = $_POST['cover_letter'];
    $attachment = $_FILES['attachment'];
    $post_id = $_POST['post_id'];
    $target_directory = "../resumes/job_post_" . $post_id;
    $target_file = $target_directory . "/" . $attachment['name'];

    $function = addApplication($pdo, $post_id, $cover_letter, $attachment['name']);
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

?>