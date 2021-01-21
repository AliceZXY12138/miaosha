<?php

/**
 *  个人信息
 * @file    
 * @date    
 * @author  
 * @version    
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Userinfo extends Common {

    /**
     * 主页面 
     */
    public function index() {
        $username = cookie('username');
        $this->assign("user",$username);
        $info = db('user')->where('username',$username)->find();
        $this->assign("info", $info);
        
        //$role_user = db('role_user')->where('user_id',$info['id'])->find();
        //$role = db('role')->where('id',$role_user['role_id'])->find();
        $role_id = session('role_id');
        $role = db('role')->where('id',$role_id)->find();
        $this->assign("role", $role);
        //??
        
        $dorminfo = Db::view('user_dorm')
            ->where('user_id',$info['id'])
            ->view('dorm','room_id','dorm.id=user_dorm.dorm_id')
            ->view('building',['name'=>'building_name'],'building.building_id=dorm.building_id')
            ->find();
        if(!$dorminfo)
            $dorm="无"; 
        else 
            $dorm = $dorminfo['building_name'].$dorminfo['room_id'];
        $this->assign("dorm", $dorm);
        
        return $this->fetch();
        
    }
    
     /**
     * edit 
     */
    public function edit() {
        $username = cookie('username');
        $this->assign("user",$username);
        $info = db('user')->where('username',$username)->find();
        if($info['gender']=="男") {
            $mchecked="checked";
            $fchecked="";
        }
        elseif ($info['gender']=="女") {
            $mchecked="";
            $fchecked="checked";
        }
        else{
            $mchecked="";
            $fchecked="";
        }
        
        $this->assign("info", $info);
        $this->assign("mchecked", $mchecked);
        $this->assign("fchecked", $fchecked);
        return $this->fetch('userinfo/edit');
    }
    /**
     * edit 
     */
    public function submit_edit() {
        //echo("edit");
        $username = cookie('username');
        $token = cookie('token');
        //$info = db('user')->field('username,token')->where('username', $username)->find();
        $name = input('post.name');
        $gender = input('post.gender');
        $phone = input('post.phone');
        $email = input('post.email');
        //echo($gender);
        db('user')->where('username',$username)->update(['name' => $name, 'gender' => $gender, 'phone' => $phone, 'email' => $email]);
        echo("<script>
            parent.layer.closeAll();
            parent.layer.msg('修改成功',{icon:1,time:1000});
            window.parent.location.href=window.parent.location.href;
            </script>");
        //return $this->redirect('userinfo/index');
    }
    
    /**
     * pw
     */
    public function pw() {
        //echo("edit");
        $username = cookie('username');
        $this->assign("user",$username);
        $info = db('user')->where('username',$username)->find();
        
        $this->assign("info", $info);
        return $this->fetch('userinfo/pw');
    }
    /**
     * edit 
     */
    public function submit_pw() {
        $username = cookie('username');
        $pass = input('post.pass');
        $newpass = input('post.newpass');
        $repass = input('post.repass');
        $info = db('user')->where('username',$username)->find();
        if($pass!=$info['password']){
            echo("<script>
            parent.layer.msg('旧密码错误',{icon:1,time:1000});
            </script>");
            return $this->fetch('userinfo/pw');
        }
        elseif($newpass!=$repass){
            echo("<script>
            parent.layer.msg('两次输入的新密码不一致',{icon:1,time:1000});
            </script>");
            return $this->fetch('userinfo/pw');
        }
        else{
            db('user')->where('username',$username)->update(['password' => $newpass]);
            echo("<script>
                parent.layer.closeAll();
                parent.layer.msg('修改成功',{icon:1,time:1000});
                </script>");
        }
    }
    

}