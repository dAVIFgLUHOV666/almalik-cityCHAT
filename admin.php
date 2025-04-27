<?php
session_start();
include 'includes/db.php';

// Проверка, является ли пользователь администратором
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "Доступ запрещен. Только для администраторов.";
    exit;
}

// Здесь будет функционал админ-панели
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Добро пожаловать в админ-панель</h1>
    <p>Здесь вы можете управлять пользователями и контентом сайта.</p>
    <!-- Добавьте функционал админ-панели здесь -->
</body>
</html> 