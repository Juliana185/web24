<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "sql203.infinityfree.com"; // Изменить на твои данные
$username = "if0_38513067"; // Изменить на твои данные
$password = "Твой_пароль"; // Изменить на твои данные
$dbname = "if0_38513067_developers_db"; // Изменить на твои данные

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Функция для валидации данных
function validate_input($data, $pattern, $error_msg) {
    if (!preg_match($pattern, $data)) {
        return $error_msg;
    }
    return null;
}

$errors = [];
$fields = ['name', 'phone', 'email', 'birthdate', 'gender', 'bio'];
$valid_data = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Валидация полей формы
    $valid_data['name'] = trim($_POST['name']);
    $valid_data['phone'] = trim($_POST['phone']);
    $valid_data['email'] = trim($_POST['email']);
    $valid_data['birthdate'] = $_POST['birthdate'];
    $valid_data['gender'] = $_POST['gender'];
    $valid_data['bio'] = trim($_POST['bio']);
    $valid_data['agree'] = isset($_POST['agree']) ? 1 : 0;
    $valid_data['languages'] = $_POST['languages'] ?? [];

    // Проверка регулярными выражениями
    if ($error = validate_input($valid_data['name'], "/^[a-zA-Zа-яА-ЯёЁ\s]+$/u", "ФИО может содержать только буквы и пробелы")) {
        $errors['name'] = $error;
    }
    if ($error = validate_input($valid_data['phone'], "/^\+?[0-9\s\-\(\)]{7,15}$/", "Некорректный телефон")) {
        $errors['phone'] = $error;
    }
    if (!filter_var($valid_data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Некорректный email";
    }
    if (empty($valid_data['birthdate'])) {
        $errors['birthdate'] = "Выберите дату рождения";
    }
    if (!in_array($valid_data['gender'], ['male', 'female'])) {
        $errors['gender'] = "Выберите пол";
    }
    if (strlen($valid_data['bio']) < 10) {
        $errors['bio'] = "Биография должна быть не менее 10 символов";
    }

    if (!empty($errors)) {
        setcookie("form_errors", json_encode($errors), time() + 60, "/");
        setcookie("form_values", json_encode($valid_data), time() + 60, "/");
        header("Location: index.html");
        exit();
    }

    // Запись в базу данных
    $stmt = $conn->prepare("INSERT INTO users (name, phone, email, birthdate, gender, bio, agree) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $valid_data['name'], $valid_data['phone'], $valid_data['email'], $valid_data['birthdate'], $valid_data['gender'], $valid_data['bio'], $valid_data['agree']);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $stmt->close();

        foreach ($valid_data['languages'] as $lang) {
            $stmt = $conn->prepare("INSERT INTO user_languages (user_id, language) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $lang);
            $stmt->execute();
            $stmt->close();
        }

        // Сохраняем значения в Cookies на 1 год
        setcookie("saved_values", json_encode($valid_data), time() + 31536000, "/");

        echo "Данные успешно сохранены!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }
}

$conn->close();
?>
