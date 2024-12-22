const express = require('express');
const cors = require('cors');
const mysql = require('mysql2');
const app = express();
const port = 3000;

// 中间件
app.use(cors()); // 允许跨域请求
app.use(express.json()); // 解析 JSON 数据


// 配置 MySQL 数据库连接
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'pwd',
    database: 'Web_Database'
  });


// API 路由：根据 uid 获取用户课程数据
app.get('/api/courses', (req, res) => {
    const { uid } = req.query;  // 获取前端传递的 uid

    // 确保传递了 uid
    if (!uid) {
      return res.status(400).send('uid is required');
    }
  
    // 查询数据库获取与 uid 相关的课程数据
    const query =  `
    SELECT 
        c.cid,
        c.title,
        c.description,
        c.owner_id,
        c.passcode,
        c.number
    FROM 
        course_user cu
    JOIN 
        course c ON cu.cid = c.cid
    WHERE 
        cu.uid = ?
    
    `;
    
    db.execute(query, [uid], (err, results) => {
      if (err) {
        return res.status(500).send('Database query failed');
      }
  
      if (results.length > 0) {
        res.json(results);  // 返回查询结果
      } else {
        res.status(404).send('No courses found for this uid');
      }
    });
  });


// // 模拟数据
// const data = {
//   courses: [
//     { id: 1, name: "高级语言程序设计", status: "未加入" },
//     { id: 2, name: "数据结构", status: "已加入" },
//     { id: 3, name: "操作系统", status: "未加入" },
//     { id: 4, name: "计算机网络", status: "已加入" },
//     { id: 5, name: "人工智能", status: "未加入" },
//     { id: 6, name: "编译原理", status: "未加入" },
//     { id: 7, name: "并行程序设计", status: "未加入" }
//   ],
//   exams: [
//     { id: 1, type: "考试", name: "高级语言程序设计2-2上机考试", time: "2023/6/8 17:14:59" },
//     { id: 2, type: "考试", name: "高级语言程序设计2-1上机考试", time: "2023/2/25 21:49:59" }
//   ],
//   competitions: [
//     { id: 1, type: "竞赛", name: "NKPC19-现场赛", time: "2023/4/22 16:59:59" },
//     { id: 2, type: "竞赛", name: "NKPC19-网络赛", time: "2023/4/19 18:59:59" }
//   ]
// };

// // API 路由：获取数据
// app.get('/api/data', (req, res) => {
//   res.json(data); // 返回 JSON 数据
// });


// 根路由：返回包含当前数据的 HTML 页面
app.get('/', (req, res) => {
    // 查询数据库获取所有课程数据
    const query = `
    SELECT 
        c.cid AS id,
        c.title AS name,
        c.description,
        c.owner_id,
        c.passcode,
        c.number
    FROM 
        course c
    `;
    
    db.execute(query, (err, results) => {
      if (err) {
        return res.status(500).send('Database query failed');
      }
  
      let html = `
        <html>
          <head>
            <title>当前数据</title>
            <style>
              body { font-family: Arial, sans-serif; margin: 20px; }
              h1 { color: #333; }
              pre { background: #f4f4f4; padding: 10px; border: 1px solid #ddd; }
            </style>
          </head>
          <body>
            <h1>当前数据</h1>
            <pre>${JSON.stringify(results, null, 2)}</pre>
          </body>
        </html>
      `;
      res.send(html);
    });
});

// 启动服务器
app.listen(port, () => {
  console.log(`后端服务器运行在 http://localhost:${port}`);
});
