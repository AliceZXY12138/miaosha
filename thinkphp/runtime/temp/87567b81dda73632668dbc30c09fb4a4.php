<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/www/wwwroot/101.37.13.45/public/../application/admin/view/test/login.html";i:1609597599;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login登录</title>
</head>
<body>

<header>
    <h1>请输入账号密码登录！</h1>
</header>
<section>
    <div>
        <form action="<?php echo url('signin'); ?>" method="post">
            <input type="text" name="username" placeholder="账号">
            <input type="password" name="password" placeholder="密码">
            <input type="submit">
        </form>
    </div>
</section>
</body>
</html>