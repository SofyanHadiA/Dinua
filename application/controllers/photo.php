<?php 
/*Kelas Controller utama yang mengatur kelas controller lainnya 
serta mengatur konten yang tertampil pada view*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class photo extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('modelcrudfiles');
    }
    public function get(){
        $uid = $this->session->userdata('id');
            if(empty($uid)){exit;}    
            $wall_id   = $this->input->post('uid');
            $wall_id   = $this->encrypt->decode($wall_id);
            $photo_id   = $this->input->post('id');
            $photo_id   = $this->encrypt->decode($photo_id);
            $aid = $this->input->post('aid');
            $aid = $this->encrypt->decode($aid);
            $this->load->library('LibDate'); //load libarary LibDate
            $table  = 'photos';
            $field  = '';
            $where  = ('aid = '.$aid.' and uid ='.$wall_id);
            $photos = $this->ModelCRUDD->get($table,$field,$where);
            if(!empty($photos)){
            //mengatur urutan photo yang tertampil
            $i=0;
            $count  = count($photos);
            foreach ($photos as $key){
                if($key['id']==$photo_id){
                    if(($i)==0){
                        $prev=$photos[$count-1];
                    } else{$prev=$photos[($i-1)];}
                    $photo=$photos[($i)];
                    if(($i)==$count-1){
                        $next=$photos[0];
                    } else{ $next=$photos[($i+1)];}
                }
                $i++;
            }
            $tid_encrypted= $photo['id'];
            $tid_encrypted = $this->encrypt->encode($tid_encrypted);
            $tid_encrypted = urlencode($tid_encrypted);
            $prev = $prev['id'];
            $prev = $this->encrypt->encode($prev);
            $prev = urlencode($prev);
            $next = $next['id'];
            $next = $this->encrypt->encode($next);
            $next = urlencode($next);
            $type = $this->encrypt->encode('I');
            $type = urlencode($type);
            // mengambil komentar foto
            $this->load->library('LibComment');
            $comment = $this->libcomment->getComment($photo['id'], 'I');
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
            $created = $photo['created'];
            $created = standard_date('DATE_IND', $created);
            $created = en2in_date($created);
            $md5_uid = md5($wall_id);
            $data= array(
                'prev' => $prev,
                'tid' => $tid_encrypted,
                'photo'=> base_url().'uploads/photos/'.$md5_uid.'/'.$photo['url'],
                'desc' => $photo['des'],
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
    public function setDescription(){ // membuat deskripsi dari photo
        $des= $this->input->post('description');
        if(!empty($des)){
        $des    = substr($des, 0, 200);
        $id     = $this->session->userdata('id');
        if(empty($id)){exit;}
        $this->load->library('libfilter');
        $filtered = $this->libfilter->checkWord($des);
            if($filtered==true){
                $table = 'reports';
                $data= array(
                    'uid' => $id,
                    'tid' => "",
                    'content' => 'I',
                    'message' => 'User ini mencoba memasukan data Foto dengan kata tersaring',
                    'created' =>now()
                );
                $this->ModelCRUDD->add($table, $data);
                $data= array('success' => 'false', 'message'=>'Kamu mencoba memasukan kata tersaring');
                echo(json_encode($data)); exit;
            }
            $des = $this->libfilter->word2($des);
        $tid    = $this->input->post('tid');
        $tid    = $this->encrypt->decode($tid);
        $data   = array('des'=>$des);
        $table  = 'photos';
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
        $id=$this->session->userdata('id');
        if(empty($id)){exit;}    
        $aid=$this->input->post('aid');
        $aid=$this->encrypt->decode($aid);
        $md5_id=md5($id);
        $name=random_string('unique').'.jpg'; 
        $dir='./uploads/photos/'.$md5_id;
		$config['upload_path']    = $dir;
                $config['allowed_types']  = 'gif|jpg|png';
                $config['file_name']      = $name;
		$config['max_size']	  = '5000';
		$config['max_width']      = '5000';
		$config['max_height']     = '5000';
        $uploaded=$this->modelcrudfiles->add($config,$dir);
		if ($uploaded)
		{
            $message ="Aku mengunggah foto baru <div width=\"50\" height=\"50\"><img src=\"".base_url()."uploads/photos/$md5_id/thumb_$name\" /></div>";
            
            $data=array(    'uid' =>$id,
                            'tid' =>$id,
                            'message' => $message,
                            'created' => now());                
            $table='status';
            $this->ModelCRUDD->add($table, $data);
                
            $data=array('aid'=>$aid, 
                        'uid'=>$id, 
                        'url'=>$name,
                        'created'=>now()
                        );
            $this->ModelCRUDD->add('photos', $data); //masukan data ke table foto
            exec("convert \"uploads/photos/$md5_id/$name\" -resize 500x500 -quality  50% \"uploads/photos/$md5_id/$name\" ");
            exec("convert \"uploads/photos/$md5_id/$name\" -resize 200x200 -quality  95% \"uploads/photos/$md5_id/thumb_$name\" ");
?><script type="text/javascript">parent.doneUpload('Berhasil Melakukan Upload'); parent.uploadResult(true);</script><?php
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
        $table = 'photos';
        $where = array ('id'=>$tid, 'uid'=>$uid);
        if ($this->ModelCRUDD->delete($table,$where)){
            echo('Foto berhasil terhapus');
        } else{echo('Foto gagal terhapus');}
    }
}