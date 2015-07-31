<script type="text/javascript">
var pageType = 'note';
function writeContentList(divId, tid, name, desc, commentCount, thumb, created){
    data='<a onclick="showCaseNote(\''+tid+'\')" id="'+divId+'">'+
         '<div class="note-thumb-box ui-corner-all">'+
            '<div class="note-title"><label>Judul : </label><span>'+name+'</span><br/></div>'+
            '<div class="note-intro"><label>Preview : </label><br/><span>'+desc+'...</span></div><br/>'+
            '<div class="note-info">'+created+' | ada '+commentCount+' komentar</div>'+
         '</div></a>'; 
    return data;   
}
</script>  

<style type="text/css">
<!--
#note-show-area{
    background: #222222;
}
.note-thumb-box{
    color: #eee;
    margin: 10px;
    padding: 10px;
    background: #272727;
    width: 40%;
    height: 120px;
    float: left;
}	

#note-title{
    width: 250px;
    background: #fff;
    padding: 10px;
    font-weight: bold;
    font-size: 1.2em;
}

#note-content{
    width: 450px;
    height: 500px;
    background: #fff;
    padding: 10px;
    overflow: auto;
}
-->
</style>


<!--- Show Case Note ---!>

<style type="text/css">
.arrw_prev{ margin-top: 0px; padding-top:0px; height: 35px; width:30px;float: left; color: white; background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_prev.png'); }
.arrw_prev:hover{ background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_prev_hover.png');}
.arrw_next{  margin-top: 0px; padding-top:0px; height: 35px; width:30px;float: right; color: white; background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_next.png'); }
.arrw_next:hover{ background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_next_hover.png');}

div#note_area{
    background: #222222;
}
div#note_wraper{
    float:left; /* important */
   	position:relative; /* important(so we can absolutely position the description div */
}
div#note_overlay{
    position:absolute; /* absolute position (so we can position it where we want)*/
   	top:0px; /* position will be on  top */
    padding: 10px;
   	width:96%;
   	/* styling bellow */
    background: #222222;
   	font-size:8px;
   	color:white;
   	opacity:0.8; /* transparency */
   	filter:alpha(opacity=80); /* IE transparency */
    display: none; /* hide it */
}

#comment-count{
    float: right;
}

/* overide the css */
.comment-area{
    margin-left: 0px !important;
    width: 95%;
}
</style>
        
<script language="javascript">
var prev;
var next;
var current;
var type;

function showCaseNote(id){
$("#note-show-area").dialog("open");
$.ajax({
    type  : 'POST',
    url   :  baseUrl+'note/get',
    dataType : 'json',
    data  : {'id':id, 'aid':albumId, 'uid':wall_owner_id},
    success: function(data) {
        if (data.empty!=true){
            
            prev = data.prev;
            next = data.next;
            current = data.tid;
            type = data.type;
            commentCount = data.commentCount;
            commentData = data.comment;
            
            $("#note_created").html("Diunggah : "+data.created);           
            
            if(commentCount>0){ 
                commentBox='';
                $.each(commentData, function(index, value) {
                    commentBox=commentBox+writeCommentBox(value.divId, value.tid, value.username, value.avatar, value.message, value.created);
                })
            }else{
                commentBox='';
            }
            $('#comment-count').html("Ada "+commentCount+' komentar');
            $("#comment-area").html(commentBox);
            
            $('#note-title').html('<span class="cl_orange">'+data.name+'</span>');
            $('#note-content').html(data.note);
            
            $("#report-note").html('<a onclick="reportClick(\'note\', \''+current+'\',\''+type+'\')" style="color: gray;">Laporkan tulisan ini</a>');
        }
    }
});      
}

$(document).ready(function(event) {
    
    $("#note-show-area").dialog({
        autoOpen: false,
        width       : '950',
        position    : ['center',50],
        resizable   : false,
        draggable   : false,
		modal: true,
        open: function(event, ui) { 
            jQuery('.ui-dialog-titlebar-close').hide();
            jQuery('.ui-dialog-titlebar').hide(); 
        }
    });
    
    $("#arrow-prev").click(function(event){
        showCaseNote(prev);
    });
    $("#arrow-next").click(function(event){
        showCaseNote(next);
    });
                
    $("#note_wraper").hover(function(event){
        $("#note_overlay").show();
    }, function(event){
        $("#note_overlay").hide();
    })
                
                $(".btn_delete").button({
                    icons: {
                        primary: "ui-icon-trash"
                    }
                });
                
                $(".btn_image").button({
                    icons: {
                        primary: "ui-icon-image"
                    }
                });
                
                $(".btn_delete").click(function(event){
                   	$.ajax({
                    type  : 'POST',
            		url   : baseUrl+'note/delete',
            		data  : {id:current},
            		success: function(data) {
            		  alert(data);
                            location.reload();}
                    });
                });
                
    $(".add_des").click(function(event){
                    $(this).hide();
                    $("#frm_note_des_area").show("slow");
                    $("#note_des").hide();
                });
                
                $('#frm_note_des').submit(function(event) {
                    desc=$('#text_note_des').val();
                    
	                   event.preventDefault();
                        $("#frm_note_des_area").hide("slow");
                        $(".add_des").show();
                       $.ajax({
            			type: 'POST',
            			url: $(this).attr('action'),
            			data: {'tid' : current, 'description': desc},
            			success: function(data) {
                            $("#note_des").html(data);
                            $("#note_des").show('slow');
            			}
                         
            		})
            		return false;
            	});
                
                $('#frm_note_comment').submit(function(event) {
                    comment=$('#input_note_comment').val();
                        data ={'tid' : current, 'message': comment, 'type' : type};
	                    event.preventDefault();
                        $.ajax({
            			type: 'POST',
                        dataType:'json',
            			url: $(this).attr('action'),
            			data: {data : JSON.stringify(data) },
            			success: function(data) {
            			     divId = data.divId;
                             tid = data.tid;
                             username = data.username;
                             avatar = avatar;
                             message = data.message;
                             created = data.created;
                             
            			    commentBox = writeCommentBox(divId, tid, username, avatar, message, created)
                            $("#comment-area").append(commentBox);
                            $("#input_note_comment").val('');
            			}
            		})
            		return false;
            	});
                $('#input_note_comment').keypress(function(e){
                      if(e.which == 13){
                       $('#frm_note_comment').submit();
                       e.preventDefault();
                       }
                }); 
                
                $('#btn-set-pp').click(function(event){
                    $.ajax({
            			type: 'POST',
                        dataType:'json',
            			url: baseUrl+'profile/setavatar',
            			data: {'tid' : current},
            			success: function(data) {
                            alert(data);
                            location.reload();
                            
            			}
                    });
                });
            });
        </script>
        
