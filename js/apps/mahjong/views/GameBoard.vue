<template>
    <div id="game-container">
      <!-- Добавляем контейнер для машинок на передний план -->
      <div
        v-for="(car, index) in miniCars"
        :key="car.id"
        class="mini-car"
        :style="car.style"
      >
        <img src="https://i.ibb.co/g6K93z6/rb-106960.png" alt="Mini car" class="car-image"/>
      </div>
  
      <div id="game-board">
        <MahjongTile
          v-for="(tile, index) in tiles"
          :key="tile.id"
          :carId="tile.carId"
          :matched="tile.matched"
          :position="tile"
          @tile-clicked="handleTileClick(tile)"
          :class="{
            highlighted: tile === firstTile || tile === secondTile,
            shake: secondTile && secondTile.id === tile.id && firstTile.carId !== secondTile.carId,
          }"
          :style="tile.style"
        />
      </div>
    </div>
  </template>
  
  <script>
  import MahjongTile from './MahjongTile.vue';
  import tilesData from './tiles.json';
  
  export default {
    components: {
      MahjongTile,
    },
    data() {
      return {
        tiles: [],
        firstTile: null,
        secondTile: null,
        miniCars: [],
      };
    },
    created() {
      this.initializeTiles();
    },
    methods: {
      initializeTiles() {
        const tileWidth = 60; // Ширина плитки
        const tileHeight = 80; // Высота плитки
        const yOffsetFirstLevel = 100; // Начальная позиция по Y для первого уровня
        const screenWidth = window.innerWidth;
  
        // Массив плиток
        this.tiles = tilesData;
  
        // Позиционирование плиток
        this.tiles.forEach((tile) => {
          tile.x = screenWidth / 2 - 3*(tileWidth) + tile.x * tileWidth ;
          tile.y = yOffsetFirstLevel + tile.y * tileHeight;
  
          // Изначальное состояние для стилей
          tile.style = { 
            left: `${tile.x}px`, 
            top: `${tile.y}px`, 
            transition: "all 0.4s ease-out",
            zIndex: 1, // По умолчанию плитки будут на фоне
          };
        });
      },
      handleTileClick(tile) {
        // Игнорируем клик по уже совпавшим плиткам
        if (tile.matched) return;
  
        // Если это первая плитка
        if (!this.firstTile) {
          this.firstTile = tile;
        } else if (this.firstTile.id === tile.id) {
          // Если нажали на ту же плитку, снимаем выделение
          this.firstTile = null;
        } else if (!this.secondTile) {
          // Если это вторая плитка, проверяем на совпадение
          this.secondTile = tile;
          this.checkForMatch();
        }
      },
      checkForMatch() {
        // Подсвечиваем обе плитки
        this.firstTile.highlighted = true;
        this.secondTile.highlighted = true;
  
        // Проверка на совпадение
        if (this.firstTile.carId === this.secondTile.carId) {
          setTimeout(() => {
            this.animateMerge();
          }, 300); // Задержка для подсветки перед анимацией слияния
        } else {
          setTimeout(() => {
            // Если не совпали, сбрасываем плитки
            this.firstTile.highlighted = false;
            this.secondTile.highlighted = false;
            this.firstTile = null;
            this.secondTile = null;
          }, 1000);
        }
      },
      animateMerge() {
        const [tile1, tile2] = [this.firstTile, this.secondTile];
  
        // Устанавливаем высокий z-index для плиток, чтобы они были поверх других слоев
        tile1.style.zIndex = 10;
        tile2.style.zIndex = 10;
  
        // Перемещаем плитки к центру экрана
        tile1.style = { ...tile1.style, top: "50%", left: "50%", transform: "translate(-50%, -50%) scale(1.5)" };
        tile2.style = { ...tile2.style, top: "50%", left: "50%", transform: "translate(-50%, -50%) scale(1.5)" };
  
        setTimeout(() => {
          this.createMiniCars();
  
          // Удаляем плитки после анимации
          this.tiles = this.tiles.filter(
            (tile) => tile.id !== tile1.id && tile.id !== tile2.id
          );
          // Очищаем состояние плиток
          this.firstTile = null;
          this.secondTile = null;
        }, 1000); // Задержка, чтобы плитки успели слиться в центр
      },
      createMiniCars() {
        const centerPosition = { top: 50, left: 50 };
  
        // Создаем 10 машинок вокруг центра
        for (let i = 0; i < 10; i++) {
          const angle = (Math.PI * 2 * i) / 10; // Угол для распределения машинок
          const offsetX = Math.cos(angle) * 30; // Начальный отступ
          const offsetY = Math.sin(angle) * 30;
  
          const moveX = Math.cos(angle) * 150; // Меншое движение по экрану
          const moveY = Math.sin(angle) * 150;
  
          this.miniCars.push({
            id: i,
            style: {
              position: "absolute",
              top: `calc(${centerPosition.top}% + ${offsetY}px)`,
              left: `calc(${centerPosition.left}% + ${offsetX}px)`,
              transform: "translate(0, 0)",
              transition: "transform 0.4s ease-out, opacity 0.6s ease-out",
              zIndex: 1000, // Устанавливаем высокий z-index для машинок
            },
            moveX,
            moveY,
          });
        }
  
        // Начинаем анимацию разлета машинок
        setTimeout(() => {
          this.miniCars.forEach((car) => {
            car.style.transform = `translate(${car.moveX}px, ${car.moveY}px)`;
            car.style.opacity = "0"; // Быстрое исчезновение
          });
        }, 100);
  
        // Удаляем машинки через 0.7 секунды
        setTimeout(() => {
          this.miniCars = [];
        }, 700);
      },
    },
  };
  </script>
  
  <style scoped>
  /* Центровка всего контейнера */
  #game-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh; /* Минимальная высота контейнера 100% от высоты окна */
    background-color: #f4f4f4; /* Цвет фона (можно изменить) */
    position: relative; /* Для правильного позиционирования машинок */
  }
  
  #game-board {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
    gap: 10px; /* Расстояние между плитками */
    width: 80%; /* Можно изменить для контроля ширины поля */
    max-width: 1000px; /* Максимальная ширина поля */
    margin: 0 auto;
  }
  
  .tile {
    transition: background-color 0.3s, transform 0.2s;
  }
  
  .tile.highlighted {
    background-color: rgba(255, 255, 0, 0.5); /* Желтая подсветка */
    transform: scale(1.1);
  }
  
  .tile.shake {
    animation: shake 0.3s;
  }
  
  .mini-car {
    position: absolute;
    font-size: 24px;
    opacity: 1;
    transition: transform 0.4s ease-out, opacity 0.6s ease-out;
  }
  
  .car-image {
    width: 40px;
    height: 40px;
  }
  </style>
  