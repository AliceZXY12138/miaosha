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

class Goods extends Common {

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
        //echo("pass by main controller<br>");
        $data = db('goods')->select();
        $len = sizeof($data);
        for ($i=0; $i<$len; $i=$i+1){
            if($data[$i]['status'] == 1){
                $data[$i]['status2'] = "在售";
            }
            else{
                $data[$i]['status2'] = "下架";
            }    
        }
        $this->assign("lists", $data);
        $this->assign("goods_size", $len);
        return $this->fetch();
    }
    public function good_edit() {
        $good_id = input('id');
        $info = db('goods')->where('good_id',$good_id)->find();
        if($info['status']=="1") {
            $s1="checked";
            $s2="";
        }
        elseif ($info['status']=="0") {
            $s1="";
            $s2="checked";
        }
        else{
            $s1="";
            $s2="";
        }
        $this->assign("info", $info);
        $this->assign("s1", $s1);
        $this->assign("s2", $s2);
        
        return $this->fetch('good_edit');
    }
    public function submit_edit() {
        $good_id = input('good_id');
        $goodname = input('goodname');
        $description = input('description');
        $stock = input('stock');
        $status = input('status');
        db('goods')->where('good_id',$good_id)->update(['goodname' => $goodname, 'description' => $description, 'stock' => $stock, 'status' => $status]);
        $this->redisgetsqldata();
    }
    public function good_add() {
        
        return $this->fetch('goods/good_add');
    }
    public function submit_add() {
        $good_id = input('good_id');
        $goodname = input('goodname');
        $description = input('description');
        $stock = input('stock');
        $status = input('status');
        db('goods')->insert(['good_id' => $good_id,'goodname' => $goodname, 'description' => $description, 'stock' => $stock, 'status' => $status]);
        $this->redisgetsqldata();
    }

    public function good_del() {
        $good_id = input('id');
        db('goods')->where('good_id',$good_id)->delete();
        $this->redisgetsqldata();
    }

    public function redisgetsqldata(){
        
        $goods = db('goods')->field('good_id,goodname,image,description,stock')->where('status', '1')->select();
        $len = sizeof($goods);
        for ($i=0; $i<$len; $i=$i+1){
            $goods[$i]['num']=1;
            
            $stock = $goods[$i]['stock'];
            $key = "stock".$goods[$i]['good_id'];
            
            $this->redis->ltrim($key,1,0);
            for($k=0;$k<$stock;$k++){
                $this->redis->lpush($key,1);
            }
        }
        $this->redis->set('goods', json_encode($goods));

    }
}
