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

        <?php if (isset($_SESSION['message'])) { ?>
            <h3 style="color: red;">	
                <?php echo $_SESSION['message']; ?>
            </h3>
	    <?php } unset($_SESSION['message']); ?>

        <hr style="width: 99%; height: 2px; color: black; background-color: black; text-align: center;">

        <input type="submit" value="Return home" onclick="window.location.href='index.php';">

        <?php $jobPostData = getJobPostByID($pdo, $_GET['post_id'])['querySet']; ?>
        <h2>Job Title: <?php echo $jobPostData['job_title']?></h2>
        <p><b>Job Description:</b> <br><?php echo $jobPostData['job_desc']?></p>

        <hr style="width: 99%; height: 2px; color: black; background-color: black; text-align: center;">

        <?php if($_SESSION['user_role'] == "Applicant") { ?>
            <input type="submit" value="Apply to this job" onclick="window.location.href='sendApplication.php?post_id=<?php echo $_GET['post_id']; ?>';">
        <?php } ?>

        <table>
            <tr>
                <th colspan="4", style="font-size: 18px;">Applicants</th>
            </tr>

            <tr>
                <th>Application ID</th>
                <th>Applicant Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php
            $applicationsData = getApplicationsByPostID($pdo, $_GET['post_id'])['querySet'];
            foreach($applicationsData as $row) {
                $applicantData = getUserByID($pdo, $row['applicant_id'])['querySet'];
            ?>
                <tr>
                    <td><?php echo $row['application_id']?></td>
                    <td><?php echo $applicantData['first_name'] . ' ' . $applicantData['last_name']?></td>
                    <td><?php echo $row['application_status']?></td>
                    <td>
                        <?php $messageCount = countMessagesByApplicationID($pdo, $row['application_id'])['querySet']?>
                        <input type="submit" value="View Application (<?php echo $messageCount['messageCount']?> Messages)" onclick="window.location.href='viewApplication.php?post_id=<?php echo $_GET['post_id']?>&application_id=<?php echo $row['application_id']; ?>';">
                    </td>
                </tr>
            <?php 
            }
            ?>
        </table>
    </body>
</html>