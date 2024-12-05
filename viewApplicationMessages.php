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
        <div class="navBar">
            <div class="logo">
                <h2 style="text-align: center;">FIND HIRE</h2>
            </div>

            <input type="submit" value="Return" onclick="window.location.href='viewApplication.php?post_id=<?php echo $_GET['post_id']?>&application_id=<?php echo $_GET['application_id']; ?>&return_to=<?php echo $_GET['return_to']?>';">

            <?php if (isset($_SESSION['message'])) { ?>
                <h3 style="color: #703410; margin: 0px 0px 0px 12px ">	
                    <?php echo $_SESSION['message']; ?>
                </h3>
	        <?php } unset($_SESSION['message']); ?>
        </div>

        <hr>

        <?php $jobPostData = getJobPostByID($pdo, $_GET['post_id'])['querySet']?>
        <h2>Job Title: <?php echo $jobPostData['job_title']?></h2>


        <div class="messageBox">
            <h2>Messages</h2>
            <div class="scrollableMessageBox">
                <?php
                $applicationMessagesData = getMessagesByApplicationID($pdo, $_GET['application_id'])['querySet'];
                foreach($applicationMessagesData as $row) {
                    $userData = getUserByID($pdo, $row['sender_id'])['querySet'];
                ?>
                    <div style="border-style: solid; width: 600px; margin: 4px 0px; padding: 8px; <?php if($_SESSION['user_id'] == $userData['user_id']) {echo "background-color: #b0f4ff;";} else {echo "background-color: #f5f5dc;";}?>">
                        <?php echo $userData['first_name'] . ' ' . $userData['last_name']?> 
                        <b><?php
                            if($userData['user_role'] == "HR") {
                                echo "(HR)";
                            }
                            if($userData['user_role'] == "Applicant") {
                                echo "(Applicant)";
                            }
                        ?></b> <br>
                        <?php echo $row['date_sent']?> <br><br>
                        <?php echo $row['message_content']?>
                    </div>
                    <?php
                    }
                    ?>
                </div>

            
        </div>

        <div class="sendMessageBox">
            <form action="core/handleForms.php" method="POST" style="all: unset;">
                <textarea name="message" rows="4" cols="82" placeholder="Type your message here" required></textarea> <br>
                <input type="hidden" name="post_id" value="<?php echo $_GET['post_id']?>">
                <input type="hidden" name="application_id" value="<?php echo $_GET['application_id']?>">
                <input type="hidden" name="return_to" value="<?php echo $_GET['return_to']?>">
                <input type="hidden" name="sender_id" value="<?php echo $_SESSION['user_id']?>">
                <input type="submit" name="sendMessageButton" value="Send Message">
            </form>
        </div>
    </body>
</html>