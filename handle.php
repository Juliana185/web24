<?php
include 'db.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

$errors = [];
$old = compact('name', 'email', 'phone');

// === Проверка на пустоту + регулярки ===
if ($name === '') {
  $errors['name'] = 'Пожалуйста, введите ФИО';
} elseif (!preg_match("/^[A-Za-zА-Яа-яЁё\s-]+$/u", $name)) {
  $errors['name'] = 'ФИО может содержать только буквы, пробелы и дефис';
}

if ($email === '') {
  $errors['email'] = 'Пожалуйста, введите Email';
} elseif (!preg_match("/^[^@\s]+@[^@\s]+\.[a-z]{2,}$/i", $email)) {
  $errors['email'] = 'Неверный формат Email';
}

if ($phone === '') {
  $errors['phone'] = 'Пожалуйста, введите номер телефона';
} elseif (!preg_match("/^\+?[0-9]{10,15}$/", $phone)) {
  $errors['phone'] = 'Телефон должен содержать от 10 до 15 цифр, возможно с +';
}

if (!empty($errors)) {
  setcookie('errors', json_encode($errors), 0, '/');
  setcookie('old', json_encode($old), 0, '/');
  header('Location: index.php');
  exit;
}

// === Сохраняем данные в cookies (на год) ===
setcookie('name', $name, time() + 365*24*60*60, '/');
setcookie('email', $email, time() + 365*24*60*60, '/');
setcookie('phone', $phone, time() + 365*24*60*60, '/');

// === Сохраняем в базу данных ===
$stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $phone);
$stmt->execute();
$stmt->close();

setcookie('success', 'Форма успешно отправлена и сохранена в базу данных!', 0, '/');
header('Location: index.php');
exit;
?>
