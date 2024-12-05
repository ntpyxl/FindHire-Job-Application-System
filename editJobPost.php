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

        Hey <?php echo getUserByID($pdo, $_SESSION['user_id'])['querySet']['first_name']?>! Edit your job post in the form below! <br>

        <?php $jobPostData = getJobPostByID($pdo, $_GET['post_id'])['querySet']?>
        <form action="core/handleForms.php?post_id=<?php echo $_GET['post_id']?>" method="POST">
            <div class="leftColumn">
                <div class="formRow">
                    <div class="col-30"><label for="job_title">Job title</label></div>
                    <div class="col-70"><input type="text" name="job_title" value="<?php echo $jobPostData['job_title']?>" required></div>
                </div>
            </div>

            <br><br><br>

            <div class="leftColumn">
                <div class="formRow">
                    <div class="col-30"><label for="job_desc">Job description</label></div>
                    <div class="col-70"><textarea name="job_desc" rows="20" cols="70" required><?php echo $jobPostData['job_desc']?></textarea></div>
                </div>
            </div>

            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

            <input type="submit" name="editJobPostButton" value="Edit job post">
        </form>
    </body>
</html>