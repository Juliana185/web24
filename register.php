<?php
// Подключение к базе данных
include('db.php');

// Получение данных из формы
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone']; // Используем phone вместо password

// Проверка на уникальность email
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email); // 's' - строковый тип
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  echo "Пользователь с таким email уже существует.";
} else {
  // Вставка нового пользователя в таблицу с подготовленным запросом
  $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $email, $phone); // 'sss' - все параметры строковые
  if ($stmt->execute()) {
    echo "Регистрация прошла успешно!";
  } else {
    echo "Ошибка: " . $stmt->error;
  }
}

// Закрытие соединения с базой данных
$stmt->close();
$conn->close();
?>
