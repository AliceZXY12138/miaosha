<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"/www/wwwroot/101.37.13.45/public/../application/customer/view/order/index.html";i:1610727106;}*/ ?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>主页</title>
        <script src="https://cdn.staticfile.org/jquery/1.8.3/jquery.min.js"></script>
        <script src="https://unpkg.com/vue/dist/vue.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
        <script src="https://unpkg.com/element-ui/lib/index.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <link rel="stylesheet" href="/file/customer.css">
    </head>
    <body>
        <div id="app">
          <el-container>
            
            <el-header  height="100px">
              <span style="float:left; padding-left:30px;line-height:64px;">
                <h2>秒杀小店</h2>
              </span>
              
              <span style="float:right; padding-right:30px;padding-top:30px;">
              
                <el-dropdown @command="handleCommand">
                  <span class="el-dropdown-link">
                    <?php echo $username; ?><i class="el-icon-arrow-down el-icon--right"></i>
                  </span>
                  <el-dropdown-menu slot="dropdown">
                      <el-dropdown-item command="logout">退出登录</el-dropdown-item>
                  </el-dropdown-menu>
                  </span>
                </el-dropdown>
              
            </el-header>
            <div class="divider"></div>

            <el-container height="800px">
              <el-aside width="200px">
                <el-menu
                    default-active="2"
                    class="el-menu-vertical-demo"
                    background-color="#545c64"
                    text-color="#fff"
                    active-text-color="#ffd04b"
                    >
                    <el-menu-item index="1" v-on:click="openUrl('/customer/main/index', '抢购商品')" >
                        <i class="el-icon-menu"></i>
                        <span slot="title">抢购商品</span>
                    </el-menu-item>
                    <el-menu-item index="2" v-on:click="openUrl('/customer/order/index', '我的订单')">
                        <i class="el-icon-menu"></i>
                        <span slot="title">我的订单</span>
                    </el-menu-item>
                    <el-menu-item index="3" v-on:click="openUrl('/customer/userinfo/index', '个人信息')">
                        <i class="el-icon-menu"></i>
                        <span slot="title">个人信息</span>
                    </el-menu-item>
                </el-menu>


              </el-aside>
              <el-main>

                <el-table :data="myorders" height="675" stripe border style="width: 100%">
                  <el-table-column type="index" label="编号" width="100"> 
                  </el-table-column>
                <el-table-column
                    prop="customer_name"
                    label="收货人"
                    width="200">
                  </el-table-column>
                  <el-table-column
                    prop="goodname"
                    label="商品名" width="200">
                  </el-table-column>
                  <el-table-column
                    prop="num"
                    label="数量" width="100">
                  </el-table-column>
                  <el-table-column
                    prop="time"
                    label="时间" >
                  </el-table-column>
                </el-table>

              </el-main>
            </el-container>
          </el-container>
        </div>
      <script>
        
          var Main = {
            data(){
              return {
                myorders: [],
              }
            },
            created() {
              this.getData()
            },
            methods:{
              getData() {
                // 调用后台接口获取tableColumnList和dataList的方法写在这里
                var vm=this;
                axios.post(
                  '/customer/order/myorders'
                        )
                  .then(function(response){
                    vm.myorders = response.data.myorders;
                    
                    })
                  .catch(function(error){
                    console.log(error)
                });
              },
              handleCommand: function(command) {
                var vm = this;
                if(command=="logout"){
                  axios.post(
                  '/customer/common/logout'
                        )
                  .then(function(response){
                    console.log(response.data);
                    vm.$message("退出成功");
                    window.location.href="/customer/login/index";
                    })
                  .catch(function(error){
                    console.log(error)
                });
                }
              },
              openUrl: function (url,msg) {
                window.location.href=url;
              },
            }
          }
          var Ctor = Vue.extend(Main);
          new Ctor().$mount('#app');
      </script>
        
        
    </body>
</html>
