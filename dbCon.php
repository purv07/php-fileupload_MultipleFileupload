<?php 
$dsn="mysql:host=localhost;dbname=fooddb";
$user="root";
$pass="";

try{
    $pdo=new PDO($dsn,$user,$pass);
}catch(PDOException $e){
    echo $e->getMessage();
}

function add($name,$cat,$quan,$price){
    global $pdo;
    try{
    $stmt=$pdo->prepare("insert into food (name,category,price,quantity) values(:a,:b,:c,:d)");
    return $stmt->execute([
        ":a"=>$name,
        ":b"=>$cat,
        ":c"=>$quan,
        ":d"=>$price,
    ]);

    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
function display(){
    global $pdo;
    try{
    $stmt=$pdo->prepare("select * from food");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

function deleteProduct($id){
    global $pdo;
    try{
        $stmt=$pdo->prepare("delete from food where id=:id");
        return $stmt->execute([
            ":id"=>$id,
        ]);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

function getDataById($id){
    global $pdo;
    try{
        $stmt=$pdo->prepare("select * from food where id=:id");
        $stmt->execute([
            ":id"=>$id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

function updateProduct($id,$name,$cat,$quan,$price ){
    global $pdo;
    try{

        $stmt=$pdo->prepare("update food set name=:a,category=:b,price=:c,quantity=:d where id=:id");
        return $stmt->execute([
            ":a"=>$name,
            ":b"=>$cat,
            ":c"=>$price,
            ":d"=>$quan,
            ":id"=>$id,
        ]);

    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

function RegisterUser($email,$pass){
    global $pdo;
    try{
        $stmt=$pdo->prepare("insert into users (email,pass) values(:a,:b)");
        return $stmt->execute([
            ":a"=>$email,
            ":b"=>$pass,
        ]);
    }catch(PDOException $e){
        if($e->getCode()== 23000){
            echo "Your Email id is Already Exist!!!";   
        }
    }
}
function LoginUser($email,$pass){
    global $pdo;
    try{
        $stmt=$pdo->prepare("select * from users where email=:a and pass=:b");
        $stmt->execute([
            ":a"=>$email,
            ":b"=>$pass
        ]);
        return $stmt->fetch();
    }catch(PDOException $e){
        echo "".$e->getMessage();
    }
}

?>