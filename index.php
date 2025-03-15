<form action="submit.php" method="POST">
    <?php
    $errors = isset($_COOKIE['form_errors']) ? json_decode($_COOKIE['form_errors'], true) : [];
    $values = isset($_COOKIE['form_values']) ? json_decode($_COOKIE['form_values'], true) : [];
    setcookie("form_errors", "", time() - 3600, "/");
    setcookie("form_values", "", time() - 3600, "/");
    ?>

    <label>ФИО:
        <input type="text" name="name" value="<?php echo isset($values['name']) ? htmlspecialchars($values['name']) : ''; ?>">
        <span class="error"><?php echo isset($errors['name']) ? $errors['name'] : ''; ?></span>
    </label>

    <label>Телефон:
        <input type="tel" name="phone" value="<?php echo isset($values['phone']) ? htmlspecialchars($values['phone']) : ''; ?>">
        <span class="error"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
    </label>

    <label>Email:
        <input type="email" name="email" value="<?php echo isset($values['email']) ? htmlspecialchars($values['email']) : ''; ?>">
        <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
    </label>

    <label>Дата рождения:
        <input type="date" name="birthdate" value="<?php echo isset($values['birthdate']) ? $values['birthdate'] : ''; ?>">
        <span class="error"><?php echo isset($errors['birthdate']) ? $errors['birthdate'] : ''; ?></span>
    </label>

    <label>Пол:
        <input type="radio" name="gender" value="male" <?php echo (isset($values['gender']) && $values['gender'] == 'male') ? 'checked' : ''; ?>> Мужской
        <input type="radio" name="gender" value="female" <?php echo (isset($values['gender']) && $values['gender'] == 'female') ? 'checked' : ''; ?>> Женский
        <span class="error"><?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?></span>
    </label>

    <label>Биография:
        <textarea name="bio"><?php echo isset($values['bio']) ? htmlspecialchars($values['bio']) : ''; ?></textarea>
        <span class="error"><?php echo isset($errors['bio']) ? $errors['bio'] : ''; ?></span>
    </label>

    <button type="submit">Сохранить</button>
</form>
