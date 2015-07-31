var baseUrl = '//dinua.net/';
var doc_title = 'Dinua - social network dengan cara positif'

var offset = 0;
var avatar   = '';

menuPanelShowed=false;
var statusTimer= setInterval( function(event){getNotification();}, 10000);


$(document).ready(function(event){
    
    $(".user-avatar-30px").css('background', 'url('+avatar+')');
    getNotification();
    $("button").button();
    
/* --------------------Navigation-----------------------*/
    /* ----------------Notify---------------*/
    $('#friend-notif').click(function(event){
        if(menuPanelShowed==true){
            $(".menu-panel").hide();
            menuPanelShowed=false;
        } else{menuPanelShowed=true;
        $("#notify-counter-friend").html('');
        $("#menu-panel-friend").toggle("fast");}
        
    });
    
    $('#message-notif').click(function(event){
        if(menuPanelShowed==true){
            $(".menu-panel").hide();
            menuPanelShowed=false;
        } else{menuPanelShowed=true;
        $("#notify-counter-message").html('');
        $("#menu-panel-message").toggle("fast");
        messageCount=0;}
        document.title=username+'mengirimkan anda pesan';
    });
    
    $('#general-notif').click(function(event){
        if(menuPanelShowed==true){
            $(".menu-panel").hide();
            menuPanelShowed=false;
        } else{menuPanelShowed=true;
        $("#notify-counter-general").html('');
        $("#menu-panel-general").toggle("fast");}
 
    });
    
   	// Expand Panel
   	$("#menu-open").click(function(event){
  		$("div#panel").slideDown("slow");
   	});	
    	
   	// Collapse Panel
   	$("#menu-close").click(function(event){
  		$("div#panel").slideUp("slow");	
   	});		
    	
   	// Switch buttons from "Log In | Register" to "Close Panel" on click
   	$("#toggle a").click(function () {
  		$("#toggle a").toggle();
   	});	
    /* End Navigation */
       
    //Mengambil notification
    getNotification();
    
    // Mengambil Status Yang Lebih Lama
    $('#get-older-status-world').click(function(event){
        $('#get-older-status-world div').text('Loading...');
        getWorldStatus();
    });
    
    
    $('#get-older-status').click(function(event){
        $('#get-older-status div').text('Loading...');
        getStatus();
    });
    
    

    
    // Mengirim data status yang baru saja dibuat
    $('#statusPost').submit(function(event){        
	    event.preventDefault(); 
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
            dataType : "json",
			success: function(data) {
                if(data.success=='true'){
                    reloadStatus();
                    $('#status-input').val('');
                }else{alert('Gagal menyimpan! '+data.message);}
			}
		})
	});
    
            
    $('#togle_status_text').click(function(event){
         $('#togle_status_text').hide();
        $('#wraper_status').fadeIn("slow");
    });
    
    $('#status-input').click(function(event){
        $('#status-input').val('');
    });
    
    $("#submit-status").button();
    
        $("body").append('<div id="dialog-delete"></div>');
    
    $( "#dialog-delete" ).dialog({
			autoOpen: false,
            resizable: false,
            modal: true,
			height:140
     });
    
    $('div.expandable p').expander({
        slicePoint:       200,  
        expandPrefix:     ' ', 
        expandText:       '<br/>selengkapnya...', 
        collapseTimer:    10000, 
        userCollapseText: '<br/>singkat...' 
    });
    
    // Album
    function addAlbum(){
        name = $('#album-name-input').val();
        desc = $('#album-desc-input').val();
        type = $('#album-type').val();
        $.ajax({
			type: 'POST',
			url: baseUrl+'album/add',
			data: {'name' : name, 'desc':desc , 'type':type},
            dataType : "json",
			success: function(data) {
                if(data.success=='true'){
                     location.reload();
                }else{alert('gagal menyimpan');}
			}
		})
    } 
		
    $("button#add").click(function(){
        $('#add-album-dialog').dialog('open');
    });		

    $("#add-album-dialog, #edit-album-dialog").dialog({
        autoOpen    : false,
        resizable   : false,
        modal: true,
        buttons: {
            "batal": function() { 
				$(this).dialog("close");
            },
            "simpan": function() { 
				addAlbum();
            } 
        }
    });
    
    $("#add").button({
            icons: {
                primary: "ui-icon-plusthick"
            }
    });
    $("#btn_prev").button({
            icons: {
                primary: "ui-icon-circle-triangle-w"
            }
    });
    $("#btn_next").button({
            icons: {
                primary: "ui-icon-circle-triangle-e"
            }
    });
    
    $(".album-box[title]").tooltip();
    
    $(".tooltip-box[title]").tooltip();
    
});
// End jQuery Function

