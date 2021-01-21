<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:75:"/www/wwwroot/101.37.13.45/public/../application/admin/view/order/index.html";i:1611220867;s:69:"/www/wwwroot/101.37.13.45/application/admin/view/public/menu_top.html";i:1609683904;s:70:"/www/wwwroot/101.37.13.45/application/admin/view/public/menu_left.html";i:1609691881;s:72:"/www/wwwroot/101.37.13.45/application/admin/view/public/menu_bottom.html";i:1605245412;s:78:"/www/wwwroot/101.37.13.45/application/admin/view/public/background_change.html";i:1609574901;s:66:"/www/wwwroot/101.37.13.45/application/admin/view/public/baidu.html";i:1605245648;}*/ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>秒杀小店-商品管理</title>
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
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="./index.html">秒杀小店后台管理系统</a></div>
        <div class="open-nav"><i class="iconfont">&#xe699;</i></div>
        <ul class="layui-nav right" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;"><?php echo $username; ?></a>
            <dl class="layui-nav-child"><!-- 二级菜单 -->
              <dd><a href="goto_userinfo">个人信息</a></dd>
              <dd><a href="logout">切换帐号</a></dd>
              <dd><a href="logout">退出</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item"><a href="/">前台首页</a></li>
        </ul>
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
    <div class="wrapper">
        <!-- 左侧菜单开始 -->
       <div class="left-nav">
    <div id="side-nav">
      <ul id="nav">
        <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
          <li class='<?php echo $vo['class']; ?>'>
              <a href='<?php echo url("$vo[action]"); ?>'>
                  <i class="iconfont">&#xe761;</i>
                  <?php echo $vo['node_name']; ?>
                  <i class="iconfont nav_right">&#xe697;</i>
              </a>
          </li>
          <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
  </div>
        <!-- 左侧菜单结束 -->
        <!-- 右侧主体开始 -->
        <div class="page-content">
          <div class="content">
            <!-- 右侧内容框架，更改从这里开始 -->
            <fieldset class="layui-elem-field layui-field-title site-title">
              <legend><a name="default">订单管理</a></legend>
            </fieldset>
            <xblock>
                <button class="layui-btn layui-btn-danger" onclick="exportAll()"><i class="layui-icon">&#xe640;</i>批量导出</button>
                <span class="x-right" style="line-height:40px">共有数据：<?php echo $orders_size; ?> 条</span>
            </xblock>
            
            
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="" value="" onclick="swapCheck()">
                        </th>
                        <th>编号</th>
                        <th>用户名</th>
                        <th>商品编号</th>
                        <th>商品名</th>
                        <th>数量</th>
                        <th>时间</th>
                        <th>地址</th>
                        <th>电话</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($lists) || $lists instanceof \think\Collection || $lists instanceof \think\Paginator): $k = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                    <tr>
                        <td>
                            <input type="checkbox" value="1" name="">
                        </td>
                        
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $vo['customer_name']; ?></td>
                        <td><?php echo $vo['good_id']; ?></td>
                        <td><?php echo $vo['goodname']; ?></td>
                        <td><?php echo $vo['num']; ?></td>
                        <td><?php echo $vo['time']; ?></td>
                        <td><?php echo $vo['address']; ?></td>
                        <td><?php echo $vo['phone']; ?></td>
                        
                        
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
                
            </table>
          
            <!-- 右侧内容框架，更改从这里结束 -->
          </div>
        </div>
        <!-- 右侧主体结束 -->
    </div>
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright">Copyright ©2017 x-admin v2.3 All Rights Reserved. 本后台系统由X前端框架提供前端技术支持</div>  
    </div>
    <!-- 底部结束 -->
    <!-- 背景切换开始 -->
	<div class="bg-changer">
        <div class="swiper-container changer-list">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/a.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/b.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/c.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/d.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/e.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/f.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/g.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/h.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/i.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/j.jpg" alt=""></div>
                <div class="swiper-slide"><img class="item" src="/temp/X-admin/images/k.jpg" alt=""></div>
                <div class="swiper-slide"><span class="reset">初始化</span></div>
            </div>
        </div>
        <div class="bg-out"></div>
        <div id="changer-set"><i class="iconfont">&#xe696;</i></div>   
    </div>
    <!-- 背景切换结束 -->
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

    <script type="text/javascript">
		//checkbox 全选/取消全选
		var isCheckAll = false;
		function swapCheck() {
			if (isCheckAll) {
				$("input[type='checkbox']").each(function() {
					this.checked = false;
				});
				isCheckAll = false;
			} else {
				$("input[type='checkbox']").each(function() {
					this.checked = true;
				});
				isCheckAll = true;
			}
		}
		// 用户-编辑
        function member_edit (title,url,obj,w,h) {
            //var oid = $(obj).parent("td").siblings("td").eq(1).text();
            x_admin_show(title,url,w,h);
        }
        /*用户-删除*/
        function member_del(obj,url){
            //alert(url);
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                $.get(url, function(data,status){
                    if(status=="success"){
                        
                            layer.msg('已删除!',{icon:1,time:1000});
                            window.location.href=window.location.href;
                        
                    }
                });
            });
        }
        /*用户-添加*/
        function member_add(title,url,w,h){
            x_admin_show(title,url,w,h);
        }
        
		//批量删除提交
        function exportAll () {
            layer.confirm('这是一个假的导出功能，确认要导出选中的所有订单吗？',function(index){
                //捉到所有被选中的，发异步进行删除
                layer.msg('导出成功', {icon: 1});
            });
         }
	</script>
</body>
</html>