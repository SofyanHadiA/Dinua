<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class super extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $admin = $this->session->userdata('type');
        if(!$admin){
            redirect(base_url());
        }
    }
    function useractivate(){
        $tid   = $this->input->get('id');
            $edit  = array('disabled'=>null);
            $table = 'accounts';
            $where = array('id'=>$tid);
            $this->ModelCRUDD->edit($table,$edit,$where);
            redirect(base_url('admin/adminpage/account'));
    }
    public function userShutdown(){
            $tid   = $this->input->get('id');
            $edit  = array('disabled'=>'9');
            $table = 'accounts';
            $where = array('id'=>$tid);
            $this->ModelCRUDD->edit($table,$edit,$where);
            redirect(base_url('admin/adminpage/account')); 
    }
    public function delete(){
            $tid   = $this->input->get('id');
            $table = $this->input->get('table');
            $where = array('id'=>$tid);
            $delete = $this->ModelCRUDD->delete($table,$where);
            if($delete){
                redirect(base_url('admin/adminpage/content')); 
            }else{
                echo('<h3>Gagal Menghapus</h3>');
            } 
    }
}