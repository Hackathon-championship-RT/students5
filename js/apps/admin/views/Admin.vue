Адына Халитова, [30.11.2024 17:55]
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
        <p v-if="uploadError" class="error">{{ uploadError }}</p>
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
        uploadError: "",
      };
    },
    methods: {
      login() {
        if (this.credentials.username && this.credentials.password) {
          this.isAuthenticated = true;
          this.loginError = "";
        } else {
          this.loginError = "Введите логин и пароль.";
        }
      },
      handleFileUpload(event) {
        this.form.logo = event.target.files[0];
      },
      async submitData() {
        if (!this.form.logo) {
          this.uploadError = "Пожалуйста, выберите логотип перед отправкой.";
          return;
        }
  
        this.uploadError = "";
        this.uploadSuccess = "";
  
        try {
          // Формируем данные для TileType
          const tileData = {
            name: this.form.brand,
            description: this.form.description,
            category: "default", // Замените на актуальную категорию
            country: this.form.country,
          };
  
          // Логируем данные перед отправкой
          console.log("Отправляем TileType данные:", tileData);
  
          const response = await fetch("/api/tile-types", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(tileData),
          });
  
          if (!response.ok) {
            throw new Error("Ошибка при создании TileType");
          }
  
          const tileType = await response.json();
  
          // Формируем данные для загрузки файла
          const formData = new FormData();
          formData.append("cover", this.form.logo);
  
          // Логируем файл, который отправляется
          console.log("Отправляем логотип:", {
            fileName: this.form.logo.name,
            fileSize: this.form.logo.size,
            fileType: this.form.logo.type,
          });
  
          const coverResponse = await fetch(`/tile-types/${tileType.id}/cover`, {
            method: "POST",
            body: formData,
          });
  
          if (!coverResponse.ok) {
            throw new Error("Ошибка при загрузке логотипа");
          }
  
          this.uploadSuccess = "Данные успешно загружены!";
          this.form = { brand: "", country: "", description: "", logo: null };
        } catch (error) {
          console.error(error);

this.uploadError = error.message || "Произошла ошибка при загрузке данных.";
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