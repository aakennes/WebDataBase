<template>
<div class="container">
    <!-- 标题 -->
    <h1 class="title">{{ problemSet.title }}</h1>
    <p class="subtitle">作业 ID: #{{ problemSet.psid }}</p>

    <!-- 描述部分 -->
    <div class="problemset-meta">
      <p><strong>描述:</strong> {{ problemSet.description }}</p>
      <p><strong>课程 ID:</strong> {{ problemSet.cid }}</p>
      <p><strong>开始时间:</strong> {{ formatTime(problemSet.start_time) }}</p>
      <p><strong>结束时间:</strong> {{ formatTime(problemSet.end_time) }}</p>
    </div>

    <!-- 问题列表 -->
    <div class="problem-list">
      <h3 class="section-title">
        <i class="icon">📖</i> 作业列表
      </h3>
      <div v-if="problems.length > 0">
        <ul class="problem-items">
          <li 
            v-for="problem in problems" 
            :key="problem.pid" 
            class="problem-item"
          >
            <div class="problem-title"
            @click="goToProblemDetails(this.psid, this.uid, problem.pid)">
            
             >> 第{{ problem.pid }}题 : {{ problem.title }}
            </div>
          </li>
        </ul>
      </div>
      <p v-else>暂无考试题目</p>
    </div>
  </div>
</template>
  


<script>
export default {
  name: "ProblemList",
  props: ["psid","uid"], // 接收传入的习题集 ID
  data() {
    return {
      problemSet: {}, // 当前习题集信息
      problems: [] // 习题集内的问题列表
    };
  },
  created() {
    if (this.psid) {
      this.fetchProblemSetDetails();
      this.fetchProblemList();


    } else {
      console.error("未提供 psid 参数");
    }
  },
  methods: {
    // 获取习题集详情
    async fetchProblemSetDetails() {
      try {
        console.log("此时psid是", this.psid);
        const response = await fetch(`http://localhost:3000/api/problemset?psid=${this.psid}`);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.problemSet = data;
      } catch (error) {
        console.error("获取习题集详情失败:", error);
      }
    },
    // 获取问题列表
    async fetchProblemList() {
      try {
        const response = await fetch(`http://localhost:3000/api/problems?psid=${this.psid}`);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.problems = data;
      } catch (error) {
        console.error("获取问题列表失败:", error);
      }
    },
     // 格式化时间
     formatTime(timestamp) {
      const date = new Date(timestamp);
      return date.toLocaleString();
    },
    goToProblemDetails(psid,uid,pid){
        window.location.href = `Problem.html?psid=${psid}&uid=${uid}&pid=${pid}`;
    }
  }
};
  </script>
  
  <style scoped>
.container {
  max-width: 900px;
  margin: 130px auto;
  padding: 40px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.title {
  font-size: 35px;
  font-weight: bold;
  margin-bottom: 10px;
  color: #333;
}

.subtitle {
  font-size: 16px;
  color: #888;
  margin-bottom: 20px;
}

.problemset-meta p {
  font-size: 14px;
  color: #666;
  margin-bottom: 10px;
}

.section-title {
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 15px;
  color: #555;
  display: flex;
  align-items: center;
}

.section-title .icon {
  font-size: 25px;
  margin-right: 8px;
}

.problem-list {
  border-top: 1px solid #eee;
  padding-top: 20px;
}

.problem-items {
  list-style: none;
  padding: 0;
  margin: 0;
}

.problem-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  margin-bottom: 15px;
  background: #f9f9f9;
  border: 1px solid #eee;
  border-radius: 6px;
}

.problem-title {
  font-size: 21px;
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
  </style>
  