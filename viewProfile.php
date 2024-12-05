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

            <input type="submit" value="Edit profile" onclick="window.location.href='editProfile.php';">
            <input type="submit" value="Return home" onclick="window.location.href='index.php';">

            <?php if (isset($_SESSION['message'])) { ?>
                <h3 style="color: #703410; margin: 0px 0px 0px 12px ">	
                    <?php echo $_SESSION['message']; ?>
                </h3>
	        <?php } unset($_SESSION['message']); ?>
        </div>

        <hr>

        <table>
            <tr>
                <th colspan="9", style="font-size: 18px;">Your Profile</th>
            </tr>

            <tr class="tableHeader">
                <th>User ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Birthdate</th>
                <th>Email Address</th>
                <th>Phone Number</th>
                <th>Home Address</th>
                <th>Status</th>
                <th>Date Registered</th>
            </tr>

            <?php $profileData = getUserByID($pdo, $_SESSION['user_id'])['querySet']; ?>
            <tr>
                <td><?php echo $profileData['user_id']?></td>
                <td><?php echo $profileData['first_name'] . ' ' . $profileData['last_name']?></td>
                <td><?php echo $profileData['age']?></td>
                <td><?php echo $profileData['birthdate']?></td>
                <td><?php echo $profileData['email_address']?></td>
                <td><?php echo $profileData['phone_number']?></td>
                <td><?php echo $profileData['home_address']?></td>
                <td><?php echo $profileData['user_role']?></td>
                <td><?php echo $profileData['date_registered']?></td>
            </tr>
        </table>
    </body>
</html>