<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class LibFilter {
    function checkWord($word, $tid=null){
        $word = strtolower($word);
        $CI =& get_instance();
         $CI->load->database();       
        $word_list=$CI->ModelCRUDD->get('forbiden_words');
        $word_list= $word_list[0]['words'];
        $word_list=  explode(';', $word_list);
        foreach($word_list as $rows){
            $pattern = '/'.($rows).'/';
            $match= preg_match($pattern, $word);
            if($match==true){
            return $pattern; exit;
            }
        }
        if($match==true){
           
            return true;   
        } else{return false;}
    }
    function word2($word){
        $CI =& get_instance();
        $word_list=$CI->ModelCRUDD->get('forbiden_words','', array('category'=>2));
        $word_list= $word_list[0]['words'];
        $word_list=  explode(';', $word_list);
        foreach($word_list as $rows){
            $count = strlen($rows);
            $star='*';
            for($i=0;$i<($count-3);$i++){
                $star.='*';
            }
            $replace = $rows[0].$star.$rows[$count-1];
            $word = str_replace($rows, $replace, $word);
        }
        return $word;
    }
}