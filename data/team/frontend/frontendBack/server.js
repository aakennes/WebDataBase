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

    // console.log("根据 uid 获取用户课程数据", results);
  
      if (results.length > 0) {
        res.json(results);  // 返回查询结果
      } else {
        res.status(404).send('No courses found for this uid');
      }
    });
  });



// API 路由：获取课程详情
app.get('/api/courseInfo', (req, res) => {
  const { cid } = req.query; // 从请求中获取课程 ID (cid)
  console.log("确认收到的课程 ID (cid)了啊:", cid); // 打印接收到的 cid

  // 检查是否提供了课程 ID
  if (!cid) {
      return res.status(400).send('课程 ID (cid) 是必需的');
  }

  // 查询课程详情  //"title","description","owner_id","passcode","number"
  const query = `
      SELECT 
          title,
          description,
          owner_id,
          passcode,
          number
      FROM 
          course
      WHERE 
          cid = ?
  `;

  // 执行查询
  db.execute(query, [cid], (err, results) => {
      if (err) {
          console.error('数据库查询失败:', err);
          return res.status(500).send('数据库查询失败');
      }

      if (results.length > 0) {
          res.json(results[0]); // 返回查询结果的第一个课程（因为 cid 是唯一的）
      } else {
          res.status(404).send('未找到指定的课程');
      }
  });
});




// 获取习题集信息
app.get('/api/problemsets', (req, res) => {
    const { cid } = req.query; // 从请求中获取 cid 参数
  
    // 检查是否提供了 cid
    if (!cid) {
      return res.status(400).send('cid is required');
    }
  
    // 查询习题集数据
    const query = `
      SELECT 
        psid,         -- 主键
        title,        -- 习题集标题
        description   -- 习题集描述
      FROM 
        problemset
      WHERE 
        cid = ?       -- 根据课程 ID 筛选
    `;
  
    db.execute(query, [cid], (err, results) => {
      if (err) {
        return res.status(500).send('Database query failed');
      }
  
      res.json(results); // 返回查询结果
    });
});


// API 路由：根据 psid 获取习题集具体信息
app.get('/api/problemset', (req, res) => {

  console.log("!!!!!!!!!!!!!!!!!!!!!!!!!已进入problemlist.js");

  const { psid } = req.query; // 从 URL 参数中获取 psid

  // 确保提供了 psid 参数
  if (!psid) {
    return res.status(400).send('psid 参数是必须的');
  }

  // 查询数据库获取与 psid 相关的习题集信息
  const query = `
    SELECT 
      psid,
      title,
      description,
      cid,
      owner_id,
      start_time,
      end_time
    FROM 
      problemset
    WHERE 
      psid = ?
  `;

  db.execute(query, [psid], (err, results) => {
    if (err) {
      console.error('查询数据库失败:', err);
      return res.status(500).send('数据库查询失败');
    }

    console.log("到底有没有！！！！！！！！！",results);

    // 如果查询到结果，返回结果；否则返回 404
    if (results.length > 0) {
      res.json(results[0]); // 返回查询结果的第一个习题集（因为 psid 是唯一的）
    } else {
      res.status(404).send('未找到对应的习题集');
    }
  });
});


// API 路由：根据 psid 获取习题集中所有题目
app.get('/api/problems', (req, res) => {
  const { psid } = req.query; // 获取传入的 psid 参数

  // 确保提供了 psid 参数
  if (!psid) {
    return res.status(400).send('psid 参数是必须的');
  }

  // 查询属于该习题集的所有题目信息
  const query = `
    SELECT 
      p.pid, 
      p.psid, 
      p.title, 
      p.submit_ac, 
      p.submit_all, 
      p.cases, 
      p.time_limit, 
      p.memory_limit, 
      p.owner_id
    FROM 
      problem p
    JOIN 
      problemset ps ON p.psid = ps.psid
    WHERE 
      p.psid = ?
  `;

  db.execute(query, [psid], (err, results) => {
    if (err) {
      console.error('查询数据库失败:', err);
      return res.status(500).send('数据库查询失败');
    }

    // 如果查询到结果，返回题目列表；否则返回空列表
    if (results.length > 0) {
      res.json(results);
    } else {
      res.status(404).send('未找到对应的题目');
    }
  });
});
  

 // API 路由：根据 psid 获取习题所有相关的信息
app.get('/api/problem', (req, res) => {
  const { psid } = req.query; // 从 URL 参数中获取 psid

  // 确保提供了 psid 参数
  if (!psid) {
      return res.status(400).send('psid 参数是必须的');
  }

  // 查询数据库获取与 psid 相关的习题信息
  const query = `
      SELECT 
          pid,
          psid,
          title,
          submit_ac,
          submit_all,
          cases,
          time_limit,
          memory_limit,
          owner_id
      FROM 
          problem
      WHERE 
          psid = ?
  `;

  db.execute(query, [psid], (err, results) => {
      if (err) {
          console.error('查询数据库失败:', err);
          return res.status(500).send('数据库查询失败');
      }

      // 如果查询到结果，返回结果；否则返回 404
      if (results.length > 0) {
          res.json(results);
      } else {
          res.status(404).send('未找到对应的习题');
      }
  });
});

