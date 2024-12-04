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
        <h2>Welcome to FindHire! Register your account below!</h2>

        <?php if (isset($_SESSION['message'])) { ?>
		    <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
	    <?php } unset($_SESSION['message']); ?>

        <form action="core/handleForms.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" required> 
            
            <label for="confirm_password">Confirm password</label>
            <input type="password" name="confirm_password" required> <br><br>

            <hr style="width: 99%; height: 2px; color: black; background-color: black;">

            <label for="first_name">First name</label>
            <input type="text" name="first_name" id="first_name" required>

            <label for="last_name">Last name</label>
            <input type="text" name="last_name" id="last_name" required> <br>

            <label for="age">Age</label>
            <input type="number" name="age" id="age" min="0" required>

            <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" min="1970-01-01" max="2024-12-31" required>

            <label for="email_address">Email Address</label>
            <input type="email" name="email_address" id="email_address" placeholder="example@email.com" required> <br>

            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" id="phone_number" pattern="[0-9]{11}" placeholder="09########" required>

            <label for="home_address">Home Address</label>
            <input type="text" name="home_address" id="home_address" placeholder="Block 1 Lot 10 Phase 2, Example Street, Sample Village, Ergo Town, The City" required> <br>

            <input type="submit" name="registerButton" value="Register account">
        </form>
        <button type="button" onclick="window.location.href='login.php'">Return to login</button>
    </body>
</html>