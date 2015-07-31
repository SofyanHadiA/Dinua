<?php 
/* Digunakan untuk mengontrol autentikasi masuk. 
Data pengguna yang masuk akan dikirimkan ke class Session */


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }
    
    // Method ini digunakan untuk mengeksekusi perintah Login
    public function index(){
        //ambil setatus masuk   
        $data=$this->ModelSession->getStatusLogin();
        if(!$data){
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $this->load->model('ModelLogin');
            
            if($email!=null && $password!=null){
                $data = $this->ModelLogin->login($email, $password);
                if($data!=null){
                    
                    // Jika belum diaktifkan
                    if($data['disabled']==2){
                        $data['message']    ='Akun Kamu Belum Aktif';
                        $data['error']      ='';
                        $data['info']       ='Silahkan periksa Kotak masuk (<i>Inbox</i>) email Kamu. Jika tidak ada mohon periksa di kotak Spam';
                        
                        $where  = array('page' => 'info');
                        $field  = array('settings');
                        $table  = 'page_settings';
        
                        $content            = $this->ModelCRUDD->get($table, $field, $where );
                        $data['content']    = unserialize($content[0]['settings']);
                        
                        $this->load->view('template', $data);
                    }
                    // Jika dinonaktifkan
                    if($data['disabled']==9){
                        $data['message']    ='Akun Kamu Di-Nonaktifkan';
                        $data['error']      ='';
                        $data['info']       ='Hal ini karena beberapa hal yang menyangkut pelanggaran yang kamu lakukan.<br/>'.
                                'Silahkan kirim pesan ke : <a href="mailto:admin@dinua.net">admin@dinua.net</a> untuk meminta diaktifkan kembali';
                        
                        $where  = array('page' => 'info');
                        $field  = array('settings');
                        $table  = 'page_settings';
        
                        $content            = $this->ModelCRUDD->get($table, $field, $where );
                        $data['content']    = unserialize($content[0]['settings']);
                        
                        $this->load->view('template', $data);
                    }
                    if($data['disabled']==null){
                        
                        // set seession                  
                        $this->ModelSession->set($data['id'], current_url());
                        // check umur pengguna
                        $this->load->library('libprofile');
                        $userdata=$this->libprofile->getProfile($data['id']);
                        $age=now()-$userdata['birthday_epoch'];
                        $signupdate= now()-$userdata['created'];
                        if (($age>=568024668)and($age<=568629468 ) and ($signupdate>=604800)){
                            $data['message']    ='Selamat!';
                            $data['error']      ='';
                            $data['info']       ='Sepertinya umur kamu minggu ini telah mencapai 18 tahun.<br/>'.
                                    '<h4>Namun kamu harus perhatikan bahwa kami akan memantau kamu dan tidak akan segan-segan menutup akun kamu, jika kamu mengirimkan konten<br/>
                                     yang negatif atau tidak sesuai untuk dilihat oleh pengguna 17 tahun kebawah. Klik <a href="'.base_url().'theworld">di sini</a> untuk melanjutkan<h4>';
                            
                            $where  = array('page' => 'info');
                            $field  = array('settings');
                            $table  = 'page_settings';
            
                            $content            = $this->ModelCRUDD->get($table, $field, $where );
                            $data['content']    = unserialize($content[0]['settings']);
                            
                            $this->load->view('template', $data);
                        }
                        else{
                            
                            redirect('theworld');
                        }
                    }
                } 
                else{ 

                $data['message']    ='Email Atau Password Anda Salah';
                $data['error']      ='';
                $data['info']       ='<a href="'.base_url().'index.html"> Silahkan Kembali Ke Halaman Sebelumnya</a>';
                
                $where  = array('page' => 'info');
                $field  = array('settings');
                $table  = 'page_settings';

                $content            = $this->ModelCRUDD->get($table, $field, $where );
                $data['content']    = unserialize($content[0]['settings']);
                
                $this->load->view('template', $data);
                }
            // jika email atau password kosong
            } else{
                $data['message']    ='Email Atau Password Anda Kosong';
                $data['error']      ='';
                $data['info']       ='<a href="'.base_url().'index.html"> Silahkan Kembali Ke Halaman Sebelumnya</a>';
                
                $where  = array('page' => 'info');
                $field  = array('settings');
                $table  = 'page_settings';

                $content            = $this->ModelCRUDD->get($table, $field, $where );
                $data['content']    = unserialize($content[0]['settings']);
                
                $this->load->view('template', $data);}
                
        } else{redirect('mywall','refesh');}
        
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }   
}