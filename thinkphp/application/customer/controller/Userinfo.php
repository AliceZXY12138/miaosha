<?php

/**
 *  登陆页
 * @file    
 * @date    
 * @author  
 * @version    
 */

namespace app\customer\controller;

use think\Controller;
use think\Request;
use think\Db;

class Userinfo extends Common {

    /**
     * 主页面 
     */
    public function index() {
        
        return $this->fetch();
    }
    public function myinfo() {
        $customer_name = cookie('customer_name');
        $info = db('customer')->field('customer_id,customer_name,address,phone')->where('customer_name', $customer_name)->find();
        $rt = array('info'=>$info);
        return json_encode($rt);
    }
    public function editInfo() {
        $customer_id = input('customer_id');
        $address = input('address');
        $phone = input('phone');
        db('customer')->where('customer_id', $customer_id)->update(['address' => $address,'phone' => $phone]);
        
    }
    public function editPass() {
        $customer_name = cookie('customer_name');
        $oldpass = input('oldpass');
        $newpass = input('newpass');
        $md5_salt = config('md5_salt');
        $code = 301;
        
        $info = db('customer')->where('customer_name', $customer_name)->find();
        if($info['customer_password']==md5(md5($oldpass).$md5_salt)){
            db('customer')->where('customer_name', $customer_name)->update(['customer_password' => md5(md5($newpass).$md5_salt)]);
            $code = 300;
        }
        else{
            $code = 301;
        }
        $rt = array('code'=>$code);
        return json_encode($rt);
        
    }

}
