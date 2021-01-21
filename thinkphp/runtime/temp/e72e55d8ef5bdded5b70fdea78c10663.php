<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"/www/wwwroot/101.37.13.45/public/../application/admin/view/test/signin.html";i:1609597626;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录结果</title>
</head>
<body>

<header>
    <h1>恭喜你，登录成功！</h1>
</header>
<section>
    <div>
        您的账号信息：
    </div>
    <div>
        <p>用户名：<?php echo $username; ?></p>
        <p>密  码：<?php echo $password; ?></p>
    </div>
    <div>
        <p>您的token</p>
        <p style="background-color: red;color: yellow"><?php echo $token; ?></p>
    </div>
    <div>
        <a href="<?php echo url('detoken'); ?>">去解析看看~</a>
    </div>
</section>
</body>
</html>