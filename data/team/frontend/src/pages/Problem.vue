<template>
 <div class="container">
    <!-- 题目配置 -->
    <div class="section-title">
      <h2>📖 题目</h2>
    </div>
    <div v-if="problem.length > 0">
      <ul class="problem-details">
        <li><strong>题目名：</strong> {{ problem[0].title }}</li>
        <li><strong>编号：</strong> {{ problem[0].pid }}</li>
        <li><strong>时间限制：</strong> {{ problem[0].time_limit }} ms</li>
        <li><strong>空间限制：</strong> {{ problem[0].memory_limit }} KiB</li>
        <li><strong>最高分：</strong> {{ highestScore !== null ? highestScore : '未提交' }}</li>
        <li><strong>通过率：</strong> {{ problem[0].submit_ac }} / {{ problem[0].submit_all }}</li>
        <li><strong>评测全部测试点：</strong> 是</li>
        <li><strong>Special Judge：</strong> 未启用</li>
      </ul>
    </div>
    <p v-else>加载中...</p>

   <!-- 操作按钮 -->
   <div class="actions">
      <button class="submit-problem-btn" @click="showSubmitDialog = true">
        <i class="icon">✈</i> 提交题目
      </button>
      <button class="view-record-btn">
        <i class="icon">✔</i> 提交记录
      </button>
    </div>

    <!-- 提交题目对话框 -->
    <div v-if="showSubmitDialog" class="dialog-overlay">
      <div class="dialog">
        <h3>提交题目</h3>
        <textarea v-model="submissionCode" placeholder="在此输入代码"></textarea>
        <div class="dialog-actions">
          <button @click="submitProblem">提交</button>
          <button @click="showSubmitDialog = false">取消</button>
        </div>
      </div>
    </div>

    <!-- 提交结果消息 -->
    <div v-if="submitMessage" class="submit-message" :class="{'success': submitSuccess, 'error': !submitSuccess}">
      {{ submitMessage }}
    </div>
  </div>
  
</template>
  
<script>
  export default {
    name: 'ProblemPage',
    props: ["psid", "uid"], // 从父组件或 URL 中传递课程 ID (cid)
    data() {
      return {
        problem: [], // 从后端加载的习题详情
        highestScore: null, // 初始化最高分
        showSubmitDialog: false, // 控制提交对话框的显示
        submissionCode: '' // 存储用户输入的代码
      };
    },
    created() {

      // 如果 psid 存在，加载习题详情
      if (this.psid) {
        this.fetchProblemDetails();
      } else {
        console.error('未提供 psid 参数');
      }

      if(this.uid) {
        this.fetchHighestScore();
      } else {
        console.error('未提供 uid 或 psid 参数');
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
          this.pid = this.problem[0].pid;
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
      // 从后端获取当前用户在该问题上的最高分
      async fetchHighestScore() {
        try {
          const response = await fetch(`http://localhost:3000/api/highestScore?uid=${this.uid}&pid=${this.pid}`);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const data = await response.json();
          this.highestScore = data.highestScore;
          console.log("当前uid", this.uid);
          console.log("当前pid", this.pid);
          console.log("当前用户的最高分", this.highestScore);
        } catch (error) {
          console.error('获取最高分失败:', error);
        }
      },
// 提交题目
      async submitProblem() {
        try {
          const response = await fetch(`http://localhost:3000/api/submit`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              uid: this.uid,
              pid: this.pid,
              code: this.submissionCode
            })
          });
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const data = await response.json();
          console.log("提交结果", data);
          this.submitMessage = '提交成功';
          this.submitSuccess = true;
          this.showSubmitDialog = false; // 关闭对话框
        } catch (error) {
          console.error('提交题目失败:', error);
          this.submitMessage = '提交失败';
          this.submitSuccess = false;
        }
      }
    },
  };
</script>
  
  <style scoped>
.container {
  max-width: 600px;
  margin: 130px auto;
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

.dialog-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.dialog {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  width: 400px;
  max-width: 90%;
}

.dialog h3 {
  margin-top: 0;
}

.dialog textarea {
  width: 100%;
  height: 150px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
  margin-bottom: 20px;
}

.dialog-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

.dialog-actions button {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.dialog-actions button:first-child {
  background: #0f9d58;
  color: #fff;
}

.dialog-actions button:last-child {
  background: #d93025;
  color: #fff;
}

.submit-message {
  margin-top: 20px;
  padding: 10px;
  border-radius: 4px;
  text-align: center;
}

.submit-message.success {
  background: #d4edda;
  color: #155724;
}

.submit-message.error {
  background: #f8d7da;
  color: #721c24;
}
  </style>
  