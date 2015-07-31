<?php 
/*Kelas Controller utama yang mengatur kelas controller lainnya 
serta mengatur konten yang tertampil pada view*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }
    
    function getOnlineUserData(){
        $uid = $this->session->userdata('id');
        $this->load->library('LibProfile');
        $field=array('id','avatar', 'realname');
        $data_user=$this->libprofile->getProfile($uid,$field);
        
        $temp= explode(' ', $data_user['realname']);
        $data['realname']= $temp[0];
        
        $temp= base_url().$data_user['avatar'].'avatar-30px.jpg';
        $data['avatar']= $temp;
        
        $data['id']=$data_user['id_encrypt'];      
        
        echo(json_encode($data));
    }
}