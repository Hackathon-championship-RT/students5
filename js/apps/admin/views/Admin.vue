<template>
    <div id="admin-panel">
      <div v-if="!isAuthenticated" class="login-form">
        <h2>Вход</h2>
        <form @submit.prevent="login">
          <label for="username">Логин:</label>
          <input id="username" v-model="credentials.username" type="text" required />
  
          <label for="password">Пароль:</label>
          <input id="password" v-model="credentials.password" type="password" required />
  
          <button type="submit">Войти</button>
        </form>
        <p v-if="loginError" class="error">{{ loginError }}</p>
      </div>
  
      <div v-else class="admin-dashboard">
        <h2>Админ-панель</h2>
        <form @submit.prevent="submitData">
          <label for="brand">Марка:</label>
          <input id="brand" v-model="form.brand" type="text" required />
  
          <label for="country">Страна:</label>
          <input id="country" v-model="form.country" type="text" required />
  
          <label for="description">Описание:</label>
          <textarea id="description" v-model="form.description" required></textarea>
  
          <label for="logo">Логотип:</label>
          <input id="logo" type="file" @change="handleFileUpload" accept="image/*" required />
  
          <button type="submit">Загрузить</button>
        </form>
        <p v-if="uploadSuccess" class="success">{{ uploadSuccess }}</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isAuthenticated: false,
        credentials: {
          username: "",
          password: "",
        },
        loginError: "",
        form: {
          brand: "",
          country: "",
          description: "",
          logo: null,
        },
        uploadSuccess: "",
      };
    },
    methods: {
      async login() {
        try {
          // Пример авторизации: отправка данных на бэкенд
          const response = await fetch("/api/login", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(this.credentials),
          });
          const data = await response.json();
  
          if (response.ok) {
            this.isAuthenticated = true;
          } else {
            this.loginError = data.message || "Ошибка авторизации.";
          }
        } catch (error) {
          this.loginError = "Сервер недоступен.";
        }
      },
      handleFileUpload(event) {
        this.form.logo = event.target.files[0];
      },
      async submitData() {
        const formData = new FormData();
        formData.append("brand", this.form.brand);
        formData.append("country", this.form.country);
        formData.append("description", this.form.description);
        formData.append("logo", this.form.logo);
  
        try {
          const response = await fetch("/api/upload", {
            method: "POST",
            body: formData,
          });
  
          if (response.ok) {
            this.uploadSuccess = "Данные успешно загружены!";
            this.form = { brand: "", country: "", description: "", logo: null };
          } else {
            this.uploadSuccess = "Ошибка загрузки данных.";
          }
        } catch (error) {
          this.uploadSuccess = "Сервер недоступен.";
        }
      },
    },
  };
  </script>
  
  <style>
  #admin-panel {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
  }
  
  h2 {
    margin-bottom: 20px;
  }
  
  form {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }
  
  label {
    font-weight: bold;
  }
  
  input,
  textarea,
  button {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  
  button {
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #0056b3;
  }
  
  .error {
    color: red;
    margin-top: 10px;
  }
  
  .success {
    color: green;
    margin-top: 10px;
  }
  </style>
  