/* -------------------- status -----------------------*/
    function getWorldStatus(){
        $.ajax({
            type: "POST", 
            url : baseUrl+"status/get/world/"+offset,
            cache: false,
            dataType : "json",
            data : {'id' : wall_owner_id},
            success: function(data){
                if(data.empty!='true'){
                    $.each(data.status, function(index, value) {
                        divId = value.div_id;
                        tid = value.tid;
                        type = value.type;
                        uid = value.uid;
                        username = value.username;
                        statusAvatar = value.avatar;
                        message = value.message,
                        created = value.created;
                        countComment= value.commentCount;
                        commentData = value.comment;
                        likeCount = value.likeCount;
                        isLike = value.isLike;
                        canPostComment = value.canPostComment;
                        wall = value.wall;
                        wallOwnerId = value.wallOwnerId;
                        
                        statusBox = writeStatusBox(divId,tid,type,uid,username, statusAvatar, message, created, countComment, likeCount, canPostComment, isLike, commentData, wall, wallOwnerId  );
                        $("#status-box").append(statusBox);
                        $("#status-box-"+divId).fadeOut('slow');
                        $("#status-box-"+divId).fadeIn();
                        $('#get-older-status-world div').text('Kiriman Terdahulu');
                    })
                    incOffset(data.offset);
                }else{
                    $('#get-older-status-world div').text('Kiriman Habis');
                }
            }
        });
    }

    function getStatus(){
        $.ajax({
            type: "POST", 
            url : baseUrl+"status/get/"+offset,
            cache: false,
            dataType : "json",
            data : {'id' : wall_owner_id},
            success: function(data){
                if(data.empty!='true'){
                    $.each(data.status, function(index, value) {
                        divId = value.div_id;
                        tid = value.tid;
                        type = value.type;
                        uid = value.uid;
                        username = value.username;
                        statusAvatar = value.avatar;
                        message = value.message,
                        created = value.created;
                        countComment= value.commentCount;
                        commentData = value.comment;
                        likeCount = value.likeCount;
                        isLike = value.isLike;
                        canPostComment = value.canPostComment;
                        wall = value.wall;
                        wallOwnerId = value.wallOwnerId;
                        
                        statusBox = writeStatusBox(divId,tid,type,uid,username, statusAvatar, message, created, countComment, likeCount, canPostComment, isLike, commentData, wall, wallOwnerId  );
                        $("#status-box").append(statusBox);
                        $("#status-box-"+divId).fadeOut('slow');
                        $("#status-box-"+divId).fadeIn();
                        $('#get-older-status div').text('Kiriman Terdahulu');
                    })
                    incOffset(data.offset);
                }else{
                    $('#get-older-status div').text('Kiriman Habis');
                }
            }
        });
    }
// Digunakan untuk memperbaharui status
    function reloadStatus(){
           $.ajax({
            type: "POST", 
            url : baseUrl+"status/getnew",
            cache: false,
            data : {'id' : wall_owner_id},
            dataType : "json",
            success: function(data){
                  if(data.empty!='true'){
                    $.each(data.status, function(index, value) { 
                      divId = value.div_id;
                        tid = value.tid;
                        type = value.type;
                        uid = value.uid;
                        username = value.username;
                        statusAvatar = value.avatar;
                        message = value.message,
                        created = value.created;
                        countComment= value.commentCount;
                        commentData = value.comment;
                        likeCount = value.likeCount;
                        isLike = value.isLike;
                        canPostComment = value.canPostComment;
                        wall = value.wall;
                        wallOwnerId = value.wallOwnerId;
                        
                        statusBox = writeStatusBox(divId,tid,type,uid,username, statusAvatar, message, created, countComment, likeCount, canPostComment, isLike, commentData, wall, wallOwnerId  );
                        
                      $('#new-status').after(statusBox);
                      $('#new-status').slideUp("slow"); 
                      $('#status-box-'+divId).fadeOut("slow");
                      $('#status-box-'+divId).fadeIn("slow");
                    });              
                  }
              }
          });
     };
/* -------------------- end status -----------------------*/  

function incOffset( inc ) {
    offset = inc;
}

function hideMessageNotif(){
    $("#menu-panel-message").hide("fast");
}


