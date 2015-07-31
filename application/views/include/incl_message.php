<div id="message-area">

</div>

<script type="text/javascript">
getMessage();
function getMessage(){
	    $.ajax({
        type: "POST", 
        url : baseUrl+"message/get/",
        cache: false,
        dataType : "json",
        success: function(data){
            messageData='';
            $.each(data, function(index, value) {
                divId = value.divId;
                tid = value.tid;
                username = value.username;
                message  = value.messageData;
                avatar   = value.avatar;
                messageData = messageData + writeMessage(divId, tid, username, avatar, message);
            })
            
            $("#message-area").html(messageData);
            $(".message-reply ").scrollTop($(".message-reply ")[0].scrollHeight);
        }
    })
}

function writeMessage(divId, tid, username, avatar, message){
        
    data='<div class="message-box" id="message-box-'+divId+'">'+
            '<hr class="space"/>'+
            '<hr />'+
            '<div class="photo-profile-small-40px float-left" style="background-image: url(\''+avatar+'\');"></div>'+
            '<div class="message-content">'+
                '<div class="message-username"><a href="'+baseUrl+'?fid='+uid+'">'+username+'</a>'+
                '<a class="message-delete" onclick="deletemessageClick(\''+divId+'\', \''+tid+'\')">hapus pesan</a>'+
                '</div>'+   
                '<div id="message-'+divId+'"  class="message-reply wrapword cl_blue"  style="max-height: 300px; overflow: auto; margin:30px 10px 0 35px">';
    $.each(message, function(index, value) {    
        data=data+'<div style="height:35px;"><div class="photo-profile-small-30px float-left" style="background: url('+value.avatar+')"></div><div>'+value.message+'</div></div><hr/>';
    })
    data=data+'</div>Balas Pesan<textarea class="message-reply-input ui-corner-all" onkeydown="checkMessageInputKey(event,this,\''+tid+'\', \''+divId+'\')"></textarea></div></div></div></div></div></div>';
    return data;

 }
 
 function checkMessageInputKey(event, textarea, uid, divId) {
	if(event.keyCode == 13 && event.shiftKey == 0) {
		message = $(textarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$(textarea).val('');
		$(textarea).focus();
		$(textarea).css('height','30px');
		if (message != '') {
            var data = {'to' : uid, 'message' : message }
    		$.ajax({
                type: "POST", 
                url : baseUrl+"chat/send",
                cache: false,
                dataType : "json",
                data : { data: JSON.stringify(data) },
                success: function(data){
                    $("#message-"+divId).append('<div style="height:35px;"><div class="photo-profile-small-30px float-left" style="background: url('+data.avatar+')"></div><div>'+data.message+'</div></div><hr/>');
                    $(".message-reply ").scrollTop($(".message-reply ")[0].scrollHeight);
                }
            })
        }
    }
}
</script>

<style type="text/css">
<!--

.message-box{
    width:100%
}
.message-reply-input{
    width: 95%;
    height: 30px;
    max-height: 60px;
    max-width: 95%;
}
.message-content{
}

.message-delete{
    float: right;
}
-->
</style>