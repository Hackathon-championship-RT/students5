<template>
    <div
      v-if="visible"
      class="ad-modal"
      @click.self="hideAd"
    >
      <div class="ad-modal-content">
        <h2>Реклама</h2>
        <p>Здесь могла быть ваша реклама</p>
        <img
          src="https://i.ibb.co/VxL3KY8/Screenshot-2024-11-30-at-20-27-30.png"
          alt="Ad"
        />
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      visible: {
        type: Boolean,
        default: false,
      },
    },
    methods: {
      hideAd() {
        this.$emit("hide");
      },
    },
  };
  </script>
  
  <style>
  .ad-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2000;
    font-family: 'IBM Plex Mono', monospace;
  }
  
  .ad-modal-content {
    background: #e2e659;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  
  .ad-modal img {
    max-width: 100%;
    height: auto;
    margin-top: 15px;
  }
  </style>
  