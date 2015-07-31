<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AdminPage extends CI_Controller {
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $admin = $this->session->userdata('type');
        if ($admin!='admin'){ $this->loginPage();}
        else{ $this->report();}   
    }
    public function loginPage(){
        $admin = $this->session->userdata('type');
        if(!$admin){
            $this->load->view('admin/login.php');  
        } 
        //jika sudah login langsung ke jendela dinding
        else {$this->mainPage();}
    }
    public function forbidenWord(){
        $table = 'forbiden_words';
        $category1= $this->ModelCRUDD->get($table,'', array('category'=>1));
        if(!empty($category1)){$category1=$category1[0]['words'];}
        $category2= $this->ModelCRUDD->get($table,'', array('category'=>2));
        if(!empty($category2)){$category2=$category2[0]['words'];}
        $category3= $this->ModelCRUDD->get($table,'', array('category'=>3));
        if(!empty($category3)){$category3=$category3[0]['words'];}
        $data['category1']=$category1;
        $data['category2']=$category2;
        $data['category3']=$category3;
        $data['page']='menu/forbiden_word.php';
        $this->load->view('admin/admin_page.php',$data);
    }
    public function saveFilter(){
        $words1 = $this->input->post('words1');
        $words2 = $this->input->post('words2');
        
        $data = array('words'=>$words1);
        $where = array('category'=>'1');
        $table = 'forbiden_words';
        $this->ModelCRUDD->edit($table,$data, $where);
        
        $data = array('words'=>$words2);
        $where = array('category'=>'2');
        $table = 'forbiden_words';
        $this->ModelCRUDD->edit($table,$data, $where);
        
        redirect('admin/adminpage/forbidenword');
    }
    public function report(){
        $table = 'reports';
        $reports= $this->ModelCRUDD->get($table);
        if(!empty($reports)){
            $i=0;
            foreach ($reports as $rows){
                // data pelapor
                $this->load->library('LibProfile');
                $user=$this->libprofile->getProfile($rows['uid']);
                $reports[$i]['user']=$user;
                switch ($rows['content']){ 
                	case 'S' : $table = 'status'; $field = 'message';break;
                	case 'E' : $table = 'ebooks';break;
                	case 'N' : $table = 'notes'; $field = 'note';break;
                    case 'I' : $table = 'photos';  $field = 'url'; break;
                }
                // data terlapor
                $where = array('id' => $rows['tid']);
                $target= $this->ModelCRUDD->get($table,'', $where);
                if(!empty($target)){
                    
                    $target=$target[0];
                    $user=$this->libprofile->getProfile($target['uid']);
                    if(!empty($user)){
                        $target['user']=$user;
                        $reports[$i]['target'] = $target;
                        $reports[$i]['target']['table'] = $table;
                        // perbaiki url konten
                        $md5_id=md5($target['uid']);
                        switch ($rows['content']){ 
                	       case 'S' : $reports[$i]['target']['content'] =$target[$field]; break;
                	       case 'E' : $table = 'ebooks';break;
                	       case 'N' : $reports[$i]['target']['content'] =$target[$field]; break;
                           case 'I' : $reports[$i]['target']['content'] ='<img src="'.base_url().'uploads/photos/'.$md5_id.'/thumb_'.$target[$field].'"/>'; break;
                        }
                    } else{unset($reports[$i]);}
                } else {
                    $reports[$i]['target']['content'] ="";
                    $reports[$i]['target']['id']="";
                    $reports[$i]['target']['user']=$reports[$i]['user'];
                    
                    $reports[$i]['target']['table'] = $table;
                }
                $i++;   
            }
        }
        $data['reports'] = $reports;
        $data['page']='menu/report.php';
        $this->load->view('admin/admin_page.php',$data);
    }
    function content(){
        // mengatur offset
        $type = $this->uri->segment(4);
        $status_offset =0;
        $photo_offset =0;
        $ebook_offset =0;
        $note_offset =0;
        switch ($type){ 
        	case 'status': $status_offset = $this->uri->segment(5);break;
            case 'photo': $photo_offset = $this->uri->segment(5);break;
            case 'ebook': $ebook_offset = $this->uri->segment(5);break;
            case 'note': $note_offset = $this->uri->segment(5);break;
        }
        $this->load->library('pagination');
        $indeks_table= array('status','photos', 'ebooks','notes');
        $offset = array($status_offset, $photo_offset, $ebook_offset, $note_offset);
        for($j=0;$j<4;$j++){
            $table = $indeks_table[$j];
            $content= $this->ModelCRUDD->get($table);
            $config['base_url'] = base_url('admin/adminpage/content/'.$indeks_table[$j].'/');
            $config['total_rows'] = count($content);
            // jika status 100 perhalman, lainnya 10
            $config['per_page'] = 10;
            //else {$config['per_page'] = 10;}
            $this->pagination->initialize($config); 
            $data[$indeks_table[$j].'_pagination'] = $this->pagination->create_links();
            
            $content= $this->ModelCRUDD->get($table,'','',10, 'created, desc', $offset[$j]);
            $i=0;
            foreach ($content as $rows){
                    // data pemilik kontent
                    $this->load->library('LibProfile');
                    $user=$this->libprofile->getProfile($rows['uid']);
                    if(!empty($user)){
                        // hitung umur pengguna 18 tahun 31556926*8=568024668 
                        $interval = now()-$user['birthday_epoch'];
                        if ($interval>568024668){
                            $user['realname'] ='<b style="color:red;">'.$user['realname'].'</b>';
                        }
                        $content[$i]['user']=$user;
                    } else{unset($content[$i]);}
                $i++;
            }
            //simpan dalam data
            $data[$indeks_table[$j]]=$content;
        }
        $data['page']='menu/content.php';
        $this->load->view('admin/admin_page.php',$data);
    }
    function account(){
        $table = 'accounts';
        $where = array('disabled'=>null);
        $new_accounts=$this->ModelCRUDD->get($table,'',$where,100, 'created, desc');
            $i=0;
            foreach ($new_accounts as $rows){
                    // data pemilik kontent
                    $this->load->library('LibProfile');
                    $user=$this->libprofile->getProfile($rows['id']);
                        // hitung umur pengguna 18 tahun 31556926*8=568024668 
                        $interval = now()-$user['birthday_epoch'];
                        if ($interval>568024668){
                            $new_accounts[$i]['realname'] ='<b style="color:red;">'.$user['realname'].'</b>';
                        }
                $i++;
            }
        
     
        $where = array('disabled'=>2);
        $unactive=$this->ModelCRUDD->get($table,'',$where,'', 'created, desc');

        $where = array('disabled'=>9);
        $banned=$this->ModelCRUDD->get($table,'',$where,'', 'created, desc');
        $data['new_account'] = $new_accounts;
        $data['unactive'] = $unactive;
        $data['banned'] = $banned;
        $data['page']='menu/account.php';
        $this->load->view('admin/admin_page.php',$data);
    }
    function password(){
        $data['page']='menu/password.php';
        $this->load->view('admin/admin_page.php',$data);
    }
}