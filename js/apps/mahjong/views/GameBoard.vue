<template>
  <div id="game-container">
    <!-- Контейнер для машинок -->
    <div
      v-for="(car, index) in miniCars"
      :key="car.id"
      class="mini-car"
      :style="car.style"
    ></div>

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
    <CarInfo 
    v-if="selectedCar" 
    :car="selectedCar" 
    :visible="carInfoVisible" 
    @hide="carInfoVisible = false" 
  />
  </div>
</template>

<script>
import MahjongTile from './MahjongTile.vue';
import tilesData from './tiles.json';
import CarInfo from "./CarInfo.vue";

export default {
  components: {
    MahjongTile,
    CarInfo,
  },
  data() {
    return {
      tiles: [],
      firstTile: null,
      secondTile: null,
      miniCars: [],
      selectedCar: null, // Выбранный автомобиль
    carInfoVisible: false, 
    };
  },
  created() {
    this.initializeTiles();
  },
  methods: {
      initializeTiles() {
const tileWidth = 60;
const tileHeight = 80;
const yOffsetFirstLevel = 100;
const screenWidth = window.innerWidth;

this.tiles = tilesData;

// Найти две плитки с одинаковым carId
const tileGroups = {};
for (const tile of this.tiles) {
  if (!tileGroups[tile.carId]) {
    tileGroups[tile.carId] = [];
  }
  tileGroups[tile.carId].push(tile);
}

// Получить carId, который встречается больше одного раза
const duplicateCarId = Object.keys(tileGroups).find(
  (carId) => tileGroups[carId].length > 1
);

if (duplicateCarId) {
  const duplicateTiles = tileGroups[duplicateCarId].slice(0, 2);

  // Заменяем их на рекламные плитки
  duplicateTiles.forEach((tile) => {
    tile.carId = -100; // Уникальный ID для рекламы
    tile.style = {
      backgroundColor: "#FFD700", // Золотой цвет для выделения
      backgroundImage: "url('https://via.placeholder.com/150?text=Ad')", // Пример изображения рекламы
      backgroundSize: "cover",
      backgroundPosition: "center",
    };
    tile.ad = true; // Указываем, что это реклама
  });
}

this.tiles.forEach((tile) => {
  tile.x = screenWidth / 2 - 3 * tileWidth + tile.x * tileWidth;
  tile.y = yOffsetFirstLevel + tile.y * tileHeight;

  tile.style = {
    ...tile.style,
    left: `${tile.x}px`,
    top: `${tile.y}px`,
    transition: "all 0.4s ease-out",
    zIndex: 1,
  };
});
},

    handleTileClick(tile) {
      if (tile.matched) return;

      if (!this.firstTile) {
        this.firstTile = tile;
      } else if (this.firstTile.id === tile.id) {
        this.firstTile = null;
      } else if (!this.secondTile) {
        this.secondTile = tile;
        this.checkForMatch();
      }

      this.showCarInfo(tile.carId);

    },
    showCarInfo(carId) {
    const carDetails = this.getCarDetails(carId);
    this.selectedCar = carDetails;
    this.carInfoVisible = true;
  },
  getCarDetails(carId) {
    // Данные об автомобилях
    const carData = {
      1: { brand: "Audi", description: "Надежный автомобиль из Германии." },
      2: { brand: "BMW", description: "Элитный бренд из Германии." },
      3: { brand: "Porsche", description: "Быстрый автомобиль спорткар." },
      4: { brand: "Volkswagen", description: "Семейный автомобиль"}
    };
    return carData[carId] || { brand: "Неизвестно", description: "Описание отсутствует." };
  },
    checkForMatch() {
      this.firstTile.highlighted = true;
      this.secondTile.highlighted = true;

      if (this.firstTile.carId === this.secondTile.carId) {
        setTimeout(() => {
          this.animateMerge();
        }, 300);
      } else {
        setTimeout(() => {
          this.firstTile.highlighted = false;
          this.secondTile.highlighted = false;
          this.firstTile = null;
          this.secondTile = null;
        }, 1000);
      }
    },
    animateMerge() {
      const [tile1, tile2] = [this.firstTile, this.secondTile];

      tile1.style.zIndex = 10;
      tile2.style.zIndex = 10;

      tile1.style = { ...tile1.style, top: "50%", left: "50%", transform: "translate(-50%, -50%) scale(1.5)" };
      tile2.style = { ...tile2.style, top: "50%", left: "50%", transform: "translate(-50%, -50%) scale(1.5)" };

      setTimeout(() => {
        this.createMiniCars();

        this.tiles = this.tiles.filter(
          (tile) => tile.id !== tile1.id && tile.id !== tile2.id
        );

        this.firstTile = null;
        this.secondTile = null;
      }, 1000);
    },
    createMiniCars() {
const centerPosition = { top: 50, left: 50 };

for (let i = 0; i < 10; i++) {
  const angle = (Math.PI * 2 * i) / 10;
  const offsetX = Math.cos(angle) * 30;
  const offsetY = Math.sin(angle) * 30;

  // Увеличенный диапазон движения
  const moveX = Math.cos(angle) * 500; 
  const moveY = Math.sin(angle) * 500;

  this.miniCars.push({
    id: i,
    style: {
      position: "absolute",
      width: "120px",
      height: "50px",
      backgroundImage:
        i > 2 && i < 8
          ? "url('https://i.ibb.co/VprfnQr/Photoroom.png')" // Другое изображение для первых 5 машинок
          : "url('https://i.ibb.co/JnsLX43/IMG-3148-Photoroom.png')", // Исходное изображение
      backgroundSize: "cover",
      backgroundPosition: "center",
      top: `calc(${centerPosition.top}% + ${offsetY}px)`,
      left: `calc(${centerPosition.left}% + ${offsetX}px)`,
      transition: "transform 2s ease-out, opacity 2.5s ease-out", // Более медленный переход
      opacity: 1, // Стартовая яркость
      zIndex: 1000,
    },
    moveX,
    moveY,
  });
}

setTimeout(() => {
  this.miniCars.forEach((car) => {
    car.style.transform = `translate(${car.moveX}px, ${car.moveY}px)`;
    car.style.opacity = "0.8"; // Более яркие машинки
  });
}, 100);

setTimeout(() => {
  this.miniCars = [];
}, 2500); // Больше времени для полного завершения

},

  },
};
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

#game-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #121212;
  position: relative;
}

#game-board {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
  gap: 10px;
  width: 80%;
  max-width: 1000px;
  margin: 0 auto;
}

.tile {
  transition: background-color 0.3s, transform 0.2s;
}

.tile.highlighted {
  background-color: #30FEFE;
  transform: scale(1.1);
  box-shadow: 5px 5px 0px #000000,
  5px 5px 10px rgba(0, 0, 0, 0.8);
}

.tile.shake {
  animation: shake 0.3s;
}

.mini-car {
  position: absolute;
  opacity: 1;
  transition: transform 0.s ease-out, opacity 0.6s ease-out;
  background-size: cover;
  background-position: center;
  border-radius: 4px;
}
</style>
