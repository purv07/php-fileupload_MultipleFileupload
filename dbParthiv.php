<?php
$dsn = "mysql:host=localhost;dbname=exam_practice";
$username = "root";
$password = "";
try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo "Error :- " . $e->getMessage();
}

function register($email, $pass)
{
    try {
        global $pdo;

        $stmt = $pdo->prepare("insert into users (email,password) values(:a,:b)");
        return $stmt->execute([
            ':a' => $email,
            ':b' => $pass
        ]);

    } catch (PDOException $e) {
        throw new Exception("Registration Failed :- ", $e->getMessage());
    }

}

function login($email, $pass)
{
    try {
        global $pdo;

        $stmt = $pdo->prepare("Select *from users where email = :a");
        $stmt->execute([
            ":a" => $email
        ]);

        $result = $stmt->fetch();
        if ($result) {
            return $result;
        } else {
            throw new Exception("Invalid Credential");
        }
    } catch (PDOException $e) {
        throw new Exception("Login Failed :- ", $e->getMessage());
    }
}
?>