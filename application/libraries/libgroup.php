<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// Library ini digunakan untuk mengambil data Group
class LibGroup{
    public function getAllCategories(){ // method ini digunakan untuk mengambil seluruh Categories
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk melakukan operasi database
        $CI->load->model('ModelCRUDD');
            // Mengirimkan parameter pengambilan database
            $where      = array('disabled'=>null);
            $field      = null;
            $table      ='group_categories';
            $data       =$CI->ModelCRUDD->get($table, $field, $where);
                      
        if(!empty($data)){
            //kembalikan hasil 
            return $data;
        }
        else{ return null;}
    }
    
    public function getAllSections(){ // method ini digunakan untuk mengambil seluruh Sections
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk melakukan operasi database
        $CI->load->model('ModelCRUDD');
            // Mengirimkan parameter pengambilan database
            $where      ='';
            $field      =array('id','name');
            $table      ='group_sections';
            $data       =$CI->ModelCRUDD->get($table, $field, $where);
                      
        if(!empty($data)){
            //kembalikan hasil 
            return $data;
        }
        else{ return null;}
    }
    
}
