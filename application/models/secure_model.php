<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class secure_model extends CI_Model {
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
        
    
    
    //-----------------------------------------//
    
    function setFriendRequest($id, $fid){
        $data=true;
        $this->db->select('uid, fid');
        $this->db->from('friends');
        $where='uid ="'.$id.'" AND fid="'.$fid.'"';
        $this->db->where($where);
        $Q = $this->db->get();
        if ($Q->num_rows() != 1){$data=2;}

        return $data;
        $Q->free_result();
    }
    
    function getFriendStatus($id, $fid){
        $data=true;
        $this->db->select('uid, fid');
        $this->db->from('friends');
        $where='uid ="'.$id.'" AND fid="'.$fid.'"';
        $this->db->where($where);
        $Q = $this->db->get();
        if ($Q->num_rows() != 1){$data=2;}

        return $data;
        $Q->free_result();
    }
    
    //Maksudnya ambel list friends
    function getFriends($id){
        $this->db->select('id, username');
        $this->db->from('accounts');
        $where='id <> '.$id;
        $this->db->where($where);
        $this->db->order_by('id', 'desc');
        $Q = $this->db->get();
        
        return $Q;
        $Q->free_result();
    }
    

    function getComment($tid){
         $this->db->select('uid, message');
         $this->db->from('status_comments');
         $where='target_id ="'.tid.'"';
         $this->db->where($where);
         $this->db->order_by('id', 'desc');
         $Q = $this->db->get();

         return $Q;
         $Q->free_result();
      }
      
    function getStatus($id){
        
        $this->db->select('status.id, status.message, accounts.username , status.created');
        $this->db->from('status, accounts');
        $where='status.tid = "'.$id.'" AND accounts.id = status.uid';
        $this->db->where($where);
        $this->db->order_by('status.id', 'desc');
        $Q = $this->db->get();

        return $Q;
        $Q->free_result();
    }
    
    function commentPost($uid, $tid ,$comment){
        $data=array(
            'uid'=>$uid,
            'target_id'=>$tid,
            'message'=>$comment,
            'created'=>now()
        );
        
        $this->db->insert('status_comments',$data);
    }
    
    //Bisa digabung neeeeeeeeeh
    function wallPost($id, $fid ,$status){
        $data=array(
            'uid'=>$id,
            'tid'=>$fid,
            'message'=>$status,
            'created'=>now()
        );
        
        $this->db->insert('status',$data);
    }
    
    function statusPost($id, $status){
        $data=array(
            'uid'=>$id,
            'tid'=>$id,
            'message'=>$status,
            'created'=>now()
        );
        
        $this->db->insert('status',$data);
    }
    
    function signup($email, $username, $password, $gender, $birthday){
        $password = do_hash($password, 'md5');

        $data= array(
            'email'	    =>$email,
            'username'	=>$username,
            'password'  =>$password,
            'gender'	=>$gender,
            'birthday'  =>$birthday,
            'created'   =>now()
        );
        $this->db->insert('accounts',$data);
    }
    
    //Lakukan perubahan kolom array untuk halaman;
     function setSessionPage($page ){
                $this->session->set_userdata('page',$page);
     }
    
    function setSession($id, $email ){
        $data = array(
                    'id'        => $id,
                    'email'     => $email,
                    'logged_in' => TRUE,
                    'page'      => 'beranda'
                    
                );
        $this->session->set_userdata($data);
    }
       
    function getLogin($email, $password){
        //hashing to md5
        $password=do_hash($password, 'md5');
        $data = array();
        $this->db->select('id, username,email');
        $this->db->from('accounts');
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->limit(1);
        $Q = $this->db->get();
        if ($Q->num_rows() == 1){
            foreach ($Q->result() as $row){
                $data = array(
                    'id'=>$row->id,
                    'email'=>$row->email,
                    'username'=> $row->username);
            }
        }
        
        $Q->free_result();
        return $data;
       
    }
    
     function getUserName($id){
        $data = array();
        $this->db->select('username');
        $this->db->from('accounts');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $Q = $this->db->get();
        if ($Q-> num_rows() == 1){
        //$data = $Q->row();
        foreach ($Q->result() as $row){
        $data = $row->username;
        }
        
        }
                
        $Q-> free_result();
        return $data;
       
     }
    
    function getProfile($id){
        $data = array();
        $this->db->select('email, username, avatar, birthday, about_me, gender');
        $this->db->from('accounts');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $Q = $this->db->get();
        if ($Q-> num_rows() == 1){
        //$data = $Q->row();
        foreach ($Q->result() as $row){
            $gender='Laki-laki';
            if($row->gender==2){
                $gender='Wanita';
            }
        $data = array(
            'email' =>$row->email,
            'username' => $row->username,
            'avatar' => $row->avatar,
            'birthday'=>$row->birthday, 
            'about_me'=>$row->about_me, 
            'gender'=>$gender,
            );
            
        }
             if(!$data['avatar']){
                $data['avatar']='../images/photos/Default.jpg';
             }  
        }
                
        $Q-> free_result();
        return $data;
       
    }
}