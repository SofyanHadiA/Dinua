<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// Library ini digunakan untuk mengambil data profil
class LibStatus {
    public function getStatus($where, $limit=null, $offset=1){ // method ini digunakan untuk mengambil semua status dari 1 akun
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk memlakukan operasi database
        $CI->load->model('ModelCRUDD');
        // Mengirimkan parameter pengambilan database;
        $field      ='';
        $table      ='status';
        $order      ='created,desc';
        $status=$CI->ModelCRUDD->get($table, $field, $where, $limit, $order, $offset);
        
        $uid = $CI->session->userdata('id');
            
        if(!empty($status)and (!empty($uid))){ 
                        
            $CI->load->library('LibProfile');
            $CI->load->library('LibFriends');
            $CI->load->library('LibComment');
            
            $i=0;
            foreach($status as $row){
                //Status ID
                $status_id = $row['id'];
                
                // set jadi readed
                if($row['readed']=='N'){
                    $CI->load->model('ModelCRUDD');
                    $table = 'status';
                    $where = array('id ' => $row['id'], 'readed'=>'N');
                    $edit = array('readed'=>'Y'); 
                    $CI->ModelCRUDD->edit($table, $edit, $where);
                }
                
                $uid_encrypted = $CI->encrypt->encode($row['uid']);
                $uid_encrypted = urlencode($uid_encrypted);
                // profil pembuat status                
                $user = $CI->libprofile->getProfile($row['uid']);
                $username =$user['realname'];
                $avatar = base_url().$user['avatar'].'avatar-40px.jpg';
                
                // mengecek dinding penerima status
                if($row['uid']!=$row['tid']){
                    $user = $CI->libprofile->getProfile($row['tid']);
                    $t_username = $user['realname'];
                    $onwall = $t_username;
                    
                    $wallOwnerId = $CI->encrypt->encode($row['tid']);
                    $wallOwnerId = urlencode($wallOwnerId);
                    
                }else{$onwall='self'; $wallOwnerId=null;}
                
                // boleh mengirim komentar atau tidak
                $isFriend = $CI->libfriends->getFriendStatus($uid, $row['uid']);
                if($isFriend=='Y' || $isFriend=='self'){
                    $isFriend=true;
                }             
                // Ambil Komentar
                $comment = $CI->libcomment->getComment($status_id,'S');              
                $commentCount = count($comment);
                
                if(!empty($comment)){
                    $temp_comment = array();
                    foreach($comment as $rows2){
                        $created  =standard_date('DATE_IND', $rows2['created']);
                        $created  =en2in_date($created);
                        
                        $comment_user = $CI->libprofile->getProfile($rows2['uid']);
                        $comment_username = $comment_user['realname'];
                        $comment_avatar = base_url().$comment_user['avatar'].'avatar-30px.jpg';
                        
                        $tid = $rows2['id'];
                        $tid = $CI->encrypt->encode($tid);
                        $tid = urlencode($tid);
                        
                        $temp_comment[] = array(
                                'tid' => $tid,
                                'username' => $comment_username,
                                'avatar' => $comment_avatar,
                                'message' => $rows2['message'],
                                'created' => $created
                        ); 
                    }
                    $comment=$temp_comment;
                    $commentCount = count($comment);
                }else{$comment=null; $commentCount =0;}

                $CI->load->library('LibLike');
                $like = $CI->liblike->getLike($row['id'],'S');              
                $likeCount = count($like);
                
                if(!empty($like)){
                    $isLike=$CI->liblike->isLike($uid, $row['id'], 'S');
                    if($isLike){$isLike=false;}
                        else{$isLike=true;}
                }else{$isLike=true;}
                                
                $created  =standard_date('DATE_IND', $row['created']);
                $created  = en2in_date($created);
                
                $comment_type = $CI->encrypt->encode('S');
                $comment_type = urlencode($comment_type);
                
                $tid = $row['id'];
                $tid = $CI->encrypt->encode($tid);
                $tid = urlencode($tid);
                
                $random_number = random_string('numeric', 9);
                
                $data['status'][]=array(
                                'div_id' => $random_number,
                                'tid' => $tid,
                                'uid' => $uid_encrypted,
                                'username' => $username,
                                'message' => $row['message'],
                                'created' => $created,
                                'avatar' => $avatar,
                                'type'  =>$comment_type,
                                'canPostComment' => $isFriend,
                                'commentCount' => $commentCount,
                                'comment' => $comment,
                                'likeCount' => $likeCount,
                                'isLike' => $isLike,
                                'wall' => $onwall,
                                'wallOwnerId' => $wallOwnerId,
                                'id' => $status_id
                                );
            }
            $data['offset'] = $offset+10;
            //kembalikan hasil 
            return $data;
        }
        else{ return null;}
    }
    
}
