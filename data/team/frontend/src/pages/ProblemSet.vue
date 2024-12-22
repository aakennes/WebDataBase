<template>
    <div>
      <h1>{{ title }}</h1>
      <p>This is the problem set page.</p>
      <a href="/index.html">Go to Home Page</a> <!-- 跳转到首页 -->
    </div>
  </template>
  
  <script>
  export default {
    name: 'ProblemSetPage',
    data() {
      return {
        title: 'Problem Set',
      };
    },
  };
  </script>
  
  <style scoped>
  h1 {
    color: green;
  }
  </style>
  