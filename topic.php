<?php
require 'includes/db.php';

$topic_id = $_GET['id'] ?? null;
if (!$topic_id) {
    echo "Тема не найдена.";
    exit();
}

$query = "SELECT * FROM topics WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$topic = $stmt->get_result()->fetch_assoc();

if (!$topic) {
    echo "Тема не найдена.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($topic['title']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($topic['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($topic['content'])); ?></p>
    <a href="index.php">Назад к форуму</a>
</body>
</html> 