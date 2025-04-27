<?php
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Вставка нового пользователя в базу данных
    $query = "INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['user_id'] = $stmt->insert_id;
        header("Location: index.php"); // Перенаправление на главную страницу
        exit();
    } else {
        $error = "Ошибка регистрации.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Регистрация</title>
</head>
<body>
  <div class="wrapper">
    <section>
      <div class="form-box">
        <div class="form-value">
          <form method="post" action="register.php">
            <h2>Регистрация</h2>
            <div class="inputbox">
              <ion-icon name="person-outline"></ion-icon>
              <input type="text" name="username" required>
              <label for="">Имя пользователя</label>
            </div>
            <div class="inputbox">
              <ion-icon name="mail-outline"></ion-icon>
              <input type="email" name="email" required>
              <label for="">Email</label>
            </div>
            <div class="inputbox">
              <ion-icon name="lock-closed-outline"></ion-icon>
              <input type="password" name="password" required>
              <label for="">Пароль</label>
            </div>
            <button type="submit">Зарегистрироваться</button>
            <div class="register">
              <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
            </div>
          </form>
          <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        </div>
      </div>
    </section>
  </div>
</body>
</html> 