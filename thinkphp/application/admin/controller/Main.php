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

class Main extends Common {

    /**
     * 主页面 
     */
    public function index() {
        
        $info = db('user')->select();
        $this->assign("lists", $info);
        $username = cookie('username');
        $this->assign("user",$username);

        $role_id = session('role_id');
        $tip = db('role')->where('role_id',$role_id)->find();
        $this->assign("tip",$tip['tip']);

        return $this->fetch();
        
    }
        

}
