<template>
    <div id="game-container">
      <div id="game-board">
        <MahjongTile
          v-for="(tile, index) in tiles"
          :key="tile.id"
          :carId="tile.carId"
          :matched="tile.matched"
          :position="tile"
          @tile-clicked="handleTileClick(tile)"
          :class="{
            highlighted: (firstTile && firstTile.id === tile.id) || (secondTile && secondTile.id === tile.id),
            shake:
              secondTile &&
              secondTile.id === tile.id &&
              firstTile.carId !== secondTile.carId,
          }"
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
  
        // Массив плиток
        this.tiles = tilesData;
  
        // Позиционирование плиток
        this.tiles.forEach((tile) => {
          // Вычисление координаты X (отступ по горизонтали)
          tile.x = tile.x * tileWidth;
  
          // Вычисление координаты Y
          tile.y = yOffsetFirstLevel + tile.y * tileHeight;
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
        if (this.firstTile.carId === this.secondTile.carId) {
          // Если плитки совпали, они исчезают
          this.firstTile.matched = true;
          this.secondTile.matched = true;
  
          // Удаляем совпавшие плитки через 1 секунду
          setTimeout(() => {
            this.tiles = this.tiles.filter(
              (tile) => tile.id !== this.firstTile.id && tile.id !== this.secondTile.id
            );
            // Очищаем состояние плиток
            this.firstTile = null;
            this.secondTile = null;
          }, 1000);
        } else {
          // Если не совпали, сбрасываем плитки через 1 секунду
          setTimeout(() => {
            this.firstTile = null;
            this.secondTile = null;
          }, 1000);
        }
      },
    },
  };
  </script>
  
  <style scoped>
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
  
  @keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
    100% { transform: translateX(0); }
  }
  </style>
  