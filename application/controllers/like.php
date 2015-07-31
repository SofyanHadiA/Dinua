<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Like extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }
    
    public function setLike(){
        $data = $this->input->post('data');
        $tid= $data['tid'];
        $type= $data['type'];
        
        $tid    = $this->encrypt->decode($tid);
        $type   = $this->encrypt->decode($type);
        
        if((!empty($tid)) and (!empty($type))){
            $uid    = $this->session->userdata('id');
            $table='likes';
            
            // check apakah user pernah like
            $this->load->library('LibCommon');
            $count = $this->libcommon->getColoumnCount($table,array('uid'=>$uid, 'tid'=>$tid,'content'=>'S'));         
            if(!$count || $count=0){
                $created = now();
                $data=array(    'uid' =>$uid,
                                'tid' =>$tid,
                                'content' => $type,
                                'created' => $created);
                $table='likes';
                
                if( $this->ModelCRUDD->add($table, $data)){
                    $count = $this->libcommon->getColoumnCount($table,array('tid'=>$tid,'content'=>'S'));
                    
                    $this->load->library('LibProfile');
                    $user = $this->libprofile->getProfile($uid,array('id','realname'));
                    
                    $data = array ( 'created'=>'baru saja',
                                    'username'=>$user['realname'],
                                    'count' => $count,
                                    );
                    echo json_encode($data);
                }
                else {
                    echo "";    
                }
            }
        }
    }
    
    public function getLike(){
        $type = $this->uri->segment(3);
        if($type=='status'){
            $type='S';
        }
        //$data=$this->input->post('data');
        //$tid=$data['tid'];
        $tid=$this->input->post('tid');
        
        $tid=$this->encrypt->decode($tid);
        $this->load->library('LibLike');
        $data=$this->liblike->getLike($tid,$type);
        if(!empty($data)){
            foreach($data as $rows){
                $this->load->library('LibProfile');
                $user_data[]=$this->libprofile->getProfile($rows['uid'],array('id','realname'));
            }   
            shuffle($user_data);
            $count = count($user_data);
            
            if($count>=5){
                $max=5;
            }else {$max=$count;}
            $data=array();
            for($i=0;$i<$max;$i++){
                $data[$i]['realname']=$user_data[$i]['realname'];
                $data[$i]['id']=$user_data[$i]['id_encrypt'];
            }
            
            echo json_encode($data);
        }
    }
    
}