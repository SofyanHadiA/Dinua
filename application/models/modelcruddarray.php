<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelCRUDDArray extends CI_Model {
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
    //method ini digunakan untuk menambahkan record baru
    function add($data, $table){
        $arrayString=serialize($data);
        if($this->db->query("INSERT INTO page_settings VALUES('login','$arrayString');")){
            return true;
        }else {return false;}
    }
    
    //method ini digunakan untuk mengambil data record  ---- FIX
    function get($param, $field, $table){
        //jika kolom tertentu yang diminta
        if(!$field==''){
            $selected='';
            //pengambilan nilai array untuk kolom yang diminta
            foreach ($data as $field){
                $selected=$selected." ".$field.",";
            }
        }
        else{$selected='*';} // jika seluruh kolom yang diminta
        
        //pengiriman query ke helper database
        $this->db->select($selected);
        $this->db->from($table);
        
        //jika parameter untuk where di tentukan
        if(!$param==''){$this->db->where($param);}
        
        //eksekusi query
        $Q=$this->db->get();
        
        //pemberian nilai variabel untuk index array
        $i=0;
        
        //pengambilan data hasil query
        foreach ($Q->result() as $row){
                //pengecekan apakah kolom masih ada
                while($element = current($row)) {
                    //mengambil key array
                    $key=key($row);
                    
                    //key array tadi digunakan untuk mengambil 
                    //kolom dan nilai hasil query
                    $data[$i]=array($key => $row->$key);

                    $data[$i]=unserialize($arrayString);

                //lanjut ke kolom berikutnya
                next($row);
              }
        $i++;
        }
        return $data;
    }
    
    
    //method ini digunakan untuk mengedit record
    function edit($id, $data, $table){
        //id - untuk UID dan TID belum bener
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }
    
    //method ini digunakan untuk men-Disable record
    function disabled($id, $disabled){
        $data = array(  'disabled' => $disabled );
        $this->db->where('id', $id);
        $this->db->update('accounts', $data);
    }
    
    //method ini digunakan untuk menghapus record
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('accounts'); 
    }
    
    
}    