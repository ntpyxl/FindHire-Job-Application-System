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

        <?php $jobPostData = getJobPostByID($pdo, $_GET['post_id'])['querySet']; ?>
        <h2>Job Title: <?php echo $jobPostData['job_title']?></h2>
        <div class="jobDescBox">
            <p><b>Job Description:</b> <br><?php echo $jobPostData['job_desc']?></p>
        </div>

        <?php if($_SESSION['user_role'] == "Applicant") { ?>
            <input type="submit" value="Apply to this job" onclick="window.location.href='sendApplication.php?post_id=<?php echo $_GET['post_id']; ?>';">
        <?php } ?>

        <table>
            <tr>
                <th colspan="4", style="font-size: 18px;">Applicants</th>
            </tr>

            <tr class="tableHeader">
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
                    <td class="application_<?php echo $row['application_status']?>">
                        <?php echo $row['application_status']?>
                    </td>
                    <td>
                        <?php $messageCount = countMessagesByApplicationID($pdo, $row['application_id'])['querySet']?>
                        <input type="submit" value="View Application (<?php echo $messageCount['messageCount']?> Messages)" onclick="window.location.href='viewApplication.php?post_id=<?php echo $_GET['post_id']?>&application_id=<?php echo $row['application_id']; ?>&return_to=viewJobPost';">
                    </td>
                </tr>
            <?php 
            }
            ?>
        </table>

        <?php if($_SESSION['user_role'] == "HR") {?>
            <table>
                <tr>
                    <th colspan="4", style="font-size: 18px;">Hired Applicants</th>
                </tr>

                <tr class="tableHeader">
                    <th>Application ID</th>
                    <th>Applicant Name</th>
                </tr>

                <?php
                $acceptedApplicantsData = getAcceptedApplicationsByPostID($pdo, $_GET['post_id'])['querySet'];
                foreach($acceptedApplicantsData as $row) {
                    $applicantData = getUserByID($pdo, $row['applicant_id'])['querySet'];
                ?>
                    <tr>
                        <td><?php echo $row['application_id']?></td>
                        <td><?php echo $applicantData['first_name'] . ' ' . $applicantData['last_name']?></td>
                    </tr>
        <?php 
            }
        }
        ?>
        </table>
    </body>
</html>