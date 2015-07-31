<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {
    
    function addReport(){
        $data = $this->input->post('data');
        $tid  = $data['tid'];
        $type = $data ['type'];
        
        $tid = $this->encrypt->decode($tid);
        $type = $this->encrypt->decode($type);
        
        if((!empty($tid))and(!empty($tid))){
            $uid = $this->session->userdata('id');
            $this->load->library('LibProfile');
            $this->load->library('LibCommon');
            
            $table = 'reports';
            $check = $this->libcommon->getColoumnCount($table, array('uid'=>$uid, 'tid'=>$tid));
            
            if(count($check)==null){
                $user = $this->libprofile->getProfile($uid);
                           
                $date_now = standard_date("DATE_ATOM", now());
                $message = $user['realname'].' telah melaporkan ini, pada '.$date_now;
                
                
                $data= array(
                    'uid' => $uid,
                    'tid' => $tid,
                    'content' => $type,
                    'message' => $message,
                    'created' =>now()
                );
                if($this->ModelCRUDD->add($table, $data)){echo json_encode(array('message'=>'berhasil dilaporkan'));}
            } else{echo json_encode(array('message'=>'anda pernah melaporkan'));}
        }
         
    }

}