<?php 
require_once "core/dbConfig.php";
require_once "core/functions.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
?>

<html>
    <head>
        <title>FindHire</title>
        <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <h2 style="text-align: center;">FIND HIRE</h2>

        Welcome <?php echo getUserByID($pdo, $_SESSION['user_id'])['querySet']['first_name']?> to FindHire! 

        <?php if (isset($_SESSION['message'])) { ?>
            <h3 style="color: red;">	
                <?php echo $_SESSION['message']; ?>
            </h3>
	    <?php } unset($_SESSION['message']); ?>

        <br>
        <?php $messageCount = getMessagesCountByApplicationID($pdo, $_GET['application_id'])['querySet']?>
        <input type="submit" value="Message HR (<?php echo $messageCount['messageCount']?> Messages)" onclick="window.location.href='viewApplicationMessages.php?post_id=<?php echo $_GET['post_id']?>&application_id=<?php echo $_GET['application_id']?>';">
        <input type="submit" value="Return home" onclick="window.location.href='index.php';">

        <hr style="width: 99%; height: 2px; color: black; background-color: black; text-align: center;">

        <?php $jobPostData = getJobPostByID($pdo, $_GET['post_id'])['querySet']?>
        <h2>Job Title: <?php echo $jobPostData['job_title']?></h2>
        <p><b>Job Description:</b> <br><?php echo $jobPostData['job_desc']?></p>

        <hr style="width: 99%; height: 2px; color: black; background-color: black; text-align: center;">

        <h3>Your Application</h3>

        <?php $applicationData = getApplicationByID($pdo, $_GET['application_id'])['querySet']?>
        <p><b>Attachment:</b> <br><?php echo $applicationData['attachment']?></p>
        <p><b>Cover Letter:</b> <br><?php echo $applicationData['cover_letter']?></p>

    </body>
</html>