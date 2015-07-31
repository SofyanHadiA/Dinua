<script type="text/javascript">
var pageType = 'ebook';
function writeContentList(divId, tid, name, desc, commentCount, thumb, created){
    data='<a onclick="showCaseEbook(\''+tid+'\')" id="'+divId+'">'+
         '<div class="ebook-thumb-box ui-corner-all">'+
            '<div class="ebook-thumb" style="background : url('+thumb+') center center no-repeat">'+
                '<div class="ebook-created">'+created+'</div>'+
            '</div>'+
            '<div class="ebook-info"><span>'+name+'</span><br/><br/>'+
                '<div class="ebook-desc wrapword">'+desc+'</div><br/>'+
                'ada '+commentCount+' komentar</div>'+'<br/>'+
         '</div></a>'; 
    return data;   
}
</script>



<!--- Show Case Ebook ---!>

<style type="text/css">
.arrw_prev{ margin-top: 0px; padding-top:0px; height: 35px; width:30px;float: left; color: white; background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_prev.png'); }
.arrw_prev:hover{ background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_prev_hover.png');}
.arrw_next{  margin-top: 0px; padding-top:0px; height: 35px; width:30px;float: right; color: white; background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_next.png'); }
.arrw_next:hover{ background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_next_hover.png');}

div#ebook_area{
    background: #222222;
}
div#ebook_wraper{
    float:left; /* important */
   	position:relative; /* important(so we can absolutely position the description div */
}
div#ebook_overlay{
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

var page = 0;

function showCaseEbook(id, page){
$("#ebook_area").dialog("open");
$.ajax({
    type  : 'POST',
    url   :  baseUrl+'ebook/get',
    dataType : 'json',
    data  : {'id':id, 'aid':albumId, 'uid':wall_owner_id, 'page':page},
    success: function(data) {
        if (data.empty!=true){
            prev = data.prev;
            next = data.next;
            current = data.tid;
            type = data.type;
            commentCount = data.commentCount;
            commentData = data.comment;
            
            $("#ebook").attr('src', data.ebook);
            $("#ebook_created").html("Diunggah : "+data.created);
            $("#ebook_des").html(data.desc);           
            $("#text_ebook_des").val(data.desc);
            
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
            
        }
    }
});      
}

$(document).ready(function(event) {
    
    $("#ebook_area").dialog({
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
    
    $("#ebook_area").dialog();
    
    $("#arrow-prev").click(function(event){
        showCaseEbook(current, prev);
    });
    $("#arrow-next").click(function(event){
        showCaseEbook(current, next);
    });
                
    $("#ebook_wraper").hover(function(event){
        $("#ebook_overlay").show();
    }, function(event){
        $("#ebook_overlay").hide();
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
            		url   : baseUrl+'ebook/delete',
            		data  : {id:current},
            		success: function(data) {
            		  alert(data);
                            location.reload();}
                    });
                });
                
    $(".add_des").click(function(event){
                    $(this).hide();
                    $("#frm_ebook_des_area").show("slow");
                    $("#ebook_des").hide();
                });
                
                $('#frm_ebook_des').submit(function(event) {
                    desc=$('#text_ebook_des').val();
                    
	                   event.preventDefault();
                        $("#frm_ebook_des_area").hide("slow");
                        $(".add_des").show();
                       $.ajax({
            			type: 'POST',
            			url: $(this).attr('action'),
            			data: {'tid' : current, 'description': desc},
            			success: function(data) {
                            $("#ebook_des").html(data);
                            $("#ebook_des").show('slow');
            			}
                         
            		})
            		return false;
            	});
                
                $('#frm_ebook_comment').submit(function(event) {
                    comment=$('#input_ebook_comment').val();
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
                            $("#input_ebook_comment").val('');
            			}
            		})
            		return false;
            	});
                $('#input_ebook_comment').keypress(function(e){
                      if(e.which == 13){
                       $('#frm_ebook_comment').submit();
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
        
<div id="ebook_area">
    <a class="arrow arrw_prev" id="arrow-prev"></a>
    
        <div id="ebook_wraper" style="margin-right: auto; margin-left: auto;  max-width: 600px;"> 
            <img id="ebook"  src="" style="max-width: 500px;" /> 
            <div id="ebook_overlay">
                  <?php if($owner==true){ ?>  
                <div align="right">
                    <button class="btn_delete">Hapus</button>
                    <button id="btn-set-pp" class="btn_image">jadikan foto profil</button>
                </div>
                      <?php } ?>  
                <div align="left">
                    <div id="ebook_des" class="wrapword cl_blue bold"></div>  
                        <div id="ebook_created" class="cl_gray">Diunggah : 00-00-0000</div>
                </div>
            </div>
        </div>
                
    <a style="float: right;" class="arrow arrw_next" id="arrow-next"></a>   
    <div style="float: right;">
        <div style="width:300px; max-height: 500px; overflow: auto;;  padding: 20px 20px 20px 20px; margin-left: 20px; background-color: #fff;" class="ui-corner-all" align="left">
            <div id="ebook_des_area">
      <?php if($owner==true){ ?>  
            <a class="add_des">Ubah keterangan</a>
        <div id="frm_ebook_des_area" style="display: none;">
            <form id="frm_ebook_des" method="post" action="<?php echo base_url() ?>ebook/setdescription">
                <textarea id="text_ebook_des" name="description" style="max-width: 280px; max-height: 50px;" ></textarea>
                <input type="hidden" name="tid" value="<?php //echo ($this->encrypt->encode($ebook['id'])); ?>" />
                <div style="float: left;">Maksimum 200 karater</div>
                <div style="float: right;"><input type="submit" name="btn_submit" value="Simpan"/></div>
            </form>
        </div>
      <?php } ?>
        <hr class="space"/>
        <hr/>
        
        </div>
        <hr class="space"/>
        <div style="background: #edeff4;">
        
        <div id="comment-count"></div>
        <hr />
        <div id="comment-area"></div>
        <?php if($canPostStatus==true){ ?>
        <div id="frm_ebook_comment_area" style="padding:5px; min-height: 30px;">
        
            <div class="user-avatar-30px photo-profile-small-30px"></div>
            <div style="margin-left:45px; margin-top: -5px;">
            <form id="frm_ebook_comment" method="post" action="<?php echo base_url()?>comment/add ">
                <textarea id="input_ebook_comment" class="ui-corner-all" name="message" style="width: 215px; height: 20px; max-height: 50px; max-width: 215px;"></textarea>
            </form>
            </div>
        </div>
        <?php }?>
        
        </div>
        </div>
        <hr class="space" />
        <div style="color: gray; float: left; margin-left: 20px;">Tekan "Esc" untuk menutup</div>
        </div>
</div> 