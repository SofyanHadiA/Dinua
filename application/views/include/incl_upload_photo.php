<script language="javascript">
$(document).ready(function() {
 $("#btn_upload").button({
    icons: {
     primary: "ui-icon-locked"
            }
    });
 $("#btn_upload").click(function(){
    $("#upload_message").show();
    });
    
/*  $('#frm_upload').submit(function(){
	    var element = $(this);
        var id = element.attr('id');
		$('#upload_loading').fadeIn("slow");
        $('#image_loading').show("slow");
        $('#upload_message').text('mohon jangan tutup dialog ini sebelum selsesai ! ');
        
	    event.preventDefault(); 
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
                $('#image_loading').fadeOut("slow");
                $('#upload_message').text(data);
			}
            
		})
        
        
		return false;
	});*/
 });
</script>

<div id="wrapper_frm_upload" style="display: none; z-index:5000;">

<?php $attr=array('id'=>'frm_upload'); echo form_open_multipart('uploadphoto',$attr);?>

<input type="file" name="userfile" size="20"/>

<br /><br />

<input id="btn_upload" type="submit" value="Upload" />
<div id="upload_loading" style="display: none;"><p id="upload_message" style="display: none; float: left;" >mohon jangan tutup dialog ini sebelum selsesai ! </p>
<img id="image_loading" src="<?php echo base_url();?>images/loading.gif" alt="Mengambil data..." /></div>
</form>
</div>