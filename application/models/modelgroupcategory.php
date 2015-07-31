<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelGroupCategory extends CI_Model {
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //method ini digunakan untuk menambahkan group category
    function add($name, $des, $disabled){
        $created=now();
        $data=array(    'name'      => $name,
                        'des'       => $des,
                        'created'   => $created,
                        'disabled'  => $disabled   );
        
        $this->db->insert('categories',$data );
    }
    
    //method ini digunakan untuk mengedit group category
    function edit($id, $name, $des, $disabled){
        $data = array(
               'name' => $title,
               'des' => $name,
               'disbled' => $disabled 
            );

        $this->db->where('id', $id);
        $this->db->update('categories', $data);
    }
    
    //
    function disabled($id, $disabled){
        $data = array(
               'disabled' => $disabled,
            );

        $this->db->where('id', $id);
        $this->db->update('categories', $data);
    }
    
    //
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('categories'); 
    }
    
    //method ini digunakan untuk mengambil group category
    function get(){
        $this->db->select('*');
        $this->db->from('categories');
        $Q=$this->db->get();
        
        foreach ($Q->result() as $row){
            $i++;

            $data['category_'.$i]=array('id'        => $row->id,
                                        'name'      => $row->name,
                                        'des'       => $row->des,
                                        'created'   => $row->created,
                                        'disabled'  => $row->disabled);
        }
        
        return $data;
    }
}    