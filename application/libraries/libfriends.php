<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class LibFriends {
    
    function getFriendStatus($uid, $fid){// Apakah sudah berteman aau tidak
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk melakukan operasi database
        $CI->load->model('ModelCRUDD');
            // Mengirimkan parameter pengambilan database
            $where      = array('uid'=>$uid, 'tid'=>$fid);
            $field      = null;
            $table      = 'friends';
            $data       = $CI->ModelCRUDD->get($table, $field, $where);
        if($uid != $fid){
        if(!empty($data)){          
            //kembalikan hasil
            if($data[0]['type']=='RQ'){
                return 'RQ';
            } 
            else {return 'Y';}
        }
        else{   
            // cek kedua kali
            // Mengirimkan parameter pengambilan database
            $where      = array('uid'=>$fid, 'tid'=>$uid);
            $field      = null;
            $table      = 'friends';
            $data       = $CI->ModelCRUDD->get($table, $field, $where);
                      
                if(!empty($data)){
                    //kembalikan hasil 
                     if($data[0]['type']=='RQ'){
                        return 'RQd';
                        } 
                     else {return 'Y';}
                }
                else{ return false;}
        }
       }else{return 'self';} // kalo sama langsung kembalikan true
    }   

    function getFriendsList($uid){
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk melakukan operasi database
        $CI->load->model('ModelCRUDD');
            // Mengirimkan parameter pengambilan database
            $where      = ('(uid = '.$uid.' or tid = '.$uid.') and (type= "Y")');
            $field      = null;
            $table      = 'friends';
            $friend_data= $CI->ModelCRUDD->get($table, $field, $where);
        
        if(!empty($friend_data)){
            foreach($friend_data as $rows){
                if ($rows['uid']==$uid){
                    $friend_id=$rows['tid'];
                } else {$friend_id=$rows['uid'];}
                
                $where      = ('id = '.$friend_id);
                $field      = null;
                $table      = 'accounts';
                $temp       = $CI->ModelCRUDD->get($table, $field, $where);
                $data[] = $temp[0];
                
            }
                // enkripsi id firend
                $i=0; 
                foreach($data as $rows){
                    $id = $CI->encrypt->encode($rows['id']);
                    $id = urlencode($id);
                    $data[$i]['id_encrypted']=$id;
                    $i++;
                }
                
            //kembalikan hasil 
            return $data;
        }
        else{ return null;}
    }   
    
    function getSugestedFriends($uid){
        // Meng-Instansikan CI libraries agar kita bisa bekerja malaluinya
        $CI =& get_instance();
        // Load ModelCRUDD untuk melakukan operasi database
        
        $friendList = $CI->libfriends->getFriendsList($uid);
        $where= 'id <> '.$uid;
        if(!empty($friendList)){
            foreach ($friendList as $rows){
                $where= $where.' and id <> '.$rows['id'];    
            }        
        }
        $CI->load->model('ModelCRUDD');
            // Mengirimkan parameter pengambilan database
            // $where      = array('disabled'=>null);
            $field      = null;
            $table      = 'accounts_active';
            $user_data  = $CI->ModelCRUDD->get($table, $field, $where);
        
        // encrypt seluruh id
        $i=0;
        foreach($user_data as $rows){
            $id = $CI->encrypt->encode($rows['id']);
            $id = urlencode($id);
            $user_data[$i]['id']=$id;
            $i++;
        }       
        
        if(count($user_data)>=5 ){
                $max=5;
            }else{$max=count($user_data);}
            
            for($i=0; $i<$max;$i++){
                $rand[$i] = array_rand($user_data);
                
                                            
            $temp[] = $user_data[$rand[$i]];
            }
        
        $temp=array_unique($temp);
        
        if(!empty($temp)){
            //kembalikan hasil 
            return $temp;
        }
        else{ return null;}
    }
}
