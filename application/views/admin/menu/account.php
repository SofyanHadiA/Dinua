<script type="text/javascript">
$(function(){
    $('#tabs').tabs();
});
</script>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Akun</a></li>
        <li><a href="#tabs-2">Belum Diaktifkan</a></li>
        <li><a href="#tabs-3">Dinonaktifkan</a></li>
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
    
if(!empty($new_account)){    
    $CI->table->set_heading('No.', 'Nama Lengkap', 'email', 'Tanggal Lahir', 'Umur', 'Bergabung Pada', 'Aksi');
    $i=0;
    foreach($new_account as $rows){
        $i++;
        $age = now()-$rows['birthday'];
        $age =(floor($age/31556926));
        $birthday = $rows['birthday'];
        $birthday = unix_to_human($birthday);
        
        $created = $rows['created'];
        $created = unix_to_human($created);
          
        $action ='<a href="'.base_url('admin/super/usershutdown').'?id='.$rows['id'].'">Nonaktifkan Pengguna</a>';
        
        
        $CI->table->add_row($i, $rows['realname'], $rows['email'], $birthday, $age, $created, $action);
    }
    echo $CI->table->generate();
}
?>
</div>
<div id="tabs-2">
<?php
if(!empty($unactive)){    
    $CI->table->set_heading('No.', 'Nama Lengkap', 'email', 'Tanggal', 'Aksi');
    $i=0;
    foreach($unactive as $rows){
        $i++;
        $created = $rows['created'];
        $created = unix_to_human($created);  
        $action ='<a href="'.base_url('admin/super/useractivate').'?id='.$rows['id'].'">Aktifkan Pengguna</a>';
        
        $CI->table->add_row($i, $rows['realname'], $rows['email'],$created, $action);
    }
    echo $CI->table->generate();
}
?>
</div>

<div id="tabs-3">
<?php
if(!empty($banned)){    
    $CI->table->set_heading('No.', 'Nama Lengkap', 'email', 'Tanggal', 'Aksi');
    $i=0;
    foreach($banned as $rows){
        $i++;
        $created = $rows['created'];
        $created = unix_to_human($created);  
        $action ='<a href="'.base_url('admin/super/useractivate').'?id='.$rows['id'].'">Aktifkan Pengguna</a>';
        
        $CI->table->add_row($i, $rows['realname'], $rows['email'],$created, $action);
    }
    echo $CI->table->generate();
}
?>
</div>
</div>