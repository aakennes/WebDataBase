import { createApp } from 'vue';
import Profile from '@/pages/profile.vue'; // 引入首页组件

const uid = window.uid; // 获取 uid

console.log('uid from profile.js:', uid);

// 创建 Vue 应用实例并挂载到 #app
createApp(Profile, {uid}).mount('#app');
