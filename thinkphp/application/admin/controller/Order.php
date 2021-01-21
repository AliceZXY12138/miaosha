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

class Order extends Common {

    /**
     * 主页面 
     */
    public function index() {
        //echo("pass by main controller<br>");
        $data = db('orders')->alias('o')
            ->join('goods g','o.good_id=g.good_id')
            ->join('customer c','o.customer_name=c.customer_name')
            ->select();
        $len = sizeof($data);
        for ($i=0; $i<$len; $i=$i+1){
            $data[$i]['time'] = date('Y-m-d H:i',$data[$i]['time']);
        }

        $this->assign("lists", $data);
        $this->assign("orders_size", $len);
        return $this->fetch();
    }
}
