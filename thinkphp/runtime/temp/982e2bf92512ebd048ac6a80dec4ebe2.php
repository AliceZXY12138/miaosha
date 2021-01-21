<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"/www/wwwroot/101.37.13.45/public/../application/admin/view/staff/staff_add.html";i:1611225788;s:66:"/www/wwwroot/101.37.13.45/application/admin/view/public/baidu.html";i:1605245648;}*/ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>秒杀小店-管理员管理-添加</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/temp/X-admin/css/font.css">
	<link rel="stylesheet" href="/temp/X-admin/css/xadmin.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.jquery.min.js"></script>
    <script src="/temp/X-admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/temp/X-admin/js/xadmin.js"></script>

</head>
<body>
    <!-- 中部开始 -->
    <div class="wrapper">
        <!-- 右侧主体开始 -->
        <div class="page-content">
          <div class="content">
            <!-- 右侧内容框架，更改从这里开始 -->
            <form class="layui-form"  action="javascript:edit();">
                <div class="layui-form-item">
                    <label for="L_user_id" class="layui-form-label">
                        <span class="x-red">*</span>用户编号
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_user_id" name="user_id" required="" disabled="" lay-verify="id"
                        autocomplete="off" class="layui-input" value="自动生成">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>不可修改
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_username" class="layui-form-label">
                        <span class="x-red">*</span>用户名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_username" name="username" required=""  lay-verify="username"
                        autocomplete="off" class="layui-input" value="">
                    </div>
                    
                </div>
                <div class="layui-form-item">
                    <label for="L_password" class="layui-form-label">
                        <span class="x-red">*</span>密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_password" name="password" required="" disabled="" lay-verify="password"
                        autocomplete="off" class="layui-input" value="123456">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>不可修改，默认密码为123456
                    </div>
                </div>
        
                <div class="layui-form-item" id="rrole">
                    <label for="L_status" class="layui-form-label">
                        <span class="x-red">*</span>身份
                    </label>
                    <div class="layui-input-inline">
                        <?php if(is_array($roles) || $roles instanceof \think\Collection || $roles instanceof \think\Paginator): $k = 0; $__LIST__ = $roles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                            <input type="radio" name="role_id" value="<?php echo $vo['role_id']; ?>" title="<?php echo $vo['role_name']; ?>">
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                
            
                <div class="layui-form-item">
                    <label for="L_edit" class="layui-form-label">
                    </label>
                    
                    <button  class="layui-btn" lay-filter="edit" lay-submit="javascript:;" >
                        确定
                        
                    </button>
                </div>
            </form>
            <!-- 右侧内容框架，更改从这里结束 -->
          </div>
        </div>
        <!-- 右侧主体结束 -->
    </div>
    <!-- 中部结束 -->

    <script type="text/javascript">
        function edit(){  
            
            var username = $('#L_username').val();
            var role_id = $('#rrole input[name="role_id"]:checked ').val();
            
            if(typeof(role_id)=="undefined"){
                layer.msg('身份不得为空',{icon:1,time:1000});
            }
            else{

                var str = "username/"+username+"/role_id/"+role_id;
                var url="/index.php/admin/staff/submit_add/"+str+".html"
                
                $.get(url, function(data,status){
                    
                    if(status=="success"){
                        parent.layer.closeAll();
                        parent.layer.msg('添加成功',{icon:1,time:1000});
                        window.parent.location.href=window.parent.location.href;
                    }
                });
            }
        }
    </script>


    <script>
    //百度统计可去掉
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
</body>
</html>