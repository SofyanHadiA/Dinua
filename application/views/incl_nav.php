<table style="float: left;"></table>
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$table_ctrl=1; //unntuk mengatur spliting
//buat dengan format tabel
echo('<table cellpadding="0" cellspaceing="0" border="0" style="float: left;"><tr>'); 

$con_page_split=$navigation['num_ctgr'] / 3; //mengatur jumlah split
for($i=1;$i<=$navigation['num_ctgr'];$i++){
    
    //untuk ngecek apakah ini <td> yang pertama atau tidak
    //Harus, karena ada spliter gambar disana 
    if($i==1){  echo('<td class="td" valign="top">' );
    }   else {  echo('<td class="td_sep" valign="top">');}
    
    $category=$navigation['category_'.$i];
    
    //Karena masih ada array di dalamnya
    $parent_section=$navigation['section_'.$i];  
    
    echo('<h3>'.$category['ctgr_name'].'</h3> <ul>');
    
        for($j=1;$j<=$parent_section['num_sect'];$j++){
            $section=$parent_section['sect_'.$j];
            echo '<li><a href="'.base_url().'general/requirements.html">'.$section.'</a></li>';
        }
         echo('</ul>');
         
    //pengecekan, kalo IYA split tabel di buat
    if($table_ctrl>=$con_page_split){
        echo('</td>');
        $table_ctrl=0;
    }
   ($table_ctrl++);//penambahan
}

echo('</tr></table>');  //penutup tabel

?>