// 获取当前用户在某个问题上的最高分
app.get('/api/highestScore', (req, res) => {
  const { uid, pid } = req.query;

  if (!uid || !pid) {
    return res.status(400).send('uid 和 pid 参数是必须的');
  }

  const query = `
    SELECT MAX(score) AS highestScore
    FROM solution
    WHERE uid = ? AND pid = ?
  `;

  db.execute(query, [uid, pid], (err, results) => {
    if (err) {
      console.error('查询最高分失败:', err);
      return res.status(500).send('数据库查询失败');
    }

    res.json({ highestScore: results[0].highestScore });
  });
});


// API 路由：提交题目
app.post('/api/submit', (req, res) => {
  const { uid, pid, code } = req.body;

  // 检查参数是否齐全
  if (!uid || !pid || !code) {
    return res.status(400).send('uid、pid 和 code 参数是必须的');
  }

  // 生成随机的运行时间、程序大小和分数
  const runTime = Math.floor(Math.random() * 5000) + 100; // 运行时间随机值（100ms - 5000ms）
  const codeSize = Buffer.byteLength(code, 'utf-8'); // 程序大小（以字节为单位）
  const runMemory = 65536; // 固定的内存使用（以 KB 为单位）
  const score = Math.floor(Math.random() * 11) * 10; // 分数随机值（0, 10, 20, ..., 100）
  const currentTime = new Date(); // 当前时间

  // 插入数据到 solution 表
  const query = `
    INSERT INTO solution (uid, pid, code_size, run_time, run_memory, \`when\`, score)
    VALUES (?, ?, ?, ?, ?, ?, ?)
  `;

  db.execute(query, [uid, pid, codeSize, runTime, runMemory, currentTime, score], (err, results) => {
    if (err) {
      console.error('插入数据失败:', err);
      return res.status(500).send('数据库插入失败');
    }

    // 返回成功结果
    res.json({
      message: '提交成功',
      result: {
        uid,
        pid,
        codeSize,
        runTime,
        runMemory,
        score,
        submittedAt: currentTime
      }
    });
  });
});



 // API 路由：根据 uid 获取个人信息
 app.get('/api/user-info', (req, res) => {
  const { uid } = req.query; // 从 URL 参数中获取 psid

  // 确保提供了 uid 参数
  if (!uid) {
      return res.status(400).send('uid 参数是必须的');
  }

  // 查询数据库获取与 psid 相关的习题信息
  const query = `
      SELECT 
          nickname,
          color,
          email,
          acnum,
          allnum
      FROM 
          user
      WHERE 
          uid = ?
  `;

  db.execute(query, [uid], (err, results) => {
      if (err) {
          console.error('查询数据库失败:', err);
          return res.status(500).send('数据库查询失败');
      }

      // 如果查询到结果，返回结果；否则返回 404
      if (results.length > 0) {
          // console.log("查询结果:", JSON.stringify(results, null, 2));
          res.json(results[0]);
      } else {
          res.status(404).send('未找到对应的个人');
      }
  });
});





app.get('/api/user-info-solutions', (req, res) => {
  const { uid } = req.query; // 从 URL 参数中获取 psid

  // 确保提供了 uid 参数
  if (!uid) {
      return res.status(400).send('uid 参数是必须的');
  }

  // 查询数据库获取与 psid 相关的习题信息
  const query = `
    SELECT 
        s.sid AS id,
        s.pid AS problemId,
        s.uid AS uid,
        u.nickname AS username,
        p.title AS title,
        s.score AS score
    FROM 
        solution s
    JOIN 
        user u ON s.uid = u.uid
    JOIN 
        problem p ON s.pid = p.pid
    WHERE 
        s.uid = ?
    ORDER BY 
        s.sid DESC
    LIMIT 7
  `;


  db.execute(query, [uid], (err, results) => {
      if (err) {
          console.error('查询数据库失败:', err);
          return res.status(500).send('数据库查询失败');
      }

      // 如果查询到结果，返回结果；否则返回 404
      if (results.length > 0) {
          res.json(results);
      } else {
          res.status(404).send('未找到对应的个人');
      }
  });
});

app.get("/api/messages", (req, res) => {
  const { uid } = req.query;

  if (!uid) {
    return res.status(400).send("uid 参数是必须的");
  }

  const query = `
    SELECT 
      m.umid, 
      m.from_uid, 
      m.to_uid, 
      m.text, 
      u.nickname, 
      u.color 
    FROM 
      user_message m
    JOIN 
      user u 
    ON 
      m.from_uid = u.uid
    WHERE 
      m.to_uid = ? 
    ORDER BY 
      m.umid DESC
  `;


  db.execute(query, [uid], (err, results) => {
    if (err) {
      console.error("查询留言失败:", err);
      return res.status(500).send("数据库查询失败");
    }
    res.json(results);
  });
});

// 提交新留言
app.post("/api/messages", (req, res) => {
  const { from_uid, to_uid, text } = req.body;

  if (!from_uid || !to_uid || !text) {
    return res.status(400).send("from_uid, to_uid 和 text 参数是必须的");
  }

  const query = `
    INSERT INTO user_message (from_uid, to_uid, text) 
    VALUES (?, ?, ?)
  `;

  db.execute(query, [from_uid, to_uid, text], (err) => {
    if (err) {
      console.error("插入留言失败:", err);
      return res.status(500).send("数据库插入失败");
    }
    res.json({ success: true, message: "留言提交成功" });
  });
});

// 启动服务器
app.listen(port, () => {
  console.log(`后端服务器运行在 http://localhost:${port}`);
});
