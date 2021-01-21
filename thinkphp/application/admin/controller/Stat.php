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

class Stat extends Common {

    /**
     * 主页面 
     */
    public function index() {
        //$info = db('building')->alias('b')->join('dorm d','b.building_id = d.building_id')->field('name, gender,count(room_id) room , sum(bed) bed,sum(available) available')->group('d.building_id,gender')->select();
        $admin = db('user')->count();
        $customer = db('customer')->count();
        $order = db('orders')->count();
        $good1 = db('goods')->where('status',1)->count();
        $good2 = db('goods')->where('status',0)->count();
        $info = array(
            ['name'=>'管理员','num'=>$admin],
            ['name'=>'用户','num'=>$customer],
            ['name'=>'订单','num'=>$order],
            ['name'=>'在售商品','num'=>$good1],
            ['name'=>'下架商品','num'=>$good2]
        );
        $this->assign("lists",$info);
        return $this->fetch();
        
    }
        

}
