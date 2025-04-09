<?php
// index.php
$errors = isset($_COOKIE['errors']) ? json_decode($_COOKIE['errors'], true) : [];
$old = isset($_COOKIE['old']) ? json_decode($_COOKIE['old'], true) : [];
$success = $_COOKIE['success'] ?? '';

// Очистка временных cookies
setcookie('errors', '', time() - 3600, '/');
setcookie('old', '', time() - 3600, '/');
setcookie('success', '', time() - 3600, '/');

// Если временных данных нет — берём долгосрочные
if (empty($old)) {
  $old = [
    'name' => $_COOKIE['name'] ?? '',
    'email' => $_COOKIE['email'] ?? '',
    'phone' => $_COOKIE['phone'] ?? '',
  ];
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Web24</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Comic Sans MS", cursive, sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: url("https://i.ytimg.com/vi/9e-D6-Hpyd0/maxresdefault.jpg") no-repeat center center fixed;
      background-size: cover;
    }

    .container {
      background: rgba(36, 63, 26, 0.92);
      padding: 30px;
      border-radius: 20px;
      max-width: 420px;
      width: 90%;
      color: #d4ffbe;
      box-shadow: 0 0 20px #3e7316;
    }

    h1 {
      text-align: center;
      color: #a6ff4d;
      margin-bottom: 20px;
    }

    .success {
      background: #d2ffcb;
      color: #2e7d32;
      padding: 10px;
      border-radius: 8px;
      text-align: center;
      margin-bottom: 15px;
      font-weight: bold;
    }

    label {
      display: block;
      margin-top: 15px;
      font-size: 16px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"] {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 2px solid #76a21e;
      background: #f6fff2;
      font-size: 16px;
      color: #000;
      margin-top: 5px;
    }

    .invalid {
      border-color: #ff4d4d !important;
      background-color: #fff0f0;
    }

    .error {
      color: #ffb3b3;
      font-size: 14px;
      margin-top: 4px;
    }

    input[type="submit"] {
      width: 100%;
      margin-top: 25px;
      padding: 12px;
      font-size: 18px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #388e3c;
    }

    @media (max-width: 480px) {
      .container {
        margin: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Добро пожаловать в Болото 🐸</h1>

    <?php if ($success): ?>
      <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="handle.php" method="POST" novalidate>
      <label>ФИО:
        <input type="text" name="name" value="<?= htmlspecialchars($old['name']) ?>" class="<?= isset($errors['name']) ? 'invalid' : '' ?>">
        <?php if (isset($errors['name'])): ?>
          <div class="error"><?= $errors['name'] ?></div>
        <?php endif; ?>
      </label>

      <label>Email:
        <input type="email" name="email" value="<?= htmlspecialchars($old['email']) ?>" class="<?= isset($errors['email']) ? 'invalid' : '' ?>">
        <?php if (isset($errors['email'])): ?>
          <div class="error"><?= $errors['email'] ?></div>
        <?php endif; ?>
      </label>

      <label>Телефон:
        <input type="tel" name="phone" value="<?= htmlspecialchars($old['phone']) ?>" class="<?= isset($errors['phone']) ? 'invalid' : '' ?>">
        <?php if (isset($errors['phone'])): ?>
          <div class="error"><?= $errors['phone'] ?></div>
        <?php endif; ?>
      </label>

      <input type="submit" value="Зарегистрироваться в болоте 🐸">
    </form>
  </div>
</body>
</html>
