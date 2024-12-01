<?php 
require_once "core/dbConfig.php";
require_once "core/functions.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
if($_SESSION['user_role'] == "HR") {
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

        Hello <?php echo getUserByID($pdo, $_SESSION['user_id'])['querySet']['first_name']?>! Would you like to submit your application to this job post?

        <?php if (isset($_SESSION['message'])) { ?>
            <h3 style="color: red;">	
                <?php echo $_SESSION['message']; ?>
            </h3>
	    <?php } unset($_SESSION['message']); ?>

        <hr style="width: 99%; height: 2px; color: black; background-color: black; text-align: center;">

        <input type="submit" value="Return" onclick="window.location.href='viewJobPost.php?post_id=<?php echo $_GET['post_id']; ?>';">

        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
            <label for="cover_letter">Cover letter</label>
            <textarea name="cover_letter" rows="4" cols="50" required></textarea> <br>

            <label for="attachment">Attachment</label>
            <input type="file" name="attachment"> <br>
            
            <input type="hidden" name="post_id" value="<?php echo $_GET['post_id']?>" />

            <input type="submit" name="sendApplicationButton">
        </form>
    </body>
</html>