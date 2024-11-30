<template>
    <div class="main-page">
      <button class="centered-button" @click="showModal = true">начать игру</button>
  
      <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
          <h2>Настройки игры</h2>
          <form @submit.prevent="startGame">
            <label>
              Уровень:
              <select v-model="settings.level" class="custom-select">
                <option value="1">1</option>
                <option value="2">2</option>
              </select>
            </label>
  
            <label>
              Сложность:
              <div class="toggle-wrapper">
                <span :class="{ active: settings.difficulty === 'classic' }" @click="settings.difficulty = 'classic'">Классика</span>
                <span :class="{ active: settings.difficulty === 'hard' }" @click="settings.difficulty = 'hard'">Хард</span>
              </div>
            </label>
  
            <label>
              Страна:
              <div class="custom-select-wrapper">
                <select v-model="settings.country" class="custom-select">
                  <option value="japan">Япония</option>
                  <option value="china">Китай</option>
                  <option value="usa">США</option>
                  <option value="germany">Германия</option>
                </select>
              </div>
            </label>
  
            <a href="/mahjong" class="submit-button">Играть</a>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref } from "vue";
  
  export default {
    setup() {
      const showModal = ref(false);
      const settings = ref({
        level: "1",
        difficulty: "classic",
        country: "japan",
      });
  
      const closeModal = () => {
        showModal.value = false;
      };
  
      const startGame = () => {
        console.log("Настройки игры:", settings.value);
        // Здесь можно добавить логику перехода к игре с заданными настройками
        showModal.value = false;
      };
  
      return { showModal, settings, closeModal, startGame };
    },
  };
  </script>
  
  <style>
  /* Основная страница */
  .main-page {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: url('https://i.ibb.co/hXtpXTN/Untitled-Project-19.jpg');
    background-size: cover;
    background-position: center;
  }
  
  .centered-button {
    padding: 15px 30px;
    font-size: 18px;
    font-family: 'IBM Plex Mono', monospace;
    background-color: #222;
    color: #fff;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
  }
  
  .centered-button:hover {
    background-color: #30FEFE;
    color: #222;
  }
  
  /* Модальное окно */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .modal-content {
    background-color: #333;
    color: #fff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
    width: 400px;
    text-align: center;
    font-family: 'IBM Plex Mono', monospace;
  }
  
  .modal-content h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #30FEFE;
  }
  
  form label {
    display: block;
    margin-bottom: 20px;
    text-align: left;
  }
  
  .custom-select-wrapper {
    position: relative;
    width: 100%;
  }
  
  .custom-select {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 10px;
    background-color: #444;
    color: #fff;
    font-family: 'IBM Plex Mono', monospace;
    cursor: pointer;
    appearance: none;
    position: relative;
    z-index: 1;
  }
  
  .custom-select:focus {
    outline: none;
    border: 1px solid #30FEFE;
  }
  
  .custom-select::after {
    content: "▼";
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    pointer-events: none;
    color: #fff;
  }
  
  .toggle-wrapper {
    display: flex;
    justify-content: space-between;
    margin-top: 5px;
  }
  
  .toggle-wrapper span {
    flex: 1;
    text-align: center;
    padding: 10px 0;
    background-color: #444;
    color: #fff;
    cursor: pointer;
    border-radius: 10px;
    transition: background-color 0.3s, color 0.3s;
  }
  
  .toggle-wrapper span.active {
    background-color: #30FEFE;
    color: #222;
  }
  
  .submit-button {
    padding: 10px 20px;
    font-size: 16px;
    font-family: 'IBM Plex Mono', monospace;
    background-color: #30FEFE;
    color: #222;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s;
    text-decoration: none;
  }
  
  .submit-button:hover {
    background-color: #00d1d1;
  }
  </style>
  