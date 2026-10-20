<?php
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $login = $_POST["login"];
    $password = $_POST["password"];

    if (empty($login)||empty($password)){
        echo "Введите данные";
    }else{
        $stmt = $pdo->prepare(
            "SELECT * FROM users
            WHERE login= :login"
        );

        $stmt->execute([
            "login" => $login
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user["password"])){
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["login"] = $user["login"];

            header("Location: index.php");
            exit;
        }else{
            echo ("Введены неправильные данные");
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Страница входа, введите ваши данные</h1>
    </header>
    <main>
        <form action="login.php" method="post">
            <label for="login" >Логин</label>
            <input id="login" type="text" name="login">
            <label for="password" >Пароль</label>
            <input id="password" type="password" name="password">

            <button type="submit">Войти</button>
        </form>
    </main> 
    <footer>
        <a href="register.php">НЕ зарегестрированы?</a>
    </footer>
</body>
</html>

