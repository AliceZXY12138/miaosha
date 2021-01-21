<?php

/**
 * 后台公共文件 
 * @file   Common.php  
 * @date   2016-8-24 18:28:34 
 * @author Zhenxun Du<5552123@qq.com>  
 * @version    SVN:$Id:$ 
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use Firebase\JWT\JWT;
use lib\Jwttoken;
 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers:x-requested-with,content-type,Authorization');
 
class Common extends Controller
{
    public $username;
    public $user_id;
    //定义一个空的登录信息
    public function _initialize() {
        if(cookie('username') && cookie('token')){
           
            $username=cookie('username');
            $this->assign("username",$username);
            $token=cookie('token');
            $info = db('user')->field('user_id,username,token')->where('username', $username)->find();
            $this->username = cookie('username');
            $this->user_id = $info['user_id'];

            if($info['token']!=$token || $token=""){
                $this->error('用户未登录', 'login/index');
            }
            else{
                cookie('username', $username, 1200);
                cookie('token', cookie('token'), 1200);
                //refresh session
                $roles = db('role_user')->field('role_id')->where('user_id', $info['user_id'])->find();
                $role_id = $roles['role_id'];
                session('role_id',$role_id);
                
                //垃圾的菜单
                
                //厉害的菜单
                $menu=db('access')->alias('a')->join('node n','a.node_id=n.node_id')->where('role_id',$role_id)->select();
                
                $request = Request::instance();
                $curaction = strtolower($request->controller())."/".$request->action();
                $len = sizeof($menu);
                for($i=0; $i<$len; $i=$i+1){
                    if($curaction == $menu[$i]['action']){
                        $menu[$i]['class']="current";
                    }
                    else{
                        $menu[$i]['class']="list";
                    }
                }
                $this->assign('menu',$menu);
                $this->assign('username',$username);
                //var_dump($curaction);
                $this->_addlog();
            }
        }    
        else
            $this->error('用户未登录', 'login/index');
    }

    /*
    登出
    */
    public function logout() {
        $username = cookie('username');
        db('user')->where('username', $username)->update(['token' => NULL]);
        session('user_role', null);
        cookie('username', null);
        cookie('token', null);
        $this->success('退出成功', 'login/index');
    }
    



    
    /**
     * 记录日志
     */
    
    private function _addLog() {

        $data = array();
        $data['querystring'] = request()->query()?'?'.request()->query():'';
        $data['m'] = request()->module();
        $data['c'] = request()->controller();
        $data['a'] = request()->action();
        $data['user_id'] = $this->user_id;
        $data['username'] = $this->username;
        $data['ip'] = ip2long(request()->ip());
	    $data['time'] = time();
        
        
        //var_dump($data);
        //var_dump(date('Y-m-d H:i',$data['time']));
        //var_dump(long2ip($data['ip']));
        db('admin_log')->insert($data);
        
    }
    
    


}


    
    
    /*public function checkToken()
    {
        $header = Request::instance()->header();
        if ($header['authorization'] == 'null'){
            echo json_encode([
                'status' => 1002,
                'msg' => 'Token不存在,拒绝访问'
            ]);
            //exit;
        }else{
            $checkJwtToken = $this->verifyJwt($header['authorization']);
            if ($checkJwtToken['status'] == 1001) {
                return true;
            }
        }
    }

    //校验jwt权限API
    protected function verifyJwt($jwt)
    {
        $key = md5('HelloJWT');
        // JWT::$leeway = 3;
        try {
            $jwtAuth = json_encode(JWT::decode($jwt, $key, array('HS256')));
            $authInfo = json_decode($jwtAuth, true);
            $msg = [];
            if (!empty($authInfo['user_id'])) {
                $msg = [
                    'status' => 1001,
                    'msg' => 'Token验证通过'
                ];
            } else {
                $msg = [
                    'status' => 1002,
                    'msg' => 'Token验证不通过,用户不存在'
                ];
            }
            return $msg;
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            echo json_encode([
                'status' => 1002,
                'msg' => 'Token无效'
            ]);
            exit;
        } catch (\Firebase\JWT\ExpiredException $e) {
            echo json_encode([
                'status' => 1003,
                'msg' => 'Token过期'
            ]);
            exit;
        } catch (Exception $e) {
            return $e;
        }
    }*/

/*
public $username = null;
 
    public function _initialize()
    {
        parent::_initialize();
        $except = ['/admin/main/index'];
        $this->checkToken();

    }
 
    public function checkToken()
    {
        $header = Request::instance()->header();
        if (isset($header['authorization'])) {
            if ($header['authorization'] == 'null') {
                echo json_encode([
                    'status' => 10005,
                    'msg'    => 'Token不存在,拒绝访问'
                ]);
                exit;
            } else {
                $token         = new Jwttoken;
                $checkJwtToken = $token->verifyJwt($header['authorization']);
                //验证通过
                if (json_decode($checkJwtToken, true)['status'] == 0) {
                    //验证成功之后 继承了公共类的所有方法都可以直接调用登录用户 不用额外传参
                    $this->username = json_decode($checkJwtToken, true)['username'];
                    return true;
                }
            }
        } else {
            //Token不存在,拒绝访问
            return json_encode([
                'status' => 10006,
                'msg'    => '请勿非法登录'
            ]);
            exit;
        }
 
    }
    */


    /*$opened=array("member"=>"","dorm"=>"","arrange"=>"");
                $this->assign('opened',$opened);
                $cur=array(
                    "member_admin"=>"", "member_dormadmin"=>"","member_student"=>"",
                    "dorm_building"=>"","dorm_dorm"=>"",
                    "arrange_checkin"=>"","arrange_checkout"=>"","arrange_change"=>""
                    );
                $this->assign('cur',$cur);*/