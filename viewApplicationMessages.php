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
        <input type="submit" value="Return" onclick="window.location.href='viewApplication.php?post_id=<?php echo $_GET['post_id']?>&application_id=<?php echo $_GET['application_id']; ?>';">

        <hr style="width: 99%; height: 2px; color: black; background-color: black; text-align: center;">

        <?php $jobPostData = getJobPostByID($pdo, $_GET['post_id'])['querySet']?>
        <h2>Job Title: <?php echo $jobPostData['job_title']?></h2>

        <hr style="width: 99%; height: 2px; color: black; background-color: black; text-align: center;">

        <h2>Messages</h2>
        
        
        <form action="core/handleForms.php" method="POST">
            <textarea name="message" rows="4" cols="50" required></textarea> <br>
            <input type="submit" name="sendMessageButton" value="Send Message">
        </form>
    </body>
</html>