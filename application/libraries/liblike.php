<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LibLike {
    public function getLike($tid, $type, $disabled=null){
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk memlakukan operasi database
        $CI->load->model('ModelCRUDD');
            // Mengirimkan parameter pengambilan database
            $where      =array('tid'=>$tid, 'content'=>$type, 'disabled'=>$disabled);
            $field      ='';
            $table      ='likes';
            $order      ='created,desc';
            $limit      = null;
            $data_like  =$CI->ModelCRUDD->get($table, $field, $where, $limit, $order);
            
            $data = array();
            
         if(!empty($data_like)){
            $tmp_data = $data_like;
            $i=0;
            
            foreach ($tmp_data as $rows){ // ambil data yang like
            
                $id=$rows['id'];
                $id=$CI->encrypt->encode($id);
                $id=urlencode($id);
                $data_like[$i]['id_encrypted']=$id;
                
                $CI->load->library('LibProfile');
                $data_user=$CI->libprofile->getProfile($rows['uid'],array('id','realname'));
                $data_like[$i]['user']=$data_user;
                               
                $i++;
           }
            $data=$data_like;
            //kembalikan hasil 
            return $data;
        }
        else{ return null;}
    }
    
    public function isLike($uid, $tid, $type){
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk memlakukan operasi database
        $CI->load->library('LibCommon');
        $table = 'likes';
        $where = array('uid'=>$uid, 'tid'=>$tid, 'content'=>$type);
        $data = $CI->libcommon->getColoumnCount($table,$where);            
        if(!empty($data)){
            return true;
        }
        else{ return false;}
    }
    
}
