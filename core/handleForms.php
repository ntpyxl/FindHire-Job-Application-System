<?php 
require_once "dbConfig.php";
require_once "functions.php";

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
?>