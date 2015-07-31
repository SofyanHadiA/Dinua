<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class modelsession extends CI_Model {
      function __construct()
        {
        // Call the Model constructor
        parent::__construct();
        }
    //untuk memasukan session
    function set($id,$page ){
        $data = array(
                    'id'        => $id,
                    'logged_in' => true,
                    'page'      => 'mywall.php'
                );
        $this->session->set_userdata($data);
    }
    function setAdmin($id){
        $data = array(
                    'id'        => $id,
                    'logged_in' => true,
                    'type'      => 'admin'
                );
        $this->session->set_userdata($data);
    }
    //mengecek status login penngguna
    function getStatusLogin(){
        if ($this->session->userdata('logged_in')){
            $data=true;
        } else {$data=false;}
        return $data;
    }
    function getIp(){
        $data=$this->session->userdata('ip_address');
        return $data;
    }
    function getId(){
        $data=$this->session->userdata('id');
        return $data;
    }
    //untuk mengatur halaman terakhir yang dikunjungi
    function setLastPage($page){
        $this->session->set_userdata('page',$page);
     }
     //mengambil halaman akhir yang dikunjungi
     function getLastPage(){
        $data=$this->session->userdata('page');
        return $data;
     }
}