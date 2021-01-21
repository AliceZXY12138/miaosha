<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"/www/wwwroot/101.37.13.45/public/../application/admin/view/goods/good_edit.html";i:1611208893;s:66:"/www/wwwroot/101.37.13.45/application/admin/view/public/baidu.html";i:1605245648;}*/ ?>
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
            <form class="layui-form"  action="javascript:edit();">
                
                <div class="layui-form-item">
                    <label for="L_good_id" class="layui-form-label">
                        <span class="x-red">*</span>商品编号
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_good_id" name="good_id" required="" disabled="" lay-verify="id"
                        autocomplete="off" class="layui-input" value="<?php echo $info['good_id']; ?>">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>不可修改
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_goodname" class="layui-form-label">
                        <span class="x-red">*</span>商品名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_goodname" name="goodname" required=""  lay-verify="goodname"
                        autocomplete="off" class="layui-input" value="<?php echo $info['goodname']; ?>">
                    </div>
                    
                </div>
                <div class="layui-form-item">
                    <label for="L_description" class="layui-form-label">
                        <span class="x-red">*</span>描述
                    </label>
                    <div class="layui-input-block">
                        <input type="text" id="L_description" name="description" required="" lay-verify="description"
                        autocomplete="off" class="layui-input" value="<?php echo $info['description']; ?>">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_stock" class="layui-form-label">
                        <span class="x-red">*</span>库存
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_stock" name="stock" required="" lay-verify="stock"
                        autocomplete="off" class="layui-input"  value="<?php echo $info['stock']; ?>">
                    </div>
                </div>
                <div class="layui-form-item" id="ssstatus">
                    <label for="L_status" class="layui-form-label">
                        <span class="x-red">*</span>状态
                    </label>

                    <div class="layui-input-inline">
                            <input type="radio" name="status" value="1" <?php echo $s1; ?> title="在售">
                            <input type="radio" name="status" value="0" <?php echo $s2; ?> title="下架">
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
        function edit(){
            
            var good_id = $('#L_good_id').val();
            var goodname = $('#L_goodname').val();
            var description = $('#L_description').val();
            var stock = $('#L_stock').val();
            var mystatus = $('#ssstatus input[name="status"]:checked ').val();
           

            var str = "good_id/"+good_id+"/goodname/"+goodname+"/description/"+description+"/stock/"+stock+"/status/"+mystatus;
            var url="/index.php/admin/goods/submit_edit/"+str+".html"
            //var str1 = "{id:"+id+",username:"+username+",name:"+name+",gender:"+gender+",phone:"+phone+",email:"+email+"}";
            //alert(url);
            
            $.get(url, function(data,status){
                
                if(status=="success"){
                    parent.layer.closeAll();
                    parent.layer.msg('修改成功',{icon:1,time:1000});
                    window.parent.location.href=window.parent.location.href;
                }
            });
            //alert(typeof(id));
            /*$.ajax({
                type:"post",
                url:"member_del",   //数据传输的控制器方法
                data:{"id":id},//这里data传递过去的是序列化以后的字符串
                success:function(data){
                    alert(data);//获取成功以后输出返回值
                    parent.layer.closeAll();
                    parent.layer.msg('修改成功',{icon:1,time:1000});
                    //window.parent.location.href=window.parent.location.href;
                }
             });*/

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