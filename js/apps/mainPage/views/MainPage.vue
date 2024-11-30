<template>
    <div class="main-page">
      <a href="/mahjong">
        <button class="centered-button">начать игру</button>
      </a>
    </div>
  </template>
  
  <script setup>
  </script>
  
  <style>
  .main-page {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    position: relative; /* Чтобы кнопка была поверх фона */
    background-image: url('https://i.ibb.co/hXtpXTN/Untitled-Project-19.jpg');
    background-size: cover; /* Растягиваем картинку, сохраняя пропорции */
    background-position: center; /* Центрируем картинку */
    background-repeat: no-repeat; /* Убираем повторение картинки */
  }
  
  .centered-button {
    padding: 10px 20px;
    font-size: 16px;
    font-family: 'IBM Plex Mono', monospace;
    background-color: #222222;
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
    z-index: 1; /* Кнопка поверх фона */
  }
  
  .centered-button:hover {
    background-color: #30FEFE;
    color: #222222;
  }
  </style>
  