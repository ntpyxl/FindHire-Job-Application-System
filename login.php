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
        Log in to your account below!
        <br>

        <?php if (isset($_SESSION['message'])) { ?>
            <h3 style="color: red;">	
                <?php echo $_SESSION['message']; ?>
            </h3>
	    <?php } unset($_SESSION['message']); ?>

        <form action="core/handleForms.php" method="POST" style="width: 400px;">
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

             <br><br><br>
                
            <input type="submit" name="loginButton" value="Log in">
        </form>

        <br>

        <input type="submit" name="registerButton" value="Register" onclick="window.location.href='register.php'">
    </body>
</html>