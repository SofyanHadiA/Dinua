<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comment extends CI_Controller {
    public function __construct(){
        parent::__construct();
    }
    public function setComment(){
        $data = $this->input->post('data');
        $data = json_decode($data);
        $comment= $data->message;
        if(!empty($comment)){
            $uid    = $this->session->userdata('id');
            $tid    = $data->tid;
            $tid    = $this->encrypt->decode($tid);
            $type   = $data->type;
            $type   = $this->encrypt->decode($type);
            
            $this->load->library('LibFilter');
            $filtered = $this->libfilter->checkWord($comment);
            if($filtered!=false){
                $table = 'reports';
                $data= array(
                    'uid' => $uid,
                    'tid' => "",
                    'content' => 'N',
                    'message' => 'User ini mencoba memasukan Komentar dengan kata tersaring',
                    'created' =>now()
                );
                $this->ModelCRUDD->add($table, $data);
                
                $data= array('success' => false, 'message'=>'Kamu mencoba memasukan kata tersaring');
                echo(json_encode($data)); exit;
            }
            $comment = $this->libfilter->word2($comment);
            $created = now();
            
            $this->load->library('LibFriends');
            $isFriend= $this->libfriends->getFriendStatus($uid,$tid);
            
            if($isFriend=='Y'){
                
                switch ($type){ 
                	case 'S' : $type_comment='Status'; $table='status'; break;
                	case 'E' : $type_comment='eBook'; $table='ebooks'; break;
                	case 'N' : $type_comment='Tulisan'; $table='notes'; break;
                    case 'I' : $type_comment='Foto'; $table='photos'; break;
                }
                $where = array('id'=>$tid);
                $content = $this->ModelCRUDD->get($table, '', $where );
                $content = $content[0];
                
                $this->load->library('LibProfile');
                $from=$this->libprofile->getprofile($uid);
                $from=$from['realname'];
                $to=$this->libprofile->getprofile($content['uid']);
                $realname=$to['realname'];
                $to=$to['email'];
                
                $this->load->library('libsendmail');
                $this->libsendmail->commentEmail($to, $realname, $from, $type_comment);
            }
            
            // ambil hanya 300 karater
            $comment = substr($comment, 0, 300);
            $data=array(    'uid' =>$uid,
                            'tid' =>$tid,
                            'message' => $comment,
                            'content' => $type,
                            'created' => $created);
            $table='comments';
            $id=$this->ModelCRUDD->add($table, $data,true);
            $random_number = random_string('numeric', 9);
            if ($id){
                $id=$this->encrypt->encode($id);
                $id=urlencode($id);
                $this->load->library('LibProfile');
                $user = $this->libprofile->getProfile($uid,array('realname'));
                $data = array ( 'divId'=>$random_number,
                                'tid'=>$id,
                                'message'=>$comment,
                                'created'=>'baru saja',
                                'username'=>$user['realname']
                                );
                echo json_encode($data);
            }
            else {
                 $data= array('success' => false, $message = 'Komentar gagal tersimpan !');
                echo(json_encode($data));  
            }
        }
    }
     public function deleteComment(){
        $data = $this->input->post('data');
        $tid = $data['tid'];
        $tid = $this->encrypt->decode($tid);
        if(!empty($tid)){
            $uid = $this->session->userdata('id');
            $where = ('id = '.$tid.' and uid='.$uid);
            $table = 'comments';
            if($this->ModelCRUDD->delete($table,$where)){
                $data= array('success' => 'true');
                echo(json_encode($data)); exit;
            }else{
                $data= array('success' => 'false');
                echo(json_encode($data)); exit;
            }
        }
    }
}