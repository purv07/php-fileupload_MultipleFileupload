<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>

<?php
require("db.php");

$editData = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
        if (uploadMultipleFiles($_FILES['files'])) {
            echo "Upload successful!";
        } else {
            echo "Upload failed.";
        }
    }
}

$data = displayFiles();

if (isset($_GET['id'])) {
    $editData = displaygetbyid($_GET['id']);
}
?>

<?php
if (isset($_GET['file'])) {
    $file = basename($_GET['file']); // Prevent path traversal
    $filePath = 'uploads/' . $file;

    if (file_exists($filePath)) {
        // Get file MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        // Set headers to force download
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mimeType); // e.g., image/jpeg
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Clear output buffer and flush
        ob_clean();
        flush();

        readfile($filePath);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}
?>



<body>
    <center>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="files[]" multiple>
            <button type="submit" name="submit">Upload</button>
        </form>



        <br><br>

        <h2>Uploaded Files</h2>
        <table border="2">
            <tr>
                <th>Name(s)</th>
                <th>Preview(s)</th>
            </tr>
            <?php foreach ($data as $val): ?>
                <tr>
                    <td>
                        <?php
                        $names = explode(",", $val['name']);
                        echo implode("<br>", $names);
                        ?>
                    </td>
                    <td>
                        <?php
                        $paths = explode(",", $val['path']);
                        foreach ($paths as $p) {
                            ?>
                            <a href="?file=<?php echo $p; ?>"  target='_blank'><img src='<?php echo $p; ?>' width='100' height='100'></a> 
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    </center>
</body>

</html>