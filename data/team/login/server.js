const express = require("express");
const path = require("path");
const mysql = require("mysql2");
const bodyParser = require("body-parser");

const app = express();

// 使用 body-parser 解析 JSON 请求
app.use(bodyParser.json());
// 设置静态文件目录，确保可以访问 public 文件夹中的文件
app.use(express.static(path.join(__dirname, "public")));

const db = mysql.createConnection({
    host: "localhost", 			// 数据库主机
    user: "root", 				// 数据库用户名
    password: "pwd", 		// 替换为你的 MySQL 密码
    database: "Web_Database", 	// 数据库名称
});

db.connect((err) => {
    if (err) {
        console.error("数据库连接失败:", err);
    } else {
        console.log("已成功连接到数据库");
    }
});

app.post('/api/register', (req, res) => {
    const { email, nickname, color, acnum, allnum } = req.body;

    // 查询当前最大的 uid
    const getMaxUidQuery = "SELECT MAX(uid) AS maxUid FROM user";
    db.query(getMaxUidQuery, (err, results) => {
        if (err) {
            console.error(err);
            return res.status(500).json({ success: false, message: "获取最大 uid 失败" });
        }

        const maxUid = results[0].maxUid || 0; // 如果没有记录，maxUid 默认为 0
        const newUid = maxUid + 1;

        // 插入新用户记录
        const insertUserQuery = `
            INSERT INTO user (uid, nickname, email, color, acnum, allnum)
            VALUES (?, ?, CONCAT(?, '@mail.nankai.edu.cn'), ?, ?, ?)
        `;

        db.query(insertUserQuery, [newUid, nickname, email, color, acnum, allnum], (err) => {
            if (err) {
                console.error(err);
                return res.status(500).json({ success: false, message: "数据库插入失败" });
            }

            res.json({ success: true });
        });
    });
});


app.post("/api/check-email", (req, res) => {
    const { email } = req.body;
    if (!email) {
        return res.status(400).json({ message: "Email is required" });
    }

    const query = "SELECT COUNT(*) AS count FROM user WHERE email = CONCAT(?, '@mail.nankai.edu.cn')";
	console.log(query);
    db.query(query, [email], (err, results) => {
        if (err) {
            console.error("数据库查询错误:", err);
            return res.status(500).json({ message: "Internal Server Error" });
        }

        const count = results[0].count;
        if (count > 0) {
            res.json({ exists: true }); 	// Email 存在
        } else {
            res.json({ exists: false }); 	// Email 不存在
        }
    });
});

const os = require('os');
const { exec } = require("child_process");

// 获取本机真实 IP 地址
function getLocalIPAddress() {
    const interfaces = os.networkInterfaces();
    for (const iface of Object.values(interfaces)) {
        for (const config of iface) {
            if (config.family === 'IPv4' && !config.internal) {
                return config.address; // 返回非内网地址
            }
        }
    }
    return 'localhost'; // 找不到真实地址时使用 localhost
}

app.post("/api/login", (req, res) => {
    const { email, isBackend } = req.body;

    if (!email) {
        return res.status(400).json({ success: false, message: "Email is required" });
    }

    const query = "SELECT COUNT(*) AS count, uid FROM user WHERE email = CONCAT(?, '@mail.nankai.edu.cn')";
    db.query(query, [email], (err, results) => {
        if (err) {
            console.error("数据库查询错误:", err);
            return res.status(500).json({ success: false, message: "Internal Server Error" });
        }

        if (results.length > 0) {
            const uid = results[0].uid; // 获取 UID
            const ipAddress = getLocalIPAddress();
            
            if (isBackend) {
				// console.log(`获取到的 IP 地址: ${ipAddress}`);
                // 动态启动后台服务
                exec("cd ../backend && php yii serve", (err, stdout, stderr) => {
                    if (err) {
                        console.error(`启动后台服务失败: ${stderr}`);
                        return res.status(500).json({ success: false, message: "启动后台失败" });
                    }

                    console.log(`后台服务启动成功: ${stdout}`);
                    res.json({ success: true, redirectUrl: `http://localhost:8080/backend?uid=${uid}` });
                });
            } else {
                // 动态启动前台服务
                const frontendCommand = exec("cd ../frontend && npm run serve");

                let frontendPort = null;

                // 捕获服务输出日志
                frontendCommand.stdout.on("data", (data) => {
                    console.log(`前台服务输出: ${data}`);
                    const portMatch = data.match(/Local:.*http:\/\/.*:(\d+)/); // 修改正则
                    if (portMatch && !frontendPort) {
                        frontendPort = portMatch[1];
                        console.log(`前台服务启动成功，端口: ${frontendPort}`);

                        // 返回给前端
                        res.json({
                            success: true,
                            redirectUrl: `http://${ipAddress}:${frontendPort}?uid=${uid}`,
                        });
                    }
                });

                // 捕获服务启动错误
                frontendCommand.stderr.on("data", (data) => {
                    console.error(`前台服务启动失败: ${data}`);
                });

                // 监听服务关闭事件
                frontendCommand.on("close", (code) => {
                    if (!frontendPort) {
                        console.error("无法启动前台服务，未获取端口信息");
                        res.status(500).json({ success: false, message: "启动前台失败" });
                    }
                });
            }
        } else {
            // 学号不存在
            res.status(401).json({ success: false, message: "学号不存在" });
        }
    });
});



// 当访问根路径时重定向到 login.html
app.get("/", (req, res) => {
    res.sendFile(path.join(__dirname, "public", "login.html"));
});

const PORT = 5000;
app.listen(PORT, () => {
    console.log(`Server is running at http://localhost:${PORT}/login.html`);
});
