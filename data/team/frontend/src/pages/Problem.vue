<template>
    <div class="container">
      <!-- 习题详情标题 -->
      <h1 class="title">习题详情</h1>
      
      <!-- 习题内容 -->
      <div v-if="problem">
        <h2 class="problem-title">{{ problem.title }}</h2>
        <p class="problem-description">{{ problem.description }}</p>
        <div class="problem-meta">
          <p>考试时长: {{ problem.during }} 分钟</p>
          <p>课程 ID: {{ problem.cid }}</p>
          <p>创建者: {{ problem.owner_id }}</p>
        </div>
      </div>
      
      <!-- 加载中或未找到数据 -->
      <p v-else>加载中...</p>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ProblemPage',
    props: ["psid"], // 从父组件或 URL 中传递课程 ID (cid)
    data() {
      return {
        psid: null, // 从 URL 中获取的 psid
        problem: null, // 从后端加载的习题详情
      };
    },
    created() {

      // 如果 psid 存在，加载习题详情
      if (this.psid) {
        this.fetchProblemDetails();
      } else {
        console.error('未提供 psid 参数');
      }
    },
    methods: {
      // 从后端获取习题详情
      async fetchProblemDetails() {
        try {
          const response = await fetch(`http://localhost:3000/api/problem?psid=${this.psid}`);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const data = await response.json();
          this.problem = data;
          console.log("解决问题的关键就是问题的关键",this.problem)
        } catch (error) {
          console.error('获取习题详情失败:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }
  
  .title {
    font-size: 30px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
  }
  
  .problem-title {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 15px;
    color: #555;
  }
  
  .problem-description {
    font-size: 16px;
    margin-bottom: 20px;
    color: #777;
  }
  
  .problem-meta p {
    font-size: 14px;
    color: #666;
    margin-bottom: 10px;
  }
  </style>
  