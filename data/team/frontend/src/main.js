import { createApp } from 'vue'
import App from './App.vue'
import router from './router'; // 确保路由文件路径正确


//createApp(App).mount('#app')

const app = createApp(App); // 创建 Vue 应用实例

app.use(router); // 使用路由
app.mount('#app');
