<?php

/**
 *  登陆页
 * @file   Login.php  
 * @date   2016-8-23 19:52:46 
 * @author Zhenxun Du<5552123@qq.com>  
 * @version    SVN:$Id:$ 
 */

namespace app\customer\controller;

use think\Controller;
use think\Loader;
use Firebase\JWT\JWT;
use lib\Jwttoken;


class Login extends Controller {

    /**
     * 登入
     */
    public function index() {
        if(cookie('customer_name') && cookie('customer_token')){
            $username=cookie('customer_name');
            $token=cookie('customer_token');
            //$info = db('customer')->field('customer_id,customer_name,token')->where('customer_name', $username)->find();
            $filename = "token/".$username.".txt";
            $line = file_get_contents($filename);
            
            if($line==$token && $token!=""){
                cookie('customer_name', $username, 1200);
                cookie('customer_token', $token, 1200);
                
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
        $username = input('username');
        $password = input('password');
        $md5_salt = config('md5_salt');

        $info = db('customer')->field('customer_id,customer_name,customer_password')->where('customer_name', $username)->find();
        if(!$info){
            $rt = array('code'=>'101'); 
            return json_encode($rt);
        }
        if(md5(md5($password).$md5_salt) != $info['customer_password']){
            $rt = array('code'=>'101'); 
            return json_encode($rt);
        }
        //用户名密码正确
        //token & cookie
        
        $jwt = self::createJwt($username);
        $token = $jwt;
        //db('customer')->where('customer_name', $username)->update(['token' => $token]);

        $filename = "token/".$username.".txt";
        touch($filename);
        $fw = fopen($filename,'w');
        fwrite($fw,$token);


        cookie('customer_name', $username, 1200);
        cookie('customer_token', $token, 1200);

        $rt = array('code'=>'100'); 
        return json_encode($rt);
        //return "100";
        //$this->success('登录成功', 'main/index');
    }

    //生成JWT
    public function createJwt($userId)
    {
        $key = md5('HelloJWT'); //jwt的签发密钥，验证token的时候需要用到
        $time = time(); //签发时间
        $expire = $time + 2400; //过期时间
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

    public function write(){
        touch('token/customer_token.txt');
        $fw = fopen('token/customer_token.txt','a');
        fwrite($fw,"hello=123\r\n");
        fwrite($fw,"world=456\r\n");

        $fr = fopen('token/customer_token.txt','r');
        while(!feof($fr)){
            $line = fgets($fr);
            if($line!=""){
                $line_split = explode("=",$line);
                echo($line_split[0]."****".$line_split[1]);
            }
        }

    }

}
    