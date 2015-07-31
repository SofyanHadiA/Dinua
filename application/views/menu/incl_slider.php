<!-- stylesheets -->
<link rel="stylesheet" href="<?php echo base_url() ?>css/slide.css" type="text/css" media="screen" />
<!-- Panel -->
<div id="toppanel-area">
<div id="toppanel">
    <a href="<?php echo base_url().'theworld'; ?>"><div id="dinua-logo"></div></a>
    <div id="top-notification-area" >
    <ul >
        <a id="friend-notif" class="top-notification">
            <div  class="notify-counter ui-corner-all" id="notify-counter-friend"></div>
        </a>
            <li >
        <div id="menu-panel-friend" class="menu-panel ui-corner-bottom panel-shadow">
            <div class="content" >
                <strong>Pertemanan</strong><br />
                <hr />
                <div class="menu-panel-message"></div>
            </div>
        </div>
    </li>
    </ul>
    <ul >
        <a id="message-notif" class="top-notification">
            <div class="notify-counter ui-corner-all" id="notify-counter-message"></div>
        </a>
        <li >
        <div id="menu-panel-message" class="menu-panel ui-corner-bottom panel-shadow">
            <div class="content" >
                <strong>Pesan</strong><br />
                <hr />
            </div>
        </div>
        </li>
    </ul>
    <ul >
        <a id="general-notif" class="top-notification">
            <div class="notify-counter ui-corner-all" id="notify-counter-general"></div>
        </a>
        <li>
        <div id="menu-panel-general" class="menu-panel ui-corner-bottom panel-shadow">
            <div class="content" >
                <strong>Pemberitahuan</strong><br />
                <hr />
            </div>
        </div>
    </li>
    </ul>
    </div>
	<div class="tab">
		<ul class="menu-bar">
            <li>
                <a href="<?php echo base_url(); ?>">
                   Hai <?php echo $user_profile['realname']; ?> !
                </a>
            </li>
            <li class="sep">|</li>
            <li>
                <a href="<?php echo base_url().'theworld'; ?>">
                   Beranda
                </a>
            </li>
            <li class="sep">|</li>
            
            <li>
                <a id="help-open">Bantuan?</a>		
			</li>
            <li class="sep">|</li>
            <li>cari temanmu : 
                <input id="serach-input" class="ui-corner-all" type="text" style="padding: 2px; width: 150px;" onkeydown="friendSearch(event);"/>
                    <li>
                        <div class="ui-corner-bottom panel-shadow">
                    </li>
            
            </li>
			
			<li class="sep">|</li>
			<li id="toggle">
                <a id="menu-open" class="close" href="<?php echo(base_url().'logout.html'); ?>"> Keluar</a>		
			</li>
		</ul> 
	</div> <!-- / top -->  
    <div id="search-panel" class="ui-corner-bottom panel-shadow">
        <a onclick="closeSearch();">Tutup</a><hr />
        <div class="search-result">
        Mencari...
        </div>
    </div>
</div>
</div>
<style type="text/css">
<!--
#search-panel {
	width: 200px;
    max-height: 300px;
	color: #999999;
	background: #272727;
	overflow: auto;
	z-index: 3;
	display:  none ;
    position: absolute;
    right: 200px;
    top: 35px;
    padding: 10px;
    text-align: left;
}
.search-result{
    max-height: 250px;
    overflow: auto;
}
-->
</style>
<script type="text/javascript">
function friendSearch(event){
    string = $("#serach-input").val();
    $("#search-panel").show();
    $.ajax({
        type: 'POST',
        url: '<?php echo(base_url()) ?>search',
        data : {search : string},
        dataType : "json",
        success: function(data) {
            if(data.empty!='true'){
                result='';
                $.each(data, function(index, value) {
                    avatar = value.avatar;
                    username = value.username;
                    tid = value.tid;
                    link = '<a href="'+baseUrl+'wall/friend?fid='+tid+'"><div style="height:30px;"><div class="photo-profile-small-30px float-left" style="background: url(\''+avatar+'\')"></div><div>'+
                        '<label>'+username+'<label></a></div></div>';
                    result = result+link+'<br/>';
                })
                 $("#search-panel .search-result").html(result+'<br/>');
            }else{
                $("#search-panel .search-result").html('tidak ditemukan <br/>');
            }
        }
    })
}
function closeSearch(){
    $("#serach-input").val('');
    $("#search-panel").hide();
}
</script>