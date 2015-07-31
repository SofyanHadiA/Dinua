<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class LibCommon  {
    
    public function getColoumnCount($table, $where="null"){
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk memlakukan operasi database
        $CI->load->model('ModelCRUDD');
           $where      = $where;
           $table      = $table;
           $data_count = $CI->ModelCRUDD->get($table, '', $where);
           
        if(!empty($data_count)){
            $count=count($data_count);
            
            //kembalikan hasil 
            return $count;
        }
        else{ return null;}
    }
    
    public function getFileList($dir, $ext='*', $hide_dir=false){
        $files = glob($dir.$ext, GLOB_BRACE);
        sort($files);
        if (!empty($files)){
            foreach ($files as $file) {
                    if($hide_dir){
                        $file=str_replace($dir, '', $file);
                    }
                    $data[]=$file;
                }
            return $data; 
        }
    }
    
}
