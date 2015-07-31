<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ebook extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('ModelCRUDFiles');
    }
    public function get(){
        $uid = $this->session->userdata('id');
        if(empty($uid)){exit;}
        $wall_id   = $this->input->post('uid');
        $wall_id   = $this->encrypt->decode($wall_id);
        $md5_uid = md5($wall_id);
        $ebook_id   = $this->input->post('id');
        $ebook_id   = $this->encrypt->decode($ebook_id);
        $page = $this->input->post('page');
        if(!$page){$page=0;} 
        $aid = $this->input->post('aid');
        $aid = $this->encrypt->decode($aid);
        $this->load->library('LibDate'); //load libarary LibDate
        $table  = 'ebooks';
        $field  = '';
        $where  = ('aid = '.$aid.' and id= '.$ebook_id.' and uid ='.$wall_id);
        $ebooks = $this->ModelCRUDD->get($table,$field,$where);
        $ebook  = $ebooks[0];       
        if(!empty($ebook)){
            $dirPDF       = 'uploads/ebooks/'.$md5_uid.'/'.$ebook['url'];
            $tempDirPDF   = 'temp/ebooks/'.$md5_uid.'/'.$ebook['url'];
                 //path to directory to scan
                    $directory  = $tempDirPDF.'/';
                    $ext        = '*.jpg';
                    $this->load->library('LibCommon');
                    $files=$this->libcommon->getFileList($directory, $ext);
             //mengatur urutan ebook yang tertampil
            $count  = count($files)-1;
            //mengatur urutan ebook yang tertampil
           foreach ($files as $key){
                    if($page==0){
                        $prev=$count;
                    } else{$prev=$page-1;}
                    if($page==$count){
                        $next=0;
                    } else{ $next=$page+1;}
            }
            $tid_encrypted= $ebook['id'];
            $tid_encrypted = $this->encrypt->encode($tid_encrypted);
            $tid_encrypted = urlencode($tid_encrypted);
            $type = $this->encrypt->encode('E');
            $type = urlencode($type);
            // mengambil komentar foto
            $this->load->library('LibComment');
            $comment = $this->libcomment->getComment($ebook['id'], 'E');
            // set default
            $commentData=array();
            if(!empty($comment)){
                foreach($comment as $rows){
                    $tid = $rows['id'];
                    $tid = $this->encrypt->encode($tid);
                    $tid = urlencode($tid);
                    $created = standard_date('DATE_IND', $rows['created']);
                    $created = en2in_date($created);
                    $divId = random_string('numeric',9);
                    $commentData[]=array(
                        'divId' => $divId,
                        'tid' => $tid,
                        'username' => $rows['user']['realname'],
                        'avatar'=> base_url().$rows['user']['avatar'].'avatar-30px.jpg',
                        'message'=> $rows['message'],
                        'created' => $created
                    );
                }
            }
            $created = $ebook['created'];
            $created = standard_date('DATE_IND', $created);
            $created = en2in_date($created);
            $data= array(
                'prev' => $prev,
                'tid' => $tid_encrypted,
                'ebook'=> base_url().'temp/ebooks/'.$md5_uid.'/'.$ebook['url'].'/ebook-'.$page.'.jpg',
                'desc' => $ebook['des'],
                'created' => $created,
                'commentCount' => count($commentData),
                'comment' => $commentData,
                'type'=>$type,
                'next' => $next
            );
            echo json_encode($data); exit;
        }
        echo json_encode(array('empty'=>true));
    }
    public function setDescription(){ // membuat deskripsi dari ebook
        $des= $this->input->post('description');
        if(!empty($des)){
            $id     = $this->session->userdata('id');
            if(empty($id)){exit;}
            $tid    = $this->input->post('tid');
            $tid    = $this->encrypt->decode($tid); 
            $des    = substr($des, 0, 200);
            
            $this->load->library('libFilter');
            $filtered = $this->libfilter->checkWord($des);
            if($filtered==true){
                $table = 'reports';
                $data= array(
                    'uid' => $id,
                    'tid' => "",
                    'content' => 'E',
                    'message' => 'User ini mencoba memasukan data Buku Elektronik dengan kata tersaring',
                    'created' =>now()
                );
                $this->ModelCRUDD->add($table, $data);
                
                $data= array('success' => 'false', 'message'=>'Kamu mencoba memasukan kata tersaring');
                echo(json_encode($data)); exit;
            }
            $des = $this->libfilter->word2($des);
                   
            $data   = array( 'des'=>$des);
            $table  = 'ebooks';
            $where  = array('id'=>$tid, 'uid'=>$id);        
            if ($this->ModelCRUDD->edit($table,$data,$where)){
                echo $des;
        }
        else {
            echo "Komentar Gagal Tersimpan, Refresh Perambah Anda";    
            }
        }        
    }
    public function add(){
        $this->load->helper('string');
        $id =$this->session->userdata('id');
        if(empty($id)){exit;}
        $aid=$this->input->post('aid');
        $aid=$this->encrypt->decode($aid);
        $md5_id=md5($id);
        $name=random_string('unique').'.pdf'; 
        $dir ='./uploads/ebooks/'.$md5_id;
    	$config['upload_path']  = $dir;
        $config['allowed_types']= 'pdf';
        $config['file_name']    = $name;
    	$config['max_size']     = '5000';
        $uploaded=$this->ModelCRUDFiles->add($config,$dir);
        if($uploaded){
            // membuat thumbs ebook
            $dirPDF     = 'uploads/ebooks/'.$md5_id.'/'.$name;
            $thumbPdf   = 'temp/ebooks/'.$md5_id.'/thumb_'.$name.'.jpg';
            $tempDirPDF = 'temp/ebooks/'.$md5_id;
            if (!file_exists($tempDirPDF)){
                mkdir($tempDirPDF ,0755);
                $file = 'uploads/index.html';
                $newfile = $tempDirPDF.'/index.html';
                if (!copy($file, $newfile)) {exit;}
            }
            $tempDirPDF = 'temp/ebooks/'.$md5_id.'/'.$name;
            if (!file_exists($tempDirPDF)){
                mkdir($tempDirPDF ,0755);
                $file = 'uploads/index.html';
                $newfile = $tempDirPDF.'/index.html';
                if (!copy($file, $newfile)) {exit;}
            }
            $tempPDF   = 'temp/ebooks/'.$md5_id.'/'.$name.'/ebook.jpg';
            if(exec("convert \"{$dirPDF}\"  \"$tempPDF\"")){
                echo 'berhasil buat preview';
            }
            exec("convert \"{$dirPDF}[0]\" -colorspace RGB \"$thumbPdf\"");
            exec("convert \"$thumbPdf\" -resize 200x200 -quality  75% \"$thumbPdf\" ");
           $data=array('aid'=>$aid, 
                        'uid'=>$id, 
                        'url'=>$name,
                        'created'=>now()
                        );
            $this->ModelCRUDD->add('ebooks',$data); //masukan data ke table ebooks
?><script>parent.doneUpload('Berhasil Melakukan Upload'); parent.uploadResult(true);</script><?php
		}
		else
		{
         ?>
	<script>
		parent.doneUpload('Gagal Melakukan Upload');
	</script>
	<?php
		}
    }
    public function delete(){
        $uid = $this->session->userdata('id');
        if(empty($uid)){exit;}        
        $tid = $this->input->post('id');
        $tid    = $this->encrypt->decode($tid);
        $table = 'ebooks';
        $where = array ('id'=>$tid, 'uid'=>$uid);
        if ($this->ModelCRUDD->delete($table,$where)){
            echo('Buku berhasil terhapus');
        } else{echo('Buku gagal terhapus');}
    }
}