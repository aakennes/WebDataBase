<template>
  <div class="container">
    <div class="content-wrapper">
      <!-- 用户信息部分 -->
      <div class="profile-info">
        <div class="avatar">
          <!-- <img src="https://via.placeholder.com/150" alt="Avatar" /> -->
          <div class="avatar-img" :style="{ backgroundColor: userInfo.color }">
            <span>{{ userInfo.nickname[0] }}</span>
          </div>

        </div>
        <div class="user-details">
          <h3>{{ userInfo.nickname }}</h3>
          <p><strong>Email:</strong> {{ userInfo.email }}</p>
          <p>
            <strong>头像颜色:</strong>
            <span :style="{ color: userInfo.color }">{{ userInfo.color }}</span>
          </p>
          <p><strong>总通过数:</strong> {{ userInfo.acnum }}</p>
          <p><strong>总提交数:</strong> {{ userInfo.allnum }}</p>
        </div>
      </div>

      <!-- 最近提交记录部分 -->
      <div class="recent-submissions">
        <h3>最近提交记录</h3>
        <table>
          <thead>
            <tr>
              <th>pid</th>
              <th>uid</th>
              <th>用户名</th>
              <th>题目名</th>
              <th>分数</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="record in recentSubmissions" :key="record.id">
              <td>#{{ record.problemId }}</td>
              <td>u:{{ record.uid }}</td>
              <td>@{{ record.username }}</td>
              <td>{{ record.title }}</td>
              <td :class="{'score-pass': record.score >= 60, 'score-fail': record.score < 60}">
                {{ record.score }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
    </div>
    <div class="message-section">
      <h3>留言功能</h3>
      <!-- 留言输入框 -->
      <textarea
        v-model="newMessage"
        placeholder="请输入您的留言"
        rows="4"
        class="message-input"
      ></textarea>
      <!-- 提交按钮 -->
      <button class="submit-button" @click="submitMessage">提交留言</button>
      <!-- 留言列表 -->
      <ul class="message-list">
        <li v-for="(message, index) in messages" :key="index">
          <pre>{{ message }}</pre> <!-- 使用 pre 标签保留换行格式 -->
        </li>
      </ul>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: "ProfilePage",
  data() {
    return {
      // 用户信息
      userInfo: {
        nickname: "张三",
        color: "red",
        email: "zhangsan@example.com",
        acnum: 120,
        allnum: 300,
      },
      // 最近提交记录
      recentSubmissions: [
        { id: 1, problemId: "101", uid: "462913", username: "吴佳璇", title: "二进制转十进制", score: 95 },
        { id: 2, problemId: "102", uid: "03083", username: "张三", title: "高级语言程序设计", score: 88 },
        { id: 3, problemId: "103", uid: "462914", username: "李四", title: "计算机网络", score: 100 },
        { id: 4, problemId: "104", uid: "05085", username: "王五", title: "编译原理", score: 72 },
        { id: 5, problemId: "105", uid: "462915", username: "赵六", title: "数据库", score: 56 },
        { id: 6, problemId: "105", uid: "462915", username: "赵六", title: "数据库", score: 56 },
        { id: 7, problemId: "105", uid: "462915", username: "赵六", title: "数据库", score: 56 },
      ],
      // 留言功能
      newMessage: "", // 存储新留言内容
      messages: [], // 存储所有留言
    };
  },
  methods: {
    // 提交留言
    submitMessage() {
      if (this.newMessage.trim()) {
        const nickname = this.userInfo?.nickname || "匿名"; // 使用用户昵称或默认值
        const messageContent = `${nickname}:
            ${this.newMessage.trim()}`; // 拼接昵称和留言内容，支持换行
        this.messages.push(messageContent); // 添加到留言列表
        this.newMessage = ""; // 清空输入框
      } else {
        alert("留言不能为空！");
      }
    },
    // 获取用户信息
    async fetchUserInfo() {
      try {
        const response = await axios.get("http://localhost:3000/api/user-info", {
          params: { uid: this.uid },
        });
        if (response.data) {
          this.userInfo = response.data;
        }
      } catch (error) {
        console.error("加载用户信息失败:", error);
      }
    },
    // 获取最近提交记录
    async fetchRecentSubmissions() {
      try {
        const response = await axios.get("http://localhost:3000/api/courses", {
          params: { uid: this.uid },
        });
        if (response.data) {
          this.recentSubmissions = response.data;
        }
      } catch (error) {
        console.error("加载最近提交记录失败:", error);
      }
    },
    
  },
  created() {
    this.fetchUserInfo();
    this.fetchRecentSubmissions();
  },
};
</script>


<style scoped>
/* 容器样式 */
.container {
  padding-top: 100px;
  width: 90%;
  max-width: 1200px;
  margin: 20px auto;
  font-family: Arial, sans-serif;
}

.content-wrapper {
  display: flex;
  flex-direction: row; /* 左右排布 */
  gap: 20px;
}

/* 用户信息部分样式 */
.profile-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: #ffffff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 20px;
}
.avatar {
  margin-left: 0px;
  margin-top: 30px;
}
/* .avatar img {
  border-radius: 50%;
  width: 200px;
  height: 200px;
  margin-bottom: 20px;
} */

.avatar-img {
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  margin-bottom: 30px;
  width: 190px;
  height: 190px;
  font-size: 48px;
  color: #fff;
  font-weight: bold;
  text-transform: uppercase;
}


.user-details {
  text-align: left;
  padding-left: 30px;
}

.user-details h3 {
  margin: 0;
  font-size: 24px;
  color: #333;
}

.user-details p {
  margin: 15px 0;
  font-size: 16px;
  color: #666;
}

.user-details span {
  font-weight: bold;
}

/* 最近提交记录部分样式 */
.recent-submissions {
  flex: 2;
  background-color: #ffffff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 40px;
}

.recent-submissions h3 {
  font-size: 30px;
  margin-top: 0px;
  margin-bottom: 25px;
  color: #333;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

thead {
  background-color: rgb(185, 111, 158);
}

th, td {
  padding: 10px;
  text-align: left;
  border: 1px solid #ddd;
}

th {
  font-weight: bold;
  color: #333;
}

.score-pass {
  color: green;
}

.score-fail {
  color: red;
}

.message-section {
  margin-top: 20px;
  padding: 20px;
  background-color: #fffcfc;
  border: 1px solid #ddd;
  border-radius: 8px;
}

.message-section h3 {
  font-size: 20px;
  color: #333;
  margin-bottom: 10px;
}

.message-input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  margin-bottom: 10px;
  font-size: 14px;
  font-family: Arial, sans-serif;
}

.submit-button {
  display: inline-block;
  background-color: #b63796;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
}

.submit-button:hover {
  background-color: #45a049;
}

.message-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.message-list li {
  background-color: #ffffff;
  border: 1px solid #ddd;
  border-radius: 4px;
  margin-top: 10px;
  padding: 10px;
}

</style>
