<?php 

$dsn = "mysql:host=localhost;dbname=fooddb";
$user = "root";
$pass = "";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch(PDOException $e) {
    echo $e->getMessage();
}

// Display all files
function displayFiles() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM fileup");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ✅ Upload multiple files and store comma-separated paths
function uploadMultipleFiles($files) {
    global $pdo;
    $uploadDir = 'uploads/';
    $uploadedPaths = [];

    foreach ($files['tmp_name'] as $key => $tmpName) {
        $originalName = basename($files['name'][$key]);
        $targetPath = $uploadDir . $originalName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $uploadedPaths[] = $targetPath;
        }
    }

    if (!empty($uploadedPaths)) {
        $filePaths = implode(',', $uploadedPaths);
        $stmt = $pdo->prepare("INSERT INTO fileup (name,path) VALUES (:a,:file_paths)");
        $stmt->execute([
            ":a"=> "Multiple",
            'file_paths' => $filePaths]);
        return true;
    }

    return false;
}
?>
