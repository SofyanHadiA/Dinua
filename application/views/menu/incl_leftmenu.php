<div id="left-menu">
    <hr class="space" />
    <div id="photo-profile-wrapper" align="center">

<script language="javascript">
$(document).ready(function(){

    $('.button-left-menu').hover(
        function() { $(this).addClass('ui-state-hover'); },
        function() { $(this).removeClass('ui-state-hover'); }
     );
     $(".btn-wall").button({
        icons: {primary: "ui-icon-home"}
     })
     $(".btn-message").button({
        icons: {primary: "ui-icon-mail-closed"}
     })
     $(".btn-profile").button({
        icons: {primary: "ui-icon-person"}
     })
      $(".btn-photo").button({
        icons: {primary: "ui-icon-image"}
     })
      $(".btn-ebook").button({
        icons: {primary: "ui-icon-document"}
     })
      $(".btn-enote").button({
        icons: {primary: "ui-icon-pencil"}
     })
});
</script>        
        <img id="photo-profile" src="<?php if($profile['avatar']!=null) {echo (base_url().$profile['avatar'].'/avatar.jpg');} else{echo (base_url().'images/photos/default.jpg');} ?>"/>

    </div>
    
    <hr class="space"/>
    <hr />
<div align="center">
    <div id="left-menu-button">
        <div class="title ui-corner-all margin-bottom-10px padd_5px bold cl_blue">Menu</div>
        
        <?php
            if(!$owner){
        ?>                
                <a href="<?php echo(base_url('').'?fid='.$id_wall_owner_encrypted);?>"><button class="btn-wall" >Dinding</button></a>
                <a onclick="messageDialogOpen()"><button class="btn-message" >Kirim Pesan</button></a>
                <a href="<?php echo(base_url('photo').'?fid='.$id_wall_owner_encrypted);?>"><button class="btn-photo" >Foto</button></a>
                <a href="<?php echo(base_url('ebook').'?fid='.$id_wall_owner_encrypted);?>"><button class="btn-ebook" >e-Book</button></a>
                <a href="<?php echo(base_url('note').'?fid='.$id_wall_owner_encrypted);?>"><button class="btn-enote" >e-Note</button></a>
                
                
<script type="text/javascript">
function messageDialogOpen(event){
    $( "#message-dialog" ).dialog('open');
}
                
$(document).ready(function(event){
    $( "#message-dialog" ).dialog({
            title: 'Kirim pesan ke <?php echo $profile['realname']; ?>',
			autoOpen: false,
            resizable: false,
            modal: true,
			height:160,
            width:400
     });
     
     $('#send-message').click(function(){
        uid = wall_owner_id;
        message = $("#message-dialog-input").val();
   		if (message != '') {
            var data = {'to' : uid, 'message' : message }
            $.ajax({
                type: "POST", 
                url : baseUrl+"chat/send",
                cache: false,
                dataType : "json",
                data : { data: JSON.stringify(data) },
                success: function(data) {
                   $('#send-message').text("Pesan Terkirim");
                   $( "#message-dialog" ).dialog('close');
			     }
		  })
        };                    
    });
});
</script>
                
                <div id="message-dialog">
                    <textarea id="message-dialog-input" style="max-width: 95%; max-height: 50px;"> </textarea>
                    <button id="send-message">Kirim Pesan</button>
                </div>
                
        <?php
            } else{
        ?>
                <a href="<?php echo(base_url(''));?>"><button class="btn-wall" >Dinding</button></a>
                <a href="<?php echo(base_url('profile')); ?>"><button class="btn-profile" >Profil</button></a>
                <a href="<?php echo(base_url('message')); ?>"><button class="btn-message" >Pesan</button></a>
                
                <a href="<?php echo(base_url('photo')); ?>"><button class="btn-photo" >Foto</button></a>
                <a href="<?php echo(base_url('ebook')); ?>"><button class="btn-ebook" >e-Book</button></a>
                <a href="<?php echo(base_url('note')); ?>"><button class="btn-enote" >e-Note</button></a>
        <?php } ?>
    </div>
    
    <hr class="space" />  
            
    <div>
        <div class="title ui-corner-all margin-bottom-10px padd_5px bold cl_blue">Teman</div>
    <?php
        $i=0;
        if(!empty($friendsList)){
            foreach ($friendsList as $row){ 
                echo('<div title="'.$row['realname'].'">');
                echo('<a href="'.base_url().'wall/friend?fid='.$row['id_encrypted'].'"><div style="float:left;margin:1px"><img src="'.base_url().$row['avatar'].'/avatar-30px.jpg" width="30px" height="30px" style="border:1px solid #ddd"/></div></a>');
                echo('</div>');
            }
        } else{echo ('<div class="cl_blue bold">Belum Memiliki Teman</div>');}
    ?>
    </div> 
</div>
</div>
<style type="text/css">
<!--
    #left-menu .title{
        font-size: 16px;background-color: #fff; width: 70%; text-align: center;
    }
	#left-menu-button button{
	   width: 90%;
       height: 25px;
       text-align: left;
       margin: 5px;
	}
-->
</style>