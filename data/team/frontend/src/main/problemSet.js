import { createApp } from 'vue';
import ProblemSet from '@/pages/ProblemSet.vue'; // 引入 Vue 组件

// 从 URL 获取 `cid`
const urlParams = new URLSearchParams(window.location.search);
const cid = urlParams.get('cid'); // 获取 cid
const uid = urlParams.get('uid'); // 获取 uid


console.log('cid:', cid);
console.log('uid:', uid);

// 创建 Vue 实例，并将 cid 传递到组件
createApp(ProblemSet, { uid, cid }).mount('#app');
