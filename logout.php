<?php
session_start();

// Удаление всех данных сессии
session_unset();

// Уничтожение сессии
session_destroy();

// Перенаправление на страницу входа
header("Location: login.php");
exit();
?> 