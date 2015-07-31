<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelGroupSection extends CI_Model {
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
        
    function getSection($categories_id){
        $this->db->select('name');
        $this->db->from('sections');
        $where='ctgrs_id = '.$categories_id;
        $this->db->where($where);
        $Q=$this->db->get();
        $i=0;         
                foreach ($Q->result() as $row){
                $i=$i+1; 
                $data['sect_'.$i]=$row->name;
                }
        $data['num_sect']=$i;        
        return $data;
        $Q->free_result();
    }
}
?>