<div id="note-show-area">
    <a class="arrow arrw_prev" id="arrow-prev"></a>
    
        <div id="note_wraper" style="margin-right: auto; margin-left: auto;  max-width: 600px;"> 
            
            <div id="note-title" class="ui-corner-all"></div>
            <hr class="space" />
            <div id="note-content" class="ui-corner-all wrapword"></div>

            <div id="note_overlay">
                  <?php if($owner==true){ ?>  
                <div align="right">
                    <button class="btn_delete">Hapus</button>
                </div>
                      <?php } ?>  
                <div align="left">
                    <div id="note_des" class="wrapword cl_blue bold"></div>  
                        <div id="note_created" class="cl_gray">Diunggah : 00-00-0000</div>
                </div>
            </div>
        </div>
                
    <a style="float: right;" class="arrow arrw_next" id="arrow-next"></a>   
    <div style="float: right;">
        <div style="width:300px; max-height: 500px; overflow: auto;;  padding: 20px 20px 20px 20px; margin-left: 20px; background-color: #fff;" class="ui-corner-all" align="left">

        <hr class="space"/>
        <div style="background: #edeff4;">
        
        <div id="comment-count"></div>
        <hr />
        <div id="comment-area"></div>
        <?php if($canPostStatus==true){ ?>
        <div id="frm_note_comment_area" style="padding:5px; min-height: 30px;">
        
            <div class="user-avatar-30px photo-profile-small-30px"></div>
            <div style="margin-left:45px; margin-top: -5px;">
            <form id="frm_note_comment" method="post" action="<?php echo base_url()?>comment/add ">
                <textarea id="input_note_comment" class="ui-corner-all" name="message" style="width: 215px; height: 20px; max-height: 50px; max-width: 215px;"></textarea>
            </form>
            </div>
        </div>
        <?php }?>
        
        </div>
        </div>
        <hr class="space" />
        <div style="color: gray; float: left; margin-left: 20px;">Tekan "Esc" untuk menutup</div><br />
        <div id="report-note" style="color: gray;margin-left: 20px;"></div>
        </div>
</div>

<?php
	if($owner==true){
?>
<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo base_url(); ?>/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
var pageType = 'note';
tinyMCE.init({
    mode : "exact",
    elements : "note-input",
    theme : "advanced",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    relative_urls : false,
    remove_script_host : true,
    document_base_url : "/",
    convert_urls : true
});
</script>
<!-- /TinyMCE -->
<div id="note_area" style="display: none;background: #f6f6f6; ">
</div>
<div id="wrapper-frm-upload" style="display: none; z-index:5000;">
<form action="<?php echo base_url();?>note/save.html" target="media-upload" method="post" accept-charset="utf-8" id="frm_upload" enctype="multipart/form-data">
<b>Judul Tulisan Kamu : </b><input type="text" name="title" size="40" maxlength="100"/>
<hr class="space"/>
<b style="float: left;">Isi Tulisan Kamu</b> <input id="btn_upload" type="submit" value="Simpan" style="float: right;" />
<textarea id="note-input" name="note" style="width:100%; height: 400px;"></textarea>
<input type="hidden" name="aid" value="<?php echo $this->encrypt->encode($albums['id']) ?>"/>
<br />
<div id="upload_loading" style="display: none;"><p id="upload_message" style="display: none; float: left;" >mohon jangan tutup dialog ini sebelum selsesai ! </p>
<img id="image_loading" src="<?php echo base_url();?>css/images/loading.gif" alt="Mengambil data..." /></div>
</form>
</div>
<iframe name="media-upload" id="media-upload" style="display:none;"></iframe><?php
	//iframe ini untuk menampung pesan, sehingga pesan tidak tertampil di jendela baru
 } // endif owner
?>