<link rel="stylesheet" href="<?php echo(base_url());?>css/home.css" type="text/css"/>
<?php include_once('incl_signup.php'); ?>
<?php include_once('incl_forgetpassword.php'); ?>
<div id="home_top">
    <div id="home_top_logo_stmik" class="span-2"></div>
    <div class="home_top_text span-7">Supported by :<br />
        <a href="http://www.stmikbumigora.ac.id" ><p style="color: #fff !important;">STMIK BUMIGORA MATARAM</p></a>
    </div>
</div>

<div id="home_mid" align="center">
<div id="cntr_login"  class="ui-corner-all">

<div id="logo_home"></div>
<hr/>
      <form method="post" action="<?php echo(base_url())."login.html"?>" >
      <div class="span-3" align="right">
      <h2 class="margin_sgnup">Email </h2>
      <h2 class="margin_sgnup">Password </h2>
      <a href="javascript:popup('rememberpass')">Lupa Password</a>      
      
      </div>
      <div align="right">
      <input class="input_login" type="text" name="email" />
      <input class="input_login" type="password" name="password" />    
      <input class="btn_submit font_18px" type="submit" value="Masuk" />
      </div>
      </form>
      <hr class="space"/>
      
      <div class="text_signup" class="span-7" align="center">
      <a href="javascript:popup('signup')">Daftar Untuk Membuat Akun</a>
      </div>      
</div>

</div>

<div id="home_btm">
dinua for Indonesia | Sofyan Hadi A - 2012 <br /> 
| powered with : Codeigniter, jQuery, jQuery UI, jQuery Tools, BluePrint, ImageMagick |
</div>

<script type="text/javascript">
$(document).ready(function(event, ui){$('#announcment-dialog').dialog({width:400,autoOpen:true,resizable:false,modal:true,
        buttons: {
            "Saya mengerti": function() { 
				$(this).dialog("close");
            }},open: function(event, ui) { $(".ui-dialog-titlebar").hide(); }});
})
</script>

<div id="announcment-dialog" style="text-align: center;">
    <h2>Dinua V. Alpha 1.1</h2>
    <hr />
        <h4>Dinua saat ini hanya untuk kepentingan riset yang bertujuan untuk 
        membantu siswa SLTP dan SLTA menggunakan <i>Social Network</i>  yang positif<hr />
        Dimohon untuk tidak memasukan data penting, rahasia ataupun semacamnya,
        karena kemungkinan masih terdapat kekurangan dan celah keamanan
        <hr />
        Jika anda memutuskan untuk mendaftar demi kepentingan riset dimohon untuk 
        mengirimkan kritik, saran dan informasi penting lainnya di dinding Dinua anda
        <hr />
        Mohon membuka dengan : <br />
        <a href="https://www.google.com/chrome/index.html"><img height="25px" width="auto" src="https://www.google.com/intl/id/images/logos/chrome_logo.gif" /></a>
        <a href="http://www.mozilla.org/"><img  height="25px" width="auto"  src="http://www.mozilla.org/media/img/home/firefox.png" /></a>
        </h4>
</div>