<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Friend extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $data = $this->ModelSession->getStatusLogin();
        if(!$data){
            exit;
        }
    }
    
    public function getOnlineFriends(){
        $id   = $this->session->userdata('id');
        $data = $this->ModelCRUDD->get('sessions');
        foreach($data as $rows){
            if (!empty($rows['user_data'])){
                $value=unserialize($rows['user_data']);
                if($value['logged_in']){
                    if ($value['id']!=$id){
                        $loggedin_id[] = $value['id'];
                    }
                }
            }
        }
        $data=null;
        if(!empty($loggedin_id)){
            $loggedin_id = array_unique($loggedin_id );
            foreach ($loggedin_id as $rows){
                //cek status pertemanan
                $this->load->library('LibFriends');
                $friend=$this->libfriends->getFriendStatus($id, $rows);
                
                // jika bertemanan masukan ke chat list
                if($friend=='Y'){
                    $table  = 'accounts_active';
                    $where  = 'id = '.$rows;
                    $userdata[] = $this->ModelCRUDD->get($table,'',$where);
                }

            }
            
            if(!empty($userdata)){
                
                foreach($userdata as $rows){
                    if(strlen($rows[0]['realname'])>20){
                        $realname = substr($rows[0]['realname'],0,20).'...';
                    }else $realname=$rows[0]['realname'];
                    
                    $name=explode(' ',$rows[0]['realname']);
                    $tid = $this->encrypt->encode($rows[0]['id']);
                    $tid = urlencode($tid);
                    $data[] = array( 'realname' => $realname,
                                     'name'     => $name[0],
                                     'tid'      => $tid,
                                     'avatar'   => base_url().$rows[0]['avatar'].'avatar-30px.jpg'
                                ); 
                }
                echo json_encode($data); 
                exit; // agar tidak berlanjut mengeksekusi perintah selanjutnya
            } 
        } 
        $data = array('empty'=>'y');
        echo json_encode($data); exit;
    }
    
    public function requestFriend(){
        $uid=$this->session->userdata('id');
        $tid=$this->input->post('tid');
        $tid=$this->encrypt->decode($tid);
        
        $this->load->library('LibFriends');
        $isFriend= $this->libfriends->getFriendStatus($uid,$tid);
        if($isFriend==false){
            // kirim email
           $this->load->library('LibProfile');
           $from=$this->libprofile->getprofile($uid);
           $from=$from['realname'];
           $to=$this->libprofile->getprofile($tid);
           $realname=$to['realname'];
           $to=$to['email'];
           $this->load->library('libsendmail');
           $this->libsendmail->friendReqEmail($to, $realname, $from);
            
            $table = 'friends';
            $data  = array( 'uid' => $uid,
                            'tid' => $tid,
                            'created' => now(),
                            'type' => 'RQ'
                            
                        );
            $this->ModelCRUDD->add($table,$data);
                
            $data=array(    
                'uid' =>$uid,
                'tid' =>$tid,
                'content' => 'F');                
            $table='notify';
            $this->ModelCRUDD->add($table, $data);
                
        echo json_encode('<p class="cl_blue bold">Menunggu Konfirmasi</p>');
        }
    }
    
    public function accRequestFriend(){
        $uid=$this->session->userdata('id');
        $tid=$this->input->post('tid');
        $tid=$this->encrypt->decode($tid);
        
        $this->load->library('LibFriends');
        $isFriend= $this->libfriends->getFriendStatus($uid,$tid);
            
        if($isFriend=='RQd'){
            $table = 'friends';
            $data  = array( 'type' => 'Y' );
            $where = ('uid = '.$tid.' and tid = '.$uid);
            $this->ModelCRUDD->edit($table,$data, $where);
            
            $where = array('uid'=>$tid, 'tid'=>$uid);
            $table='notify';
            $this->ModelCRUDD->delete($table, $where);
        }
        echo json_encode('<p class="cl_blue bold">Telah Dikonfirmasi</p>');
    }
    
    public function ignoreRequestFriend(){
        $uid=$this->session->userdata('id');
        $tid=$this->input->post('tid');
        $tid=$this->encrypt->decode($tid);
        
        $this->load->library('LibFriends');
        $isFriend= $this->libfriends->getFriendStatus($uid,$tid);
            
        if($isFriend=='RQd'){ 
            
            $table = 'friends';
            $where = ('uid = '.$tid.' and tid = '.$uid);
            $this->ModelCRUDD->delete($table,$where);
            
            $where = array('uid'=>$tid, 'tid'=>$uid);
            $table='notify';
            $this->ModelCRUDD->delete($table, $where);
        }
        echo json_encode('<p class="cl_blue bold">Telah Diabaikan</p>');
    }
    
    public function deleteFriend(){
        $uid=$this->session->userdata('id');
        $tid=$this->input->post('tid');
        $tid=$this->encrypt->decode($tid);
        
        $this->load->library('LibFriends');
        $isFriend= $this->libfriends->getFriendStatus($uid,$tid);
            
        if($isFriend=='Y' || $isFriend=='self'){    
            
            $table = 'friends';
            $where = ('uid = '.$tid.' and tid = '.$uid);
            $this->ModelCRUDD->delete($table,$where);
            $where = ('uid = '.$uid.' and tid = '.$tid);
            $this->ModelCRUDD->delete($table,$where);
            
       }
        echo json_encode('<p class="cl_blue bold">Telah Dihapus</p>');
    }
    
    public function findFriend(){
        $uid=$this->session->userdata('id');
        $search=$this->input->post('search');
        $table = ' accounts_active';
        $where = 'realname like "%'.$search.'%"';
        $limit = 10;
        $data = $this->ModelCRUDD->get($table,'', $where, $limit, 'realname,asc');
            
        if(!empty($data)){
            foreach($data as $rows){
                $tid = $rows['id'];
                $tid = $this->encrypt->encode($tid);
                $tid = urlencode($tid);
                $json_data[] = array('username' => $rows['realname'], 'tid' =>$tid, 'avatar' => base_url().$rows['avatar'].'avatar-30px.jpg'); 
            }
        } else {$json_data=array('empty'=>'true');}
        echo json_encode($json_data);
    }
}