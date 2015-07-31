<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notify extends CI_Controller {
    
    function getAllNotify(){
        $uid = $this->session->userdata('id');
        
        /* get notify general */
        $where = array('tid' => $uid, 'checked' => 'N', 'content'=>'S');
        $table = 'notify';
        $data = $this->ModelCRUDD->get($table,'',$where);
        $count=count($data);
        if(!empty($data)){
            $before=array();
            foreach ($data as $rows){
                // tandai dengan dibaca
                $edit = 'checked = "Y"';
                $where = 'id = '.$rows['id'];
                $this->ModelCRUDD->delete($table,$where);
                
                // ambil data pengirim
                $table = 'accounts';
                $where = 'id = '.$rows['uid'];
                $temp=$this->ModelCRUDD->get($table,'',$where);
                $user_data=$temp[0];
                
                $name=$user_data['realname'];
                $uid = $rows['uid'];
                
                $find = array_search($uid,$before);
                if($find===false){
                    
                    $before[] = $uid;
                    $uid = $this->encrypt->encode($uid);
                    $uid = urlencode($uid);
                    
                    $temp =explode(' ', $user_data['realname']); 
                    $firstName=$temp[0];
                    
                    $json_data['general'][]= array(  
                                        'tid'       => $uid,
                                        'avatar'  => base_url().$user_data['avatar'].'avatar-30px.jpg',
                                        'username' => $name
                                     );
                }
            }
        }
        
        /* get notify message */
        $where = array('tid' => $uid, 'checked' => 'N');
        $table = 'messages';
        $data = $this->ModelCRUDD->get($table,'',$where);
        $count=count($data);
        if(!empty($data)){
            $before=array();
            foreach ($data as $rows){
                // ambil data pengirim
                $table = 'accounts';
                $where = 'id = '.$rows['uid'];
                $temp=$this->ModelCRUDD->get($table,'',$where);
                $user_data=$temp[0];
                
                $name=$user_data['realname'];
                $uid = $rows['uid'];
                
                $find = array_search($uid,$before);
                if($find===false){
                    
                    $before[] = $uid;
                    $uid = $this->encrypt->encode($uid);
                    $uid = urlencode($uid);
                    
                    $temp =explode(' ', $user_data['realname']); 
                    $firstName=$temp[0];
                    
                    $json_data['message'][]= array(  
                                        'tid'       => $uid,
                                        'avatar'  => base_url().$user_data['avatar'].'avatar-30px.jpg',
                                        'username' => $name,
                                        'from'     => $firstName
                                     );
                }
            }
        }
        
        /* get notify general */
        $where = array('tid' => $uid, 'checked' => 'N', 'content'=>'F');
        $table = 'notify';
        $data = $this->ModelCRUDD->get($table,'',$where);
        $count=count($data);
        if(!empty($data)){
            $before=array();
            foreach ($data as $rows){              
                // ambil data pengirim
                $table = 'accounts';
                $where = 'id = '.$rows['uid'];
                $temp=$this->ModelCRUDD->get($table,'',$where);
                $user_data=$temp[0];
                
                $name=$user_data['realname'];
                $uid = $rows['uid'];
                
                $find = array_search($uid,$before);
                if($find===false){
                    
                    $before[] = $uid;
                    $uid = $this->encrypt->encode($uid);
                    $uid = urlencode($uid);
                    
                    $temp =explode(' ', $user_data['realname']); 
                    $firstName=$temp[0];
                    
                    $json_data['friend'][]= array(  
                                        'tid'       => $uid,
                                        'avatar'  => base_url().$user_data['avatar'].'avatar-30px.jpg',
                                        'username' => $name
                                     );
                }
            }
        }
         
        if(!empty($json_data)){
            echo (json_encode($json_data));
        }        
        else{$data=array('empty'=>'true'); echo json_encode($data); }
    }
}