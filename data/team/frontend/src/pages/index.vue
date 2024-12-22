<template>
    <div>
      <h1>{{ title }}</h1>
      <p>Welcome to the home page.!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!</p>
      <a href="/ProblemSet.html">Go to Problem Set</a> <!-- 跳转到问题集页面 -->
    </div>

    <header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <a href="index.html" class="logo">
              <img src="assets/images/logo.png" />
            </a>
            <ul class="nav">
              <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
              <li class="scroll-to-section"><a href="#men">Men's</a></li>
              <li class="scroll-to-section"><a href="#women">Women's</a></li>
            </ul>
            <a class="menu-trigger"><span>Menu</span></a>
          </nav>
        </div>
      </div>
    </div>
  </header>
  
  </template>
  
  <script>
  export default {
    name: 'HomePage',
    data() {
      return {
        title: 'Home Page',
      };
    },
  };
  </script>
  
  <style scoped>
  h1 {
    color: blue;
  }
  </style>
  