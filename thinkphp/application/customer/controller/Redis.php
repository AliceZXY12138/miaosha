<?php
namespace app\customer\controller;

use think\Controller;
use think\Cache;

    
class Redis extends Controller 
{
    public $redis = null;

    public function _initialize() {
        parent::_initialize();
        $this->redis = new \Redis(); // 实例化
        $this->redis->connect('127.0.0.1','6379');
    }
    public function index()
    {
        echo "redis_test";
    }
    public function getsqldata(){
        //redis里包含的信息：各个商品的stock，完整的表格
        
        $goods = db('goods')->field('good_id,goodname,image,description,stock')->where('status', '1')->select();
        $len = sizeof($goods);
        for ($i=0; $i<$len; $i=$i+1){
            $goods[$i]['num']=1;
            //$this->redis->set("stock_".$goods[$i]['good_id'], $goods[$i]['stock']);
            $stock = $goods[$i]['stock'];
            $key = "stock".$goods[$i]['good_id'];
            
            $this->redis->ltrim($key,1,0);
            for($k=0;$k<$stock;$k++){
                $this->redis->lpush($key,1);
            }
        }
        $this->redis->set('goods', json_encode($goods));
        /*for($i=0;$i<110;$i++){
            $this->redis->lpush('mytest',1);
        }*/

    }
    public function refreshstock(){
        //redis里包含的信息：各个商品的stock，完整的表格
        $goods = json_decode($this->redis->get('goods'),true);
        $len = sizeof($goods);
        for ($i=0; $i<$len; $i=$i+1){
            $goods[$i]['stock'] = $this->redis->llen("stock".$goods[$i]['good_id']);
        }
        $this->$redis->set('goods', json_encode($goods));
    }



    public function test1()
    {
        $redis = new \Redis();
    	$redis->connect('127.0.0.1', 6379);
        // $redis->auth('password'); # 如果没有密码则不需要这行
     
    	//把 'test'字符串存入 redis
        //$redis->set('test_name', 'test');
        // 把 'test_name' 的 值从 redis 读取出来 
        
        var_dump($this->redis->lrange('stock1022331',0,-1));
        var_dump($this->redis->llen('stock1022331'));
    }
    public function test_inc()
    {
        $redis = new \Redis();
    	$redis->connect('127.0.0.1', 6379);
        $redis->incr("username");
        echo $redis->get("username");
    }
    public function test_dec()
    {
        $redis = new \Redis();
    	$redis->connect('127.0.0.1', 6379);
        $redis->decr("username");
        echo $redis->get("username");
    }
    public function test_settimeout()
    {
        $redis = new \Redis();
    	$redis->connect('127.0.0.1', 6379);
        $redis->incr("username2");
    	$redis->expire("username2",20);  //设置过期时间，单位秒
        echo $redis->get("username2");
    }
    public function test_login()
    {
        //此处如何实现连续尝试三次出现验证码？
        return $this->fetch();
    }
    public function dologin()
    {
        //获取用户提交的用户名和密码
        $username = input('username');
        $password = input('password');
        //用户存在数据库的密码
        $pwd = '123456';
 
        $redis = new \Redis();
    	$redis->connect('127.0.0.1', 6379);
        $num = $redis->get($username);
        if($num > 5){
            echo '登录次数超过5次,请5分钟后再尝试';
            exit();
        }
 
        if($password != $pwd){
            //登录失败进行计数操作，key为用户名这里认为是唯一值，value就是错误次数
            $redis->incr($username);
            $redis->expire($username,20);  //设置过期时间，单位秒
            echo '登录失败';
        }else{
            echo '登录成功';
        }
    }
}