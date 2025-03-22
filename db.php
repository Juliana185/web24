<?php
$servername = "localhost"; // Хост
$username = "yusboikoya"; // Имя пользователя базы данных
$password = "YFQ7sW3JV6VWSS_4"; // Пароль базы данных
$dbname = "yusboikoya"; // Имя базы данных

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Получаем данные из POST запроса
$data = json_decode(file_get_contents('php://input'), true);

// Проверка, что данные не пустые
if (empty($data['name']) || empty($data['email']) || empty($data['phone'])) {
  echo "Ошибка: Все поля должны быть заполнены.";
  exit();
}

$name = $data['name'];
$email = $data['email'];
$phone = $data['phone'];

// Вставляем данные в таблицу users
$sql = "INSERT INTO users (name, email, phone) VALUES ('$name', '$email', '$phone')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
