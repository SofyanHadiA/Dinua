<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// Library ini digunakan untuk mengambil data profil
class LibAlbum {
    public function getAlbum($table, $id, $type, $disabled=null){ // method ini digunakan untuk mengambil semua status dari 1 akun
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk memlakukan operasi database
        $CI->load->model('ModelCRUDD');
            // Mengirimkan parameter pengambilan database
           //Untuk ngambil album
            $where      =array('uid'=>$id, 'disabled'=>$disabled);
            $field      ='';
            $table      =$table;
            $limit      = null;
            $order      ='created,desc';
            $data       =$CI->ModelCRUDD->get($table, $field, $where, $limit, $order);
            
        if(!empty($data)){
            $count = count($data);
            for($i=0; $i<$count; $i++) {
                 $rows=$data[$i];
                 $aid=$rows['id'];
                 $created = standard_date('DATE_IND', $rows['created']);
                 $created = en2in_date($created);
                 $data[$i]['created']=$created;
                 
                 // Mengambil thumbnails album
                 $data[$i]['thumb']=null; // beri nilai awal
                 if($type!='note'){
                     $where      =array('aid'=>$aid, 'uid'=>$id);
                     $field      = array('url');
                     $table      = $type.'s';
                     $temp       =$CI->ModelCRUDD->get($table, $field, $where);
                     
                     if(!empty($temp)){ 
                        $md5_id = md5($id);
                        $rand = array_rand($temp);
                        if($type=='photo'){
                            $rand =base_url().'uploads/'.$table.'/'.md5($id).'/thumb_'.$temp[$rand]['url'];
                        } 
                        else if ($type=='ebook'){
                            $rand =base_url().'temp/'.$table.'/'.md5($id).'/thumb_'.$temp[$rand]['url'].'.jpg';
                        }
                     }
                        else{$rand=null;}
                     
                     $data[$i]['thumb']=$rand;
                 }
            }
            //kembalikan hasil 
            return $data;
        }
        else{ return null;}
    }
    
    public function getContent($type, $aid, $uid, $disabled=null){
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk memlakukan operasi database
        $CI->load->model('ModelCRUDD');
        
        $table  = $type.'s';     
        $where      =array('aid'=>$aid, 'uid'=>$uid , 'disabled'=>null);
        $field      ='';
        $order      ='created, desc';
        $limit      =null;
        $temp       =$CI->ModelCRUDD->get($table, $field, $where, $limit, $order);
             
        if(!empty($temp)){
            $i=0;
            foreach($temp as $rows){
                $created = standard_date('DATE_IND', $rows['created']);
                $created = en2in_date($created);
                $temp[$i]['created']=$created;
                
                // mengeset thumbnailnya
                if($type=='photo'){
                    $thumb =base_url().'uploads/'.$table.'/'.md5($uid).'/thumb_'.$rows['url'];
                } 
                else if ($type=='ebook'){
                    $thumb =base_url().'temp/'.$table.'/'.md5($uid).'/thumb_'.$rows.'.jpg';
                } 
                else{$thumb=null;}
                
                $temp[$i]['thumb']=$thumb;
                $i++;
            }
            $data = $temp;                           
        }
             else{$data=null;}
             
        return $data;
    }
    
}
