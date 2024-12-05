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

            <input type="submit" value="Return home" onclick="window.location.href='index.php';">

            <?php if (isset($_SESSION['message'])) { ?>
                <h3 style="color: #703410; margin: 0px 0px 0px 12px ">	
                    <?php echo $_SESSION['message']; ?>
                </h3>
	        <?php } unset($_SESSION['message']); ?>
        </div>

        <hr>

        <table>
            <tr>
                <th colspan="6", style="font-size: 18px;">Your Application History</th>
            </tr>

            <tr class="tableHeader">
                <th>Application ID</th>
                <th>Job Post</th>
                <th>Status</th>
                <th>Date Sent</th>
                <th>Actions</th>
            </tr>

            <?php
            $applicationsData = getApplicationsByApplicantID($pdo, $_SESSION['user_id'])['querySet'];
            foreach($applicationsData as $row) {
                $jobPostData = getJobPostByID($pdo, $row['post_id'])['querySet'];
            ?>
                <tr>
                    <td><?php echo $row['application_id']?></td>
                    <td><?php echo $jobPostData['job_title']?></td>
                    <td class="application_<?php echo $row['application_status']?>">
                        <?php echo $row['application_status']?>
                    </td>
                    <td><?php echo $row['date_sent']?></td>
                    <td>
                        <?php $messageCount = countMessagesByApplicationID($pdo, $row['application_id'])['querySet']?>
                        <input type="submit" value="View Application (<?php echo $messageCount['messageCount']?> Messages)" onclick="window.location.href='viewApplication.php?post_id=<?php echo $row['post_id']?>&application_id=<?php echo $row['application_id'];?>&return_to=viewSentApplications';">
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </body>
</html>