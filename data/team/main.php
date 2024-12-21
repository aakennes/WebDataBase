<?php
session_start();

// 预设的用户名和密码
$valid_username = 'admin';
$valid_password = 'password123';

// 检查表单是否提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 验证用户名和密码
    if ($username === $valid_username && $password === $valid_password) {
        // 登录成功，设置会话
        $_SESSION['username'] = $username;
        header('Location: welcome.php');
        exit();
    } else {
        // 登录失败
        $error_message = "用户名或密码错误！";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录失败</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>登录失败</h2>
        <p style="color: red;"><?php if (isset($error_message)) echo $error_message; ?></p>
        <a href="login.html">返回登录页面</a>
    </div>
</body>
</html>
