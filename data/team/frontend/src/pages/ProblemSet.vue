<template>
    <div class="container">
    <h1>习题集</h1>
    <div v-if="course">
      <h2>{{ course.title }}</h2>
      <p>{{ course.description }}</p>
      <p>人数: {{ course.number }}</p>
    </div>

    <h3>习题列表</h3>
    <div v-if="problems.length > 0" class="problem-grid">
      <div v-for="problem in problems" :key="problem.pid" class="problem-card">
        <h4>{{ problem.title }}</h4>
        <p>{{ problem.description }}</p>
      </div>
    </div>
    <p v-else>暂无习题</p>
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
.container {
  margin: 20px auto;
  max-width: 800px;
}
.problem-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}
.problem-card {
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
  </style>
  