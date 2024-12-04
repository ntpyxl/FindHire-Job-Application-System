<?php
require_once "dbConfig.php";
require_once "functions.php";

$function = editApplicationByID($pdo, $_GET['status'], $_GET['application_id']);
if($function['statusCode'] == "200"){
    $_SESSION['message'] = $function['message'];
    header("Location: ../viewJobPost.php?post_id=" . $_GET['post_id']);
} elseif($function['statusCode'] == "400") {
    $_SESSION['message'] = "Error " . $function['statusCode'] . ": " . $function['message'];
    header('Location: ../viewApplication.php?post_id=' . $_GET['post_id'] . '&application_id=' . $_GET['$application_id']);
}

?>