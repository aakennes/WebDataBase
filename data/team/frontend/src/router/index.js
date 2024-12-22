import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '@/components/HomePage.vue'; // 引入主页组件
import HelloWorld from '@/components/HelloWorld.vue'; // 引入 HelloWorld 组件

const routes = [
  {
    path: '/', // 路径为 /
    name: 'HomePage',
    component: HomePage, // 主页
  },
  {
    path: '/hello', // 路径为 /hello
    name: 'HelloWorld',
    component: HelloWorld, // HelloWorld 页面
  },
];

const router = createRouter({
  history: createWebHistory(), // 使用 HTML5 History 模式
  routes,
});

export default router;
