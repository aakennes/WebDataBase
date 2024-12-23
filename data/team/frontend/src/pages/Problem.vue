<template>
 <div class="container">
    <!-- 题目配置 -->
    <div class="section-title">
      <h2>📖 题目配置</h2>
    </div>
    <div v-if="problem">
      <ul class="problem-details">
        <li><strong>题目名：</strong> {{ problem[0].title }}</li>
        <li><strong>编号：</strong> {{ problem[0].pid }}</li>
        <li><strong>时间限制：</strong> {{ problem[0].time_limit }} ms</li>
        <li><strong>空间限制：</strong> {{ problem[0].memory_limit }} KiB</li>
        <li><strong>最高分：</strong>
          <span :class="{'status-success': problem.status === '已通过', 'status-failed': problem.status !== '已通过'}">
            {{ problem[0].status }}
          </span>
        </li>
        <li><strong>通过率：</strong> {{ problem[0].submit_ac }} / {{ problem[0].submit_all }}</li>
        <li><strong>评测全部测试点：</strong> 是</li>
        <li><strong>Special Judge：</strong> 未启用</li>
      </ul>
    </div>
    <p v-else>加载中...</p>

   <!-- 操作按钮 -->
   <div class="actions">
      <button class="submit-problem-btn">
        <i class="icon">✈</i> 提交题目
      </button>
      <button class="view-record-btn">
        <i class="icon">✔</i> 提交记录
      </button>
    </div>
  </div>
  
</template>
  
<script>
  export default {
    name: 'ProblemPage',
    props: ["psid"], // 从父组件或 URL 中传递课程 ID (cid)
    data() {
      return {
        problem: [], // 从后端加载的习题详情
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
          if (this.problem.length > 0) {
              console.log("习题详情", this.problem[0].title);
          } else {
              console.log("没有找到习题详情");
          }

        } catch (error) {
          console.error('获取习题详情失败:', error);
        }
      },
    },
  };
</script>
  
  <style scoped>
.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.section-title {
  font-size: 20px;
  font-weight: bold;
  color: #333;
  margin-bottom: 10px;
  display: flex;
  align-items: center;
}

.problem-details {
  list-style: none;
  padding: 0;
  margin: 0 0 20px 0;
}

.problem-details li {
  font-size: 16px;
  margin-bottom: 8px;
}

.status-success {
  color: green;
}

.status-failed {
  color: red;
}

.quick-jump select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
  margin-bottom: 20px;
}

.actions {
  display: flex;
  flex-direction: column; /* 垂直排列按钮 */
  gap: 10px;
}

.submit-problem-btn,
.view-record-btn {
  padding: 10px 0;
  border: 1.5px solid transparent;
  border-radius: 8px;
  font-size: 18px;
  font-weight: bold;
  text-align: center;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.submit-problem-btn {
  color: #a6197d;
  border-color: #a6197d;
  background-color: transparent;
}

.view-record-btn {
  color: #0f9d58;
  border-color: #0f9d58;
  background-color: transparent;
}

.submit-problem-btn:hover {
  background-color: rgba(166, 25, 125, 0.1);
}

.view-record-btn:hover {
  background-color: rgba(15, 157, 88, 0.1);
}

.icon {
  font-size: 24px;
  margin-right: 8px;
}
  </style>
  