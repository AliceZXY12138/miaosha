<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"/www/wwwroot/101.37.13.45/public/../application/customer/view/main/index.html";i:1611240997;}*/ ?>
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
                    {{ username }}<i class="el-icon-arrow-down el-icon--right"></i>
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
                    default-active="1"
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

                <el-row>
                  <el-col :span="8" v-for="(item,index) in goodlist" :key="item.good_id" :offset="index > 0 ?  2: 0">
                    <el-card :body-style="{ padding: '20px' }">
                      <el-image :src="item.image" class="image"></el-image>
                      <div style="padding: 0px;">
                        <span class="demonstration"><h2>{{ item.goodname }}</h2></span>
                        
                        <span>简介： {{ item.description }}</span><br>
                        <span>库存：{{ item.stock }}【同一订单限购1件】</span>
                        <el-button type="info" @click="refresh">刷新</el-button>
                        <br>
                        <div class="bottom clearfix">
                          
                          <el-input-number v-model="item.num" @change="handleChange" :min="1" :max="1" label="描述文字"></el-input-number>
                          
                          <el-button type="warning" @click="confirmbuy(item)">购买</el-button>
                          <br><br>
                          
                        </div>
                      </div>
                    </el-card>
                  </el-col>
                </el-row>

              </el-main>
            </el-container>
          </el-container>
        </div>
      <script>
        
          var Main = {
            data(){
              return {
                currentDate: new Date(),
                goodlist: [],
                username: '',
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
                  '/customer/main/goods'
                        )
                  .then(function(response){
                    vm.goodlist = response.data.goodlist;
                    vm.username = response.data.username;
                    //console.log(vm.goodlist);
                    
                    })
                  .catch(function(error){
                    console.log(error)
                });
              },
              refresh() {
                var vm=this;
                axios.post(
                  '/customer/main/refresh'
                        )
                  .then(function(response){
                    console.log(response.data);
                    vm.goodlist = response.data.goodlist;
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
              handleChange(value) {
                console.log(value);
              },
              openUrl: function (url,msg) {
                window.location.href=url;
              },
              confirmbuy: function(item) {
                var vm = this;
                axios.post(
                  '/customer/main/confirmbuy',
                  item
                        )
                  .then(function(response){
                    console.log(response.data);
                    if(response.data.code=="401"){
                      vm.$confirm(response.data.msg, '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                      }).then(() => {
                        vm.$options.methods.buy(item,vm);
                        
                      }).catch(() => {
                        vm.$message({
                          type: 'info',
                          message: '已取消购买'
                        });          
                      });
                    }
                    else if(response.data.code=="400"){
                      vm.$alert(response.data.msg, '提示', {
                        confirmButtonText: '确定',
                        callback: action => {
                          vm.$message({
                            type: 'info',
                            message: '已取消购买'
                          });
                        }
                      });
                    }
                  })
                  .catch(function(error){
                    console.log(error)
                });
              },
              buy: function(item,vm) {
                axios.post(
                  '/customer/main/buy',
                  item
                        )
                  .then(function(response){
                    console.log(response.data);
                    //vm.goodlist = response.data.goodlist;
                    if(response.data.code=="400"){
                      vm.$message({
                        message: '库存不足，购买失败',
                        type: 'error'
                      });
                    }
                    else if(response.data.code=="401"){
                      vm.$message({
                        message: '购买成功',
                        type: 'success'
                      });
                    }
                    })
                  .catch(function(error){
                    console.log(error)
                    vm.$message({
                      message: '出错了，购买失败',
                      type: 'error'
                    });
                });
              },
            }
          }
          var Ctor = Vue.extend(Main);
          new Ctor().$mount('#app');
      </script>
        
        
    </body>
</html>
