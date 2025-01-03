import { createApp } from 'vue';
import ProblemPage from '@/pages/Problem.vue'; // 引入 Problem.vue 组件


// 从 URL 获取 `cid`
const urlParams = new URLSearchParams(window.location.search);
const psid = urlParams.get('psid'); // 获取 cid
const uid = urlParams.get('uid');
const pid = urlParams.get('pid');
console.log('psid:', psid);

// 创建 Vue 应用实例并挂载到 #app
createApp(ProblemPage, {uid, psid , pid }).mount('#app');
