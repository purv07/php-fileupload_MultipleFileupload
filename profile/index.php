<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php 
require"dbcon.php";

if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD']==="POST"){
    $name=$_POST['name'];
    $age=$_POST['age'];
    $file=$_FILES['file'];
    AddRecord($name,$age,$file);
}
$data=displaydata();

if(isset(($_GET['updateid']))){
    $id=$_GET['updateid'];
    $dataMain=getbyid($id);

}

if(isset($_COOKIE['UserName'])){
    echo $_COOKIE['UserName'];
}else{
    echo 'Cookie not set';
}
if(isset($_POST['update'])){
    $id=$_GET['updateid'];
    $name=$_POST['name'];
    $age=$_POST['age'];
    $file=$_FILES['file'];
    updatedata($id,$name,$age,$file);
    setcookie("UserName",$name,time()+3600*24,'/');
    header("Location: index.php");
}
?>
<body>
<center>
<form method="post" enctype="multipart/form-data">
    <input type="text" value="<?php echo isset($dataMain['name'])?$dataMain['name']:'' ?>" name="name" placeholder="enter name"/><br><br>
    <input type="text" value="<?php echo isset($dataMain['age'])?$dataMain['age']:'' ?>" name="age" placeholder="enter Age"/><br><br>
    <input type="file" name="file"/><br><br>
    <input type="submit" name="update" />
</form>

<br><br>
<table border="2">
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Path</th>
        <th>Action</th>
    </tr>
    <?php foreach($data as $value): ?>
    <tr>
        <td><?php echo $value['name'] ?></td>
        <td><?php echo $value['age'] ?></td>
        <td><img src="<?php echo $value['path'] ?>" width="100" height="100" /></td>
        <td><a href="?updateid=<?php echo $value['id']; ?>">Update</a></td>
    </tr>
    <?php endforeach; ?>
</table>
    
</center>
</body>
</html>