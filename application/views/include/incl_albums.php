<div id="album-title" class="bold cl_blue font_16px">Album <?php echo $type_ind.' oleh '.$profile['realname'];?></div>
<?php
	if($owner==true){
?>
    <div style="float: right; padding-top:10px;" class="font_10px"  align="center">
        <button id="add">Buat Album Baru</button>
    </div>
<?php
	}
?>
    <hr class="space" />
    <hr />
    <div id="album-area">
<?php
if(!empty($albums)){
    foreach($albums as $rows){ 
        if($rows['thumb']==null){
            $default_image ='bg-album-'.$type.'.png';
            $rows['thumb']=base_url().'css/images/media/'.$default_image;
        }
        if($rows['des']==null){
            $rows['des']='Tidak ada deskripsi';
        }
        if($owner==false){
            $url  = base_url().$type.'/show/'.$rows['id'].'?fid='.$id_wall_owner_encrypted;
        }else{
            $url  = base_url().$type.'/show/'.$rows['id'];
        }
        echo('  <div class="album-box ui-corner-all" title="<div><span>'.$rows['des'].'</span></div>'.$rows['created'].' ">
                <a href="'.$url.'">
                    <div class="album-content ui-corner-all" style="background : url(\''.$rows['thumb'].'\') center center no-repeat"></div>
                   <div class="album-name wordwrap ui-corner-bottom">'.$rows['name'].'</div></a>
                </div>');
    }
}else{ echo '<div class="loading-scroll ui-corner-all">Sangat disayangkan!<br/>Tidak album untuk '.$type.'</div>';}
?>
    </div>
    
<div id="add-album-dialog">
    <label>Nama Album : </label>
    <input id="album-name-input" class="ui-corner-all" name="album-name"/><br />
    <label>Deskripsi : </label>
    <textarea id="album-desc-input" class="ui-corner-all" name="album-desc"></textarea>
    <input id="album-type" type="hidden" name="type" value="<?php echo $type_encrypted ?>" />
</div>