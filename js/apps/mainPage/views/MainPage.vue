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
    background-color: black;
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
  }
  
  .centered-button:hover {
    background-color: #30FEFE;
    color: #222222;
  }
  </style>
  