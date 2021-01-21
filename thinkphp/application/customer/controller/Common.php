<?php

/**
 * 后台公共文件 
 * @file   Common.php  
 * @date   2016-8-24 18:28:34 
 * @author Zhenxun Du<5552123@qq.com>  
 * @version    SVN:$Id:$ 
 */

namespace app\customer\controller;

use think\Controller;
use think\Request;
use Firebase\JWT\JWT;
use lib\Jwttoken;
 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers:x-requested-with,content-type,Authorization');
 
class Common extends Controller
{
    public $username;
    
    
    //定义一个空的登录信息
    public function _initialize() {
        

        if(cookie('customer_name') && cookie('customer_token')){
           
            $username=cookie('customer_name');
            $token=cookie('customer_token');
            $this->assign("username",$username);
            //$info = db('customer')->field('customer_id,customer_name,token')->where('customer_name', $username)->find();
            $this->username = cookie('customer_name');

            $filename = "token/".$username.".txt";
            $line = file_get_contents($filename);


            if($line!=$token || $token==""){
                $this->error('用户未登录', 'login/index');
            }
            else{
                cookie('customer_name', $username, 1200);
                cookie('customer_token', $line, 1200);
            }
        }    
        else{
            $this->error('用户未登录', 'login/index');
            
        }
        
    }

    /*
    登出
    */
    public function logout() {
        $username = cookie('customer_name');
        //db('customer')->where('customer_name', $username)->update(['token' => NULL]);
        $filename = "token/".$username.".txt";
        touch($filename);
        $fw = fopen($filename,'w');
        fwrite($fw,"");

        cookie('customer_name', null);
        cookie('customer_token', null);
        
        echo("ok");
    }
    
}
