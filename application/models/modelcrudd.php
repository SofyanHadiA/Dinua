<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelcrudd extends CI_Model {
      
    //method ini digunakan untuk menambahkan record baru
    function add($table,$data,$return_id=false){        
        if ($this->db->insert($table,$data)){
            if($return_id==false){
                return true;
            }else{
                return $this->db->insert_id();
            }
            
        }else {return false;}
    }
    
    //method ini digunakan untuk mengambil data record  ---- FIX
    function get($table, $field=NULL, $where=NULL, $limit=NULL, $order=NULL, $offset = NULL  ){
        //jika kolom tertentu yang diminta
        if(!$field==NULL){
            $selected='';
            //pengambilan nilai array untuk kolom yang diminta
            foreach ($field as $field){
                $selected=$selected." ".$field.",";
            }
        }
        else{$selected='*';} // jika seluruh kolom yang diminta
        
        //pengiriman query ke helper database
        $this->db->select($selected);
        $this->db->from($table);
        
        if (!empty($order)){
            $order=explode(',',$order);
            $this->db->order_by($order[0], $order[1]);
            }
        
        //jika parameter untuk where di tentukan
        if(!empty($where)){$this->db->where($where);}
        
/*        if(!empty($limit)){
            $this->db->limit($limit);
        }
        
         if(!empty($offset)){
            $this->db->limit($offset);
        }*/
        
        //eksekusi query
        $Q=$this->db->get('',$limit, $offset);
        
        //pemberian nilai variabel untuk index array
        $i=0;
        $data='';
        
        //pengambilan data hasil query
        foreach ($Q->result() as $row){ 
        $a =get_object_vars($row);    
                foreach($row as $value){
                    $key = key($a);
                    $array[$key]=$value;
                    next($a);
                }
                
            $data[$i]=$array;
            $i++;
        }
        
        $Q->free_result();
        return $data;      
    }
    
    
    //method ini digunakan untuk mengedit record
    function edit($table, $data, $where){
        $this->db->where($where);
       if ($this->db->update($table, $data)){
            return true;
       }else{return false;}
        
    }
    
    //method ini digunakan untuk men-Disable record
    function disabled($id, $disabled){
        $data = array(  'disabled' => $disabled );
        $this->db->where('id', $id);
        $this->db->update('accounts', $data);
    }
    
    //method ini digunakan untuk menghapus record
    function delete($table, $where){
        $this->db->where($where);
        if($this->db->delete($table)){
            return true;
        } else {return false;}
    }
    
    // Method ini untuk melakukan query yang tidak tersedia diatas
    function costum($query){
         if($this->db->query($query)){
            return true;
         } else return false;
    }
}    