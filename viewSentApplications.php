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
        <input type="submit" value="Return home" onclick="window.location.href='index.php';">

        <hr style="width: 99%; height: 2px; color: black; background-color: black; text-align: center;">

        <table>
            <tr>
                <th colspan="5", style="font-size: 18px;">Your Application History</th>
            </tr>

            <tr>
                <th>Application ID</th>
                <th>Job Post</th>
                <th>Attachment</th>
                <th>Status</th>
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
                    <td><?php echo $row['attachment']?></td>
                    <td><?php echo $row['application_status']?></td>
                    <td>
                        <input type="submit" value="View Application" onclick="window.location.href='viewApplication.php?post_id=<?php echo $row['post_id']?>&application_id=<?php echo $row['application_id']; ?>';">
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </body>
</html>