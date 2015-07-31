<?php 
/* Digunakan untuk mengontrol autentikasi masuk. 
Data pengguna yang masuk akan dikirimkan ke class Session */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class adminlogin extends CI_Controller {
    public function __construct(){
        parent::__construct();
    }
    // Method ini digunakan untuk mengeksekusi perintah Login
    public function index(){
        $admin = $this->session->userdata('type');
        if(!$admin){
            $username=$this->input->post('username');
            $password=$this->input->post('password');
            $this->load->model('ModelLogin');
            if($username!=null && $password!=null){
                $data = $this->ModelLogin->adminLogin($username, $password);
                if($data!=null){
                    $this->ModelSession->setAdmin($data['id']);
                    redirect('admin/adminpage');
                } 
                else{ 
                    echo 'Email Atau Password Anda Salah';
                }
            } else{
                    echo 'Email Atau Password Anda Kosong';
                }
        }redirect('admin/adminpage');
    }
    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }
    function setpassword(){
        $pass1=$this->input->post('pass1');
        $pass2=$this->input->post('pass2');
        $username=$this->input->post('username');
        if($pass1==$pass2){
            $password = md5($pass1);
            $edit = array('username'=>$username, 'password'=>$password);
            $table = 'admin_accounts';
            $this->ModelCRUDD->edit($table, $edit, array('id'=>1) );
        }
    }   
}