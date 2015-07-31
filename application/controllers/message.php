<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class message extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }
    
    public function getChatHistory(){
         $id = $this->session->userdata('id');
         $tid = $this->input->post('to');
         $tid  = $this->encrypt->decode($tid);      
         
         $table = 'messages';
         
         //ambil pesan yang untuk pengguna selama satu 
         $where = '((uid = '.$id.' and tid = '.$tid.') OR (uid = '.$tid.' and tid = '.$id.')) and created >= '.(now()-86400);
         $data = $this->ModelCRUDD->get($table,'',$where,10,'created, desc');
         
         $count = count($data)-1;
         $temp = $data;
         for($i=0;$i<=$count;$i++){
            $data[$i]=$temp[$count-$i];
         }
         
         if(!empty($data)){            
            foreach ($data as $rows){
                // ambil data pengirim
                $table = 'accounts';
                $where = 'id = '.$rows['uid'];
                $temp=$this->ModelCRUDD->get($table,'',$where);
                $user_data=$temp[0];
                
                 // ambil data lawan chating
                 $table = 'accounts';
                 $where = 'id = '.$tid;
                 $temp=$this->ModelCRUDD->get($table,'',$where);
                 // Ambil nama depan saja
                 $temp =explode(' ', $temp[0]['realname']); 
                 $chatboxtitle=$temp[0];    
                 
                 $uid = $this->encrypt->encode($rows['uid']);
                 $uid = urlencode($uid);
                 
                 $json_data[]= array('u'       => $uid,
                                     'avatar'  => base_url().$user_data['avatar'].'avatar-30px.jpg',
                                     'from'    => $chatboxtitle, // ambil yang paling depan saja
                                     'message' => $rows['message']
                                   );
                //set pesan menjadi terbaca
                $table_2 = 'messages';
                $where_2 = 'id = '.$rows['id'];
                $data_2  = array('readed' => 'Y', 'checked' => 'Y');
                $this->ModelCRUDD->edit($table_2,$data_2, $where_2);
            }
            // kembalikan menggunakan tipe data json
            echo json_encode($json_data);
            
            // set smua menjadi terbaca :)
            exit;
        }
    }
    
    function checkNewChat(){
         $id = $this->session->userdata('id');
        $table = 'messages';
        //ambil pesan yang berhubungan dengan pengguna
        $where = array('tid' => $id, 'readed'=>"N", 'checked'=>'N');
        $data = $this->ModelCRUDD->get($table,'',$where);
        
        if(!empty($data)){            
            foreach ($data as $rows){
                // ambil data pengirim
                $table = 'accounts';
                $where = 'id = '.$rows['uid'];
                $temp=$this->ModelCRUDD->get($table,'',$where);
                $user_data=$temp[0];
                
                    // Ambil nama depan saja
                    $temp =explode(' ', $user_data['realname']); 
                    $name=$temp[0];
                    
                $uid = $this->encrypt->encode($rows['uid']);
                $uid = urlencode($uid);
                
                $json_data= array(  'tid'      => $uid,
                                    'username' => $user_data['realname'],
                                    'avatar'   => base_url().$user_data['avatar'].'avatar-30px.jpg',
                                    'from'     => $name, // ambil yang paling depan saja
                                    'message'  => $rows['message']
                                 );
                //set pesan menjadi terbaca
                $table_2 = 'messages';
                $where_2 = 'id = '.$rows['id'];
                $data_2  = array('checked' => 'Y');
                $this->ModelCRUDD->edit($table_2,$data_2, $where_2);
            }
            // kembalikan menggunakan tipe data json
            echo json_encode($json_data);
            
            // set smua menjadi terbaca :)
            exit;
        }else{
            $json_data=array("empty"=>true);
            echo json_encode($json_data);
        }
    }
    
    public function getChatNew(){
        $id = $this->session->userdata('id');
        $table = 'messages';
        //ambil pesan yang berhubungan dengan pengguna
        $where = 'tid = '.$id.' and readed = "N"';
        $data = $this->ModelCRUDD->get($table,'',$where);
        
        if(!empty($data)){            
            foreach ($data as $rows){
                // ambil data pengirim
                $table = 'accounts';
                $where = 'id = '.$rows['uid'];
                $temp=$this->ModelCRUDD->get($table,'',$where);
                $user_data=$temp[0];
                
                    // Ambil nama depan saja
                    $temp =explode(' ', $user_data['realname']); 
                    $name=$temp[0];
                    
                $uid = $this->encrypt->encode($rows['uid']);
                $uid = urlencode($uid);
                
                $json_data= array(  'u'       => $uid,
                                    'avatar'  => base_url().$user_data['avatar'].'avatar-30px.jpg',
                                    'from'    => $name, // ambil yang paling depan saja
                                    'message' => $rows['message']
                                 );
                //set pesan menjadi terbaca
                $table_2 = 'messages';
                $where_2 = 'id = '.$rows['id'];
                $data_2  = array('readed' => 'Y');
                $this->ModelCRUDD->edit($table_2,$data_2, $where_2);
            }
            // kembalikan menggunakan tipe data json
            echo json_encode($json_data);
            
            // set smua menjadi terbaca :)
            exit;
        }else{
            $json_data=array("empty"=>true);
            echo json_encode($json_data);
        }
        
    }
    function sendChat(){
        
        $data = $this->input->post('data');
        $data = json_decode($data);
            
        $tid = $data->to;
        $tid = $this->encrypt->decode($tid);
		$message = $data->message;
        
        if((!empty($tid))and(!empty($message))){
            $uid = $this->session->userdata('id');
            
            $message = substr($message, 0, 200);
            
            $data = array(  'uid' => $uid,
                            'tid' => $tid,
                            'message' => $message,
                            'created' => now()
                    );
    		$table = 'messages';
    		$this->ModelCRUDD->add($table,$data);
            
            $table = 'accounts';
            $where = 'id = '.$uid;
            $temp=$this->ModelCRUDD->get($table,'',$where);
            $sender_data=$temp[0];
            
            $table = 'accounts';
            $where = 'id = '.$tid;
            $temp=$this->ModelCRUDD->get($table,'',$where);
            $reciever_data=$temp[0];
            $reciever_name= explode(' ',$reciever_data['realname']);
            
            // kirim email
            $from=$sender_data['realname'];
            $realname=$reciever_data['realname'];
            $to=$reciever_data['email'];
            
            $this->load->library('libsendmail');
            $this->libsendmail->messageEmail($to, $realname, $from);
            
            
            $uid = $this->encrypt->encode($uid);
            $uid = urlencode($uid);
            
                    $json_data= array(  'u'       => $uid,
                                        'avatar'  => base_url().$sender_data['avatar'].'avatar-30px.jpg',
                                        'to'      => $reciever_name[0], // ambil yang paling depan saja
                                        'message' => $message);
                     echo json_encode($json_data);
        }
    }
    
     public function getMessage(){
         $uid = $this->session->userdata('id');
         $tid = $this->input->post('tid');
         if(!empty($uid)){
            
             $table = 'messages';
             $where = '((uid = '.$uid.') OR (tid = '.$uid.'))';
             $data = $this->ModelCRUDD->get($table,'',$where,'','created, desc');
             
             $uid_encrypted = $this->encrypt->encode($uid);
             $uid_encrypted = urlencode($uid_encrypted);
                        
             if(!empty($data)){ 
                foreach ($data as $rows){
                    if( $rows['uid']==$uid){
                        $tid[] = $rows['tid'];
                    }else{$tid[] = $rows['uid'];}
                }
                
                $tid = array_unique($tid);
                
                // urutkan
                $temp = $tid;
                $tid = null;
                foreach ($temp as $rows){
                    $tid[] = $rows;
                }
                
                foreach ($tid as $rows){
                    $tid_encrypted = $this->encrypt->encode($rows);
                    $tid_encrypted = urlencode($tid_encrypted);
                    // ambil data lawan
                    $table = 'accounts';
                    $where = 'id = '.$rows;
                    $temp=$this->ModelCRUDD->get($table,'',$where);
                    $user_data=$temp[0];
                    
                    //ambil data pesan
                     $table = 'messages';
                     $where = '((uid = '.$uid.' and tid = '.$rows.') OR (uid = '.$rows.' and tid = '.$uid.'))';
                     $data = $this->ModelCRUDD->get($table,'',$where,'','created, asc');
                     
                    //ambil data pengirim pesan
                    $i=0; $messageData=array(); // kosongkan
                    foreach($data as $rows2){ 
                        $table = 'accounts';
                        $where = 'id = '.$rows2['uid'];
                        $temp=$this->ModelCRUDD->get($table,'',$where);
                        $messageData[$i]['avatar'] =base_url().$temp[0]['avatar'].'avatar-30px.jpg';
                        $messageData[$i]['message'] =$rows2['message'];
                        $messageData[$i]['created'] =$rows2['created'];
                        
                        $i++;
                     }
                     $random_number = random_string('numeric', 9);
                     $json_data[]= array('divId'   => $random_number,
                                         'tid'     => $tid_encrypted,
                                         'avatar'  => base_url().$user_data['avatar'].'avatar-40px.jpg',
                                         'username'=> $user_data['realname'],
                                         'messageData' => $messageData
                                       );
                     
                }
                // kembalikan menggunakan tipe data json
                echo json_encode($json_data);
                
                // set smua menjadi terbaca :)
                exit;
             }
        }
    }
}