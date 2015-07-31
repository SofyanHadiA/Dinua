<?php 
/*Kelas Controller utama yang mengatur konten yang tertampil pada view*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class userpage extends CI_Controller {
    
var $globData = array();
var $tid, $uid, $id, $id_encrypted;
var $wallOwner;

    public function __construct(){
        parent::__construct();
        $this->load->model('ModelPageSettings');
        
        $this->load->library('LibProfile');
        $this->load->library('LibAlbum');
        $this->load->library('LibFriends');
        
        global $globData, $tid, $uid, $id, $wallOwner, $id_encrypted;
        $globData['isloged']=$this->ModelSession->getStatusLogin();
        
        if($globData['isloged']){
        $tid = $this->input->get('fid');
        $uid = $this->session->userdata('id');
                                                       
        if(empty($tid)){ // mengecek siapakah yang punya wall
            $id=$uid;
            $wallOwner=true;
        }
        else{ // mengecek jika id teman terdeklarasi maka yang punya wall adalah teman  
            $wallOwner=false;
            $tid = $this->encrypt->decode($tid);
            if(!$tid){
                redirect(base_url());
            }
            $id=$tid;
            
            //jika dinding yang dituju adalah dinding sendiri
            if($id == $uid){
                redirect(base_url());
            }
        }
        
        $id_encrypted = $this->encrypt->encode($id);
        $id_encrypted = urlencode($id_encrypted);
        
        
        // Membedakan beberapa jenis id
        $globData['id_wall_owner']=$id;
        $globData['uid']=$uid;
        $globData['id_wall_owner_encrypted']=$id_encrypted;
        
        // Siapa yang memiliki wall
        $globData['owner']=$wallOwner;

        // Data akun yang sedang login
        $globData['user_profile']=$this->libprofile->getProfile($uid);
        
        // Data pemilik Wall
        $globData['profile']=$this->libprofile->getProfile($id);
                
        // Mengambil list teman
        $globData['friendsList']=$this->libfriends->getFriendsList($id);
        $globData['sugestedList']=$this->libfriends->getSugestedFriends($uid);
        
        // Boleh menambhakan konten
        if($wallOwner==false){
            // Mengecek status pertemanan
            $globData['friendStatus']=$this->libfriends->getFriendStatus($uid,$id);}
        else{  $globData['friendStatus']='self';}
            
            //Untuk mengatur boleh tidak bikin status
            if($globData['friendStatus']=='Y' || $globData['friendStatus']=='self'){
                $globData['canPostStatus']=true;}
            else{
                $globData['canPostStatus']=false;}
        }else{$this->loginPage();}
    }
    
    // method pertama yang dijalankan
    // gunanya untuk mengecek keadaan login pengguna di cookies
	public function index(){
        global $globData;
        //jika penggguna belum login
        if ($globData['isloged']==false){
            //buka halman login
                $this->loginPage();
            }
        if ($globData['isloged']==true){
            //buka halaman dinding
                $this->wallPage();    
            }   
        //jika pengguna telah login
        //else{getMyWallPage();}
    }
    
    //mengambil halaman login
    function loginPage(){
        global $globData;
        if(!$globData['isloged']){
            
            $table='page_settings';
            $field='';
            $where=array('page'=>'login');
            
            $content=$this->ModelCRUDD->get($table, $field, $where);
            
            //untuk mengembalikan array agar bisa dibaca oleh PHP [ unserialize ]
            $data['content']=unserialize($content[0]['settings']);

            $this->load->view('template.php',$data);  
        } 
        //jika sudah login langsung ke jendela dinding
        else {$this->wallPage();}
    }
    
    public function worldPage(){
        global $globData, $tid, $uid, $id, $wallOwner;
        
         if ($globData['isloged']){
            $data=$globData;            
            //Content untuk ngambil isi halaman Dinding
            $data['content']=$this->ModelPageSettings->worldPage();
            
            $this->load->view('template.php',$data);
         }
    }
    
    //mengambil halaman dinding
    public function wallPage(){
        global $globData, $tid, $uid, $id, $wallOwner;
        
        if ($globData['isloged']){
            $data=$globData;           
                        
            //Content untuk ngambil isi halaman Dinding
            $data['content']=$this->ModelPageSettings->mywallPage();
            
            //Ngambil list grup kategori untuk jadi navigasi dari database
            $this->load->library('LibGroup'); // Library untuk data group
            $data['categories']=$this->libgroup->getAllCategories();
            
            //Ngambil list grup seksi untuk jadi navigasi dari database
            $data['sections']=$this->libgroup->getAllSections();
            
            $this->load->view('template.php',$data);
            }
    
     else {redirect(base_url());}
    }

    
    public function profilePage(){
        global $globData, $tid, $uid, $id, $wallOwner;
        
        //jika sudah masuk baru bisa mengakses halaman ini
         if ($globData['isloged']){
            $data=$globData;
            $id=$this->session->userdata('id');    
            //Content untuk ngambil isi halaman profile
            $data['content']=$this->ModelPageSettings->profilePage();    
            
            //Ngambil list grup kategori untuk jadi navigasi dari database
            $this->load->library('LibGroup'); // Library untuk data group
            $data['categories']=$this->libgroup->getAllCategories();
            
            //Ngambil list grup seksi untuk jadi navigasi dari database
            $data['sections']=$this->libgroup->getAllSections();
            
            $data['friendsList']=$globData['friendsList'];
                        
            $data['sugestedList']=$this->libfriends->getSugestedFriends($id);
            
            //Mengambil data Accounts
            $profile = $this->libprofile->getProfile($id);
            // atur informasi yang tertampil
            switch ($profile['gender']){ 
            	case 'M' : $profile['gender']='Laki-Laki'; break;
                case 'F' : $profile['gender']='Perempuan'; break;
            	default :$profile['gender']='Laki-Laki';
            }
            $profile ['password'] ="**********";
            $data['profile']= $profile;
            
            $this->load->view('template.php',$data);
        }    
        else {redirect(base_url());}
    }
    
    /*--------------------------------------CONTENT---------------------------------*/
    
    public function contentPage(){
        global $globData, $tid, $uid, $id, $wallOwner;
        //jika sudah masuk baru bisa mengakses halaman ini
         if ($globData['isloged']){
            // ambil jenis halaman
            $type = $this->uri->segment(1);
            $type = strtolower($type);
            
            if(($type=='photo')||($type=='ebook')||($type=='note')){
                $data=$globData;
                $data['type'] = $type;
                
                $type_encrypted = $this->encrypt->encode($type);
                $type_encrypted = urlencode($type_encrypted);
                $data['type_encrypted'] =$type_encrypted;
                
                $aid=$this->uri->segment(3);
                $data['aid'] = $aid;
                //Untuk ngambil album
                $where      =array('id'=>$aid,'uid'=>$id, 'disabled'=>null);
                $field      ='';
                $table      =$type.'_albums';
                $limit      = 1;
                $albums     =$this->ModelCRUDD->get($table, $field, $where, $limit);
                // Kalo kosong kembali ke halaman album
                if(empty($albums)){redirect($type);}
                else{
                    $albums = $albums[0];
                    // ubah tanggalnya dulu
                    $created = standard_date('DATE_IND', $albums['created']);
                    $created = en2in_date($created);
                    $aid_encrypted = $this->encrypt->encode($aid);
                    $aid_encrypted = urlencode($aid_encrypted);
                    
                    $albums['created']=$created;
                    $albums['aid_encrypted']=$aid_encrypted;
                
                    $data['albums']=$albums;
                    $contents = $this->libalbum->getContent($type,$aid, $id);
                                        
                    $data['contents']=$contents;
                }
                $data['image_dir']=md5($id);
                
                switch ($type){ 
                	case 'photo': $data['content']=$this->ModelPageSettings->photoPage();break;
                	case 'ebook': $data['content']=$this->ModelPageSettings->ebookPage();break;
                	case 'note': $data['content']=$this->ModelPageSettings->notePage();break;
                }
                
                
                $this->load->view('template.php',$data);
            }
        }     
        else {redirect(base_url());}
    }
    /*--------------------------------------CONTENT---------------------------------*/   
    
    /*--------------------------------------ALBUM-----------------------------------*/
    public function albumPage(){
        global $globData, $tid, $uid, $id, $wallOwner;
        
        //jika sudah masuk baru bisa mengakses halaman ini
        if ($globData['isloged']){    
            $type = $this->uri->segment(1);
            $type = strtolower($type);
            
            if(($type=='photo')||($type=='ebook')||($type=='note')){
                $data = $globData;
                $data['type'] = $type;
                
                // ubah tipe ke bahasa Indonesia
                switch ($type){ 
                	case 'photo' : $type_ind = 'Foto';break;
                    case 'ebook' : $type_ind = 'e-Book';break;
                    case 'note' : $type_ind = 'e-Note';break;
                }
                $data['type_ind'] = $type_ind;
                
                $type_encrypted = $this->encrypt->encode($type);
                $type_encrypted = urlencode($type_encrypted);
                $data['type_encrypted'] =$type_encrypted;
                
                //Untuk ngambil album
                $this->load->library('LibAlbum');
                $albums         =$this->libalbum->getAlbum($type.'_albums',$id, $type);
                $data['albums'] =$albums;
                
                $data['content']=$this->ModelPageSettings->albumPage();
                
                $this->load->view('template.php',$data);
            }
        }    
        else {redirect(base_url());}
    }
    /*--------------------------------------ALBUM-----------------------------------*/
    
     public function messagePage(){
        global $globData, $tid, $uid, $id, $wallOwner;
        
        //jika sudah masuk baru bisa mengakses halaman ini
        if ($globData['isloged']){   
            
                $data = $globData;
                
                $data['content']=$this->ModelPageSettings->messagePage();
                
                $this->load->view('template.php',$data);
        }    
        else {redirect(base_url());}
    }
}