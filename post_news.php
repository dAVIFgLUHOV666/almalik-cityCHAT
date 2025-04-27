<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $query = "INSERT INTO news (title, content, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        echo "Новость опубликована!";
    } else {
        echo "Ошибка публикации.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Публикация новости</title>
</head>
<body>
    <form method="post" action="post_news.php">
        <input type="text" name="title" placeholder="Заголовок" required>
        <textarea name="content" placeholder="Содержание" required></textarea>
        <button type="submit">Опубликовать</button>
    </form>
</body>
</html> 