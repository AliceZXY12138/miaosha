<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"/www/wwwroot/101.37.13.45/public/../application/customer/view/userinfo/index.html";i:1611240052;}*/ ?>
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
                    default-active="3"
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


                <el-form  label-width="80px" :model="info" >
                  <el-form-item label="用户编号" required prop="customer_id">
                    <el-input v-model="info.customer_id" :disabled="true"></el-input>
                  </el-form-item>
                  <el-form-item label="用户名" required prop="customer_name">
                    <el-input v-model="info.customer_name" :disabled="true"></el-input>
                  </el-form-item>
                  <el-form-item label="地址" required prop="address">
                    <el-input v-model="info.address"></el-input>
                  </el-form-item>
                  <el-form-item label="电话" required prop="phone">
                    <el-input v-model="info.phone"></el-input>
                  </el-form-item>
                  <el-form-item>
                    <el-button type="warning" @click="editInfo(info)">修改信息</el-button>
                    <el-button type="info" @click="dialogVisible = true">修改密码</el-button>
                  </el-form-item>
                </el-form>

                <el-dialog
                  title="提示"
                  :visible.sync="dialogVisible"
                  width="30%"
                  >

                  <el-form  label-width="100px" :model="pass" >
                    <el-form-item label="原密码" required prop="oldpass">
                      <el-input v-model="pass.oldpass"  show-password></el-input>
                    </el-form-item>
                    <el-form-item label="新密码" required prop="newpass">
                      <el-input v-model="pass.newpass"  show-password></el-input>
                    </el-form-item>
                    <el-form-item label="确认新密码" required prop="newpass">
                      <el-input v-model="pass.newpass2"  show-password></el-input>
                    </el-form-item>
                    <el-form-item>
                    
                      <el-button type="warning" @click="editPass(pass)">确 定</el-button>
                      <el-button type="warning" plain @click="dialogVisible = false">取 消</el-button>
                    
                    </el-form-item>

                  </el-form>
                </el-dialog>


              </el-main>
            </el-container>
          </el-container>
        </div>
      
        <script>
        
            var Main = {
              data(){
                return {
                  info: {},
                  dialogVisible: false,
                  pass: {
                    oldpass: '',
                    newpass: '',
                    newpass2: ''
                  }
                }
              },
              created() {
                this.getData()
              },
              
              methods:{
                getData() {
                var vm=this;
                axios.post(
                  '/customer/userinfo/myinfo'
                        )
                  .then(function(response){
                    vm.info = response.data.info;
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
                editInfo: function(info){
                  var vm=this;
                  axios.post(
                    '/customer/userinfo/editInfo',
                    info
                      )
                  .then(function(response){
                    //console.log(response.data)
                    vm.$message({
                        message: '修改成功',
                        type: 'success'
                      });
                    })
                  .catch(function(error){
                    console.log(error)
                  });
                },
                handleClose(done) {
                  this.$confirm('确认关闭？')
                    .then(_ => {
                      done();
                    })
                    .catch(_ => {});
                },
                editPass: function(pass){
                  var vm=this;
                  if(pass.newpass!=pass.newpass2){
                    vm.$message({
                          message: '两次输入的新密码不一致',
                          type: 'error'
                        });
                  }
                  else{
                    axios.post(
                      '/customer/userinfo/editPass',
                      pass
                        )
                    .then(function(response){
                      if(response.data.code=="300"){
                        vm.dialogVisible = false;
                        vm.$message({
                            message: '修改成功',
                            type: 'success'
                          });
                      }
                      else if(response.data.code=="301"){
                        vm.dialogVisible = false;
                        vm.$message({
                            message: '修改失败，原密码错误',
                            type: 'error'
                          });
                      }
                      vm.pass={}
                    })
                    .catch(function(error){
                      console.log(error)
                      vm.pass={}
                    });
                  }
                }
              }
            }
            var Ctor = Vue.extend(Main);
            new Ctor().$mount('#app');
        </script>
          
    </body>
</html>
