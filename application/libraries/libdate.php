<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class LibDate {

    public function getDateOnly($date){
        $temp       = unix_to_human($date);
        $temp       = explode(' ', $temp);
        $array_date = explode('-',$temp[0]);
        $data       = $array_date[2].'-'.$array_date[1].'-'.$array_date[0];
        return $data;
    }
    
    public function getTimeOnly($date){
        $temp       = unix_to_human($date);
        $temp       = explode(' ', $temp);
        $data       = $temp[0];
        return $data;
    }
    
}
