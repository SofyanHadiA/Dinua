<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelLogin extends CI_Model {
    
      function __construct()
        {
        // Call the Model constructor
        parent::__construct();
        }
    
    function login($email, $password){
        $password   = do_hash($password, 'md5');
        
        $this->db->select('id,disabled');
        $this->db->from('accounts');
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->limit(1);
        $Q = $this->db->get();
        
        $data=array();
        if ($Q->num_rows() == 1){
            foreach ($Q->result() as $row){
                $data = array('id'=>$row->id, 'disabled'=>$row->disabled);
            }
        }
        $Q->free_result();
        return $data;
    }
    
    function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }

    function adminLogin($username, $password){
        $password   = do_hash($password, 'md5');
        
        $this->db->select('id');
        $this->db->from('admin_accounts');
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('disabled', null);
        $this->db->limit(1);
        $Q = $this->db->get();
        $data=array();
        if ($Q->num_rows() == 1){
            foreach ($Q->result() as $row){
                $data = array('id'=>$row->id);
            }
        }
        
        $Q->free_result();
        return $data;
    }
}