/* status box */
function writeStatusBox(divId, tid, type, uid, username, statusAvatar, message, created, countComment, likeCount, showInputComment, showLike, commentData, wall, wallOwnerId ){
    
    data='<div id="status-box-'+divId+'">'+
            '<hr class="space"/>'+
            '<hr />'+
            '<div id="status-'+divId+'" class="status-area ui-corner-all shadow">'+
            '<a href="'+baseUrl+'?fid='+uid+'"><div class="photo-profile-small-40px float-left" style="background-image: url(\''+statusAvatar+'\');"></div></a>'+
                 '<div class="status-delete-box" onmouseover="showDeleteStatus(\''+divId+'\')" >'+
                    '<a id="status-delete-'+divId+'" class="status-delete" onclick="deleteStatusClick(\''+divId+'\', \''+tid+'\')">hapus</a>'+                    
                 '</div>'+
                 '<div class="status-report-box" onmouseover="showReportStatus(\''+divId+'\')" >'+
                    '<a id="status-report-'+divId+'" class="status-report" onclick="statusReportClick(\''+divId+'\', \''+tid+'\',\''+type+'\')">Laporkan</a>'+                    
                 '</div>'+
                 '<div class="status-box"><div class="status-username"><a href="'+baseUrl+'?fid='+uid+'">'+username+'</a>';
    if(wall!='self'){
        data = data + '  pada dinding <a href="'+baseUrl+'?fid='+wallOwnerId+'">'+wall+'</a>';
    }                 
    data=data +  '</div>'+
                 '<div id="status-message-'+divId+'"  class="status-message expandable"><p class="wrapword">'+message+'</p></div>'+
                 '<div class="status-info">'+created+' | '+countComment+' komentar'+
                 ' | <span class="status-like-count" id="status-like-count-'+divId+'" onmouseover="getUserLike(\''+divId+'\',\''+tid+'\')">'+likeCount+' menyukai ini </span>';
    if(showLike==true){
        data = data +'<a id="trigger-status-like-'+divId+'" onclick="statusLike(\''+divId+'\',\''+tid+'\',\''+type+'\')"><img src="'+baseUrl+'css/images/icon/like-icon.png"/>  Suka</a>';
    }
    data = data + '</div></div></div>';
    
    if(countComment>=1){
        data=data+'<div class="comment-area-box">';
        $.each(commentData, function(index, value) {
            data=data+writeCommentBox(divId, value.tid, value.username, value.avatar, value.message, value.created)
            divId = divId+11;
        })
        data=data+'</div>';
    }
    
    if(showInputComment==true){
        data=data+writeCommentInput(divId, tid, type);
    }
    data = data + '</div>';
    return data;
}


/* comment box */
function writeCommentBox(divId, tid, username, avatar, message, created){
    data =  '<div class="comment-area ui-corner-all shadow" id="comment-area-'+divId+'">'+
                '<div class="comment-delete-box" onmouseover="showDeleteComment(\''+divId+'\')" >'+
                    '<a id="comment-delete-'+divId+'" class="comment-delete" onclick="deleteCommentClick(\''+divId+'\', \''+tid+'\')">hapus</a></div>'+
                '<div class="photo-profile-small-30px float-left" style=" background : url(\''+avatar+'\')"></div>'+
                '<div class="comment-box">'+
                    '<div class="comment-username">'+username+'</div>'+
                    '<div class="comment-message cl_blue" ><p class="wrapword">'+message+'</p>'+
                        '<div class="comment-info" style="font-size: 11px;">'+created+'</div>'+
                    '</div>'+
                '</div>'+
             '</div>';
    return data;
}

/* comment Input */
function writeCommentInput(divId, tid, type){
    data='<div id="input-comment-area-'+divId+'" class="input-comment-area ui-corner-all shadow">'+
            '<a class="link-start-comment" id="link-start-comment-'+divId+'" onclick="commentStart(\''+divId+'\',\''+tid+'\',\''+type+'\')">'+
                '<div align="center">'+
                    '<input  type="text" class="ui-corner-all" style="padding: 5px; width: 90%; color: #ddd;" value="Tulis komentar..."/>'+
                '</div>'+
            '</a>'+ 
         '</div>'
    return data;
} 

/* -------------------- like ------------------------*/

function statusLike(divId, statusId,type){
    var data = {'tid' : statusId, 'type' : type};
    $.ajax({
        type: "POST", 
        url : baseUrl+"like/add",
        cache: false,
        dataType : "json",
        data : { data: data },
        success: function(data){
            count = data.count;
                $("#status-like-count-"+divId).fadeOut().fadeIn().text(count+" termasuk Kamu menyukai ini").addClass("cl_red bold");
                $("#trigger-status-like-"+divId).hide();
        }
    })
};
// Mengambil data user yang like
var tooltipShowed= new Array();
function getUserLike(divId, statusId){
    if (tooltipShowed[divId]==undefined || tooltipShowed[divId]!=true){
        tooltipShowed[divId]=true;
        var data = {'tid' : statusId};
        $.ajax({
            type: "POST", 
            url : baseUrl+"like/get/status",
            cache: false,
            dataType : "json",
            data : 'tid='+statusId,
            success: function(data){
                listUserLike='';
                $.each(data, function(index, value) {
                    name = value.realname;
                    listUserLike = listUserLike+name+', ';
                });
                    $('#status-like-count-'+divId).append(listUserLike+' ...');             
            }
        });
    };
}
/* -------------------- like ------------------------*/

