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
        
        <input type="submit" value="View profile" onclick="window.location.href='viewProfile.php';">
        <?php if($_SESSION['user_role'] == "HR") { ?>
            <input type="submit" value="Post a new job" onclick="window.location.href='addJobPost.php';">
            <input type="submit" value="View posted jobs" onclick="window.location.href='viewPostedJobs.php';">
        <?php }
        if($_SESSION['user_role'] == "Applicant") { ?>
            <input type="submit" value="View applications" onclick="window.location.href='viewSentApplications.php';">
        <?php } ?>
        <input type="submit" value="Logout" onclick="window.location.href='core/logout.php';">

        <?php if (isset($_SESSION['message'])) { ?>
            <h3 style="color: red;">	
                <?php echo $_SESSION['message']; ?>
            </h3>
	    <?php } unset($_SESSION['message']); ?>

        <hr style="width: 99%; height: 2px; color: black; background-color: black; text-align: center;">

        <table>
            <tr>
                <th colspan="5", style="font-size: 18px;">Job Posts</th>
            </tr>

            <tr>
                <th>Post ID</th>
                <th>Recruiter</th>
                <th>Job Title</th>
                <th>Date Posted</th>
                <th>Actions</th>
            </tr>

            <?php
            $jobPostsData = getAllJobPosts($pdo)['querySet'];
            foreach($jobPostsData as $row) {
                $recruiterData = getUserByID($pdo, $row['poster_id'])['querySet'];
            ?>
                <tr>
                    <td><?php echo $row['post_id']?></td>
                    <td><?php echo $recruiterData['first_name'] . ' ' . $recruiterData['last_name']?></td>
                    <td><?php echo $row['job_title']?></td>
                    <td><?php echo $row['date_posted']?></td>
                    <td>
                        <?php $applicationCount = countApplicationsByPostID($pdo, $row['post_id'])['querySet']?>
                        <input type="submit" value="View Post (<?php echo $applicationCount['applicationCount']?> applications)" onclick="window.location.href='viewJobPost.php?post_id=<?php echo $row['post_id']; ?>';">
                        <?php if($_SESSION['user_role'] == "HR") { ?>
                            <input type="submit" value="Edit Post" onclick="window.location.href='editJobPost.php?post_id=<?php echo $row['post_id']; ?>';">
                            <input type="submit" value="Delete Post" onclick="window.location.href='deleteJobPost.php?post_id=<?php echo $row['post_id']; ?>';">
                        <?php } ?>
                    </td>
                </tr>
            <?php 
            }
            ?>
        </table>
    </body>
</html>