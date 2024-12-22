
<!-- 模板开始 用来定义组件的结构（HTML 内容） -->
<template>
  <img alt="Vue logo" src="./assets/logo.png">
  <!-- msg 是传递给 HelloWorld 组件的一个 prop（属性） -->
  <div>
    
    <router-view />
  </div>

  <div id="app">
    <nav>
      <!-- 全局导航链接 -->
      <router-link to="/">HomePage</router-link>
      
      <br>
      <router-link to="/hello">HelloWorld</router-link>
    </nav>
    <router-view /> <!-- 路由出口，渲染匹配的页面组件 -->
  </div>

</template>
<!-- 模板结束 -->




<!-- <script> 是 Vue 的脚本部分，用来定义组件的逻辑（例如数据、方法、生命周期等） -->
<script>
//import HelloWorld from './components/HelloWorld.vue'

export default {
  name: 'App',
  components: {
    //HelloWorld 
  }
//   注册子组件 HelloWorld，使其可以在当前组件中使用。注册后，可以在 <template> 部分中通过 <HelloWorld /> 使用这个组件。

}
</script>
<!-- <script>结束 -->





<!-- <style> 是 Vue 的样式部分，用来定义组件的 CSS 样式。 -->
<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
