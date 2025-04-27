<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Получение сообщений из базы данных
$query = "SELECT messages.message, users.username, messages.image_path FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.created_at ASC";
$result = $conn->query($query);

if (!$result) {
    echo "Ошибка выполнения запроса: " . $conn->error;
    exit();
}

$messages = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

// Обработка отправки нового сообщения с изображением
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];
    $image_path = null;

    // Проверка и загрузка изображения
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            $image_path = '../uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        }
    }

    $stmt = $conn->prepare("INSERT INTO messages (user_id, message, image_path, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $user_id, $message, $image_path);
    $stmt->execute();

    header("Location: chat.php");
    exit();
}

function getColorClass($username) {
    $firstLetter = strtolower($username[0]);
    $colors = [
        'a' => 'color-a',
        'b' => 'color-b',
        'c' => 'color-c',
        'd' => 'color-d',
        'e' => 'color-e',
        // Добавьте больше цветов для других букв
    ];
    return $colors[$firstLetter] ?? 'default-color';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Чат</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Чат</h1>
    <div class="chat-box">
        <?php foreach ($messages as $msg): ?>
            <div class="message <?php echo isset($_SESSION['username']) && $msg['username'] === $_SESSION['username'] ? 'user' : 'other'; ?>">
                <strong class="username <?php echo getColorClass($msg['username']); ?>"><?php echo htmlspecialchars($msg['username']); ?>:</strong>
                <span><?php echo htmlspecialchars($msg['message']); ?></span>
                <?php if (!empty($msg['image_path'])): ?>
                    <img src="<?php echo htmlspecialchars($msg['image_path']); ?>" alt="Изображение" style="max-width: 200px;">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <form method="post" action="chat.php" enctype="multipart/form-data">
        <textarea name="message" required></textarea>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Отправить</button>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('click', function() {
                    const modal = document.createElement('div');
                    modal.style.position = 'fixed';
                    modal.style.top = '0';
                    modal.style.left = '0';
                    modal.style.width = '100%';
                    modal.style.height = '100%';
                    modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                    modal.style.display = 'flex';
                    modal.style.alignItems = 'center';
                    modal.style.justifyContent = 'center';
                    modal.style.zIndex = '1000';

                    const modalImg = document.createElement('img');
                    modalImg.src = img.src;
                    modalImg.style.maxWidth = '90%';
                    modalImg.style.maxHeight = '90%';

                    modal.appendChild(modalImg);
                    document.body.appendChild(modal);

                    modal.addEventListener('click', function() {
                        document.body.removeChild(modal);
                    });
                });
            });
        });
    </script>
</body>
</html> 