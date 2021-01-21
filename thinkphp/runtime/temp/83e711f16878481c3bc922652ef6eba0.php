<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/www/wwwroot/101.37.13.45/public/../application/admin/view/test/token.html";i:1609598138;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Token</title>
</head>
<body>
<header>
    <h1>Token解析结果！</h1>
</header>
<section>
    <div>
        <p>用户名：<?php echo $token->user; ?></p>
        <p>密码：<?php echo $token->pwd; ?></p>
    </div>
    <div>
        <a href="<?php echo url('index'); ?>">返回主页</a>
    </div>
</section>
</body>
</html>