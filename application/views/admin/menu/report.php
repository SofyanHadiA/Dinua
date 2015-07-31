<div align="center">
    <h2>Laporan</h2>
<?php
if(!empty($reports)){
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
    
    $CI->table->set_heading('No.', 'Pelapor', 'Konten', 'Oleh' ,'Pesan', 'Tanggal', 'Aksi');
    $i=0;
    foreach($reports as $rows){
        $i++;
        $created = $rows['created'];
        $created = unix_to_human($created);

        $reporter = '<a href="'.base_url().'wall/friend?fid='.$rows['user']['id_encrypt'].'" >'.$rows['user']['realname'].'</a>';
        $reported = '<a href="'.base_url().'wall/friend?fid='.$rows['target']['user']['id_encrypt'].'" >'.$rows['target']['user']['realname'].'</a>';
        
        $action ='<a href="'.base_url('admin/report/delete').'?id='.$rows['id'].'">Hapus Laporan</a> <hr/>'.
                 '<a href="'.base_url('admin/super/delete').'?id='.$rows['target']['id'].'&table='.$rows['target']['table'].'">Hapus Konten</a> <hr/>'.
                 '<a href="'.base_url('admin/super/usershutdown').'?id='.$rows['target']['user']['id'].'">Nonaktifkan Pengguna</a>';;
        
        $CI->table->add_row($i,$reporter, $rows['target']['content'], $reported, $rows['message'],$created, $action);
    }
    echo $CI->table->generate();
}else{
    echo('<h3>Tidak Ada Laporan</h3>');
}
?>
</div>