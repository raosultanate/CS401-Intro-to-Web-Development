<?php
session_start();
$_SESSION['signupErr'] = array();

if(count($_COOKIE)>1){
    header("location: index.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/CSS/login.css">
    <link rel="stylesheet" href="CSS/passValidator.css">
    <link rel="icon" sizes="57x57" href="Images/logo.png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="JS/passValidatorLogin.js"></script>
</head>

<body>
    <a href="index.php"><img src="/Images/logo.png" alt="" class="logo"></a>
    <div class="mainFrame">

        <header>
            <h1>Login</h1>
            <br><br>
            <img src="Images/mainUser.svg" alt="">

        </header><br>

        <form action="login_Handler.php" class="formDesign" method="POST">

            <ul>
                <?php
                echo '<label for="emailID">Email ID </label>';
                if (count($_SESSION["loginErr"])>0){
                    $temp = $_SESSION['credentials'][0];
                    echo "<li><input type='text' id='emailID'placeholder='Email ID'
                    value='{$temp}' name='emailID' required></li>";
                    echo "<div id='pswd_info3'>
                    <h4>Email requirement not met:</h4>
                    <ul>
                        <li class='invalid'><strong>Invalid Email Address</strong></li>
                    </ul>
                </div>";
                }
                else {
                    echo "<li><input type='text' id='emailID' placeholder='Email ID'
                    value='' name='emailID' required></li>";  
                    echo "<div id='pswd_info3'>
                    <h4>Email requirement not met:</h4>
                    <ul>
                        <li class='invalid'><strong>Invalid Email Address</strong></li>
                    </ul>
                </div>";
                }

                ?>
                <br>
                <label for="pass">Password</label>
                <li><input type="password" id="pass" placeholder="Password" name="userPassword" required></li>
                <li>
                    <input type="submit" name="submit" value="submit">
                </li>
            </ul>
        </form>
        Dont have an account?<a href="signUp.php">Create Account</a>
        <a href="index.php">Home</a>

        <div class="message">
            <?php 
                    if(count($_SESSION["loginErr"])>0) {
                        foreach ($_SESSION["loginErr"] as $errors) {
                            echo "<div class='errorMessage'><h3>{$errors}</h3></div>";
                        }
                    }
                ?>

        </div>

    </div>

</body>

</html>