<template>
  <div class="container">
    
    <div class="content-wrapper">
      
      <!-- 左侧团队信息 -->

      <!-- 习题集列表 -->
      <div class="main-section">
        <!-- 显示课程信息 -->
        <h1 class="title">{{ course.description }}</h1>
        <p class="subtitle">课程 ID: #{{ this.cid }}</p>
        <div class="problemsets">
          <h3 class="section-title">
            <i class="icon">📖</i> 作业习题集 >>
          </h3>
          <div v-if="problemsets.length > 0">
            <ul class="problem-list">
              <li 
                v-for="problemset in problemsets" 
                :key="problemset.psid" 
                class="problem-item"
                @click="goToProblem(problemset.psid,this.uid)" 
              >
                <div class="problem-title">
                  习题集{{ problemset.psid }}: {{ problemset.title }}
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
          <p v-else class="no-problems">暂无作业题目</p>
        </div>
      </div>
      <div class="team-section">
        <h3 class="team-title">管理员</h3>
        <div class="team-list">
          <div 
            v-for="member in authorMembers" 
            :key="member.uid" 
            class="team-member"
            @mouseover="showTooltip(member.nickname)"
            @mouseout="hideTooltip"
            @click="goToProfile(member.uid)" 
            title="点击查看个人资料"
          >
            <div class="avatar" :style="{ backgroundColor: member.color || '#ccc' }">
              <span>{{ member.nickname[0] }}</span>
            </div>
            <div v-if="tooltipVisible && member.nickname === tooltipText" class="tooltip">
              {{ tooltipText }}
            </div>
          </div>
        </div>
        <h3 class="team-title">成员</h3>
        <div class="team-list">
          <div 
            v-for="member in teamMembers" 
            :key="member.uid" 
            class="team-member"
            @mouseover="showTooltip(member.nickname)"
            @mouseout="hideTooltip"
            @click="goToProfile(member.uid)" 
            title="点击查看个人资料"
          >
            <div class="avatar" :style="{ backgroundColor: member.color || '#ccc' }">
              <span>{{ member.nickname[0].toUpperCase() }}</span>
            </div>
            <div v-if="tooltipVisible && member.nickname === tooltipText" class="tooltip">
              {{ tooltipText }}
            </div>
          </div>
        </div>
        <div class="pagination">
          <button @click="prevPage" :disabled="currentPage === 1">上一页</button>
          <button @click="nextPage" :disabled="this.teamMembers.length !== 20 ">下一页</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
  import axios from 'axios';
  export default {
    name: "ProblemSet",
    props: ["cid", "uid"], // 从父组件或 URL 中传递课程 ID (cid) 和用户 ID (uid)
    data() {
      return {
        course: {}, // 初始化课程信息为空对象
        problemsets: [], // 初始化习题集为空数组
        teamMembers: [], // 团队成员信息
        authorMembers: [],
        currentPage: 1, // 当前分页
        itemsPerPage: 20, // 每页显示的成员数
        tooltipText: "", // 悬停显示的昵称
        tooltipVisible: false // 悬停提示是否可见
      };
    },
    async created() {
      console.log("此时用户uid是", this.uid); // 检查 uid 是否正确传递
      await this.fetchCourseDetails();
      await this.fetchProblemSets();
      await this.fetchauthorMembers();
      this.fetchTeamMembers(); // 获取团队成员信息
    },
    methods: {
      // 获取课程信息
      async fetchCourseDetails() {
        console.log("开始在ProblemSet页面抓取课程信息");
        try {
          const response = await fetch(`http://localhost:3000/api/courseInfo?cid=${this.cid}`);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const data = await response.json();
          this.course = data;
          console.log("课程详情", this.course);
        } catch (error) {
          console.error("获取课程详情失败:", error);
        }
      },
      // 获取习题集信息
      async fetchProblemSets() {
        console.log("开始在ProblemSet页面抓取习题集信息");
        try {
          const response = await fetch(`http://localhost:3000/api/problemsets?cid=${this.cid}`);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const data = await response.json();
          this.problemsets = data; // 成功获取数据后赋值
          console.log("成败在此一举", this.problemsets);
        } catch (error) {
          console.error("获取习题集失败:", error);
          this.problemsets = []; // 出现错误时将习题集初始化为空数组
        }
      },
      // 获取团队成员信息
      async fetchTeamMembers() {
        try {
          const response = await axios.get(`http://localhost:3000/api/get-team-members`, {
            params: { cid: this.cid, page: this.currentPage }
          });
          this.teamMembers = response.data;
        } catch (error) {
          console.error("加载团队成员失败:", error);
        }
      },
      // 获取管理员员信息
      async fetchauthorMembers() {
        try {
          const response = await axios.get(`http://localhost:3000/api/get-team-authors`, {
            params: { cid: this.cid}
          });
          this.authorMembers = response.data;
        } catch (error) {
          console.error("加载团队成员失败:", error);
        }
      },
      // 跳转到问题详情页面
      goToProblem(psid) {
        window.location.href = `ProblemList.html?uid=${this.uid}&psid=${psid}`;
      },
      // 分页逻辑
      prevPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
          this.fetchTeamMembers();
        }
      },
      nextPage() {
        if(this.teamMembers.length == 20){
          this.currentPage++;
          this.fetchTeamMembers();
        }
        
      },
      // 显示和隐藏悬停提示
      showTooltip(nickname) {
        console.log("showTooltip" + nickname);
        this.tooltipText = nickname;
        this.tooltipVisible = true;
      },
      hideTooltip() {
        this.tooltipText = "";
        this.tooltipVisible = false;
      },
      goToProfile(profileId) {
        const uid = this.uid; // 当前用户的 UID
        window.location.href = `profile.html?uid=${uid}&profileid=${profileId}`;
      },
    }
  };
</script>

  
<style scoped>
.container {
  max-width: 1200px;
  margin: 130px auto;
  padding: 60px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
  display: flex;
  flex-direction: row;
}

.content-wrapper {
  display: flex;
  flex-wrap: nowrap;
  width: 100%;
}

.team-section {
  flex: 1;
  background: #f9f9f9;
  padding: 10px 25px 25px 35px;
  border-radius: 8px;
  margin-left: 15px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.team-list {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.team-member {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  font-size: 16px;
  color: #fff;
  font-weight: bold;
  background: #ccc;
  cursor: pointer;
}

.team-member:hover .tooltip {
  display: block;
}

.tooltip {
  position: absolute;
  background-color: #333;
  color: #fff;
  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  z-index: 100;
  transform: translateY(-30px); /* 提升到头像上方 */
  opacity: 0.9;
}

.avatar {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  overflow: hidden;
  /* margin-right: 15px; */
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

.main-section {
  flex: 3;
  margin: 20px;
}

.pagination {
  margin-top: 10px;
  display: flex;
  padding: 25px;
  justify-content: space-between;
}
.pagination button {
  padding: 5px 10px;
  border: none;
  background: #007bff;
  color: #fff;
  border-radius: 4px;
  cursor: pointer;
}
.pagination button:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.title {
  font-size: 35px;
  font-weight: bolder;
  color: #333;
  margin-bottom: 10px;
}

.team-title {
  font-size: 25px;
  font-weight: bolder;
  color: #333;
  margin-top: 20px;
  margin-bottom: 20px;
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
  margin: 20px;
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
  