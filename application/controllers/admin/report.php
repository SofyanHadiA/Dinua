<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class report extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $admin = $this->session->userdata('type');
        if(!$admin){
            redirect(base_url());
        }
    }
    public function delete(){
            $tid = $this->input->get('id');
            $table = 'reports';
            $where = array('id'=>$tid);
            $this->ModelCRUDD->delete($table,$where);
            redirect(base_url('admin/adminpage/report')); 
    }
}