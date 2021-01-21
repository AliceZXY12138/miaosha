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
use think\Url;

class Member extends Common {

    /**
     * 主页面 
     */
    protected $beforeActionList = [
        'permission',
        'open'
    ];
    //'second' =>  ['except'=>'hello'],
    //    'three'  =>  ['only'=>'hello,data'],
    protected function permission(){
        $role_id = session('role_id');
        $permission=db('access')->alias('a')->join('node n','a.node_id=n.id')->where('role_id',$role_id)->where('name',"用户管理")->find();
        if(!$permission){
            echo("<script>
            alert(\"您没有权限访问该页面\");
            window.history.back();
            </script>");
            return;
        }
    }
    protected function open(){
        $opened=array("member"=>"opened","dorm"=>"","arrange"=>"");
        //$opened['member']="opened";
        $this->assign('opened',$opened);
    }
    public function index() {
        
        return $this->fetch();
    }
    
    public function member_admin() {
        $cur=array(
            "member_admin"=>"class=\"current\"", "member_dormadmin"=>"","member_student"=>"",
            "dorm_building"=>"","dorm_dorm"=>"",
            "arrange_checkin"=>"","arrange_checkout"=>"","arrange_change"=>""
            );
        $this->assign('cur',$cur);
        
        $role_id_admin = db('role')->field('id')->where('name','高级管理员')->find();
        $user_admin = db('role_user')->alias('ru')->join('user u','ru.user_id = u.id')->where('ru.role_id',$role_id_admin['id'])->select();
        $user_admin_size = sizeof($user_admin);
        $this->assign("user_admin", $user_admin);
        $this->assign("user_admin_size", $user_admin_size);

        return $this->fetch('member/member_admin');
    }
    public function member_dormadmin() {
        $cur=array(
            "member_admin"=>"", "member_dormadmin"=>"class=\"current\"","member_student"=>"",
            "dorm_building"=>"","dorm_dorm"=>"",
            "arrange_checkin"=>"","arrange_checkout"=>"","arrange_change"=>""
            );
        $this->assign('cur',$cur);
        
        $role_id_dormadmin = db('role')->field('id')->where('name','普通管理员')->find();
        $user_dormadmin = db('role_user')->alias('ru')->join('user u','ru.user_id = u.id')->where('ru.role_id',$role_id_dormadmin['id'])->select();
        $user_dormadmin_size = sizeof($user_dormadmin);
        $this->assign("user_dormadmin", $user_dormadmin);
        $this->assign("user_dormadmin_size", $user_dormadmin_size);
        
        return $this->fetch('member/member_dormadmin');
    }
    public function member_student() {
        $cur=array(
            "member_admin"=>"", "member_dormadmin"=>"","member_student"=>"class=\"current\"",
            "dorm_building"=>"","dorm_dorm"=>"",
            "arrange_checkin"=>"","arrange_checkout"=>"","arrange_change"=>""
            );
        $this->assign('cur',$cur);
        
        $role_id_student = db('role')->field('id')->where('name','学生')->find();
        $user_student = db('role_user')->alias('ru')->join('user u','ru.user_id = u.id')->where('ru.role_id',$role_id_student['id'])->select();
        $user_student_size = sizeof($user_student);
        $this->assign("user_student", $user_student);
        $this->assign("user_student_size", $user_student_size);
        
        return $this->fetch('member/member_student');
    }
     /**
     * edit 
     */
    public function member_edit() {
        $id = input('id');
        //$id = input('post.id');
        $info = db('user')->where('id',$id)->find();
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
        
        return $this->fetch('member_edit');
    }
    
     public function submit_edit() {
         
        $id = input('id');
        $username = input('username');
        $name = input('name');
        $gender = input('gender');
        $phone = input('phone');
        $email = input('email');
        
        db('user')->where('id',$id)->update(['name' => $name, 'gender' => $gender, 'phone' => $phone, 'email' => $email]);
        //return var_dump(input('id'));
        
    }
    
    public function member_del() {
        $id = input('id');
        $username = cookie('username');
        $info = db('user')->field('id')->where('username', $username)->find();
        if($id==$info['id']){
            return "no";
        }
        else{
            db('user')->where('id',$id)->delete();
            db('role_user')->where('user_id',$id)->delete();
        }
        
        //return var_dump(input('id'));
    }
    
    public function member_add(){
        return $this->fetch("member/member_add");
    }
    public function submit_add(){
        $role = input('role');
        $username = input('username');
        $password = input('password');
        $name = input('name');
        $gender = input('gender');
        $phone = input('phone');
        $email = input('email');
        
        $test = db('user')->where('username', $username)->find();
        if($test){
            return "no";
        }
        else{
            $id = db('user')->insertGetId(['username'=>$username ,'password'=>$password,'name' => $name, 'gender' => $gender, 'phone' => $phone, 'email' => $email]);
            db('role_user')->insert(['role_id'=>$role,'user_id'=>$id]);
        }
        
    }

}
