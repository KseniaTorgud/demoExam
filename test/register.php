<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $login = $_POST["login"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    if (empty($login)||empty($password)||empty($email)){
        echo "Введите данные";
    }else{
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(
            "INSERT INTO users(login, password, email)
            VALUES(:login, :password, :email)"
        );
        $stmt->execute([
            "login" =>$login,
            "password" => $hash,
            "email" => $email
        ]);
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
        <h1>Страница регистриции, введите ваши данные</h1>
    </header>
    <main>
        <form action="register.php" method="post">
            <label for="login" >Логин</label>
            <input id="login" type="text" name="login">
            <label for="password" >Пароль</label>
            <input id="password" type="password" name="password">
            <label for="email" >Почта</label>
            <input id="email" type="email" name="email">

            <button type="submit">Отправить</button>
        </form>
    </main> 
    <footer>
        <a href="login.php">Ужу зарегестрированы?</a>
    </footer>
</body>
</html>

