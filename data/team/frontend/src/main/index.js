import { createApp } from 'vue';
import Index from '@/pages/index.vue'; // 引入首页组件


// 从 window 中获取 uid
const uid = window.uid;

console.log("!@!@!@!@!@!@!@!",uid);

createApp(Index, { uid }).mount('#app');
