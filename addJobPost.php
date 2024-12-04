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
        <h2 style="text-align: center;">FIND HIRE</h2>

        Hello <?php echo getUserByID($pdo, $_SESSION['user_id'])['querySet']['first_name']?>! Would you like to add a new job post?

        <?php if (isset($_SESSION['message'])) { ?>
            <h3 style="color: red;">	
                <?php echo $_SESSION['message']; ?>
            </h3>
	    <?php } unset($_SESSION['message']); ?>

        <hr style="width: 99%; height: 2px; color: black; background-color: black; text-align: center;">

        <input type="submit" value="Return" onclick="window.location.href='index.php';">

        <form action="core/handleForms.php" method="POST">
            <label for="job_title">Job title</label>
            <input type="text" name="job_title" required> <br>

            <label for="job_desc">Job description</label>
            <textarea name="job_desc" rows="20" cols="70" required></textarea> <br>

            <input type="submit" name="addJobPostButton">
        </form>
    </body>
</html>