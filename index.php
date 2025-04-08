<?php 

session_start();

if(isset($_SESSION['user'])){
    echo "Session Data :- ".$_SESSION['user'];
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
require('dbCon.php');

if (isset($_GET['addData'])) {
    $name = $_GET['item_name'];
    $category = $_GET['item_category'];
    $price = $_GET['item_price'];
    $quantity = $_GET['item_quantity'];

    add($name, $category, $price, $quantity);
}
$data = display();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    deleteProduct($id);
    header('Location: index.php');
}
if (isset($_GET['update'])) {
    $id = $_GET['update'];
    $dataone = getDataById($id);

}
if (isset($_GET['updateData'])) {
    $id = $_GET['id'];
    $name = $_GET['item_name'];
    $category = $_GET['item_category'];
    $price = $_GET['item_price'];
    $quantity = $_GET['item_quantity'];

    updateProduct($id, $name, $category, $price, $quantity);
    header('Location: index.php');
}
?>

<body>
    <center>
        <h2>Form</h2>
        <form method="get">
            <input type="hidden" value="<?php echo isset($_GET['update']) ? $dataone['id'] : ''; ?>" name="id"><br><br>
            <input type="text" value="<?php echo isset($_GET['update']) ? $dataone['name'] : ''; ?>" name="item_name"
                placeholder="enter name"><br><br>
            <input type="text" value="<?php echo isset($_GET['update']) ? $dataone['category'] : ''; ?>"
                name="item_category" placeholder="enter category"><br><br>
            <input type="text" value="<?php echo isset($_GET['update']) ? $dataone['price'] : ''; ?>" name="item_price"
                placeholder="enter price"><br><br>
            <input type="text" value="<?php echo isset($_GET['update']) ? $dataone['quantity'] : ''; ?>"
                name="item_quantity" placeholder="enter quantity"><br><br>
            <input type="submit" name="<?php echo isset($_GET['update']) ? 'updateData' : 'addData' ?>"
                value="<?php echo isset($_GET['update']) ? 'Update' : 'Add' ?>" />
        </form>
        <table border="2">
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Cat</th>
                <th>price</th>
                <th>quan</th>
                <th>Action</th>
            </tr>
            <?php


            foreach ($data as $value) {
                ?>
                <tr>
                    <td><?php echo $value['id']; ?></td>
                    <td><?php echo $value['name']; ?></td>
                    <td><?php echo $value['category']; ?></td>
                    <td><?php echo $value['price']; ?></td>
                    <td><?php echo $value['quantity']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $value['id']; ?>">Delete</a>
                        <a href="?update=<?php echo $value['id']; ?>">Update</a>
                    </td>
                </tr>
                <?php
            }
            ?>

        </table>

        <?php 
        
        if(isset($_GET['logout'])){
            session_destroy();
            header('Location: login.php');
        }

        ?>

        <br><br><br>
        <form method="get">
            <input type="submit" name="logout" value="logout" >
        </form>

    </center>
</body>

</html>