<?php 
require_once "core/dbConfig.php";
require_once "core/functions.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
if($_SESSION['user_role'] == "Applicant") {
    header("Location: index.php");
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

        Hello <?php echo getUserByID($pdo, $_SESSION['user_id'])['querySet']['first_name']?>! Are you sure you want to delete this job post along with its submitted applications?

        <table>
            <tr>
                <th colspan="4", style="font-size: 18px;">Job Post</th>
            </tr>

            <tr class="tableHeader">
                <th>Post ID</th>
                <th>Recruiter</th>
                <th>Job Title</th>
                <th>Date Posted</th>
            </tr>

            <?php
            $jobPostData = getJobPostByID($pdo, $_GET['post_id'])['querySet'];
            $recruiterData = getUserByID($pdo, $jobPostData['poster_id'])['querySet'];
            ?>
            <tr>
                <td><?php echo $jobPostData['post_id']?></td>
                <td><?php echo $recruiterData['first_name'] . ' ' . $recruiterData['last_name']?></td>
                <td><?php echo $jobPostData['job_title']?></td>
                <td><?php echo $jobPostData['date_posted']?></td>
            </tr>
        </table>

        <form action="core/handleForms.php?post_id=<?php echo $_GET['post_id']?>" method="POST" style="all: unset;">
            <input type="submit" name="deleteJobPostButton" value="Delete job post">
        </form>
    </body>
</html>