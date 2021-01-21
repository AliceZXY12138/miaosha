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

class Dorm extends Common {
    
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
        $permission=db('access')->alias('a')->join('node n','a.node_id=n.id')->where('role_id',$role_id)->where('name',"宿舍管理")->find();
        if(!$permission){
            echo("<script>
            alert(\"您没有权限访问该页面\");
            window.history.back();
            </script>");
            return;
        }
    }
    protected function open(){
        $opened=array("member"=>"","dorm"=>"opened","arrange"=>"");
        //$opened['dorm']="opened";
        $this->assign('opened',$opened);
    }
    
    public function index() {
        return $this->fetch();
    }
    public function building() {
        $cur=array(
            "member_admin"=>"", "member_dormadmin"=>"","member_student"=>"",
            "dorm_building"=>"class=\"current\"","dorm_dorm"=>"",
            "arrange_checkin"=>"","arrange_checkout"=>"","arrange_change"=>""
            );
        $this->assign('cur',$cur);
        
        $building = db('building')->select();
        $building_size = sizeof($building);
        $this->assign("building", $building);
        $this->assign("building_size", $building_size);

        return $this->fetch('dorm/building');
    }
    public function building_edit() {
        $id=input('id');
        $info = db('building')->where('building_id',$id)->find();
        $this->assign("oldid", $id);
        $this->assign("info", $info);

        return $this->fetch('dorm/building_edit');
    }
    public function submit_building_edit() {
        $oldid = input('oldid');
        $id = input('id');
        $name = input('name');
        
        //unique name
        $testname = db('building')->where('name', $name)->find();
        if($oldid!=$id)
            $test = db('building')->where('building_id', $id)->find();
            
        if($testname['building_id']!=$oldid || $test) 
            return "no";
        else{
            db('building')->where('building_id',$oldid)->update(['building_id' => $id, 'name' => $name]);
            db('dorm')->where('building_id',$oldid)->update(['building_id' => $id]);
        }
        
    }
    
    public function building_add(){
        return $this->fetch("dorm/building_add");
    }
    public function submit_building_add(){
        $id = input('id');
        $name = input('name');
        $testid = db('building')->where('building_id', $id)->find();
        $testname = db('building')->where('name', $name)->find();
        if($testid || $testname){
            return "no";
        }
        else{
            db('building')->insert(['building_id'=>$id,'name'=>$name]);
        }
        
    }
    
    public function building_del() {
        $id = input('id');
        db('building')->where('building_id',$id)->delete();
        db('dorm')->where('building_id',$id)->delete();
    }
    
    public function dorm() {
        $cur=array(
            "member_admin"=>"", "member_dormadmin"=>"","member_student"=>"",
            "dorm_building"=>"","dorm_dorm"=>"class=\"current\"",
            "arrange_checkin"=>"","arrange_checkout"=>"","arrange_change"=>""
            );
        $this->assign('cur',$cur);
        
        $dorm = db('building')->alias('b')->join('dorm d','b.building_id = d.building_id')->select();
        $dorm_size = sizeof($dorm);
        $this->assign("dorm", $dorm);
        $this->assign("dorm_size", $dorm_size);

        return $this->fetch('dorm/dorm');
    }
    
    public function dorm_edit() {
        $id=input('id');
        $info = db('building')->alias('b')->join('dorm d','b.building_id = d.building_id')->where('d.id',$id)->find();
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
        return $this->fetch('dorm/dorm_edit');
    }
    public function submit_dorm_edit() {
        $id = input('id');
        $name = input('name');
        $room_id = input('room_id');
        $gender = input('gender');
        $bed = input('bed');
        $available = input('available');
        
        $building = db('building')->where('name', $name)->find();
        $building_id = $building['building_id'];
        
        $test = db('dorm')->where('building_id',$building_id)->where('room_id',$room_id)->find();
        if($test['id']!=$id){
            return "room";
        }
        elseif($bed<$available){
            return "bed";
        }
        else{
            db('dorm')->where('id',$id)->update(['room_id' => $room_id, 'gender' => $gender, 'bed' => $bed, 'available' => $available]);
        }
    }
    
    public function dorm_add(){
        return $this->fetch("dorm/dorm_add");
    }
    public function submit_dorm_add() {
        //$id = input('id');
        $name = input('name');
        $room_id = input('room_id');
        $gender = input('gender');
        $bed = input('bed');
        $available = input('available');
        
        $building = db('building')->where('name', $name)->find();
        
        if(!$building){
            return "building";
        }
        else{
            $building_id = $building['building_id'];
            $test = db('dorm')->where('building_id',$building_id)->where('room_id',$room_id)->find();
            if($test){
                return "room";
            }
            elseif($bed<$available){
                return "bed";
            }
            else{
                db('dorm')->insert(['building_id' => $building_id, 'room_id' => $room_id, 'gender' => $gender, 'bed' => $bed, 'available' => $available]);
            }
        }
    }
    public function dorm_del() {
        $id = input('id');
        db('dorm')->where('id',$id)->delete();
        
    }

}
