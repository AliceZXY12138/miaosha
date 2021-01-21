<?php

/**
 *  登陆页
 * @file   Login.php  
 * @date   2016-8-23 19:52:46 
 * @author Zhenxun Du<5552123@qq.com>  
 * @version    SVN:$Id:$ 
 */

namespace app\admin\controller;

use think\Controller;
use think\Loader;
use Firebase\JWT\JWT;
//use app\index\controller\Jwttoken;
use lib\Jwttoken;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers:x-requested-with,content-type,Authorization');


class Login extends Controller {

    /**
     * 登入
     */
    public function index() {
        if(cookie('username') && cookie('token')){
            $username=cookie('username');
            $token=cookie('token');
            $info = db('user')->field('user_id,username,token')->where('username', $username)->find();
            if($info['token']==$token && $token!=""){
                cookie('username', $username, 1200);
                cookie('token', cookie('token'), 1200);
                $this->success('登录成功', 'main/index');
            }
            else{
                $this->fetch();
            }
        }
        return $this->fetch();
        
    }
    /**
     * 处理登录
     */
    public function dologin() {
        //验证密码流程
        $username = input('post.username');
        $password = input('post.password');
        $md5_salt = config('md5_salt');

        $info = db('user')->field('user_id,username,password')->where('username', $username)->find();
        if(!$info){
            $this->error('用户名或密码错误');
        }
        if(md5(md5($password).$md5_salt) != $info['password']){
             $this->error('用户名或密码错误');
        }
        //用户名密码正确
        //token & cookie
        
        $jwt = self::createJwt($username);
        $token = $jwt;
        db('user')->where('username', $username)->update(['token' => $token]);
        cookie('username', $username, 1200);
        cookie('token', $token, 1200);

        //session
        $roles = db('role_user')->field('role_id')->where('user_id', $info['user_id'])->find();
        $role_id = $roles['role_id'];
        session('role_id',$role_id);
        
        $this->success('登录成功', 'main/index');
    }

    //生成JWT
    public function createJwt($userId)
    {
        $key = md5('HelloJWT'); //jwt的签发密钥，验证token的时候需要用到
        $time = time(); //签发时间
        $expire = $time + 1200; //过期时间
        $token = array(
            "user_id" => $userId,
            "iss" => "yuyu",//签发组织
            "aud" => "yuyu", //签发作者
            "iat" => $time,
            "nbf" => $time,
            "exp" => $expire
        );
        $jwt = JWT::encode($token, $key);
        return $jwt;
    }

}
    