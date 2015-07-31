	<script type="text/javascript">
 
		$(document).ready(function(event){
			var chat_menuRoot = $( "#chat-menu-root" );
			var chat_menu = $( "#chat-menu" );
 
			// Hook up chat-menu root click event.
			chat_menuRoot
				.attr( "href", "javascript:void(0)" )
				.click(function(){
				    // Toggle the chat-menu display.
				    chat_menu.toggle();
				    // Blur the link to remove focus.
				    chat_menuRoot.blur();
                    //the ajax
                   	$.ajax({
                        type  : 'POST',
                		url   : '<?php echo(base_url());?>friend/online',
                        dataType : "json",
                		success: function(data) {
                		  $("#chat-menu").html('');
                          if (data.empty!='y'){
                                $.each(data, function(index, value) { 
                                   name = value.name;
                                   tid  = value.tid;
                                   avatar = value.avatar;
                                   realname = value.realname;
                                   $("#chat-menu").append(
                                    '<a onclick="javascript:startChat(\''+name+'\',\''+tid+'\');" id="'+tid+'">'+
                                    '<div style="vertical-align: middle; height:30px;">'+
                                    '<div class="photo-profile-small-30px float-left" style="background:url(\''+avatar+'\') no-repeat center center"></div>'+
                                    '<div style="margin-left:35px; padding-top:7px;">'+realname+'</div>'+
                                    '</div></a>');
                                    
                                });
                          }
                          else{$("#chat-menu").html('<div class="cl_blue">Tidak ada teman yang online</div>')}
                        }
                    });
				    // Cancel event (and its bubbling).
				    return( false );
                });
 
			// Hook up a click handler on the document so that
			// we can hide the chat-menu if it is not the target of
			// the mouse click.
			$( document ).click(function( event ){
 	 		var  menuPanel=$(".menu-panel");
			     // Check to see if this came from the chat-menu.
					if (chat_menu.is( ":visible" ) && !$( event.target ).closest( "#chat-menu" ).size()){
						// The click came outside the chat-menu, so
						// close the chat-menu.
						chat_menu.hide();
					}
			});
            
             $(function() {
            		//$( "a#chat-menu-root" ).button();
                    $( "#chat-menu-root" )
            			.button({
            			     icons: {
            						primary: "ui-icon-comment"
            					}
            			});
            		$( "#chat-offline" )
            				.button( {
            					text: false,
            					icons: {
            						primary: "ui-icon-power"
            					}
            				})
            				.parent()
            					.buttonset();
               	});
                
    });
	</script>

<script type="text/javascript" src="<?php echo(base_url());?>js/chat.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo(base_url());?>css/chat.css" />
	<div id="site-bottom-bar" class="fixed-position">
		<div id="site-bottom-bar-frame">
			<div id="site-bottom-bar-content">
                
				<button id="chat-menu-root">Obrolan</button>
                <button id="chat-offline">Jadikan Offline</button>
				<div id="chat-menu" class="ui-corner-top"></div>
			</div>
		</div>
	</div>

<?php
	include("incl_help.php");
?>