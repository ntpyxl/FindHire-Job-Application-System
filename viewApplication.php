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

            <?php if($_GET['return_to'] == "viewJobPost") {?>
                <input type="submit" value="Return" onclick="window.location.href='viewJobPost.php?post_id=<?php echo $_GET['post_id'] ?>';">
            <?php
            } if($_GET['return_to'] == "viewSentApplications") {?>
                <input type="submit" value="Return" onclick="window.location.href='viewSentApplications.php';">
            <?php
            }
            ?>

            <?php $messageCount = countMessagesByApplicationID($pdo, $_GET['application_id'])['querySet']?>
            <input type="submit" value="Message (<?php echo $messageCount['messageCount']?> Messages)" onclick="window.location.href='viewApplicationMessages.php?post_id=<?php echo $_GET['post_id']?>&application_id=<?php echo $_GET['application_id']?>&return_to=<?php echo $_GET['return_to']?>';">

            <?php if (isset($_SESSION['message'])) { ?>
                <h3 style="color: #703410; margin: 0px 0px 0px 12px ">	
                    <?php echo $_SESSION['message']; ?>
                </h3>
	        <?php } unset($_SESSION['message']); ?>
        </div>

        <hr>

        <?php $jobPostData = getJobPostByID($pdo, $_GET['post_id'])['querySet']?>
        <h2>Job Title: <?php echo $jobPostData['job_title']?></h2>
        <div class="jobDescBox">
            <p><b>Job Description:</b> <br><?php echo $jobPostData['job_desc']?></p>
        </div>

        <div class="applicationDetailsBox">
            <div class="applicationDetailsHeader">
                <h3>Application Details</h3>

                <span style="padding: 0px 0px 0px 20px;">
                    <?php
                    $applicationData = getApplicationByID($pdo, $_GET['application_id'])['querySet'];
                    if($_SESSION['user_role'] == "HR") {
                        if($applicationData['application_status'] != "Pending") {
                    ?>
                            <input type="submit" value="Repend application" onclick="window.location.href='core/editApplicationStatus.php?post_id=<?php echo $_GET['post_id']?>&application_id=<?php echo $_GET['application_id']?>&status=Pending';">
                        <?php
                        } if($applicationData['application_status'] != "Accepted") {
                        ?>
                            <input type="submit" value="Accept application" onclick="window.location.href='core/editApplicationStatus.php?post_id=<?php echo $_GET['post_id']?>&application_id=<?php echo $_GET['application_id']?>&status=Accepted';">
                        <?php
                        } if($applicationData['application_status'] != "Rejected") {
                        ?>
                            <input type="submit" value="Reject application" onclick="window.location.href='core/editApplicationStatus.php?post_id=<?php echo $_GET['post_id']?>&application_id=<?php echo $_GET['application_id']?>&status=Rejected';">
                    <?php
                        }
                    }
                    ?>
                </span>

                <span style="padding: 0px 0px 0px 24px;">
                    <input type="submit" value="Download attachment" onclick="window.location.href='core/downloadFile.php?post_id=<?php echo $_GET['post_id']?>&application_id=<?php echo $_GET['application_id']?>';">
                </span>
            </div>

            <?php $applicantData = getUserByID($pdo, $applicationData['applicant_id'])['querySet']?>
    
            <span style="padding: 0px 12px;">
                <b>Applicant:</b>
                <?php echo $applicantData['first_name'] . ' ' . $applicantData['last_name']?> <br>
            </span>
            
            <div class="applicationCoverLetterBox">
                <p><b>Cover Letter:</b> <br>
                <?php echo $applicationData['cover_letter']?></p>
            </div>
        </div>

    </body>
</html>