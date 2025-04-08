<?php 

$dsn="mysql:host=localhost;dbname=fooddb";
$user="root";
$pass="";

try{

    $pdo=new PDO($dsn,$user,$pass);

}catch(PDOException $e ){
    echo $e->getMessage();
}

function uploadfile($file){
    global $pdo;
    $filename=$file['name'];
    $fileTemp=$file['tmp_name'];
    $uplodDir='uploads/';

    if(!is_dir($uplodDir)){
        mkdir($uplodDir,0777,true); 
    }

    $filepath=$uplodDir.basename($filename);

    if(move_uploaded_file($fileTemp,$filepath)){
        $stmt=$pdo->prepare("insert into fileup (name,path) values(:a,:b)");
        $stmt->execute([
            ":a"=> $filename,
            ":b"=> $filepath,
        ]);
    }else{
        echo "not uploaded";
    }
}

function displayFiles(){
    global $pdo;

    $stmt=$pdo->prepare("select * from fileup");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function displaygetbyid($id){
    global $pdo;

    $stmt=$pdo->prepare("select * from fileup where id=:a");
    $stmt->execute([
        ":a"=> $id,
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateFile($id, $file){
    global $pdo;
    
    $filename=$file['name'];
    $fileTemp=$file['tmp_name'];
    $uplodDir='uploads/';

    if(!is_dir($uplodDir)){
        mkdir($uplodDir,0777,true); 
    }

    $filepath=$uplodDir.basename($filename);

    if(move_uploaded_file($fileTemp,$filepath)){
        $stmt=$pdo->prepare("update fileup set name=:a,path=:b where id=:id");
        $stmt->execute([
            ":a"=> $filename,
            ":b"=> $filepath,
            ":id"=> $id,
        ]);
    }else{
        echo "not uploaded";
    }
}


?>