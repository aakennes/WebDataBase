<template>

  <div class="container">
    <!-- 我的课程部分 -->
    <div v-if="courses.length > 0" class="section">
      <h3>我的课程</h3>
      <div class="courses-grid">
        <div v-for="course in courses" :key="course.cid" class="card">
          <a :href="`ProblemSet.html?cid=${course.cid}`" class="title">{{ course.title }}</a>
          <a :href="`ProblemSet.html?cid=${course.cid}`" class="description">{{ course.description }}</a>
          <button v-if="course.status === '未加入'" class="btn btn-primary">加入课程</button>
          <p v-else>已加入</p>
        </div>
      </div>
    </div>
  </div>

</template>
  
<script>
  export default {
    name: 'HomePage',
    props: ['uid'],  // 接收从外部传入的 uid
  data() {
    return {
      courses: [] // 课程数据
    };
  },
  created() {
    this.fetchCourses(); // 页面加载时获取课程数据
  },
  methods: {
   // 从后端获取课程数据
   async fetchCourses() {
      try {
        const response = await fetch(`http://localhost:3000/api/courses?uid=${this.uid}`);
        console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!",this.uid);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        console.log("data出来了没！！！！",data);
        this.courses = data || []; // 更新课程数据
        console.log("hahahhahahahhahaha",this.courses)
      } catch (error) {
        console.error('获取课程数据失败:', error);
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
  /* margin-top: -20px; */
  padding-top: 100px;
  background-color: #f8f9fa;
  margin: 60px auto;
  max-width: 1000px;
  /* padding: 30px;  */
  border-radius: 10px;
}
.section {
  margin-bottom: 30px;
}

.courses-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* 两列布局 */
  gap: 20px; /* 每个卡片之间的间距 */
}

.card {
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.card .title {
  font-size: 1.1em; /* 增大字体大小 */
  font-weight: bold; /* 加粗字体 */
  margin-bottom: 10px; /* 增加与描述之间的间距 */
}
.card .description {
  font-size: 0.8em; /* 减小字体大小 */
  color: #7e7e7e; /* 设置较浅的颜色 */
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
  background-color: #979da3;
  color: white;
  border: none;
}
  </style>
  