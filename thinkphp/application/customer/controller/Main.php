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
use think\Cache;
use think\cache\driver\Redis;

class Main extends Common {

    /**
     * 主页面 
     */
    public $redis = null;
    public $cnt=0;
    
    
    public function _initialize() {
        parent::_initialize();
        $this->redis = new \Redis(); // 实例化
        $this->redis->connect('127.0.0.1','6379');
        
    }
    public function index() {
        
        return $this->fetch();
    }

    public function goods() {
        //后台完成后，将这句改成从缓存获取goods
        $goods = json_decode($this->redis->get('goods'),true);
        $username = cookie('customer_name');
        $len = sizeof($goods);
        for ($i=0; $i<$len; $i=$i+1){
            $goods[$i]['stock'] = $this->redis->llen("stock".$goods[$i]['good_id']);
        }
        $this->redis->set('goods', json_encode($goods));
        
        $rt = array('goodlist'=>$goods, 'username'=>$username);
        return json_encode($rt);
    }

    public function refresh(){
        $goods = json_decode($this->redis->get('goods'),true);
        $len = sizeof($goods);
        for ($i=0; $i<$len; $i=$i+1){
            $goods[$i]['stock'] = $this->redis->llen("stock".$goods[$i]['good_id']);
        }
        $this->redis->set('goods', json_encode($goods));

        $rt = array('goodlist'=>$goods);
        return json_encode($rt);
    }

    public function buy() {
        //input
        $good_id = input('good_id');
        $num = input('num');
        $code = 400;
        $cnt = 0;
        $key = "stock".$good_id;
        while($this->redis->lpop($key)){
            $cnt++;
            if($cnt==$num) break;
        }
        if($cnt<$num){
            //rollback
            while($cnt>0){
                $this->redis->lpush($key,1);
                $cnt--;
            }
        }
        //if($this->redis->lpop('mytest')){
        else if($cnt==$num){
            $username = cookie('customer_name');
            $data = array('good_id' => $good_id, 'num' => $num, 'username' => $username);
            $url = "http://101.37.13.45:8080/api/miaosha/order?".http_build_query($data);
            file_get_contents($url);
            $code = 401;
        }
        
        $rt = array('code'=>$code);
        return json_encode($rt);
        
    }

    public function confirmbuy(){
        //input
        $good_id = input('good_id');
        $num = input('num');
        $stock = $this->redis->llen("stock".$good_id);

        if($stock < $num){
            $msg = "当前库存".$stock."件，您购买".$num."件，库存不足，无法购买";
            $code = 400;
        }
        else{
            $msg = "当前库存".$stock."件，您购买".$num."件，库存充足，是否确认购买？";
            $code = 401;
        }
        $rt = array('msg'=>$msg,'code'=>$code);
        return json_encode($rt);
    }
    

}
