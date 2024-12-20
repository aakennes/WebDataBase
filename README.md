# WebDataBase

## 数据表说明

导入数据:

```sql
LOAD DATA LOCAL INFILE 'data/solution.csv'
     INTO TABLE solution
     FIELDS TERMINATED BY ',' 
     ENCLOSED BY '"'
     LINES TERMINATED BY '\n'
     IGNORE 1 ROWS;
```

由于生数据存在一些冗余列, 所以对生数据进行了缩减, 只保留有效列

同时除了 user.csv 包含全体数据外, 其他数据均只包含 cid = 12, 13, 14

user.csv 在生数据中也已清除密码, 现在的前台可以不检查密码直接通过

### user.csv

主键 : "uid"

其他键 : "gid","nickname","email"

无用键 : "qq","tel","realname","school","words","signup_time","removed","password"

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