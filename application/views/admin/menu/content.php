<script type="text/javascript">
$(function(){
    $('#tabs').tabs();
});
</script>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Status</a></li>
        <li><a href="#tabs-2">Foto</a></li>
        <li><a href="#tabs-3">e-Books</a></li>
        <li><a href="#tabs-4">e-Note</a></li>
    </ul>

    <div id="tabs-1">
<?php
$CI =& get_instance();
    $CI->load->library('table');
    $tmpl = array (
                        'table_open'          => '<table id="table-report" border="1" cellpadding="4" cellspacing="0" style="max-width=95%">',
                        
                        'row_start'           => '<tr>',
                        'row_end'             => '</tr>',
                        'cell_start'          => '<td>',
                        'cell_end'            => '</td>',
    
                        'table_close'         => '</table>'
                  );
    
    $CI->table->set_template($tmpl);
    
if(!empty($status)){  
    echo $status_pagination;
    $CI->table->set_heading('No.', 'Oleh', 'Isi', 'Tanggal', 'Aksi');
    $i=0;
    foreach($status as $rows){
        $i++;
        $created = $rows['created'];
        $created = unix_to_human($created);  
        $action ='<a href="'.base_url('admin/super/delete').'?id='.$rows['id'].'&table=status">Hapus Konten</a> <hr/>'.
                 '<a href="'.base_url('admin/super/usershutdown').'?id='.$rows['uid'].'">Nonaktifkan Pengguna</a>';;
        
        $user = '<a href="'.base_url().'wall/friend?fid='.$rows['user']['id_encrypt'].'">'.$rows['user']['realname'].'</a>';
        
        $CI->table->add_row($i, $user, $rows['message'],$created, $action);
    }
    echo $CI->table->generate();
}
?>
    </div>
    <div id="tabs-2">
    <?php
	if(!empty($photos)){
    echo $photos_pagination;
    $CI->table->set_heading('No.', 'Oleh', 'Isi', 'Tanggal', 'Aksi');
    $i=0;
    foreach($photos as $rows){
        $i++;
        $created = $rows['created'];
        $created = unix_to_human($created);  
        $action ='<a href="'.base_url('admin/super/delete').'?id='.$rows['id'].'&table=photos">Hapus Konten</a> <hr/>'.
                 '<a href="'.base_url('admin/super/usershutdown').'?id='.$rows['uid'].'">Nonaktifkan Pengguna</a>';;
        
        $md5_uid=md5($rows['uid']);
        
        $user = '<a href="'.base_url().'wall/friend?fid='.$rows['user']['id_encrypt'].'">'.$rows['user']['realname'].'</a>';
        $CI->table->add_row($i, $user, '<img src="'.base_url().'uploads/photos/'.$md5_uid.'/thumb_'.$rows['url'].'"/>',$created, $action);
    }
    echo $CI->table->generate();
}
?>
    </div>
    <div id="tabs-3">
<?php
	if(!empty($ebooks)){
	   echo $ebooks_pagination;
    $CI->table->set_heading('No.', 'Oleh', 'Isi', 'Tanggal', 'Aksi');
    $i=0;
    foreach($ebooks as $rows){
        $i++;
        $created = $rows['created'];
        $created = unix_to_human($created);  
        $action ='<a href="'.base_url('admin/super/delete').'?id='.$rows['id'].'&table=ebooks">Hapus Konten</a> <hr/>'.
                 '<a href="'.base_url('admin/super/usershutdown').'?id='.$rows['uid'].'">Nonaktifkan Pengguna</a>';;
        
        $md5_uid=md5($rows['uid']);
        $user = '<a href="'.base_url().'wall/friend?fid='.$rows['user']['id_encrypt'].'">'.$rows['user']['realname'].'</a>';
        $content = 'Judul : <b>'.$rows['name'].'</b> <br/><img src="'.base_url().'temp/ebooks/'.$md5_uid.'/thumb_'.$rows['url'].'.jpg"/>';
        $CI->table->add_row($i, $user, $content,$created, $action);
    }
    echo $CI->table->generate();
}
?>
    </div>
    <div id="tabs-4">
<?php
	if(!empty($notes)){
    echo $notes_pagination;
    $CI->table->set_heading('No.', 'Oleh', 'Isi', 'Tanggal', 'Aksi');
    $i=0;
    foreach($notes as $rows){
        $i++;
        $created = $rows['created'];
        $created = unix_to_human($created);  
        $action ='<a href="'.base_url('admin/super/delete').'?id='.$rows['id'].'&table=notes">Hapus Konten</a> <hr/>'.
                 '<a href="'.base_url('admin/super/usershutdown').'?id='.$rows['uid'].'">Nonaktifkan Pengguna</a>';;
        
        $md5_uid=md5($rows['uid']);
        $user = '<a href="'.base_url().'wall/friend?fid='.$rows['user']['id_encrypt'].'">'.$rows['user']['realname'].'</a>';
        
        $content = 'Judul : <b>'.$rows['name'].'</b> <br/><div style="max-height:75px; overflow:auto;">'.strip_tags($rows['note']).'</div>';
        $CI->table->add_row($i, $user,  $content, $created, $action);
    }
    echo $CI->table->generate();
}
?>
    </div>
</div>