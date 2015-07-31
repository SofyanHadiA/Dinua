<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Album extends CI_Controller {
    function addAlbum(){
        $uid = $this->session->userdata('id');
        $name = $this->input->post('name');  
        $desc = $this->input->post('desc'); 
        $type = $this->input->post('type');
        $type = $this->encrypt->decode($type);
        if((!empty($type)) || (!empty($name))){  
            if(!empty($desc)){
                $desc =  substr($desc,0,200);
            }
            $this->load->library('LibFilter');
            $filtered1 = $this->libfilter->checkWord($name);
            $filtered2 = $this->libfilter->checkWord($desc);
            if($filtered1==true || $filtered2==true){
                $table = 'reports';
                $data= array(
                    'uid' => $uid,
                    'tid' => "",
                    'content' => '',
                    'message' => 'User ini mencoba memasukan data Album dengan kata tersaring',
                    'created' =>now()
                );
                $this->ModelCRUDD->add($table, $data);
                $data= array('success' => 'false', 'message'=>'Kamu mencoba memasukan kata tersaring');
                echo(json_encode($data)); exit;
            }
            $name = $this->libfilter->word2($name);
            $desc = $this->libfilter->word2($desc);
            
                $table = $type.'_albums';
                $data = array(
                    'uid' => $uid,
                    'name' => substr($name,0,30),
                    'des' =>$desc,
                    'created' => now()
                );
            if($this->ModelCRUDD->add($table, $data)){
                $data = array('success'=>'true'); echo(json_encode($data)); exit;
            }
        }
        $data = array('success'=>'false');
        echo(json_encode($data));
    }
    function editAlbum(){
        $aid  = $this->input->post('id');  
        $aid  = $this->encrypt->decode($aid);
        $name = $this->input->post('name');  
        $desc = $this->input->post('desc'); 
        $type = $this->input->post('type');
        $type = $this->encrypt->decode($type);
        if((!empty($type)) || (!empty($name)) || (!empty($aid))){  
            if(!empty($desc)){
                $desc = substr($desc,0,200);
                $desc = str_replace("\n", ' ', $desc);
                // words filtering :)
                $this->load->library('LibFilter');
                $filtered = $this->libfilter->checkWord($desc);
                if($filtered==true){
                    $data= array('success' => 'false', 'message'=>'Kamu mencoba memasukan kata tersaring');
                    echo(json_encode($data)); exit;
                }
            }
                $uid = $this->session->userdata('id');
                $table = $type.'_albums';
                $where = array('uid' =>$uid, 'id'=>$aid);
                $edit  = array( 'name' => substr($name,0,30),                    
                                'des' =>$desc );
            if($this->ModelCRUDD->edit($table, $edit, $where)){
                $data = array('success'=>'true'); echo(json_encode($data)); exit;
            }
        }
        $data = array('success'=>'false');
        echo(json_encode($data));
    }
    function deleteAlbum(){
        $aid  = $this->input->post('id');  
        $aid  = $this->encrypt->decode($aid);
        $type = $this->input->post('type');
        $type = $this->encrypt->decode($type);
        if((!empty($type)) and (!empty($aid))){  
            $uid = $this->session->userdata('id');
            $table = $type.'_albums';
            $where = array('uid' =>$uid, 'id'=>$aid);
            $this->load->library('libalbum');
            $check = $this->libalbum->getContent($type, $aid, $uid);
            if($check==null){
                if($this->ModelCRUDD->delete($table, $where)){
                    $data = array('success'=>'true'); echo(json_encode($data)); exit;
                }
            }
        }
        $data = array('success'=>'false');
        echo(json_encode($data));
    }
    function getContentList(){
        $uid = $this->session->userdata('id');  
        $fid = $this->input->post('uid');
        $fid = $this->encrypt->decode($fid);
        if(!empty($fid)){
            $id = $fid;
        } else {$id = $uid;}
        $offset = $this->input->post('offset');
        $type = $this->uri->segment(1);
        $aid = $this->input->post('id');
        $aid = $this->encrypt->decode($aid);
        $data['empty']='true';
        if((!empty($type)) and (!empty($aid)) and (!empty($id))){
            if(empty($offset)){
                $offset = null;
            }
            switch ($type){ 
           	    case 'photo': $limit=20; $commentType = 'I'; break;
               	case 'ebook': $limit=6; $commentType = 'E'; break;
               	case 'note': $limit=6; $commentType = 'N'; break;
            }
            // eksekusi query paginasi ke ModelCRUDD
            $where      =array('aid'=>$aid, 'uid'=>$id, 'disabled'=>null);
            $field      ='';
            $table      = $type.'s';
            $order      ='created, desc';
            $temp       =$this->ModelCRUDD->get($table, $field, $where, $limit, $order, $offset);           
        if(!empty($temp)){ 
            $i=0;
            $data = null;
            foreach($temp as $row){  
                $this->load->library('LibComment');
                $comment = $this->libcomment->getComment($row['id'], $commentType);              
                $commentCount = count($comment);
                $random_number = random_string('numeric', 9);
                $created  =standard_date('DATE_IND', $row['created']);
                $created  = en2in_date($created);
                $tid = $row['id'];
                $tid = $this->encrypt->encode($tid);
                $tid = urlencode($tid);
                switch ($type){ 
               	    case 'photo': 
                       $thumb = base_url().'uploads/photos/'.md5($id).'/thumb_'.$row['url']; 
                       $title ='';
                       $desc  = $row['des'];
                       $thumb = $thumb;
                       break;
                   	case 'ebook': 
                        $thumb = base_url().'temp/ebooks/'.md5($id).'/thumb_'.$row['url'].'.jpg';
                        $title = $row['name'];
                        $desc  = $row['des'];
                        $thumb = $thumb;
                        break;
                   	case 'note': 
                       $title = $row['name']; 
                       $desc  = substr($row['note'],0,100);
                       $desc  = strip_tags($desc);
                       $thumb = '';
                       break;
                }
                $data['data'][]=array(
                                'tid' => $tid,
                                'title' => $title,
                                'desc' => $desc,
                                'thumb' => $thumb,
                                'created' => $created,
                                'divId' => $random_number,
                                'commentCount' => $commentCount,
                                );
            }
            switch ($type){ 
               	    case 'photo': $offset=$offset+20;break;
                   	case 'ebook': $offset=$offset+6;break;
                   	case 'note' : ;break;
                }
            $data['offset']=$offset;
        }
        }
        echo(json_encode($data));
    }
}