<template>
  <div class="main-page">
    <!-- Кнопка для открытия модального окна -->
    <button class="centered-button" @click="showModal = true; console.log('Модальное окно открыто')">
      начать игру
    </button>

    <!-- Модальное окно -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h2>Настройки игры</h2>
        <form @submit.prevent="startGame">
          <!-- Выбор уровня -->
          <label>
            Уровень:
            <select v-model="settings.level" class="custom-select">
              <option value="1">1</option>
              <option value="2">2</option>
            </select>
          </label>

          <!-- Выбор сложности -->
          <label>
            Сложность:
            <div class="toggle-wrapper">
              <span :class="{ active: settings.difficulty === 'classic' }" @click="settings.difficulty = 'classic'">
                Классика
              </span>
              <span :class="{ active: settings.difficulty === 'hard' }" @click="settings.difficulty = 'hard'">
                Хард
              </span>
            </div>
          </label>

          <!-- Выбор страны -->
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

          <!-- Кнопка для начала игры -->
          <a href="/mahjong" class="submit-button">Играть</a>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios"; // Подключаем axios

export default {
  setup() {
    const userUuid = ref(null);
    const showModal = ref(false);
    const settings = ref({
      level: "1",
      difficulty: "classic",
      country: "japan",
    });

    // Закрытие модального окна
    const closeModal = () => {
      showModal.value = false;
    };

    // Отправка настроек игры
    const startGame = async () => {
      console.log("Запуск startGame...");
      console.log("Настройки игры:", settings.value);

      try {
        console.log("Отправка запроса...");
        const response = await axios.post("/game", {
          userUuid: userUuid.value,
          settings: settings.value,
        });

        console.log("Ответ сервера:", response.data);

        // Закрываем модальное окно после успешного запроса
        showModal.value = false;

        // Перенаправление, если сервер вернул URL
        if (response.data.redirectUrl) {
          console.log("Перенаправление на:", response.data.redirectUrl);
          window.location.href = response.data.redirectUrl;
        }
      } catch (error) {
        console.error("Ошибка при отправке запроса:", error);
      }
    };

    // Проверка UUID в localStorage или генерация нового
    onMounted(() => {
      const storedUuid = localStorage.getItem("userUuid");
      if (storedUuid) {
        userUuid.value = storedUuid;
      } else {
        const newUuid = uuidv4(); // Генерация нового UUID
        localStorage.setItem("userUuid", newUuid);
        userUuid.value = newUuid;
      }
    });

    // Функция генерации UUID
    function uuidv4() {
      return "10000000-1000-4000-8000-100000000000".replace(/[018]/g, (c) =>
        (+c ^ (crypto.getRandomValues(new Uint8Array(1))[0] & (15 >> (+c / 4)))).toString(16)
      );
    }

    return {
      userUuid,
      showModal,
      settings,
      closeModal,
      startGame,
    };
  },
};
</script>

<style>
/* Анимация фона */
@keyframes zoomBackground {
  0% {
    background-size: 100%;
  }
  100% {
    background-size: 120%;
  }
}

/* Основная страница */
.main-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-image: url('https://i.ibb.co/23QVrT2/Screenshot-2024-11-30-at-18-32-26-1.png');
  background-size: 100%;
  background-position: center;
  animation: zoomBackground 10s infinite alternate ease-in-out;
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
}

.toggle-wrapper {
  display: flex;
  justify-content: space-between;
}

.toggle-wrapper span {
  flex: 1;
  text-align: center;
  padding: 10px 0;
  background-color: #444;
  color: #fff;
  cursor: pointer;
  border-radius: 10px;
}

.toggle-wrapper span.active {
  background-color: #30FEFE;
  color: #222;
}

.submit-button {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #30FEFE;
  color: #222;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  text-decoration: none;
}

.submit-button:hover {
  background-color: #00d1d1;
}
</style>
