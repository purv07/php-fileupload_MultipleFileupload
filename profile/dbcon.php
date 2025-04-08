<?php 

$dsn="mysql:host=localhost;dbname=fooddb";
$user="root";
$pass="";

try{
    $pdo=new PDO($dsn, $user, $pass);
}catch(PDOException $e){
    echo $e->getMessage();
}

function AddRecord($name,$age,$file){
    global $pdo;
    $filename=$file["name"];
    $fileTemp=$file["tmp_name"];
    $uploadDir="uploads/";
    if(!is_dir($uploadDir)){
        mkdir($uploadDir,0777,true);
    }

    $filePath=$uploadDir.basename($filename);

    if(move_uploaded_file($fileTemp,$filePath)){
        $stmt=$pdo->prepare("insert into profile (name,age,path) values(:a,:b,:c)");
        $stmt->execute(([
            ":a"=> $name,
            ":b"=> $age,
            ":c"=> $filePath,
        ]));
    }else{
        echo "Profile Not Uploaded";
    }

}
function displaydata(){
    global $pdo;
    $stmt=$pdo->prepare("select * from profile");
    $stmt->execute([]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getbyid($id){
    global $pdo;
    $stmt=$pdo->prepare("select * from profile where id=:id");
    $stmt->execute([
        ":id"=> $id
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updatedata($id,$name,$age,$file){
    global $pdo;
    $filename=$file["name"];
    $fileTemp=$file["tmp_name"];
    $uploadDir="uploads/";
    if(!is_dir($uploadDir)){
        mkdir($uploadDir,0777,true);
    }

    $filePath=$uploadDir.basename($filename);

    if(move_uploaded_file($fileTemp,$filePath)){
        $stmt=$pdo->prepare("update profile set name=:a,age=:b,path=:c where id=:id");
        $stmt->execute(([
            ":a"=> $name,
            ":b"=> $age,
            ":c"=> $filePath,
            ":id"=> $id,
        ]));
    }else{
        echo "Profile Not Uploaded";
    }
}
?>