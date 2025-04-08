<?php 
 session_start();
 if (isset($_SESSION["user"])){
    header("Location:index.php");
 }
?>

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
        <h2>Login</h2>
        <form method="post" >
            <input type="text" name="email" placeholder="enter email id"><br><br>
            <input type="password" name="pass" placeholder="enter password"><br><br>
            <input type="submit" name="Login" value="Login" /><br><br>
        </form>
        <p style="color:red;">

        <?php 
            if(isset($_POST['Login'])){
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $msg=LoginUser($email,$pass);
                if($msg== ''){
                    echo 'Not Found';    
                }else{
                    echo 'Login Succcccesful';
                    $_SESSION['user']=$email;
                    header("Location: index.php");
                }
            }
        ?>

        </p>
        <p>don't have a account <a href="reg.php">Register Now</a></p>
    </center>
</body>

</html>