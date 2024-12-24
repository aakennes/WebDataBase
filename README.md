# WebDataBase

course -> 团队

user   -> 个人

登录界面 : node.js

前台界面 : Vue.js(https://vuejs.org/api/)

登录界面及前台界面后端 : node.js

后台界面 : Yii2

后台界面后端 : php

登录端口 : 5000

如果以上端口被占用，需要清理以上端口

## 文件结构
```
--  team---  login       --
	 |		
	 +---  frontend     --
	 |
	 +---  backend	     --
```

## 环境要求

环境要求:

```
npm 10.7.0 +
mysql 5.7 +
node v22.12.0 +
php 8.1 +
Composer 2.2.6 +
```


在team文件夹中使用以下指令初始化并运行:

```bash
# 加载数据库
make refresh-db
# 初始化并运行
make all
# 安装所需安装包
make install
# 运行项目
make start
```

## 数据表说明

导入数据:

```sql
LOAD DATA LOCAL INFILE 'data/data/problem.csv'
     INTO TABLE temptable
     FIELDS TERMINATED BY ',' 
     ENCLOSED BY '"'
     LINES TERMINATED BY '\n'
     IGNORE 1 ROWS;
```

导出数据:

```sql
SELECT * 
INTO OUTFILE '/var/lib/mysql-files/course.csv'
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"' 
LINES TERMINATED BY '\n'
FROM course;
```

由于生数据存在一些冗余列, 所以对生数据进行了缩减, 只保留有效列

同时除了 user.csv 包含全体数据外, 其他数据均只包含 cid = 12, 13, 14

user.csv 在生数据中也已清除密码, 现在的前台可以不检查密码直接通过

导入sql:

```bash
mysql -u root -p Web_Database < Web_Database_backup.sql
```

导出sql(非必要进制导出sql到install.sql中):
```bash
mysqldump -u root -p Web_Database > Web_Database_backup.sql
```


### user.csv

用户表, 表明了用户信息

主键 : "uid"

其他键 : "gid","nickname","email","color","acnum","allnum"

无用键 : "qq","tel","realname","school","words","signup_time","removed","password"

### user_message.csv

留言表

主键 : umid

其他键 : from_uid, to_uid, text

### message.csv

信息表, 张贴在首页

主键 : "mid"

其他键 : "title","content","when"

无用键 : "from","to","from_del","to_del","cid","psid"

### solution.csv

提交记录表

主键 : "sid"

其他键 : "uid","pid","code_size","run_time","run_memory","when","score"

无用键 : "status_id","lang_id","share","detail","compile_info"

### course.csv

课程信息表

主键 : "cid"

其他键 : "title","description","owner_id","passcode","number"

无用键 : "visiable","teacher","semester"

### course_user.csv

课程 id(cid) 与用户 id(uid) 的对应表

主键 : "cid","uid"

### problemset.csv

习题集信息表

主键 : "psid"

其他键 : "title","description","during","cid","owner_id"

无用键 : "private","secret_time","type"

### problemset_maintainer.csv

习题集创建者表, 表明该习题题由某个 user 创建

主键 : "psid","uid"

### problemset_user.csv

习题集 id(psid) 与用户 id(uid) 的对应表

主键 : "psid","uid"

### problem.csv

习题信息表

主键 : "pid"

其他键 : "psid","title","submit_ac","submit_all","cases","time_limit","memory_limit","owner_id"

// cases 表示样例个数

无用键 : "extra","special_judge","detail_judge","extension"

### problem_maintainer.csv

题目创建者表, 表明该题目由某个 user 创建

主键 : "pid","uid"

### problem_user.csv

习题 id(pid) 与用户 id(uid) 的对应表

主键 : "pid","uid"