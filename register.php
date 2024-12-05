<?php 
require_once "core/dbConfig.php";
require_once "core/functions.php";

if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
?>

<html>
    <head>
        <title>FindHire Login Page</title>
        <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <h2>Welcome to FindHire!</h2>
        Register your account below! <br>

        <?php if (isset($_SESSION['message'])) { ?>
		    <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
	    <?php } unset($_SESSION['message']); ?>

        <form action="core/handleForms.php" method="POST">
            <div class="leftColumn">
                <div class="formRow">
                    <div class="col-30"><label for="username">Username</label></div>
                    <div class="col-70"><input type="text" name="username" required></div>
                </div>
            </div>

            <br><br><br>

            <div class="leftColumn">
                <div class="formRow">
                    <div class="col-30"><label for="password">Password</label></div>
                    <div class="col-70"><input type="password" name="password" required></div>
                </div>
            </div>

            <div class="rightColumn">
                <div class="formRow">
                    <div class="col-30"><label for="confirm_password">Confirm password</label></div>
                    <div class="col-70"><input type="password" name="confirm_password" required></div>
                </div>
            </div>

            <hr>

            <div class="leftColumn">
                <div class="formRow">
                    <div class="col-30"><label for="first_name">First name</label></div>
                    <div class="col-70"><input type="text" name="first_name" id="first_name" required></div>
                </div>
            </div>

            <div class="rightColumn">
                <div class="formRow">
                    <div class="col-30"><label for="last_name">Last name</label></div>
                    <div class="col-70"><input type="text" name="last_name" id="last_name" required></div>
                </div>
            </div>

            <br><br><br>

            <div class="leftColumn">
                <div class="formRow">
                    <div class="col-30"><label for="age">Age</label></div>
                    <div class="col-70"><input type="number" name="age" id="age" min="0" required></div>
                </div>
            </div>

            <div class="rightColumn">
                <div class="formRow">
                    <div class="col-30"><label for="birthdate">Birthdate</label></div>
                    <div class="col-70"><input type="date" name="birthdate" id="birthdate" min="1970-01-01" max="2024-12-31" required></div>
                </div>
            </div>

            <br><br><br>

            <div class="leftColumn">
                <div class="formRow">
                    <div class="col-30"><label for="email_address">Email Address</label></div>
                    <div class="col-70"><input type="email" name="email_address" id="email_address" placeholder="example@email.com" required></div>
                </div>
            </div>

            <div class="rightColumn">
                <div class="formRow">
                    <div class="col-30"><label for="phone_number">Phone Number</label></div>
                    <div class="col-70"><input type="tel" name="phone_number" id="phone_number" pattern="[0-9]{11}" placeholder="09########" required></div>
                </div>
            </div>

            <br><br><br>

            <div class="bigColumn">
                <div class="formRow">
                    <span style="width: 120px; text-align: right;"><label for="home_address">Home Address</label></span>
                    <input type="text" name="home_address" id="home_address" placeholder="Block 1 Lot 10 Phase 2, Example Street, Sample Village, Ergo Town, The City" required>
                </div>
            </div>

            <br><br><br>

            <input type="submit" name="registerButton" value="Register account">
        </form>

        <br>

        <input type="submit" value="Return to login page" onclick="window.location.href='login.php'">
    </body>
</html>