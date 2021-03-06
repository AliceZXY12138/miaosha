<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"/www/wwwroot/101.37.13.45/public/../application/customer/view/login/index.html";i:1611226186;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <script src="https://cdn.staticfile.org/jquery/1.8.3/jquery.min.js"></script>
        <script src="https://unpkg.com/vue/dist/vue.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
        <script src="https://unpkg.com/element-ui/lib/index.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <link rel="stylesheet" href="/file/customer.css">
</head>
<body>
    <center><div id="app" style="width:500px">
        <h3>&emsp;&emsp;秒杀小店用户端登录</h3>
        <el-form ref="form" :model="form" label-width="80px">
            <el-form-item label="账号">
                <el-input v-model.number="form.username"></el-input>
            </el-form-item>
            <el-form-item label="密码">
                <el-input v-model="form.password" show-password></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">登录</el-button>
            </el-form-item>
        </el-form>
    </div></center>
    
        <script>
            var Main = {
                data() {
                    return {
                        form: {
                            username: '',
                            password: ''
                        }
                    }
                },
                methods: {
                    onSubmit() {
                        var vm = this;
                        axios.post(
                            '/customer/login/dologin',
                            this.form
                        )
                        .then(function(response){
                            console.log(response.data);
                            var code = response.data.code;
                            if(code=="100"){
                                console.log(response.data);
                                window.location.href="/customer/main/index";
                            }
                            else if(code=="101"){
                                vm.$message({
                                    showClose: true,
                                    message: '账号或密码错误',
                                    type: 'error'
                                    });
                                
                            }
                        })
                        .catch(function(error){
                            console.log(error)
                        });
                    },
                    
                }
            }
            var Ctor = Vue.extend(Main)
            new Ctor().$mount('#app')
        </script>
    
</body>
</html>