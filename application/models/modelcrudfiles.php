<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelcrudfiles extends CI_Model {
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function  add($config,$dir){
        if( !file_exists($dir)){ //mengecek apakah direktori sudah terbuat atau belum
            mkdir($dir,0755); //jika belum, maka direktori dibentuk
            $file = 'uploads/index.html';
            $newfile = $dir.'/index.html';
            if (!copy($file, $newfile)) {exit;}
        } 
            $this->load->library('upload', $config);
        
	if($this->upload->do_upload()){ // jika upload berhasil kembalikan true
            return true;
	} else{
            return false;
	}
        $config->free_result();
    }
    
}