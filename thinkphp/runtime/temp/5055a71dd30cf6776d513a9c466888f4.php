<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"/www/wwwroot/101.37.13.45/public/../application/admin/view/clogin/index.html";i:1610435699;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
    <center><div id="app" style="width:500px">
        <h3>&emsp;&emsp;学生选宿舍系统</h3>
        <el-form ref="form" :model="form" label-width="80px">
            <el-form-item label="学号">
                <el-input v-model.number="form.sno"></el-input>
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
                            sno: '',
                            password: ''
                        }
                    }
                },
                methods: {
                    onSubmit() {
                        axios.post(
                            'http://101.37.13.45/index.php/clogin/test',
                            this.form
                        )
                        .then(function(response){
                            console.log(response.data)
                            //window.location.href="form.html"
                        })
                        .catch(function(error){
                            console.log(error)
                        });
                    }
                }
            }
            var Ctor = Vue.extend(Main)
            new Ctor().$mount('#app')
        </script>
    
</body>
</html>