function showDeleteStatus(id){
    $('a.status-delete').hide();
    $('a#status-delete-'+id).show();
}
function showReportStatus(id){
    $('a.status-report').hide();
    $('a#status-report-'+id).show();
}
function showDeleteComment(id){
    $('a.comment-delete').hide();
    $('a#comment-delete-'+id).show();
}

function deleteStatusClick(divId, statusId){
    $("#dialog-delete").html('<p>Apakah anda yakin untuk menghapus status ini</p>'+
    '<button class="button" onclick="dialogClose()">Batal</button>'+
    '<button onclick="deleteStatus(\''+divId+'\',\''+statusId+'\')">Ya</button></div>');
    
    $("#dialog-delete").dialog( "open" );
}
// combine !
function statusReportClick(divId, statusId, type){
    var data = {'tid' : statusId, 'type' : type};
    $.ajax({
        type: "POST", 
        url : baseUrl+"report/add/",
        cache: false,
        dataType : "json",
        data : { data: (data) },
        success: function(data){
                $("#status-report-"+divId).html(data.message);
        }
    });
}
function reportClick(divId, tid, type){
    var data = {'tid' : tid, 'type' : type};
    $.ajax({
        type: "POST", 
        url : baseUrl+"report/add/",
        cache: false,
        dataType : "json",
        data : { data: (data) },
        success: function(data){
                $("#report-"+divId).html(data.message);
        }
    });
}

function dialogClose(){
    $("#dialog-delete").dialog( "close" );
}

function deleteStatus(divId, statusId){
    dialogClose()
    var data = {'tid' : statusId};
    $.ajax({
        type: "POST", 
        url : baseUrl+"status/delete",
        cache: false,
        dataType : "json",
        data : { data: JSON.stringify(data) },
        success: function(data){
            if(data.success=='true'){
                $("#status-box-"+divId).slideUp('slow');
            }
        }
    });
}

function deleteCommentClick(divId, commentId){
    
    var data = {'tid' : commentId};
    $.ajax({
        type: "POST", 
        url : baseUrl+"comment/delete",
        cache: false,
        dataType : "json",
        data : { data: (data) },
        success: function(data){
            if(data.success=='true'){
                $("#comment-area-"+divId).slideUp('slow');
            }
        }
    });
    
}


/* notification */
function hideNotification(){
     $("#BeeperBox").hide();
}

function stopHide() {
    clearTimeout(timerNotification);
}
    
function startHide() {
    timerNotification=setInterval(hideNotification, 10000 );
}
var timerNotification=setInterval(hideNotification, 10000 );

function showNotification(name,message, action, icon){
    $("body").append(
        '<div id="BeeperBox" class="UIBeeper"  onmouseover="stopHide()" onmouseout="startHide()" onclick="hideNotification()">'+
         '<div class="UIBeeper_Full">'+
            '<div class="Beeps">'+
               '<div class="UIBeep UIBeep_Top UIBeep_Bottom UIBeep_Selected" style="opacity: 5; ">'+
                  '<a class="UIBeep_NonIntentional" '+action+'>'+
                     '<div class="UIBeep_Icon">'+
                        '<i class="'+icon+'"></i>'+
                     '</div>'+
                     '<span class="beeper_x">&nbsp;</span>'+
                     '<div class="UIBeep_Title">'+
                        '<span class="cl_blue">'+name+' </span><span>'+message+'</span>'+
                     '</div>'+
                  '</a>'+
               '</div>'+
            '</div>'+
         '</div>'+
      '</div>'
    );
    
    $("#BeeperBox").show();
    notificationShowed=true;
}

function clearNotifyGeneral(){
    $("#notify-counter-general").html('');
    $("#menu-panel-general .content").html('<strong>Umum</strong><br /><hr />');
}

function clearNotifyMessage(){
    $("#notify-counter-message").html('');
    $("#menu-panel-message .content").html('<strong>Pesan</strong><br /><hr />');
}

