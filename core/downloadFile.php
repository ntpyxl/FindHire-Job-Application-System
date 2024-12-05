<?php 
require_once "dbConfig.php";
require_once "functions.php";

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

?>