<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class LibThumb {

    public function getPhoto50x($id, $photo_id){
        $md5_id          = md5($id);
        $md5_photo_id    = md5($photo_id);
        
        $dir = './temp/images/'.$md5_id;
        if( !file_exists($dir)){ //mengecek apakah direktori sudah terbuat atau belum
            mkdir($dir,777);} //jika belum, maka direktori dibentuk
        
        $file = './temp/images/'.$md5_id.'/thumb50_'.$md5_photo_id;
        if( !file_exists($file)){ //mengecek apakah direktori sudah terbuat atau belum
            exec("convert \"uploads/images/$md5_id/$md5_photo_id\" -resize 50x50 -quality  75% \"temp/images/$md5_id/thumb50_$name\" ");
        }
        return $data;
    }
    
    public function getTimeOnly($date){
        $temp       = unix_to_human($date);
        $temp       = explode(' ', $temp);
        $data       = $temp[0];
        return $data;
    }
    
}
