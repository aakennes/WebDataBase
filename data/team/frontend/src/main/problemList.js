import { createApp } from 'vue';
import ProblemList from '@/pages/ProblemList.vue';

// 从 URL 获取 `psid`
const urlParams = new URLSearchParams(window.location.search);
const psid = urlParams.get('psid');

console.log('psid:', psid);

// 创建 Vue 实例并挂载
createApp(ProblemList, { psid }).mount('#app');
