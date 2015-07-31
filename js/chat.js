var windowFocus = true;
var uid;
var username;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 33000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();

var indeksChat = 0;
var chatBoxOpen = new Array;

$(document).ready(function(event){
	originalTitle = document.title;
       
    // AJAX    
    var chatTimer= setInterval( function(event){getChat();}, 2500);
	getChat();
    function getChat(){
        $.ajax({
            type: "POST", 
            url : baseUrl+"chat/check",
            cache: false,
            dataType : "json",
            success: function(data){
                if(data.empty!=true){
                        chatboxtitle= data.from;
                        message  = data.message;
                        avatar   = data.avatar;
                        tid = data.tid;
                        username = data.username;
                    if(chatBoxOpen[chatboxtitle]!=true){                   
                        if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none'){
                            toggleChatBoxGrowth(chatboxtitle);
                        }
                        getNotification();
                        $( "#chat-menu-root" ).button({icons: {primary: "ui-icon-alert"}});                   
                        action = 'onclick="startChat(\''+chatboxtitle+'\',\''+tid+'\');"';
                        showNotification(username,'mengirimkan pesan obrolan', action, 'icon');      
                        
                        document.title=username+' mengirimkan anda pesan';      
                        
                        $("#menu-panel-message .content").append('<div><a onclick="startChat(\''+chatboxtitle+'\',\''+tid+'\');hideMessageNotif();"> '+
                         '<div class="photo-profile-small-30px float-left" style="background-image: url(\''+avatar+'\');"></div>'+
                        '<strong>'+username+'</strong> mengirikan anda pesan obrolan</a></div>');       
                        
                    }else{$( "#chat-menu-root" ).button({icons: {primary: "ui-icon-comment"}}) }
                	    $("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><div class="photo-profile-small-30px" style="background:url(\''+avatar+'\') no-repeat center center;"></div>'+
                        '<div class="chatboxmessagecontent wrapword">'+message+'</div></div>');
                	    $("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
                }
            }
        });
	};
    
    
    
	$([window, document]).blur(function(event){
		windowFocus = false;
	}).focus(function(event){
		windowFocus = true;
		document.title = originalTitle;
	});   
});

// main function startChat
function startChat(to, uid) {
    // membuat chatBox
	createChatBox(to, uid);
	$("#chatbox_"+to+" .chatboxtextarea").focus();
}

// mengatur ulang chatBoxes
function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		chatboxtitle = chatBoxes[x];

		if ($("#chatbox_"+chatboxtitle).css('display') != 'none') {
			if (align == 0) {
                width =225;
				$("#chatbox_"+chatboxtitle).css('right', width+'px');
			} else {
				width = ((align+1)*(225))+5;
				$("#chatbox_"+chatboxtitle).css('right', width+'px');
			}
			align++;
            
            chatBoxOpen[chatboxtitle] = true;
		}
	}
}


function createChatBox(chatboxtitle, uid, minimizeChatBox) {
    
	if ($("#chatbox_"+chatboxtitle).length > 0) {
		if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
			$("#chatbox_"+chatboxtitle).css('display','block');
			restructureChatBoxes();
		}
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
        $("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
        $( "#chat-menu-root" ).button({icons: {primary: "ui-icon-comment"}});
        chatBoxOpen[chatboxtitle] = true;
		return;
	}
	$(" <div />" ).attr("id","chatbox_"+chatboxtitle)
	.addClass("chatbox")
	.html('<div class="chatboxhead"><div class="chatboxtitle">'+chatboxtitle+'</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">-</a> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\', \''+uid+'\');"></textarea></div>')
	.appendTo($( "body" ));

        // take history chat for a day
        $.ajax({
        type: "POST", 
        url : baseUrl+"chat/get/history",
        data :"to="+uid,
        cache: false,
        dataType : "json",
        success: function(data){
        $.each(data, function(index, value) {  
            
        chatboxtitle= value.from;
        message  = value.message;
        avatar   = value.avatar,
        //message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
	    $("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><div class="photo-profile-small-30px" style="background:url(\''+avatar+'\') no-repeat center center;"></div>'+
        '<div class="chatboxmessagecontent wrapword">'+message+'</div></div>');
        
        $("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
        chatBoxOpen[chatboxtitle] = true;   
        }); 
        }
        });//end
    $( "#chat-menu-root" ).button({icons: {primary: "ui-icon-comment"}});

	$("#chatbox_"+chatboxtitle).css('bottom', '0px');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if ($("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}

	if (chatBoxeslength == 0) {
	    width = 225;
		$("#chatbox_"+chatboxtitle).css('right', width+'px');
	} else {
		width = ((chatBoxeslength+1)*(225))+5;
		$("#chatbox_"+chatboxtitle).css('right', width+'px');
	}
	
	chatBoxes.push(chatboxtitle);

	if (minimizeChatBox == 1) {
		minimizedChatBoxes = new Array();

		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) {
			if (minimizedChatBoxes[j] == chatboxtitle) {
				minimize = 1;
			}
		}

		if (minimize == 1) {
			$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
			$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
		}
	}

	chatboxFocus[chatboxtitle] = false;

	$("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(event){
		chatboxFocus[chatboxtitle] = false;
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(event){
		chatboxFocus[chatboxtitle] = true;
		newMessages[chatboxtitle] = false;
		$('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	$("#chatbox_"+chatboxtitle).click(function(event) {
		if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
			$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

	$("#chatbox_"+chatboxtitle).show();
}

function closeChatBox(chatboxtitle) {
	$('#chatbox_'+chatboxtitle).css('display','none');
    chatBoxOpen[chatboxtitle] = false;
	restructureChatBoxes();
}

function toggleChatBoxGrowth(chatboxtitle){
    if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none'){ 
        
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
		$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
        $("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
        chatBoxOpen[chatboxtitle]=true;        
	
    } else {
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
        
        chatBoxOpen[chatboxtitle]=false;
	}
	
}

function checkChatBoxInputKey(event, chatboxtextarea, chatboxtitle, uid) {
	if(event.keyCode == 13 && event.shiftKey == 0) {
		message = $(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$(chatboxtextarea).val('');
		$(chatboxtextarea).focus();
		$(chatboxtextarea).css('height','44px');
		if (message != '') {
        var data = {'to' : uid, 'message' : message }
		$.ajax({
        type: "POST", 
        url : baseUrl+"chat/send",
        cache: false,
        dataType : "json",
        data : { data: JSON.stringify(data) },
        success: function(data){
                chatboxtitle= data.to;
                message  = data.message;
                avatar   = data.avatar;                
        	    $("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><div class="photo-profile-small-30px" style="background:url(\''+avatar+'\') no-repeat center center;"></div>'+
                '<div class="wrapword chatboxmessagecontent">'+message+'</div></div>');
                
        	    $("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
                }
			});
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$(chatboxtextarea).css('overflow','auto');
	}
	 
}