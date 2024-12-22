<template>

    <div class="container">
    <!-- 我的课程部分 -->
    <div v-if="courses.length > 0" class="section">
      <h3>我的课程</h3>
      <div class="courses-grid">
        <div v-for="course in courses" :key="course.id" class="card">
          <p>{{ course.name }}</p>
          <button v-if="course.status === '未加入'" class="btn btn-primary">加入课程</button>
          <p v-else>已加入</p>
        </div>
      </div>
    </div>

    <!-- 竞赛考试部分 -->
    <div v-if="exams.length > 0 || competitions.length > 0" class="section">
      <h3>竞赛考试</h3>
      <!-- 考试 -->
      <div v-for="exam in exams" :key="exam.id" class="card exam">
        <h4 class="title text-danger">{{ exam.type }}</h4>
        <p>{{ exam.name }}</p>
        <small>{{ exam.time }}</small>
      </div>
      <!-- 竞赛 -->
      <div v-for="competition in competitions" :key="competition.id" class="card competition">
        <h4 class="title text-success">{{ competition.type }}</h4>
        <p>{{ competition.name }}</p>
        <small>{{ competition.time }}</small>
      </div>
    </div>

    <!-- 报名竞赛 -->
    <div class="section">
      <button class="btn btn-secondary">报名竞赛考试</button>
    </div>
  </div>

  
  </template>
  
  <script>
  export default {
    name: 'HomePage',
    data() {
    return {
      // 示例数据
      courses: [
         { id: 1, name: "高级语言程序设计", status: "未加入" },
        { id: 2, name: "数据结构", status: "已加入" },
        { id: 3, name: "操作系统", status: "未加入" },
        { id: 4, name: "计算机网络", status: "已加入" },
        { id: 5, name: "编译原理", status: "未加入" }
      ],
      exams: [
        { id: 1, type: "考试", name: "高级语言程序设计2-2上机考试", time: "2023/6/8 17:14:59" },
        { id: 2, type: "考试", name: "高级语言程序设计2-1上机考试", time: "2023/2/25 21:49:59" }
      ],
      competitions: [
        { id: 1, type: "竞赛", name: "NKPC19-现场赛", time: "2023/4/22 16:59:59" },
        { id: 2, type: "竞赛", name: "NKPC19-网络赛", time: "2023/4/19 18:59:59" }
      ]
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    // 模拟获取动态数据
    async fetchData() {
      try {
        // 使用 fetch 从 API 获取数据
        const response = await fetch('/api/data');
        const data = await response.json();

        // 更新数据
        this.courses = data.courses || [];
        this.exams = data.exams || [];
        this.competitions = data.competitions || [];
      } catch (error) {
        console.error('获取数据失败:', error);
      }
    },
    mounted() {
    // 动态加载 custom.js
      const script = document.createElement("script");
      script.src = "assets/js/custom.js";
      script.defer = true;
      document.body.appendChild(script);
    },

    }
  };
  </script>
  
  <style scoped>
.container {
  background-color: #f8f9fa;
  margin: 40px auto;
  max-width: 1000px;
  padding: 30px; /* 添加 padding 属性 */
  border-radius: 10px;
}
.section {
  margin-bottom: 30px;
}

.courses-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* 两列布局！！！！！！！！！ */
  gap: 20px; /* 每个卡片之间的间距 */
}

.card {
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.card .title {
  font-weight: bold;
}
.btn {
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
}
.btn-primary {
  background-color: #007bff;
  color: white;
  border: none;
}
.btn-secondary {
  background-color: #6c757d;
  color: white;
  border: none;
}
  </style>
  