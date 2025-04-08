<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
require("dbCon.php");


?>

<body>
    <center>
        <h2>Reg</h2>
        <form method="post">
            <input type="text" name="email" placeholder="enter email id"><br><br>
            <input type="password" name="pass" placeholder="enter password"><br><br>
            <input type="submit" name="reg" value="reg" /><br><br>
        </form>
        <p style="color:red;">
        <?php
        if (isset($_POST['reg'])) {
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $msg = RegisterUser($email, $pass);
        }
        ?></p>
        <p>Already have a account <a href="login.php">Login Now</a></p>

    </center>

</body>

</html>