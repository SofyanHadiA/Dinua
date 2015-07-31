<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    public function setProfile(){    
        
    $uid = $this->session->userdata('id');
    if(!empty($uid)){ 
        $data=$this->input->post('data');
        if(empty($data)){ exit;}
        
        $type=$this->input->post('type');
        $type=$this->encrypt->decode($type);
        
        $ret = $data[0];
        
        $error=array();
        switch ($type){ 
        	case 'realname': 
                $firstname = substr($data[0],0,10);
                $middlename = substr($data[1],0,10);
                $lastname = substr($data[2],0,10);
                
                $realname = $firstname.' '.$middlename.' '.$lastname;
                if(strlen($realname) < 8) { $error[]='Nama Lengkap Terlalu Pendek'; }
                if((empty($firstname)) || (empty($middlename)) || (empty($lastname))){
                    $error[]='Mohon untuk mengisi semua kolom nama';
                }
                else{ $data=array('realname'  => $realname); $ret = $realname; };

        	break;
        
        	case 'email' :
                $email = $data[0];
                if(!preg_match("^[a-zA-Z0-9]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$^", $email)){ $error[]='Email belum valid'; }
                else{
                    // masukan ke kolom salt
                    $table = "accounts";
                    $where = array('id' => $uid);
                    $salt = random_string('alnum',10);
                    $edit = array('salt'=>$salt);
                    $this->ModelCRUDD->edit($table, $edit,$where);
                    
                    $email_hashed = $this->encrypt->encode($email, $salt);
                    $email_hashed = $this->encrypt->encode($email_hashed, $salt);
                    $email_hashed = urlencode($email_hashed);
                    
                    // kirim email ke email baru
                    $to      = $email; // Send email to our user
                    $subject = 'Dinua Signup | Verification'; // Give the email a subject
$message = '
Kamu telah meminta untuk merubah alamat email kamu ke : '.$email.'

Untuk menerima perubahan silahkan klik tautan di bawah ini:                               
----------------------------------------------------------------------------
http://www.dinua.net/change_email?a='.$email_hashed.'
----------------------------------------------------------------------------
                
Terimkasih atas partisipasi Kamu
                                
ABAIKAN PESAN INI JIKA KAMU MERASA TIDAK PERNAH MEMINTA ME-RESET PASSWORD'; // Our message above including the link
                
                $headers = 'From:dinua-noreply@dinua.net' . "\r\n"; // Set from headers
                mail($to, $subject, $message, $headers); // Send our email
                    $ret = 'Silahkan klik tautan yang telah terkirim ke email : '.$email;
                    echo json_encode($ret);
                    exit();
                }
        	break;
            
            case 'password':
                $pass1=$data[0]; $pass2=$data[1];
                if($pass1!=$pass2){ $error[]='Kata Sandi Tidak Sama'; }
                else{$password = do_hash($pass1, 'md5'); $data=array('password'  => $password); $ret="Berhasil dirubah, dimohon untuk menggunakan password baru saat login";}
            break;
            
            case 'gender' :
                $gender=$data[0];
                if(!($gender=="M" || "F")){ $error[]='Jenis Kelamin'; }
                else{ $data=array('gender'  => $gender); $ret = $gender;}
            break;
            
            case 'birthday' :
                $birthday = $data[0];
                $explode=explode('-', $birthday);
                $tmp=(int)$explode[2];  
                if( ($tmp<1940) or ($tmp>2012) ){$error[]='Tahun Lahir Diluar Jangkauan';}
                elseif($tmp>2006){$error[]='Anda Terlalu Muda Untuk Menggunakan Dinua';}
                elseif(!checkdate($explode[1], $explode[0], $explode[2])){ $error[]='Ada Kesalahan Pada Tanggal Lahir'; }
                else{$birthday=$explode[2].'-'.$explode[1].'-'.$explode[0].' 00:00 AM';
                    $birthday = human_to_unix($birthday);
                    $data = array('birthday'=>$birthday);
                  
                    $ret= standard_date('DATE_IND_NOTIME',$birthday);
                    $ret = en2in_date($ret);
                }  
                
            break;
            
            case 'country' : $data = array('country'=>$data[0]);break;
            case 'city': $data = array('city'=>$data[0]);break;
            case 'address': $data = array('address'=>$data[0]);break;
            case 'occupation': $data = array('occupation'=>$data[0]);break;
            case 'work_at': $data = array('work_at'=>$data[0]);break;
            case 'about_me': $data = array('about_me'=>$data[0]);break;
        	default :
        }    
        
        if(empty($error)){
            if ($this->ModelCRUDD->edit('accounts', $data, array('id'=>$uid))){
                $data = array($ret);
                echo json_encode($data);
            }
        }else{
            //Tampilkan pemberitahuan berhasil terjadi kesalahan variabel daftar
            $data = array('error' =>  'true', 'message'=> $error);
            echo json_encode($data);
        }
    }
    }
    
    public function changeEmail(){
        
    }
    
    public function setPhotoProfile(){
        $tid = $this->input->post('tid');
        $tid = $this->encrypt->decode($tid);
        
        $uid = $this->session->userdata('id');
        
        $table = 'photos';
        $where = 'id = '.$tid.' and uid = '.$uid;
        $data_photo = $this->ModelCRUDD->get($table,'',$where);

        if(!empty($data_photo)){
            $md5_uid = md5($uid);
            $url = $data_photo[0]['url'];
            $dir = 'uploads/avatars/'.$md5_uid;
            if( !file_exists($dir)){ //mengecek apakah direktori sudah terbuat atau belum
                mkdir($dir,0755);
                
                $file = 'uploads/index.html';
                $newfile = $dir.'/index.html';
                copy($file, $newfile);                
            } //jika belum, maka direktori dibentuk
            
            exec("convert \"uploads/photos/$md5_uid/$url\" -resize 175x175 -quality 150% \"uploads/avatars/$md5_uid/avatar.jpg\" ");
            exec("convert \"uploads/photos/$md5_uid/$url\" -resize 60x60 -quality 150% -crop 40x40+15+15 \"uploads/avatars/$md5_uid/avatar-30px.jpg\" ");
            exec("convert \"uploads/photos/$md5_uid/$url\" -resize 70x70 -quality 150% -crop 50x50+15+15 \"uploads/avatars/$md5_uid/avatar-40px.jpg\" ");
            exec("convert \"uploads/photos/$md5_uid/$url\" -resize 80x80 -quality 150% -crop 60x60+15+15 \"uploads/avatars/$md5_uid/avatar-50px.jpg\" ");
            exec("convert \"uploads/photos/$md5_uid/$url\" -resize 100x100 -quality 150% -crop 80x80+15+15 \"uploads/avatars/$md5_uid/avatar-70px.jpg\" ");
            
            $table = 'accounts';
            $edit  = array ('avatar'=>$dir.'/');
            $where = 'id = '.$uid;
            
            if($this->ModelCRUDD->edit($table, $edit,$where)){
                echo json_encode(array("Berhasil Di Rubah"));
            }
        }
    }
    
    public function editProfile(){
        $uid = $this->session->userdata('id');
        $type = $this->input->post('type');
        $type = $this->encrypt->decode($type);
        if((!empty($uid)) and (!empty($type))){
            $this->load->library('LibProfile');
            $data = $this->libprofile->getProfile($uid,array('id',$type));
            if(!empty($data)){
                $data = $data[$type];
                $data = $this->libprofile->switchType($data, $type);
            }
            echo json_encode($data);
        }
    }
    
}