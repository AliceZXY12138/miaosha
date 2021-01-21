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

class Staff extends Common {

    /**
     * 主页面 
     */
    public $redis = null;

    public function _initialize() {
        parent::_initialize();
        $this->redis = new \Redis(); // 实例化
        $this->redis->connect('127.0.0.1','6379');
    }

    public function index() {
       
        $data = db('user')->alias('u')->join('role_user ru','ru.user_id = u.user_id')->join('role r','r.role_id = ru.role_id')->select();
        $len = sizeof($data);
        
        $this->assign("lists", $data);
        $this->assign("staff_size", $len);
        return $this->fetch();
    }
    public function staff_edit() {
        $user_id = input('id');
        $info = db('user')->alias('u')->join('role_user ru','ru.user_id = u.user_id')->join('role r','r.role_id = ru.role_id')->where('u.user_id',$user_id)->find();
        
        $roles = db('role')->select();
        $this->assign("info", $info);
        $this->assign("roles", $roles);
        return $this->fetch('staff_edit');

    }
    public function submit_edit() {
        $user_id = input('user_id');
        $role_id = input('role_id');
        db('role_user')->where('user_id',$user_id)->update(['role_id' => $role_id]);
        
    }
    public function staff_add() {
        $roles = db('role')->select();
        $this->assign("roles", $roles);
        return $this->fetch('staff/staff_add');
    }
    public function submit_add() {
        $md5_salt = config('md5_salt');
        $username = input('username');
        $password = md5(md5('123456').$md5_salt);
        $role_id = input('role_id');

        $user_id = db('user')->insertGetId(['username' => $username,'password' => $password]);
        db('role_user')->insert(['role_id' => $role_id,'user_id' => $user_id]);
    }

    public function staff_del() {
        $user_id = input('id');
        db('user')->where('user_id',$user_id)->delete();
        db('role_user')->where('user_id',$user_id)->delete();
    }

    
}
