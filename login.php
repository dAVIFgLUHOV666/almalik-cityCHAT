<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка пользователя в базе данных
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Неверный пароль.";
        }
    } else {
        $error = "Пользователь не найден.";
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
    <title>Вход</title>
</head>
<body>
  <div class="wrapper">
    <section>
      <div class="form-box">
        <div class="form-value">
          <form method="post" action="login.php">
            <h2>Вход</h2>
            <div class="inputbox">
              <ion-icon name="mail-outline"></ion-icon>
              <input type="text" name="username" required>
              <label for="">Имя пользователя</label>
            </div>
            <div class="inputbox">
              <ion-icon name="lock-closed-outline"></ion-icon>
              <input type="password" name="password" required>
              <label for="">Пароль</label>
            </div>
            <div class="forget">
              <label>
                <input type="checkbox"> Запомнить меня
              </label>
              <label>
                <a href="#">Забыли пароль?</a>
              </label>
            </div>
            <button type="submit">Войти</button>
            <div class="register">
              <p>Нет аккаунта? <a href="register.php">Регистрация</a></p>
            </div>
          </form>
          <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        </div>
      </div>
    </section>
  </div>
</body>
</html> 