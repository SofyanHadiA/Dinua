<?php 
/*Kelas Controller utama yang mengatur kelas controller lainnya 
serta mengatur konten yang tertampil pada view*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Status extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('LibStatus');
    }
    public function setStatus(){
        $status = $this->input->post('status'); 
        if(!empty($status)){
            $uid    = $id=$this->session->userdata('id');
            $tid    = $this->input->post('tid');
            $tid    = $this->encrypt->decode($tid);
            $created = now();
            
            $this->load->library('LibFilter');
            $filtered = $this->libfilter->checkWord($status,$uid);
            if($filtered==true){
                $table = 'reports';
                $data= array(
                    'uid' => $uid,
                    'tid' => "",
                    'content' => 'S',
                    'message' => 'User ini mencoba memasukan status dengan kata tersaring',
                    'created' =>now()
                );
                $this->ModelCRUDD->add($table, $data);
                
                $data= array('success' => 'false', 'message'=>'Kamu mencoba memasukan kata tersaring');
                echo(json_encode($data)); exit;
            }
            $status = $this->libfilter->word2($status);
            
            $this->load->library('LibFriends');
            $isFriend= $this->libfriends->getFriendStatus($uid,$tid);
            if($isFriend=='Y' || $isFriend=='self'){
                // jika statusnya berteman, kirim email ke teman
                if($isFriend=='Y'){
                    $this->load->library('LibProfile');
                    $from=$this->libprofile->getprofile($uid);
                    $from=$from['realname'];
                    $to=$this->libprofile->getprofile($tid);
                    $realname=$to['realname'];
                    $to=$to['email'];
                    $this->load->library('libsendmail');
                    $this->libsendmail->statusEmail($to, $realname, $from);
                }
                $status = substr($status, 0, 500);
                // menambhakan expanable jika line break lebih sama dengan 5
                $lnbrCount = substr_count($status, "\n");
                if ($lnbrCount>=5){
                    $remove = array("\n", "\r\n", "\r");
                    $status = str_replace ($remove,' ', $status);
                }
                $data=array(    'uid' =>$uid,
                                'tid' =>$tid,
                                'message' => $status,
                                'created' => $created);                
                $table='status';
                if($this->ModelCRUDD->add($table, $data)){
                    // masuka ke tabel notify
                    if($tid!=$uid){
                        $data=array(    
                                'uid' =>$uid,
                                'tid' =>$tid,
                                'content' => 'S');                
                        $table='notify';
                        $this->ModelCRUDD->add($table, $data);
                    }
                    $data= array('success' => 'true');
                    echo(json_encode($data)); exit;
                }else{
                    $data= array('success' => 'false', 'message' => $message);
                    echo(json_encode($data)); exit;
                }
            }
        }
    }
    public function deleteStatus(){
        $data = $this->input->post('data');
        $data = json_decode($data);
        $tid = $data->tid;
        $tid = $this->encrypt->decode($tid);
        if(!empty($tid)){
            $id = $this->session->userdata('id');
            $where = ('id = '.$tid.' and tid ='.$id);
            $table = 'status';
            if($this->ModelCRUDD->delete($table,$where)){
                $data= array('success' => 'true');
                echo(json_encode($data)); exit;
            }else{
                $data= array('success' => 'false');
                echo(json_encode($data)); exit;
            }
        }
    }
    public function getStatus(){
        $uid = $this->session->userdata('id');
        $fid = $this->input->post('id');
        $fid = $this->encrypt->decode($fid);
        if(!empty($fid)){
            $id = $fid;
        } else {$id = $uid;}
        // pengaturan pagginasi
        $offset = ($this->uri->segment(3));
        if(empty($offset)){
            $offset = null;
        }
        if(!empty($id)){ 
            // eksekusi query paginasi ke ModelCRUDD
            $where  =array('tid'=>$id , 'disabled'=>null);
            $data = $this->libstatus->getStatus($where, 5, $offset);
            if(empty($data)){ $data['empty']='true';}
            echo(json_encode($data));
        }
    }
    public function getNewStatus(){
        $uid = $this->session->userdata('id');
        $wall_id=$this->input->post('id');
        $wall_id=$this->encrypt->decode($wall_id);
        if(!empty($wall_id) and !empty($uid)){        
            $where=('tid = '.$wall_id.' and readed = "N"');
            $data = $this->libstatus->getStatus($where);
            if(empty($data)){ $data['empty']='true';}
            echo(json_encode($data));
        }
    }
    function getWorldStatus(){
        $uid = $this->session->userdata('id');
        $wall_id=$this->input->post('id');
        if(!empty($uid)){        
            // pengaturan pagginasi
            $offset = ($this->uri->segment(4));
            if(empty($offset)){
                $offset = 0;
            }
            $this->load->library('LibFriends');
            $friends = $this->libfriends->getFriendsList($uid);
            $count = count($friends);
            // ambil status sendiri
            $where='( uid = '.$uid.' ) ';
            if(!empty($friends)){
                $i=0;
                foreach($friends as $rows){
                    $where=$where.' or ( uid = '.$rows['id'].' ) ';
                }
            }
            //$where = array("disabled"=>null);
            $data = $this->libstatus->getStatus($where, 10, $offset);
            if(!empty($data)){
                echo(json_encode($data)); exit;
            }
        }
        $data['empty']='true';
        echo(json_encode($data));
    }
}