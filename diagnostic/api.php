<?php
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $login = $_POST["login"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    $isValid = true;

    if(!preg_match("/^[A-Za-z0-9]{6,}$/", $login)){
        echo ("Ошибка в ведении логина");
        $isValid = false;
    }
    if(strlen($password) < 8){
        echo ("Ошибка в ведении пароля");
        $isValid = false;
    }
    if( !preg_match("/^[А-Яа-яЁё\s]+$/u", $name)){
        echo ("Ошибка в введенном имени");
        $isValid = false;
    }
    if(!preg_match("/^8(\d{3}\)\d{3}-\d{2}-\d{2}$/", $phone)){
        echo ("Ошибка в номере телефона");
        $isValid = false;
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo ("Ошибка при введении почты");
        $isValid = false;
    }
    if ($isValid == true) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "INSERT INTO users(login, password, name, phone, email)
            VALUES(:login, :password, :name, :phone, :email)"
        );
        $stmt->execute([
            "login" => $login, 
            "password" => $passwordHash,
            "name" => $name, 
            "phone" => $phone, 
            "email" => $email
        ]);

        echo ("Пользователь добавлен");
    }
}