<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php
require("db.php");

$editData = null;

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_FILES['file'])) {
    if (isset($_POST['id']) && $_POST['id'] !== '') {
        updateFile($_POST['id'], $_FILES['file']);
    } else {
        uploadfile($_FILES['file']);
    }
}

$data = displayFiles();

if (isset($_GET['id'])) {
    $editData = displaygetbyid($_GET['id']);
}
?>


<body>
<center>
    <form method="post" enctype="multipart/form-data">
        <?php if ($editData): ?>
            <p>Updating File: <strong><?php echo $editData['name']; ?></strong></p>
            <img src="<?php echo $editData['path']; ?>" width="100" height="100" /><br><br>
            <input type="hidden" name="id" value="<?php echo $editData['id']; ?>" />
        <?php endif; ?>

        <input type="file"  name="file" required />
        <input type="submit" name="submit" value="<?php echo $editData ? 'Update' : 'Upload'; ?>" />
    </form>

    <br><br><br>

    <table border="2">
        <tr>
            <th>Name</th>
            <th>Path</th>
            <th>Action</th>
        </tr>
        <?php foreach ($data as $val): ?>
            <tr>
                <td><?php echo $val['name']; ?></td>
                <td><a href="<?php echo $val['path']; ?>"><img src="<?php echo $val['path']; ?>" width="100" height="100" /></a></td>
                <td><a href="?id=<?php echo $val['id']; ?>">Update</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</center>

</body>

</html>