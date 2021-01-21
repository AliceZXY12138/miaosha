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

class Log extends Common {

    /**
     * 主页面 
     */
    public function index() {
        //echo("pass by main controller<br>");
        $data = db('admin_log')->select();
        $len = sizeof($data);
        for ($i=0; $i<$len; $i=$i+1){
            $data[$i]['time'] = date('Y-m-d H:i:s',$data[$i]['time']);
            $data[$i]['ip'] = long2ip($data[$i]['ip']);
        }

        $this->assign("lists", $data);
        return $this->fetch();
    }
}
