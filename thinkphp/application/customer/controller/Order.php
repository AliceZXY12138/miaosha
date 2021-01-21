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

class Order extends Common {

    /**
     * 主页面 
     */
    public function index() {
        
        return $this->fetch();
    }
    public function myorders() {
        $customer_name = cookie('customer_name');
        $myorders = db('orders')->alias('o')->where('customer_name', $customer_name)
            ->join('goods g','o.good_id = g.good_id')
            ->field('customer_name,goodname,num,time')
            ->select();
        $len = sizeof($myorders);
        for ($i=0; $i<$len; $i=$i+1){
            $myorders[$i]['time'] = date('Y-m-d H:i:s',$myorders[$i]['time']);
        }
        
        $rt = array('myorders'=>$myorders);
        return json_encode($rt);
    }
    
        

}
