<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:77:"/www/wwwroot/101.37.13.45/public/../application/admin/view/user/user_add.html";i:1611219778;s:66:"/www/wwwroot/101.37.13.45/application/admin/view/public/baidu.html";i:1605245648;}*/ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>秒杀小店-商品管理-编辑</title>
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
            <form class="layui-form"  action="javascript:add();">
                
                <div class="layui-form-item">
                    <label for="L_customer_id" class="layui-form-label">
                        <span class="x-red">*</span>用户编号
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_customer_id" name="customer_id" required="" lay-verify="id"
                        autocomplete="off" class="layui-input" value="">
                    </div>
                    
                </div>
                <div class="layui-form-item">
                    <label for="L_customer_name" class="layui-form-label">
                        <span class="x-red">*</span>用户名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_customer_name" name="customer_name" required="" lay-verify="goodname"
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
                <div class="layui-form-item">
                    <label for="L_address" class="layui-form-label">
                        <span class="x-red">*</span>地址
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_address" name="address" required="" lay-verify="address"
                        autocomplete="off" class="layui-input" value="">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_phone" class="layui-form-label">
                        <span class="x-red">*</span>电话
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_phone" name="phone"  required=""
                        autocomplete="off" class="layui-input"  value="">
                    </div>
                </div>
                
            
                <div class="layui-form-item">
                    <label for="L_edit" class="layui-form-label">
                    </label>
                    
                    <button  class="layui-btn" lay-filter="edit" lay-submit="javascript:;" >
                        修改
                        
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
        function add(){
            
            var customer_id = $('#L_customer_id').val();
            var customer_name = $('#L_customer_name').val();
            
            var address = $('#L_address').val();
            var phone = $('#L_phone').val();
           
            var str = "customer_id/"+customer_id+"/customer_name/"+customer_name+"/address/"+address+"/phone/"+phone;
            var url="/index.php/admin/user/submit_add/"+str+".html"
            
            $.get(url, function(data,status){
                
                if(status=="success"){
                    parent.layer.closeAll();
                    parent.layer.msg('修改成功',{icon:1,time:1000});
                    window.parent.location.href=window.parent.location.href;
                }
            });

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