<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SignUp extends CI_Controller {
    
    public function index(){
    $this->load->model('ModelSession');    
    $data=$this->ModelSession->getStatusLogin();
    if(!$data){
        
        $btnsignup=$this->input->post('btnsignup');    
        
        if(!empty($btnsignup)){
            
        $realname=$this->input->post('signupname');
        $realname=xss_clean($realname);
        
            $this->load->library('LibFilter');
            $filtered = $this->libfilter->checkWord($realname);
   /*         if($filtered==true){
                //Tampilkan pemberitahuan berhasil terjadi kesalahan variabel daftar
                $data['message']    ='Nama anda termasuk dalam daftar kata tersaring';
                $data['error']      ='';
                $data['info']       ='Silahkan diubah';
                
                $where  = array('page' => 'info');
                $field  = array('settings');
                $table  = 'page_settings';
                
                $content            = $this->ModelCRUDD->get($table, $field, $where);
                $data['content']    = unserialize($content[0]['settings']);
                    
                $this->load->view('template', $data);
            }*/
        
        $email=$this->input->post('signupemail');
        $email=xss_clean($email);
        
        $pass1=$this->input->post('password1');
        $pass1=xss_clean($pass1);
        
        $pass2=$this->input->post('password2');
        $pass2=xss_clean($pass2);
        
        $gender=$this->input->post('gender');
        $gender=xss_clean($gender);
        
        $birthday=$this->input->post('birthday');
        $birthday=xss_clean($birthday);
    
        // check apakah user sudah terdaftfar
        $table = 'accounts';
        $where = 'email = "'.$email.'"';
        
        $checked = $this->ModelCRUDD->get($table,'', $where);
        
        if(!empty($checked)){
            $data['message']    ='Email Telah Terdaftar';
            $data['error']      ='';
            $data['info']       ='Silahkan kembali ke halaman sebelumnya untuk <a href="index.html">masuk</a>';
            
            $where  = array('page' => 'info');
            $field  = array('settings');
            $table  = 'page_settings';
            
            $content            = $this->ModelCRUDD->get($table, $field, $where);
            $data['content']    = unserialize($content[0]['settings']);
                
            $this->load->view('template', $data);
        }else{
        
        //Array for contain Errors
        $error=array();
    
        //Validate name
		//if it's NOT valid
		if(strlen($realname) < 4) { $error[]='Nama Lengkap Belum Valid'; }
        //Validate email
        if(!preg_match("^[a-zA-Z0-9]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$^", $email)){ $error[]='Email'; }
        //Validate password
        if($pass1!=$pass2){ $error[]='Kata Sandi Tidak Sama'; }
        //Validate gender
        if(!($gender=="gender1" || "gender2")){ $error[]='Jenis Kelamin'; }
        else{        
            switch($gender){
            case 'gender1' : $gender=1; break;
            case 'gender2' : $gender=2; break;}
        }
        //Validate Birthday       
        $explode=explode('-', $birthday);
        $tmp=(int)$explode[2];
        $year_now = now();
        $year_now = unix_to_human($year_now);
        $explode_year_now=explode('-', $year_now);
        $year_now=(int)$explode_year_now[0];
        print_r($explode);
        $age = $year_now-$tmp;
        
        if( ($tmp<1940) or ($tmp>$year_now) ){$error[]='Tahun Lahir Diluar Jangkauan';}
        if($age>60){$error[]='Anda Terlalu Tua Untuk Menggunakan Dinua';}
        if($age<13){$error[]='Anda Terlalu Muda Untuk Menggunakan Dinua';}
        if(!checkdate($explode[1], $explode[0], $explode[2])){ $error[]='Ada Kesalahan Pada Tanggal Lahir'; }
        else{$birthday=$explode[2].'-'.$explode[1].'-'.$explode[0].' 00:00 AM';}
        $birthday = human_to_unix($birthday);  
            
        if(empty($error)){
            //password hasing menggunkan MD5
            $password = do_hash($pass1, 'md5'); // MD5 
            //atur salt
            $salt = random_string('alnum',10);
            $data=array('realname'  => $realname,
                        'email'     => $email,
                        'password'  => $password,
                        'gender'    => $gender,
                        'birthday'  => $birthday,
                        'created'   => now(),
                        'ip'        => $this->ModelSession->getIp(),
                        'lastlogin' => now(),
                        'salt'=>$salt
            );
            
            if ($this->ModelCRUDD->add('accounts',$data)){ 
                // mengirinkan email verifikasi
                
                //enkripsi
                $enc_email = $this->encrypt->encode($email);
                $enc_email = urlencode($enc_email);
                $enc_password = $this->encrypt->encode($password);
                $enc_password = urlencode($enc_password);
                
                // Kirim
                $to      = $email; // Send email to our user
                $subject = 'Dinua Signup | Verification'; // Give the email a subject
$message = '
Terimakasih Kamu sudah mau mendaftar!
                
Akun Kamu sudah terbentuk, namun belum diaktifkan. 
Untuk mengaktifkanya silahkan Kamu mengklik tautan dibawah ini :
                
----------------------------------------------------------------------------
http://www.dinua.net/verify?a='.$enc_email.'&b='.$enc_password.'
----------------------------------------------------------------------------
                
Data untuk login : 
----------------------------------------------------------------------------
Username: '.$realname.'
Password: '.$pass1.'
----------------------------------------------------------------------------

Terimkasih atas partisipasi Kamu
                                
Perhatian !
Saat ini dinua digunakan hanya untuk kepentingan riset'; // Our message above including the link
                
                $headers = 'From:dinua-noreply@dinua.net' . "\r\n"; // Set from headers
                mail($to, $subject, $message, $headers); // Send our email

                
                //Tampilkan pemberitahuan berhasil mendaftar
                $data['message']    ='Anda Berhasil Mendaftar';
                $data['error']      ='';
                $data['info']       ='Sebuah pesan untuk mengaktifkan akun Anda telah kami kirimkan ke surel (email) Anda <br/>'.
                                     'Untuk mulai menggunakan Dinua silahkan <a href="index.html">masuk</a> ';
                if($age>17){
                //Jika berumur lebih dari 18 tahun, tampilkan peringatan
                     $data['info'] =  $data['info'].'<br/> <h3 class="cl_red">Mohon diperhatikan : Sepertinya umur Anda diatas 17 tahun</h3>
                     <h4>Kami akan memantau Anda dan tidak akan segan-segan menutup akun Anda jika Anda mengirimkan konten<br/>
                     yang negatif atau tidak sesuai untuk didapat oleh pengguna 17 tahun kebawah<h4>';
                }
                $where  = array('page' => 'info');
                $field  = array('settings');
                $table  = 'page_settings';

                $content            = $this->ModelCRUDD->get($table, $field, $where);
                $data['content']    = unserialize($content[0]['settings']);
                
                $this->load->view('template', $data);
            }
        }
        else{
            //Tampilkan pemberitahuan berhasil terjadi kesalahan variabel daftar
            $data['message']    ='Ada Kesalahan Ketika Mendaftar';
            $data['error']      =$error;
            $data['info']       ='';
            
            $where  = array('page' => 'info');
            $field  = array('settings');
            $table  = 'page_settings';
            
            $content            = $this->ModelCRUDD->get($table, $field, $where);
            $data['content']    = unserialize($content[0]['settings']);
                
            $this->load->view('template', $data);
        } 
        }
        }
        else{redirect('index','refesh');}
    }
    else{redirect('index','refesh');}
    }
    
    public function verify(){
        $email = $this->input->get('a');
        $password= $this->input->get('b');
        
        $email = $this->encrypt->decode($email);
        $password = $this->encrypt->decode($password);
        
        if((!empty($email))and(!empty($password))){
            $where = array('email'=>$email, 'password'=>$password, 'disabled'=>'2');
            $table = 'accounts';
            $edit = array('disabled'=>null);
            $data = $this->ModelCRUDD->edit($table,$edit,$where);
            if($data){
                $data = array();
                 //Tampilkan pemberitahuan berhasil verifikasi
                 $data['message']    ='Verifikasi Berhasil';
                 $data['error']      ='';
                 $data['info']       ='Akun Kamu berhasil diaktifkan. Untuk mulai menggunakan Dinua silahkan <a href="index.html">masuk</a> ';                    
                 $where  = array('page' => 'info');
                 $field  = array('settings');
                 $table  = 'page_settings';
    
                 $content            = $this->ModelCRUDD->get($table, $field, $where);
                 $data['content']    = unserialize($content[0]['settings']);
                    
                 $this->load->view('template', $data); 
            }
            
        }
            // Default
            //Tampilkan gagal verifikasi
            $data['message']    ='Ada Kesalahan Ketika Verifikasi';
            $data['error']      ='';
            $data['info']       ='';
            
            $where  = array('page' => 'info');
            $field  = array('settings');
            $table  = 'page_settings';
            
            $content            = $this->ModelCRUDD->get($table, $field, $where);
            $data['content']    = unserialize($content[0]['settings']);
                
            $this->load->view('template', $data);
    }
    
    public function forgetPassword(){
        $this->load->model('ModelSession');    
        $data=$this->ModelSession->getStatusLogin();
        if(!$data){
        $email = $this->input->post('email');
        
        // ambil data akun
        $table = "accounts_active";
        $where = array('email' => $email);
        $data = $this->ModelCRUDD->get($table,'',$where);
        
        if(!empty($data)){
            $data = $data[0];
            $realname = $data['realname'];
            $new_password = random_string('alnum',10);
            
            // masukan ke kolom salt
            $table = "accounts";
            $where = array('email' => $email);
            $salt = random_string('alnum',10);
            $edit = array('salt'=>$salt);
            $this->ModelCRUDD->edit($table, $edit,$where);
            // hash $salt
            $salt = $this->encrypt->encode($salt);
            $salt = urlencode($salt);
            
            $email_hashed = $this->encrypt->encode($email);
            $email_hashed = $this->encrypt->encode($email_hashed);
            $email_hashed = urlencode($email_hashed);
            
            $new_password_hashed = $this->encrypt->encode($new_password);
            $new_password_hashed = urlencode($new_password_hashed);
            
            $true_hashed = $this->encrypt->encode(true);
            $true_hashed = urlencode($true_hashed);
            
            // tambahan waktu agar link expired
            $expired = now()+10800;
            $expired = $this->encrypt->encode($expired);
            $expired = urlencode($expired);
            
            $to      = $email; // Send email to our user
            $subject = 'Dinua | Reset Password '; // Give the email a subject
            $message = '
           
Halo '.$realname.',
Seperti yang kamu minta, password kamu akan kami rubah. 
Untuk masuk password yang kamu harus ketikan adalah yang dibawah ini : 

Password: '.$new_password.'

Untuk menerima perubahan password, silahkan klik link di bawah ini
------------------------------------------------------------------------
'.base_url().'password_reset?a='.$new_password_hashed.'&pass='.$true_hashed.'&b='.$email_hashed.'&c='.$salt.'&e='.$expired.'
------------------------------------------------------------------------
Masa aktif link selama 3 jam.

Terimkasih atas partisipasi Kamu

ABAIKAN PESAN INI JIKA KAMU MERASA TIDAK PERNAH MEMINTA ME-RESET PASSWORD

'; // Our message above including the link
                
                $headers = 'From:dinua-noreply@dinua.net' . "\r\n"; // Set from headers
                mail($to, $subject, $message, $headers); // Send our email

                //Tampilkan pemberitahuan berhasil mengirimkan pesan
                $data['message']    ='Anda Telah Meminta Me-<i>reset</i> Password';
                $data['error']      ='';
                $data['info']       ='Sebuah pesan untuk merubah password Anda telah kami kirimkan ke surel (email) Anda <br/>'.
                                     'Mohon untuk diperiksa';
                
                $where  = array('page' => 'info');
                $field  = array('settings');
                $table  = 'page_settings';

                $content            = $this->ModelCRUDD->get($table, $field, $where);
                $data['content']    = unserialize($content[0]['settings']);
                
                $this->load->view('template', $data);
            }else{
                //Tampilkan pemberitahuan berhasil email tidak terdaftra
                $data['message']    ='Email Anda Tidak Terdaftar Atau Belum Aktif';
                $data['error']      ='';
                $data['info']       ='';
                
                $where  = array('page' => 'info');
                $field  = array('settings');
                $table  = 'page_settings';

                $content            = $this->ModelCRUDD->get($table, $field, $where);
                $data['content']    = unserialize($content[0]['settings']);
                
                $this->load->view('template', $data);
            }
        }
    }
    
    public function resetPassword(){
        $this->load->model('ModelSession');    
        $data=$this->ModelSession->getStatusLogin();
        if(!$data){
            $email = $this->input->get('b');
            $email = $this->encrypt->decode($email);
            $email = $this->encrypt->decode($email);
            
            $new_password = $this->input->get('a');
            $new_password = $this->encrypt->decode($new_password);
            
            $salt = $this->input->get('c');
            $salt = $this->encrypt->decode($salt);
            
            $expired = $this->input->get('e');
            $expired = $this->encrypt->decode($expired);
            
            $checking = $this->input->get('pass');
            $checking = $this->encrypt->decode($checking);
            
            if(($checking==true) and (!empty($new_password)) and (!empty($email)) and (!empty($expired)) and (!empty($salt))){
                // check expired
                $now = now();
                if($expired<$now){
                    //Tampilkan pemberitahuan reset expired
                            $data['message']    ='Link Yang Anda Gunakan Telah Kadaluarsa';
                            $data['error']      ='';
                            $data['info']       ='<a href="index.html">Silahkan reset ulang password anda</a>';
                            
                            $where  = array('page' => 'info');
                            $field  = array('settings');
                            $table  = 'page_settings';
            
                            $content            = $this->ModelCRUDD->get($table, $field, $where);
                            $data['content']    = unserialize($content[0]['settings']);
                            
                            $this->load->view('template', $data);
                }else{
                
                    // ambil data akun
                    $table = "accounts_active";
                    $where = array('email' => $email, 'salt' => $salt);
                    $data = $this->ModelCRUDD->get($table,'',$where);
    
                    if(!empty($data)){
                        $data=array();
                        // rubah password
                        $new_password = md5($new_password);
                        $table = "accounts";
                        $edit = array('password'=>$new_password);
                        $where = array('email' => $email);
                        $this->ModelCRUDD->edit($table,$edit,$where);
                                       
                            //Tampilkan pemberitahuan berhasil mereset password
                            $data['message']    ='Anda Telah Berhasil Me-<i>reset</i> Password';
                            $data['error']      ='';
                            $data['info']       ='<a href="index.html">Silahkan masuk menggunakan password yang baru</a>';
                            
                            $where  = array('page' => 'info');
                            $field  = array('settings');
                            $table  = 'page_settings';
            
                            $content            = $this->ModelCRUDD->get($table, $field, $where);
                            $data['content']    = unserialize($content[0]['settings']);
                            
                            $this->load->view('template', $data);
                    }else{redirect('index','refesh');}
                }    
            }else{                                   
                        //Tampilkan pemberitahuan berhasil mendaftar
                        $data['message']    ='Ada Kesalahan Ketika Me-<i>reset</i> Password Anda';
                        $data['error']      ='';
                        $data['info']       ='<a href="index.html">Silahkan mengulangi untuk meminta <i>rset</i> password</a>';
                        
                        $where  = array('page' => 'info');
                        $field  = array('settings');
                        $table  = 'page_settings';
        
                        $content            = $this->ModelCRUDD->get($table, $field, $where);
                        $data['content']    = unserialize($content[0]['settings']);
                        
                        $this->load->view('template', $data);
            }
        }else{redirect('index','refesh');}
    }
}   