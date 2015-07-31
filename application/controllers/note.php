<?php 
/*Kelas Controller utama yang mengatur kelas controller lainnya 
serta mengatur konten yang tertampil pada view*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Note extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
    }
    public function get(){
        $uid = $this->session->userdata('id');
        if(empty($uid)){exit;}
        
        $wall_id   = $this->input->post('uid');
        $wall_id   = $this->encrypt->decode($wall_id);
        
        $note_id   = $this->input->post('id');
        $note_id   = $this->encrypt->decode($note_id);
        
        $aid = $this->input->post('aid');
        $aid = $this->encrypt->decode($aid);
        
        $this->load->library('LibDate'); //load libarary LibDate
        
        $table  = 'notes';
        $field  = '';
        $where  = ('aid = '.$aid.' and uid ='.$wall_id);
        $notes = $this->ModelCRUDD->get($table,$field,$where);
               
        if(!empty($notes)){
            //mengatur urutan note yang tertampil
            $i=0;
            $count  = count($notes);
            foreach ($notes as $key){
                if($key['id']==$note_id){
                    if(($i)==0){
                        $prev=$notes[$count-1];
                    } else{$prev=$notes[($i-1)];}
                    
                    $note=$notes[($i)];
                    
                    if(($i)==$count-1){
                        $next=$notes[0];
                    } else{ $next=$notes[($i+1)];}
                }
                $i++;
            }
            
            $tid_encrypted= $note['id'];
            $tid_encrypted = $this->encrypt->encode($tid_encrypted);
            $tid_encrypted = urlencode($tid_encrypted);
            
            $prev = $prev['id'];
            $prev = $this->encrypt->encode($prev);
            $prev = urlencode($prev);
            
            $next = $next['id'];
            $next = $this->encrypt->encode($next);
            $next = urlencode($next);
            
            $type = $this->encrypt->encode('N');
            $type = urlencode($type);
            
            // mengambil komentar foto
            $this->load->library('LibComment');
            $comment = $this->libcomment->getComment($note['id'], 'N');
            
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
            
            $created = $note['created'];
            $created = standard_date('DATE_IND', $created);
            $created = en2in_date($created);
            
            $md5_uid = md5($wall_id);
            
            $data= array(
                'prev' => $prev,
                'tid' => $tid_encrypted,
                'name' => $note['name'],
                'note'=> $note['note'],
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
    
    public function add(){
        $this->load->helper('string');
        $id=$this->session->userdata('id');
        
        if(empty($id)){exit;}
        
        $aid=$this->input->post('aid');
        $aid=$this->encrypt->decode($aid);
        
        $note=$this->input->post('note');
        $name=$this->input->post('title');
        
        $this->load->library('LibFilter');
        
        $note = $this->libfilter->word2($note);
        $name = $this->libfilter->word2($name);
            
        $filtered1 = $this->libfilter->checkWord($note);
        $filtered2 = $this->libfilter->checkWord($name);
            if($filtered1==true || $filtered2==true){
                $table = 'reports';
                $data= array(
                    'uid' => $uid,
                    'tid' => "",
                    'content' => 'N',
                    'message' => 'User ini mencoba memasukan Tulisan dengan kata tersaring',
                    'created' =>now()
                );
                $this->ModelCRUDD->add($table, $data);
                                
?>
<script>parent.doneUpload('Tulisan anda terdapat kata-kata tersaring (sensor)');</script>
<?php exit();}
        
        $table  = 'notes';
        $data   = array(    'aid'=>$aid,
                            'uid'=>$id,
                            'name'=>$name,
                            'note'=>$note,
                            'created' => now()
                        );
        $saved=$this->ModelCRUDD->add($table, $data);
        
		if ($saved){
        $message ="Aku membuat tulisan baru dengan judul : <b>".$name."</b> ayo lihat</div>";
            
            $data=array(    'uid' =>$id,
                            'tid' =>$id,
                            'message' => $message,
                            'created' => now());                
            $table='status';
            $this->ModelCRUDD->add($table, $data);
		
            ?>
<script>parent.doneUpload('Berhasil Melakukan Upload');parent.uploadResult(true);</script>
	<?php
		}
		else
		{?>
<script>parent.doneUpload('Gagal Melakukan Upload');</script>
<?php
		}
    }
    
    public function delete(){
        $id = $this->input->post('id');
        $id = $this->encrypt->decode($id);
        
        $uid=$this->session->userdata('id');
        
        if((empty($id)) and (empty($uid))){exit;}
        $table = 'notes';
        $where = array ('id'=>$id, 'uid'=>$uid);
        if ($this->ModelCRUDD->delete($table,$where)){
            echo('Tulisan berhasil terhapus'); exit;
        }
        echo('Tulisan gagal terhapus');
    }
}