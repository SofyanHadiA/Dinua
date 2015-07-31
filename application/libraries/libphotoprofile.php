<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class LibPhotoProfile {

    public function get($id){
        //digunakan untuk mengambil foto profil
        
        // Instantiate the CI libraries so we can work with them
        $CI =& get_instance();
        $CI->load->model('ModelCRUDD');
        
        $where      =array('id'=>$id);
        $field      =array( 'avatar' );
        $table      ='accounts';
        $profile    = $CI->ModelCRUDD->get($table, $field, $where);
        if(!empty($profile)){
        $data       = $profile[0]['avatar'];
        return $data;}
        else{ return null;}
    }
    
   
}