var messageCount=0;
var generalCount=0;
//Mengambil notification
function getNotification(){
    $.ajax({
        type: "POST", 
        url : baseUrl+"notify",
        cache: false,
        dataType : "json",
        success: function(data){
            if(data.empty!='true'){
                // general
                general = data.general;
                if(general!=undefined){
                    count = general.length;
                    generalCount=generalCount+count;
                    clearNotifyGeneral();
                    $("#notify-counter-general").html(generalCount);    
                    $.each(general, function(index,     value) {
                        username = value.username;
                        tid = value.tid;
                        $("#menu-panel-general .content").append('<a href="'+baseUrl+'">'+
                         '<div class="photo-profile-small-30px float-left" style="background-image: url(\''+avatar+'\');"></div>'+
                        '<strong>'+username+'</strong> mengirikan sesuatu di dinding kamu</a></div>');
                        
                        action = 'onclick="location.href=\''+baseUrl+'\'"';
                        showNotification(username,'mengirikan sesuatu di dinding kamu', action, 'icon');   
                    });
                }
                // message
                message = data.message;
                if(message!=undefined){
                    count = message.length;
                    messageCount=messageCount+count;
                    clearNotifyMessage();
                    $("#notify-counter-message").html(messageCount);
    
                    $.each(message, function(index, value) {
                        username = value.username;
                        tid = value.tid;
                        chatboxtitle = value.from;
                        $("#menu-panel-message .content").append('<div><a onclick="startChat(\''+chatboxtitle+'\',\''+tid+'\');hideMessageNotif();"> '+
                         '<div class="photo-profile-small-30px float-left" style="background-image: url(\''+avatar+'\');"></div>'+
                        '<strong>'+username+'</strong> mengirikan anda pesan obrolan</a></div>');
                    })
                    document.title=username+'mengirimkan anda pesan';                    
                }
                
                // friend
                friend = data.friend;
                count = friend.length;
                friendCount=count;
                $("#notify-counter-friend").html(friendCount);
                    text='';
                $.each(friend, function(index, value) {
                    username = value.username;
                    tid = value.tid;
                    avatar = value.avatar;
                    text = text+'<a href="'+baseUrl+'wall/friend?fid='+tid+'">'+
                    '<div class="photo-profile-small-30px float-left" style="background-image: url(\''+avatar+'\');"></div>'+
                    '<strong>'+username+'</strong> mengirim permintaan pertemanan</a></div><hr class="space"/>';
                })
                $("#menu-panel-friend .content .menu-panel-message").html(text);
            }
        }
    })
}


var realname = '';

function commentStart(id_inc,tid,type){createCommentBox(id_inc,tid,type);};

function createCommentBox(id_inc,tid,type){
    $(".input-comment-box").hide();
    $('.link-start-comment').show();
    if(avatar==''){
        $.ajax({
        type: "POST", 
        url : baseUrl+"user/getdata",
        dataType : "json",
        cache: false,
            success: function(data){
                    avatar    = data.avatar;
                    realname  = data.realname;
            }
        });
    }
    $("#link-start-comment-"+id_inc).hide();
        $("#link-start-comment-"+id_inc).after(
            '<div class="input-comment-box" style="padding:5px">'+
            '<div class="float-left photo-profile-small-30px" style="background-image: url(\''+avatar+'\')"></div>'+
            '<div style="margin-left:35px; margin-top: -5px;">'+
            '<textarea id="txt-comment-'+id_inc+'" class="txt-comment ui-corner-all" name="message" onkeydown="checkCommentBoxInputKey(event, \''+id_inc+ '\',\''+tid+ '\',\''+type+ '\')"></textarea>'+ 
            '</div>'+
            '</div>'
        );
    $('#txt-comment-'+id_inc).focus();
};

function checkCommentBoxInputKey(event, id_inc, tid, type) {
    if(event.keyCode == 13 && event.shiftKey == 0) {
		message =$('#txt-comment-'+id_inc).val();
		var data = {'message': message , 'tid':tid, 'type' : type,}
		$('#txt-comment-'+id_inc).focus();
		$('#txt-comment-'+id_inc).css('height','17px');
		if (message != '') {
            $.ajax({
                type: "POST", 
                url : baseUrl+"comment/add",
                cache: false,
                data : {data : JSON.stringify(data)},
                dataType : "json",
                success: function(data){
                    if(data.success!=false){
                        divId = data.divId;
                        tid = data.tid;
                        username = data.username;
                        message = data.message;
                        created = data.created;
                        coomentBox = writeCommentBox(divId, tid, username, avatar, message,  created  );
                        $('#txt-comment-'+id_inc).val('');
                        $('#input-comment-area-'+id_inc).before(coomentBox);
                    }else{
                        alert(data.message);
                    }
        		}
            });
        } 
    };
};