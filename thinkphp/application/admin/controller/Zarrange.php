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

class Arrange extends Common {

    /**
     * 主页面 
     */
    protected $beforeActionList = [
        'permission',
        'open'
    ];
    protected function permission(){
        
        $username=cookie('username');
        $role_id = session('role_id');
        $permission=db('access')->alias('a')->join('node n','a.node_id=n.id')->where('role_id',$role_id)->where('name',"分配宿舍")->find();
        if(!$permission){
            echo("<script>
            alert(\"您没有权限访问该页面\");
            window.history.back();
            </script>");
            return;
        }
    }
    protected function open(){
        $opened=array("member"=>"","dorm"=>"","arrange"=>"opened");
        //$opened['arrange']="opened";
        $this->assign('opened',$opened);
    }
    
    public function checkout() {
        $cur=array(
            "member_admin"=>"", "member_dormadmin"=>"","member_student"=>"",
            "dorm_building"=>"","dorm_dorm"=>"",
            "arrange_checkin"=>"","arrange_checkout"=>"class=\"current\"","arrange_change"=>""
            );
        $this->assign('cur',$cur);
        
        $info = Db::view('user_dorm')
            ->view('dorm','room_id','dorm.id=user_dorm.dorm_id')
            ->view('building',['name'=>'building_name'],'building.building_id=dorm.building_id')
            ->view('user','id,username,name,gender','user.id=user_dorm.user_id')
            ->select();
        $info_size = sizeof($info);
        
        $this->assign('info',$info);
        $this->assign('info_size',$info_size);
        return $this->fetch('arrange/checkout');
        
    }
    
    public function out(){
        $user_id = input('id');
        $ud = db('user_dorm')->where('user_id',$user_id)->find();
        $dorm_id = $ud['dorm_id'];
        $dorm = db('dorm')->where('id',$dorm_id)->find();
        $newa = (int)$dorm['available']+1;
        
        db('dorm')->where('id',$dorm_id)->update(['available'=>$newa]);
        db('user_dorm')->where('user_id',$user_id)->delete();
    }
    
    public function checkin() {
        $cur=array(
            "member_admin"=>"", "member_dormadmin"=>"","member_student"=>"",
            "dorm_building"=>"","dorm_dorm"=>"",
            "arrange_checkin"=>"class=\"current\"","arrange_checkout"=>"","arrange_change"=>""
            );
        $this->assign('cur',$cur);
        
        $info = Db::view('role_user','user_id')
            ->view('user','name,gender','role_user.user_id=user.id','LEFT')
            ->view('user_dorm','dorm_id','user_dorm.user_id=user.id','LEFT')
            ->where('role_id',3)
            ->where('dorm_id',null)
            ->select();
        $info_size = sizeof($info);
        
        $this->assign('info',$info);
        $this->assign('info_size',$info_size);
        return $this->fetch('arrange/checkin');
        
    }
    
    public function in_form() {
        
        $id=input('id');
        $info = db('user')->where('id',$id)->find();
        $dorm = db('dorm')->alias('d')->join('building','building.building_id=dorm.building_id')->where('gender',$info['gender'])->where('available','>',0)->select();
        
        $this->assign("info", $info);
        $this->assign("dorm", $dorm);
        return $this->fetch('arrange/in_form');
    }
    /*
    public function get_dorm() {
        $gender=input('gender');
        //$info = db('user')->where('id',1)->find();
        $dorm = db('dorm')->alias('d')->join('building','building.building_id=dorm.building_id')->where('gender',$gender)->where('available','>',0)->select();
        
        //$this->assign("info", $info);
        //$this->assign("dorm", $dorm);
        return $dorm;
    }*/
     public function in_submit() {
        $user_id=input('user_id');
        
        $dorm_id=input('dorm_id');
        $dorm = db('dorm')->where('id',$dorm_id)->find();
        $newa = (int)$dorm['available']-1;
        db('dorm')->where('id',$dorm_id)->update(['available'=>$newa]);
        db('user_dorm')->insert(['user_id'=>$user_id,'dorm_id'=>$dorm_id]);
        
    }
    
    public function change() {
        $cur=array(
            "member_admin"=>"", "member_dormadmin"=>"","member_student"=>"",
            "dorm_building"=>"","dorm_dorm"=>"",
            "arrange_checkin"=>"","arrange_checkout"=>"","arrange_change"=>"class=\"current\""
            );
        $this->assign('cur',$cur);
        
        $info = Db::view('user_dorm')
            ->view('dorm','room_id','dorm.id=user_dorm.dorm_id')
            ->view('building',['name'=>'building_name'],'building.building_id=dorm.building_id')
            ->view('user','id,username,name,gender','user.id=user_dorm.user_id')
            ->select();
        $info_size = sizeof($info);
        
        $this->assign('info',$info);
        $this->assign('info_size',$info_size);
        return $this->fetch('arrange/change');
        
    }
    public function change_form() {
        $user_id=input('user_id');
        //$info = db('user')->where('id',$user_id)->find();
        $info = Db::
              view('user_dorm','user_id,dorm_id')
            ->view('dorm','room_id','dorm.id=user_dorm.dorm_id')
            ->view('building',['name'=>'building_name'],'building.building_id=dorm.building_id')
            ->view('user','username,name,gender','user.id=user_dorm.user_id')
            ->where('user_id',$user_id)
            ->find();
        $dorm = db('dorm')->alias('d')->join('building','building.building_id=dorm.building_id')->where('gender',$info['gender'])->where('available','>',0)->select();
        
        $this->assign("info", $info);
        $this->assign("dorm", $dorm);
        return $this->fetch('arrange/change_form');
    }
    public function change_submit() {
        $user_id=input('user_id');
        $olddorm_id=input('olddorm_id');
        $dorm_id=input('dorm_id');
        
        $olddorm = db('dorm')->where('id',$olddorm_id)->find();
        $newa_old = (int)$olddorm['available']+1;
        db('dorm')->where('id',$olddorm_id)->update(['available'=>$newa_old]);
        
        $dorm = db('dorm')->where('id',$dorm_id)->find();
        $newa = (int)$dorm['available']-1;
        db('dorm')->where('id',$dorm_id)->update(['available'=>$newa]);
        
        db('user_dorm')->where('user_id',$user_id)->update(['dorm_id'=>$dorm_id]);
        
    }

}
