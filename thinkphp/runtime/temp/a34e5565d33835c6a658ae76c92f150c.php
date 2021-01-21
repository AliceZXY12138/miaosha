<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"/www/wwwroot/101.37.13.45/public/../application/admin/view/test/detoken.html";i:1609597579;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>token解析页面</title>
</head>
<body>
<header>
    <h1>请输入您的token字符串</h1>
</header>
<section>
    <form action="<?php echo url('token'); ?>" method="post">
        <input type="text" name="token">
        <input type="submit">
    </form>
</section>
</body>
</html>