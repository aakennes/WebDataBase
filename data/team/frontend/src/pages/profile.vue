<template>
  <div class="container">
    <div v-if="isLoading" class="loading">
      <p>加载中，请稍候...</p>
    </div>
    <div v-else class="content-wrapper">
      <!-- 用户信息部分 -->
      <div class="profile-info">
        <div class="avatar-profile">
          <div class="avatar-profile-img" :style="{ backgroundColor: userInfo.color || '#ccc' }">
            <span>{{ userInfo.nickname ? userInfo.nickname[0] : 'N/A' }}</span>
          </div>
        </div>
        <div class="user-details">
          <h3>{{ userInfo.nickname || '未知用户' }}</h3>
          <p><strong>Email:</strong> {{ userInfo.email || '暂无邮箱' }}</p>
          <p>
            <strong>头像颜色:</strong>
            <span :style="{ color: userInfo.color || '#ccc' }">{{ userInfo.color || '无' }}</span>
          </p>
          <p><strong>总通过数:</strong> {{ userInfo.acnum }}</p>
          <p><strong>总提交数:</strong> {{ userInfo.allnum }}</p>
        </div>
      </div>

      <!-- 最近提交记录部分 -->
      <div class="recent-submissions">
        <h3>最近提交记录</h3>
        <table v-if="recentSubmissions.length > 0">
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
        <p v-else>暂无提交记录</p>
      </div>
    </div>

    <!-- 留言功能 -->
    <div class="message-container">
      <!-- 留言输入框 -->
      <textarea
        v-model="newMessage"
        placeholder="评论"
        rows="4"
        class="message-input"
      ></textarea>
      <button class="submit-button" @click="submitMessage">提交留言</button>
      <!-- 留言列表 -->
      <div class="message-list">
        <div v-for="(message, index) in messages" :key="message.umid" class="message-item">
          <div class="message-header">
            <div class="avatar">
              <div class="avatar-img" :style="{ backgroundColor: message.color || '#ccc' }">
                <span>{{ message.nickname ? message.nickname[0] : 'N/A' }}</span>
              </div>
            </div>
            <div class="message-info">
              <span class="message-floor">#{{ index + 1 }}</span>
              <span class="message-author">{{ message.nickname || "匿名" }}</span>
            </div>
          </div>
          <!-- 添加一个留言正文框 -->
          <div class="message-body-wrapper">
            <div class="message-body">
              <p>{{ message.text }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>
</template>


<script>
import axios from "axios";
export default {
  name: "ProfilePage",
  props: ["uid"],
  data() {
    return {
      userInfo: {
        nickname: "",
        color: "",
        email: "",
        acnum: 0,
        allnum: 0,
      },
      recentSubmissions: [],
      isLoading: true,
      newMessage: "", // 存储新留言内容
      messages: [], // 存储所有留言
    };
  },
  methods: {
    // 提交留言
    async submitMessage() {
      if (this.newMessage.trim()) {
        try {
          const response = await axios.post("http://localhost:3000/api/messages", {
            from_uid: this.uid,
            to_uid: this.uid, // 留言发送给自己
            text: this.newMessage.trim(),
          });
          if (response.data.success) {
            this.newMessage = ""; // 清空输入框
            await this.fetchMessages(); // 重新获取留言列表
          }
        } catch (error) {
          console.error("提交留言失败:", error);
        }
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
          this.userInfo = { ...response.data };
        }
      } catch (error) {
        console.error("加载用户信息失败:", error);
      }
    },
    // 获取最近提交记录
    async fetchRecentSubmissions() {
      try {
        const response = await axios.get("http://localhost:3000/api/user-info-solutions", {
          params: { uid: this.uid },
        });
        if (response.data) {
          this.recentSubmissions = response.data;
        }
      } catch (error) {
        console.error("加载最近提交记录失败:", error);
      }
    },
    // 获取所有留言
    async fetchMessages() {
      try {
        const response = await axios.get("http://localhost:3000/api/messages", {
          params: { uid: this.uid },
        });
        if (response.data) {
          this.messages = response.data;
        }
      } catch (error) {
        console.error("加载留言失败:", error);
      }
    },
  },
  async created() {
    try {
      await Promise.all([this.fetchUserInfo(), this.fetchRecentSubmissions(), this.fetchMessages()]);
    } catch (error) {
      console.error("加载数据时发生错误:", error);
    } finally {
      this.isLoading = false;
    }
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
.avatar-profile {
  margin-left: 0px;
  margin-top: 30px;
}

.avatar-profile-img {
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

/* 留言容器样式 */
.message-container {
  background: #f9f9f9; /* 背景颜色 */
  border-radius: 10px; /* 圆角 */
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* 阴影效果 */
  margin-top: 20px;
}

/* 留言输入框样式 */
.message-input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-bottom: 10px;
  font-size: 14px;
}

/* 提交按钮样式 */
.submit-button {
  display: inline-block;
  background: linear-gradient(120deg, #ab31e4, #e431bd); /* 按钮渐变色 */
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  font-weight: bold;
}

.submit-button:hover {
  background: linear-gradient(120deg, #7e24a8, #ad138b); /* 按钮渐变色反转 */
}

/* 留言列表样式 */
.message-list {
  margin-top: 10px;
  padding: 0;
}

/* 留言单条样式 */
.message-item {
  background: white;
  margin-bottom: 10px;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column; /* 修改为垂直排列 */
  align-items: flex-start;
}

.message-body-wrapper {
  border: 1px solid #ddd; /* 边框颜色 */
  border-radius: 5px; /* 圆角 */
  padding: 10px;
  margin-top: 10px;
  background: #f9f9f9; /* 背景色 */
  width: 100%; /* 宽度填充父容器 */
}
.message-body {
  font-size: 14px;
  color: #444;
  line-height: 1.5;
  word-wrap: break-word; /* 自动换行 */
  white-space: pre-wrap; /* 保留换行 */
}

/* 头像样式 */
.avatar {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  overflow: hidden;
  margin-right: 15px;
}

.avatar-img {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  font-size: 18px;
  color: white;
  font-weight: bold;
  text-transform: uppercase;
}

/* 留言头部样式 */
.message-header {
  display: flex;
  align-items: center;
  margin-bottom: 5px;
}

.message-floor {
  font-size: 12px;
  color: #888;
  margin-right: 10px;
}

.message-author {
  font-size: 16px;
  font-weight: bold;
  color: #333;
}

/* 留言内容样式 */
.message-body {
  font-size: 14px;
  color: #444;
  line-height: 1.5;
  word-wrap: break-word; /* 自动换行 */
  white-space: pre-wrap; /* 保留换行 */
}



</style>
