<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// Library ini digunakan untuk mengambil data profil
class LibComment {
    public function getComment($id, $content,$disabled=null){ // method ini digunakan untuk mengambil semua comment
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk memlakukan operasi database
        $CI->load->model('ModelCRUDD');
           $where      = array('tid'=>$id, 'content'=>$content, 'disabled'=>$disabled);
           $field      = array('id', 'uid', 'tid', 'message', 'created');
           $table      = 'comments';
           $order      = 'created, asc';
           $limit      = null;
           $data_comment       = $CI->ModelCRUDD->get($table, $field, $where, $limit, $order);
           
        if(!empty($data_comment)){
            $tmp_data_comment = $data_comment;
            $i=0;
           foreach ($tmp_data_comment as $rows){ 
            
                // enkripsi id comment
                $id=$rows['id'];
                $id=$CI->encrypt->encode($id);
                $id=urlencode($id);
                $data_comment[$i]['id_encrypted']=$id;
            
                // ambil data pembuat comment
                $where      = array('id'=>$rows['uid']);
                $field      = array('avatar', 'realname');
                $table      = 'accounts';
                $limit      = null;
                $data_user  = $CI->ModelCRUDD->get($table, $field, $where);
                $data_comment[$i]['user']=$data_user[0];
                
                $i++;
           }
            $data=$data_comment;
            //kembalikan hasil 
            return $data;
        }
        else{ return null;}
    }
    
}
