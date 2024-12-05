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

            <input type="submit" value="Return to your profile" onclick="window.location.href='viewProfile.php'">

            <?php if (isset($_SESSION['message'])) { ?>
                <h3 style="color: #703410; margin: 0px 0px 0px 12px ">	
                    <?php echo $_SESSION['message']; ?>
                </h3>
	        <?php } unset($_SESSION['message']); ?>
        </div>

        <hr>

        <?php $profileData = getUserByID($pdo, $_SESSION['user_id'])['querySet'] ?>
        <form action="core/handleForms.php" method="POST">
            <div class="leftColumn">
                <div class="formRow">
                    <div class="col-30"><label for="first_name">First name</label></div>
                    <div class="col-70"><input type="text" name="first_name" id="first_name" value="<?php echo $profileData['first_name']?>" required></div>
                </div>
            </div>

            <div class="rightColumn">
                <div class="formRow">
                    <div class="col-30"><label for="last_name">Last name</label></div>
                    <div class="col-70"><input type="text" name="last_name" id="last_name" value="<?php echo $profileData['last_name']?>" required></div>
                </div>
            </div>

            <br><br><br>

            <div class="leftColumn">
                <div class="formRow">
                    <div class="col-30"><label for="age">Age</label></div>
                    <div class="col-70"><input type="number" name="age" id="age" min="0" value="<?php echo $profileData['age']?>" required></div>
                </div>
            </div>

            <div class="rightColumn">
                <div class="formRow">
                    <div class="col-30"><label for="birthdate">Birthdate</label></div>
                    <div class="col-70"><input type="date" name="birthdate" id="birthdate" min="1970-01-01" max="2024-12-31" value="<?php echo $profileData['birthdate']?>" required></div>
                </div>
            </div>

            <br><br><br>

            <div class="leftColumn">
                <div class="formRow">
                    <div class="col-30"><label for="email_address">Email Address</label></div>
                    <div class="col-70"><input type="email" name="email_address" id="email_address" placeholder="example@email.com" value="<?php echo $profileData['email_address']?>" required></div>
                </div>
            </div>

            <div class="rightColumn">
                <div class="formRow">
                    <div class="col-30"><label for="phone_number">Phone Number</label></div>
                    <div class="col-70"><input type="tel" name="phone_number" id="phone_number" pattern="[0-9]{11}" placeholder="09########" value="<?php echo $profileData['phone_number']?>" required></div>
                </div>
            </div>

            <br><br><br>

            <div class="bigColumn">
                <div class="formRow">
                    <span style="width: 120px; text-align: right;"><label for="home_address">Home Address</label></span>
                    <input type="text" name="home_address" id="home_address" placeholder="Block 1 Lot 10 Phase 2, Example Street, Sample Village, Ergo Town, The City" value="<?php echo $profileData['home_address']?>" required>
                </div>
            </div>

            <br><br><br>

            <input type="submit" name="editProfileButton" value="Edit profile">
        </form>
    </body>
</html>