        <link rel="stylesheet" href="<?php echo(base_url());?>css/screen.css" type="text/css" media="screen, projection"/>
        <link rel="stylesheet" href="<?php echo(base_url());?>css/style.css"  type="text/css" media="screen, projection"/>
        
        <style type="text/css">
        .arrw_prev{ margin-top: 0px; padding-top:0px; height: 35px; width:30px;float: left; color: white; background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_prev.png'); }
        .arrw_prev:hover{ background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_prev_hover.png');}
        .arrw_next{  margin-top: 0px; padding-top:0px; height: 35px; width:30px;float: right; color: white; background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_next.png'); }
        .arrw_next:hover{ background: no-repeat center  center url('<?php echo base_url(); ?>css/images/arrw_next_hover.png');}
        </style>
        <script language="javascript"> <?php //untuk mengambil photo dari tombol next dan orev ?>
            $(document).ready(function() {
                $(".arrow").click(function(){
                    var element = $(this);
                    var id      = element.attr('id');
                   	$.ajax({
                    type  : 'POST',
            		url   : '<?php echo(base_url());?>photo/get?a=<?php echo($aid); ?>',
            		data  : 'id='+id,
            		success: function(data) {
            		  var url = data;
                      if (data!='kosong'){
                        //$("#image_area").attr("src", data);
                        $("#photo_area").dialog("open");
                        $("#photo_area").html(data);
            }
        }
        });
                });
            });
        </script>
        <a class="arrow arrw_prev" id="<?php echo $prev['id']; ?>"></a>
        <div style="background: #222222; float: left;">
        <div align="center">
        <img id="image_area" style="" src="<?php echo base_url().'uploads/images/'.$id.'/'.$photo['url'];?>" width="100%" height="auto" />
        </div>
        </div>
        <div style="float: left;">
        
        <div style="width:150px; padding: 20px 20px 20px 20px; margin-left: 20px; background-color: #fff;" class="ui-corner-all" align="left">
        <div id="photo_des_area">
        <?php
	           //cek apakah deskripsi sudah ada, jika ada deskripsi ditampilkan
               if(!empty($photo['des'])){
                    echo($photo['des']);
                    echo('<a class="add_des">Tambahkan Keterangan</a>');
               } else{
                ?>
                    <a class="add_des">Tambahkan Keterangan</a>
                <?php
               }
        ?>
        <script language="javascript">
            $(document).ready(function() {
                $(".add_des").click(function(){
                    $(this).hide();
                    $("#frm_photo_des_area").show("slow");
                });
                
                $("#btn_photo_des").click(function(){
                    $("#frm_photo_des_area").hide("slow");
                    $(".add_des").show();
                });
                
                
                $("#frm_photo_des").submit(function(){
                    $("#frm_photo_des_area").hide();
                });  
            });   
        </script>
        <div id="frm_photo_des_area" style="display: none;">
            <form id="frm_photo_des" action="#">
                <textarea id="text_photo_des" name="message" style="max-width: 135px; max-height: 70px;"></textarea>
                <input type="hidden" name="tid" value="<?php  ?>" />
                <input id="btn_photo_des" type="button" name="btn_submit" value="Simpan"/>
            </form>
        </div>
        
        </div>
        <hr class="space"/>
        <hr/>
        <div><a>Komentar</a></div>
        </div>
        <hr class="space" />
        <div style="color: gray; float: left; margin-left: 20px; ">Tekan "Esc" untuk menutup</div>
        </div>
        <a class="arrow arrw_next" id="<?php echo $next['id']; ?>" accesskey=""></a>