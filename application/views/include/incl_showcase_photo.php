<script type="text/javascript">
var pageType = 'photo';
function writeContentList(divId, tid, name, desc, commentCount, thumb, created){
    data='<a id="'+divId+'" onclick="showCasePhoto(\''+tid+'\')">'+
            '<div class="photo-thumb ui-corner-all shadow tooltip-box" title="'+created+'" style="background: grey url('+thumb+') no-repeat center center ;">'+
         '</div></a>';
    return data;   
}
</script>    

<!--- Show Case Photo ---!>

<style type="text/css">
.arrw_prev{ margin-top: 0px; padding-top:0px; height: 35px; width:30px;float: left; color: white; background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_prev.png'); }
.arrw_prev:hover{ background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_prev_hover.png');}
.arrw_next{  margin-top: 0px; padding-top:0px; height: 35px; width:30px;float: right; color: white; background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_next.png'); }
.arrw_next:hover{ background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_next_hover.png');}

div#photo_area{
    background: #222222;
}
div#photo_wraper{
    float:left; /* important */
   	position:relative; /* important(so we can absolutely position the description div */
}
div#photo_overlay{
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

function showCasePhoto(id){
$("#photo_area").dialog("open");
$.ajax({
    type  : 'POST',
    url   :  baseUrl+'photo/get',
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
            
            $("#photo").attr('src', data.photo);
            $("#photo_created").html("Diunggah : "+data.created);
            $("#photo_des").html(data.desc);           
            $("#text_photo_des").val(data.desc);
            
            if(commentCount>0){ 
                commentBox='';
                $.each(commentData, function(index, value) {
                    commentBox=commentBox+writeCommentBox(value.divId, value.tid, value.username, value.avatar, value.message, value.created)
    
                })
            }else{
                commentBox='';
            }
            $('#comment-count').html("Ada "+commentCount+' komentar');
            $("#comment-area").html(commentBox);
            
            $("#report-foto").html('<a onclick="reportClick(\'foto\', \''+current+'\',\''+type+'\')" style="color: gray;">Laporkan foto ini</a>');
            
        }
    }
});      
}

$(document).ready(function(event) {
    
    $("#photo_area").dialog({
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
    
    $("#photo_area").dialog();
    
    $("#arrow-prev").click(function(event){
        showCasePhoto(prev);
    });
    $("#arrow-next").click(function(event){
        showCasePhoto(next);
    });
                
    $("#photo_wraper").hover(function(event){
        $("#photo_overlay").show();
    }, function(event){
        $("#photo_overlay").hide();
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
            		url   : baseUrl+'photo/delete',
            		data  : {id:current},
            		success: function(data) {
            		  alert(data);
                            location.reload();}
                    });
                });
                
    $(".add_des").click(function(event){
                    $(this).hide();
                    $("#frm_photo_des_area").show("slow");
                    $("#photo_des").hide();
                });
                
                $('#frm_photo_des').submit(function(event) {
                    desc=$('#text_photo_des').val();
                    
	                   event.preventDefault();
                        $("#frm_photo_des_area").hide("slow");
                        $(".add_des").show();
                       $.ajax({
            			type: 'POST',
            			url: $(this).attr('action'),
            			data: {'tid' : current, 'description': desc},
            			success: function(data) {
                            $("#photo_des").html(data);
                            $("#photo_des").show('slow');
            			}
                         
            		})
            		return false;
            	});
                
                $('#frm_photo_comment').submit(function(event) {
                    comment=$('#input_photo_comment').val();
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
                            $("#input_photo_comment").val('');
            			}
            		})
            		return false;
            	});
                $('#input_photo_comment').keypress(function(e){
                      if(e.which == 13){
                       $('#frm_photo_comment').submit();
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
        
<div id="photo_area">
    <a class="arrow arrw_prev" id="arrow-prev"></a>
    
        <div id="photo_wraper" style="margin-right: auto; margin-left: auto;"> 
            <img id="photo"  src="" /> 
            <div id="photo_overlay">
                  <?php if($owner==true){ ?>  
                <div align="right">
                    <button class="btn_delete">Hapus</button>
                    <button id="btn-set-pp" class="btn_image">jadikan foto profil</button>
                </div>
                      <?php } ?>  
                <div align="left">
                    <div id="photo_des" class="wrapword cl_blue bold"></div>  
                        <div id="photo_created" class="cl_gray">Diunggah : 00-00-0000</div>
                </div>
            </div>
        </div>
                
    <a style="float: right;" class="arrow arrw_next" id="arrow-next"></a>   
    <div style="float: right;">
        <div style="width:300px; max-height: 500px; overflow: auto;;  padding: 20px 20px 20px 20px; margin-left: 20px; background-color: #fff;" class="ui-corner-all" align="left">
            <div id="photo_des_area">
      <?php if($owner==true){ ?>  
            <a class="add_des">Ubah keterangan</a>
        <div id="frm_photo_des_area" style="display: none;">
            <form id="frm_photo_des" method="post" action="<?php echo base_url() ?>photo/setdescription">
                <textarea id="text_photo_des" name="description" style="max-width: 280px; max-height: 50px;" ></textarea>
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
        <div id="frm_photo_comment_area" style="padding:5px; min-height: 30px;">
        
            <div class="user-avatar-30px photo-profile-small-30px"></div>
            <div style="margin-left:45px; margin-top: -5px;">
            <form id="frm_photo_comment" method="post" action="<?php echo base_url()?>comment/add ">
                <textarea id="input_photo_comment" class="ui-corner-all" name="message" style="width: 215px; height: 20px; max-height: 50px; max-width: 215px;"></textarea>
            </form>
            </div>
        </div>
        <?php } 
            // prepare for report
        ?>
        
        </div>
        </div>
        <hr class="space" />
        <div style="color: gray; float: left; margin-left: 20px;">Tekan "Esc" untuk menutup</div> <br />
        <div id="report-foto" style="color: gray;margin-left: 20px;"></div>
        </div>
</div> 