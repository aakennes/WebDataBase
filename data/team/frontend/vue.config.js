const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,

   // 配置多页面支持
   pages: {
    index: {
      entry: './src/main/index.js', // 首页入口文件
      template: './public/index.html', // 首页 HTML 模板
      filename: 'index.html', // 输出的 HTML 文件名
      title: 'Home Page', // 页面标题
    },
    problemSet: {
      entry: './src/main/problemSet.js', // 问题集入口文件
      template: './public/ProblemSet.html', // 问题集 HTML 模板
      filename: 'ProblemSet.html', // 输出的 HTML 文件名
      title: 'Problem Set', // 页面标题
    },
    problem:{
      entry: 'src/main/problem.js', // 问题集入口文件
      template: 'public/Problem.html', // 问题集 HTML 模板
      filename: 'Problem.html', // 输出的 HTML 文件名
      title: 'Problem Page', // 页面标题
    },
    profile: {
      entry: 'src/main/profile.js', // 问题集入口文件
      template: 'public/profile.html', // 问题集 HTML 模板
      filename: 'profile.html', // 输出的 HTML 文件名
      title: 'Profile Page', // 页面标题
    },
  }

})
