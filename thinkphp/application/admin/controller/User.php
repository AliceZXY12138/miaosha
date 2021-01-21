<?php

/**
 *  登陆页
 * @file    
 * @date    
 * @author  
 * @version    
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class User extends Common {

    /**
     * 主页面 
     */
    public function index() {
        $data = db('customer')->select();
        $len = sizeof($data);
        $this->assign("lists", $data);
        $this->assign("user_size", $len);
        return $this->fetch();
    }
    public function user_edit() {
        $customer_id = input('id');
        $info = db('customer')->where('customer_id',$customer_id)->find();
        $this->assign("info", $info);
        
        return $this->fetch('user_edit');
    }
    public function submit_edit() {
        $customer_id = input('customer_id');
        $customer_name = input('customer_name');
        $address = input('address');
        $phone = input('phone');
       
        db('customer')->where('customer_id',$customer_id)->update(['address' => $address, 'phone' => $phone]);
    }
    public function user_add() {
        
        return $this->fetch('user/user_add');
    }
    public function submit_add() {
        $md5_salt = config('md5_salt');
        $customer_id = input('customer_id');
        $customer_name = input('customer_name');
        $password = md5(md5('123456').$md5_salt);
        $address = input('address');
        $phone = input('phone');
        db('customer')->insert(['customer_id' => $customer_id,'customer_name' => $customer_name, 'customer_password'=> $password, 'address' => $address, 'phone' => $phone]);
    }

    public function user_del() {
        $customer_id = input('id');
        db('customer')->where('customer_id',$customer_id)->delete();
    }
}
