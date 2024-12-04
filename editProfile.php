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
        <h2>Welcome to FindHire! Edit your profile below!</h2>

        <?php if (isset($_SESSION['message'])) { ?>
		    <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
	    <?php } unset($_SESSION['message']); ?>

        <?php $profileData = getUserByID($pdo, $_SESSION['user_id'])['querySet'] ?>
        <form action="core/handleForms.php" method="POST">
            <label for="first_name">First name</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo $profileData['first_name']?>" required>

            <label for="last_name">Last name</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo $profileData['last_name']?>" required> <br>

            <label for="age">Age</label>
            <input type="number" name="age" id="age" min="0" value="<?php echo $profileData['age']?>" required>

            <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" min="1970-01-01" max="2024-12-31" value="<?php echo $profileData['birthdate']?>" required>

            <label for="email_address">Email Address</label>
            <input type="email" name="email_address" id="email_address" placeholder="example@email.com" value="<?php echo $profileData['email_address']?>" required> <br>

            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" id="phone_number" pattern="[0-9]{11}" placeholder="09########" value="<?php echo $profileData['phone_number']?>" required>

            <label for="home_address">Home Address</label>
            <input type="text" name="home_address" id="home_address" placeholder="Block 1 Lot 10 Phase 2, Example Street, Sample Village, Ergo Town, The City" value="<?php echo $profileData['home_address']?>" required> <br>

            <input type="submit" name="editProfileButton" value="Edit profile">
        </form>
        <input type="submit" value="Return to profile" onclick="window.location.href='viewProfile.php'">
    </body>
</html>