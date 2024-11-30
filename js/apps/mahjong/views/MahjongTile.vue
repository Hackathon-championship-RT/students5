<template>
    <div
      class="tile"
      :style="tileStyle"
      @click="handleClick"
      :class="{ hidden: matched }"
    >
      <img
        v-if="!imageErrorFlag"
        :src="tileImage"
        alt="Mahjong Tile"
        @error="imageError"
      />
      <div v-else class="fallback-text">Mahjong Tile</div>
    </div>
  </template>
  
  <script>
//   import Audi from "@icons/audi.svg";

  export default {
    props: {
      carId: Number,
      matched: Boolean,
      position: Object,
    },
    data() {
      return {
        imageErrorFlag: false,
      };
    },
    computed: {
      tileStyle() {
        return {
          left: `${this.position.x}px`,
          top: `${this.position.y}px`,
          zIndex: this.position.z || 1,
          position: 'absolute',
        };
      },
      tileImage() {
        if (this.carId == 1)
            return `https://i.postimg.cc/VNs23s58/audi.png`; // Статичное изображение
            // return "Audi";
        if (this.carId == 2)
            return 'https://i.postimg.cc/pTGpqRcm/bmw.png';
        if (this.carId == 3)
            return 'https://i.postimg.cc/9fc02rv4/porsche.png';
        if (this.carId == 4) 
            return 'https://i.postimg.cc/90wFbTqk/vw.png';
      },
    },
    methods: {
      handleClick() {
        if (!this.matched) {
          this.$emit('tile-clicked', this.carId);
        }
      },
      imageError() {
        this.imageErrorFlag = true; // Устанавливаем флаг, если изображение не загрузилось
        console.error(`Image not found for tile: mahjong${this.carId}.png`);
      },
    },
  };
  </script>
  
  <style scoped>
  .tile {
    width: 60px;
    height: 80px;
    background-color: white;
    border-radius: 10px;
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: opacity 0.5s ease;
    box-shadow: 5px 5px 0px #30FEFE,
      5px 5px 10px rgba(0, 0, 0, 0.8);
  }
  
  .tile.hidden {
    opacity: 0;
    pointer-events: none;
  }
  
  .tile img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 10px;
  }
  
  .fallback-text {
    font-size: 14px;
    color: #333;
    text-align: center;
    line-height: 80px; /* Выравнивание текста по центру */
    font-weight: bold;
  }
  </style>
  