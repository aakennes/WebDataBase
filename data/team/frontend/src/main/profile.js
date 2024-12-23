import { createApp } from 'vue';
import Profile from '@/pages/profile.vue'; // 引入首页组件

const urlParams = new URLSearchParams(window.location.search);
const profileid = urlParams.get('profileid'); // 获取 cid
const uid = urlParams.get('uid'); // 获取 uid

console.log('uid from profile.js:', uid);

// 创建 Vue 应用实例并挂载到 #app
createApp(Profile, {uid, profileid}).mount('#app');
