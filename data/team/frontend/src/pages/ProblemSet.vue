<template>
  <div class="container">
    <!-- 显示课程信息 -->
    <h1 class="title">{{ course.description }}</h1>
    <p class="subtitle">课程 ID: #{{ course.number }}</p>

    <!-- 习题集列表 -->
    <div class="problemsets">
      <h3 class="section-title">
        <i class="icon">📖</i> 考试题目 >>
      </h3>
      <div v-if="problemsets.length > 0">
        <ul class="problem-list">
          <li 
            v-for="problemset in problemsets" 
            :key="problemset.psid" 
            class="problem-item"
            @click="goToProblem(problemset.psid)" 
          >
            <div class="problem-title">
              第{{ problemset.psid }}题: {{ problemset.title }}
            </div>
            <div 
              class="problem-status"
              :class="{
                'not-submitted': problemset.status === '未提交',
                'failed': problemset.status === '未通过',
                'success': problemset.status === '已通过'
              }"
            >
              {{ problemset.status }}
            </div>
          </li>
        </ul>
      </div>
      <p v-else class="no-problems">暂无考试题目</p>
    </div>
  </div>
  </template>


<script>
  export default {
  name: "ProblemSet",
  props: ["cid", 'uid'], // 从父组件或 URL 中传递课程 ID (cid)
  data() {
    return {
      course: {}, // 初始化课程信息为空对象
      problemsets: [] // 初始化习题集为空数组
    };
  },
  async created() {
    // 在组件创建时获取课程详情和习题集数据
    await this.fetchCourseDetails();
    await this.fetchProblemSets();
  },
  methods: {
    // 获取课程信息
    async fetchCourseDetails() {
      console.log("开始在ProblemSet页面抓取课程信息")
      try {
        const response = await fetch(`http://localhost:3000/api/courseInfo?cid=${this.cid}`);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.course = data;
        console.log("课程详情",this.course);
      } catch (error) {
        console.error("获取课程详情失败:", error);
      }
    },
    // 获取习题集信息
    async fetchProblemSets() {
      console.log("开始在ProblemSet页面抓取习题集信息")
      try {
        const response = await fetch(`http://localhost:3000/api/problemsets?cid=${this.cid}`);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.problemsets = data; // 成功获取数据后赋值
        console.log("成败在此一举",this.problemsets);
      } catch (error) {
        console.error("获取习题集失败:", error);
        this.problemsets = []; // 出现错误时将习题集初始化为空数组
      }
    },

    // 跳转到问题详情页面
    goToProblem(psid) {
      
      window.location.href = `Problem.html?uid=${this.uid}&psid=${psid}`;
    }

  }
};
</script>
  
<style scoped>
.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 60px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
}

.title {
  font-size: 35px;
  font-weight: bolder;
  color: #333;
  margin-bottom: 10px;
}

.subtitle {
  font-size: 16px;
  color: #888;
  margin-bottom: 20px;
}

.section-title {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 15px;
  color: #555;
  display: flex;
  align-items: center;
}

.section-title .icon {
  font-size: 24px;
  margin-right: 8px;
}

.problemsets {
  border-top: 1px solid #eee;
  padding-top: 20px;
}

.problem-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.problem-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  margin-bottom: 10px;
  background: #fff;
  border: 1px solid #eee;
  border-radius: 6px;
  transition: background-color 0.3s ease; /* 添加平滑过渡效果 */
}

.problem-item:hover {
  background-color: #f5f5f5; /* 鼠标悬停时变为灰色 */
}

.problem-title {
  font-size: 18px;
  font-weight: bold;
  color: #333;
}

.problem-status {
  font-size: 14px;
  font-weight: bold;
  padding: 4px 8px;
  border-radius: 4px;
  text-align: center;
}

.problem-status.not-submitted {
  background: #ffedcc;
  color: #d48806;
}

.problem-status.failed {
  background: #ffcccc;
  color: #d93025;
}

.problem-status.success {
  background: #d4edda;
  color: #28a745;
}

.no-problems {
  text-align: center;
  color: #888;
  font-size: 16px;
  margin-top: 20px;
}
  </style>
  