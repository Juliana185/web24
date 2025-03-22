const form = document.querySelector("form"),
  nameField = form.querySelector(".name-field"),
  nameInput = nameField.querySelector(".name"),
  emailField = form.querySelector(".email-field"),
  emailInput = emailField.querySelector(".email"),
  phoneField = form.querySelector(".phone-field"),
  phoneInput = phoneField.querySelector(".phone");

// === ВАЛИДАЦИЯ ===
function checkName() {
  const namePattern = /^[A-Za-z]+(?: [A-Za-z]+)*$/;  // Проверка на только английские буквы и пробелы
  if (!nameInput.value.match(namePattern)) {
    nameField.classList.add("invalid");
  } else {
    nameField.classList.remove("invalid");
  }
}

function checkEmail() {
  const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
  if (!emailInput.value.match(emailPattern)) {
    emailField.classList.add("invalid");
  } else {
    emailField.classList.remove("invalid");
  }
}

function checkPhone() {
  const phonePattern = /^\+?[0-9]{10,15}$/;
  if (!phoneInput.value.match(phonePattern)) {
    phoneField.classList.add("invalid");
  } else {
    phoneField.classList.remove("invalid");
  }
}

// Восстановление данных из localStorage при загрузке страницы
window.onload = () => {
  if (localStorage.getItem('name')) {
    nameInput.value = localStorage.getItem('name');
  }
  if (localStorage.getItem('email')) {
    emailInput.value = localStorage.getItem('email');
  }
  if (localStorage.getItem('phone')) {
    phoneInput.value = localStorage.getItem('phone');
  }
};

// Сохранение данных в localStorage
function saveDataToLocalStorage() {
  localStorage.setItem('name', nameInput.value);
  localStorage.setItem('email', emailInput.value);
  localStorage.setItem('phone', phoneInput.value);
}

// Отправка формы
form.addEventListener("submit", (e) => {
  e.preventDefault();
  checkName();
  checkEmail();
  checkPhone();

  // Если все данные валидны
  if (
    !nameField.classList.contains("invalid") &&
    !emailField.classList.contains("invalid") &&
    !phoneField.classList.contains("invalid") &&
    nameInput.value.trim() !== "" && emailInput.value.trim() !== "" && phoneInput.value.trim() !== ""
  ) {
    // Отправляем данные на сервер
    const data = {
      name: nameInput.value,
      email: emailInput.value,
      phone: phoneInput.value,
    };

    // Замените URL на ваш реальный серверный URL
    fetch('http://yusboikoya.temp.swtest.ru/register.php', { // Используйте правильный URL
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    })
    .then(response => response.text())
    .then(data => {
      alert(data); // Показать сообщение от сервера
      form.reset();  // Очищаем форму
      // Удаляем данные из localStorage после успешной регистрации
      localStorage.removeItem('name');
      localStorage.removeItem('email');
      localStorage.removeItem('phone');
    })
    .catch(error => {
      alert('Ошибка при отправке данных: ' + error.message);
    });
  } else {
    // Сохраняем последние введенные данные в localStorage
    saveDataToLocalStorage();
    alert('Ошибка: Все поля должны быть заполнены корректно');
  }
});
