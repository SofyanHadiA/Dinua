<script language="javascript">
var albumId = '<?php echo $albums['aid_encrypted'] ?>'
var albumName = '<?php echo $albums['name'] ?>';
var albumDesc = '<?php echo $albums['des'] ?>';
var albumType = '<?php echo $type_encrypted ?>';

var offset = 0;
var uploaded=false;

$(document).ready(function(){
    getContent();
    
    function editAlbum(){
        name = $('#album-name-input').val();
        desc = $('#album-desc-input').val();
        
        $.ajax({
			type: 'POST',
			url: baseUrl+'album/edit',
			data: {'id' : albumId,'name' : name, 'desc':desc , 'type':albumType},
            dataType : "json",
			success: function(data) {
                if(data.success=='true'){
                     location.reload();
                }else{alert('gagal menyimpan');}
			}
		})
    };    	
    function deleteAlbum(){
        type = $('#album-type').val();
        $.ajax({
			type: 'POST',
			url: baseUrl+'album/delete',
			data: {'id' : albumId,  'type':albumType},
            dataType : "json",
			success: function(data) {
                if(data.success=='true'){
                     location.reload();
                }else{alert('gagal menghapus kemungkinan karena koneksi atau album tidak kosong');}
			}
		})
    };	
    
    
    $("#get-older-content").click(function(event){
        $(".loading-scroll").text('Loading...');
        getContent();
    })
    
    
    
    $("#btn-content-add").button({icons:{primary: "ui-icon-plusthick"}}).click(function(event)
        {$('#wrapper-frm-upload').dialog('open');
    });
    $("#btn-album-edit").button({icons:{primary: "ui-icon-gear"}}).click(function(event){
        $('#album-name-input').val(albumName);
        $('#album-desc-input').val(albumDesc);
        $("#edit-album-dialog").dialog({buttons:{
            "batal": function() {$(this).dialog("close");},
            "simpan": function() {editAlbum();}
          }
        }); 
        $("#edit-album-dialog").dialog('open');
        
    });
    
    $("#btn-album-delete").button({icons:{primary: "ui-icon-trash"}}).click(function(event){
        $("body").append('<div id="delete-album-dialog">Perhatian : jika album tidak kosong maka album tidak bisa dihapus. Apakah anda yakin untuk menghapus album ini </div>');
            
        $("#delete-album-dialog").dialog({        
            resizable   : false,
            draggable   : false,
            modal: true,
            autoOpen: false,
            buttons: {
                "ya": function(){deleteAlbum();}, 
                "batal": function(){$(this).dialog("close");}
            }
        });
        
        $("#delete-album-dialog").dialog('open');
    });    

 $("#btn_upload").click(function(){
    $("#upload_message").show();
    });
    
    $('#frm-upload').submit(function(){
	    var element = $(this);
        var id = element.attr('id');
		$('#upload_loading').fadeIn("slow");
        $('#image_loading').show("slow");
        $('#upload_message').text('mohon jangan tutup dialog ini sebelum selsesai ! ');
	});
    
    $("#wrapper-frm-upload").dialog({
        autoOpen    : false,
        width       : 600,
        resizable   : false,
        modal       : true,
        close       : function(){if(uploaded==true){location.reload();}}, 
        open        : function(event, ui) { 
            jQuery('.ui-dialog-titlebar-close').show();
            jQuery('.ui-dialog-titlebar').show(); 
        },
        buttons: {
            "Tutup": function() { 
				$(this).dialog("close");
                } 
        }
    });
 });
 
function doneUpload(msg){
    $('#image_loading').hide("slow");
    $('#upload_message').text(msg);
};
function uploadResult(value){
    uploaded=value;
};
function getContent(){
        $.ajax({
			type: 'POST',
            cache : false,
			url: baseUrl+pageType+'/getlist',
            data: {'id' : albumId, 'type':albumType, 'offset' : offset, 'uid' : wall_owner_id},
            dataType : "json",
			success: function(data) {
                if(data.empty!='true'){
                     contentList='';
                     $.each(data.data, function(index, value) {
                        divId = value.divId;
                        tid = value.tid;
                        title = value.title;
                        desc=value.desc;
                        commentCount = value.commentCount;
                        thumb = value.thumb;
                        created = value.created;
                        contentList = contentList + writeContentList(divId, tid, title, desc, commentCount, thumb, created);
                     })
                     $("#content-area").append(contentList);
                     incOffset(data.offset);
                     $(".loading-scroll").text('Konten Terdahulu');
                }else{
                    $(".loading-scroll").text('Konten Habis');
                }
			}
    })
};
</script>

<div style="width: 100%; text-align: left;">
    <div id="album-title" class="bold cl_blue font_14px"><?php echo $albums['name'] ?> Oleh <?php echo $profile['realname']?> </div>
    <div id="album-created" class="" style="text-align: left;">
    <?php
        echo $albums['created'];
    ?>
    </div>
<?php
if($owner==true){
?>
    <div style="float: right;" class="font_10px"  align="center">
        <button id="btn-content-add">Tambah</button>
        <button id="btn-album-edit">Sunting Album</button>
        <button id="btn-album-delete">Hapus Album</button>
    </div>
<?php
	}
?>
</div>
<div id="album-desc" class="wrapword float-left" style="text-align: left; width: 350px; max-height: 200px;">
<?php
    echo $albums['des'];
?>
</div>

<hr class="space" />

<hr />

<div id="content-thumb" style="width:100%; max-height: 1000px; overflow: auto;">
<div id="content-area"></div>
<?php
include($content['showcase']);
?>
</div>

<hr class="space" />

<div>
    <a id="get-older-content"><div class="loading-scroll ui-corner-all">Konten Terdahulu</div></a>
</div>
<?php
	// div tampilkan foto
?>
<div id="content-area" style="display: none;background: #222222; "></div>

<?php
if($owner==true){
?>
<div id="edit-album-dialog">
    <label>Nama Album : </label>
    <input id="album-name-input" class="ui-corner-all" name="album-name"/><br />
    <label>Deskripsi : </label>
    <textarea id="album-desc-input" class="ui-corner-all" name="album-desc"></textarea>
</div>
<?php if($type == 'photo' || $type == 'ebook' ) {?>
<div id="wrapper-frm-upload" style="display: none; z-index:5000;">
    <form action="<?php echo base_url($type) ?>/add" target="media-upload" method="post" accept-charset="utf-8" id="frm-upload" enctype="multipart/form-data">
        <input type="file" name="userfile" size="20"/>
        <input type="hidden" name="aid" value="<?php echo $this->encrypt->encode($albums['id']) ?>"/>
        <br /><br />
        <input id="btn_upload" type="submit" value="Upload" />
        <div id="upload_loading" style="display: none;"><p id="upload_message" style="display: none; float: left;" >mohon jangan tutup dialog ini sebelum selsesai ! </p>
        <img id="image_loading" src="<?php echo base_url();?>css/images/loading.gif" alt="Mengambil data..." /></div>
    </form>
</div>
<iframe name="media-upload" id="media-upload" style="display:none;"></iframe>
<?php
	}
 }
?>