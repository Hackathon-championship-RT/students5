<template>
    <transition name="fade">
      <div v-if="visible" class="car-info" @click.self="hideInfo">
        <div class="car-content">
          <h3>{{ car.brand }}</h3>
          <p>{{ car.description }}</p>
        </div>
      </div>
    </transition>
  </template>
  
  <script>
  export default {
    props: {
      car: {
        type: Object,
        required: true,
      },
      visible: {
        type: Boolean,
        default: false,
      },
    },
    emits: ["hide"],
    methods: {
      hideInfo() {
        this.$emit("hide");
      },
    },
  };
  </script>
  
  <style>
  .car-info {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: rgba(0, 0, 0, 0.85);
    color: white;
    padding: 20px;
    box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
    z-index: 2000;
    cursor: pointer;
    font-family: 'IBM Plex Mono', monospace;;
  }
  
  .car-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
  }
  
  .car-content h3 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #30fefe;
  }
  
  .car-content p {
    font-size: 16px;
    line-height: 1.5;
  }
  
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s;
  }
  
  .fade-enter, 
  .fade-leave-to {
    opacity: 0;
  }
  </style>
  