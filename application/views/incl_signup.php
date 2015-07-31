<script type="text/javascript" src="<?php echo(base_url());?>js/signup.js"> </script>
<link rel="stylesheet" href="<?php echo(base_url());?>css/tcal.css" type="text/css">
<div id="signup-overlay" class="popup-overlay"></div>
<div id="signup-box" class="popup-box">
	<div class="dialog-content">
	  <div id="dialog-message" align="center"><h2 class="cl_orange"><b>Silahkan Daftar Untuk Terhubung</b></h2><hr />
      <form id="form1" name="frm_signup" method="post" action="<?php echo(base_url().'signup.html') ?>">
      <div class="span-4" align="right">
      <h3 id="nameInfo" class="marginTop_15px margin-bottom-35px">Nama Lengkap </h3>
      <h3 id="emailInfo" class="marginTop_15px margin-bottom-35px" >Email </h3>
      <h3 id="pass1Info" class="marginTop_15px margin-bottom-35px">Kata Sandi </h3>
      <h3 id="pass2Info" class="marginTop_15px margin-bottom-35px">Ulang Kata Sandi </h3>
      <h3 class="marginTop_15px margin-bottom-35px">Jenis Kelamin </h3>
      <h3 class="marginTop_15px margin-bottom-35px">Tanggal lahir </h3>      
      </div>

      <div align="left">
      <input id="signupName" class="input_login" type="text" name="signupname" title="Nama Lengkap" />
      <input id="signupEmail" class="input_login" type="text" name="signupemail" title="Email Anda" />
      <input id="pass1" class="input_login" type="password" name="password1" title="Kata Sandi" />  
      <input id="pass2" class="input_login" type="password" name="password2" title="Ulang Kata Sandi"/>
      <div  class="marginTop_20px margin-bottom-15px" align="left" title="Jenis Kelamin">
        <label><input type="radio" name="gender" value="gender1" checked="" />Laki-laki</label>
        <label><input type="radio" name="gender" value="gender2"  />Perempuan</label>
      </div>
      <input id="birthDay" type="text" name="birthday" class="datepicker input_login" value="00-00-0000" />
        <script type="text/javascript"> 
        $( ".datepicker" ).datepicker({
			                 changeMonth: true,
			                 changeYear: true,
                             yearRange : "c-60",
                             dateFormat: "dd-mm-yy",
                             maxDate: "-13y"
        });</script>
      <div align="center">
      <div  ><input  id="signupButton" class="btn_submit font_18px" type="submit" name="btnsignup" value="Daftar" /></div>
      </div>
      </div>
    </form>
</div>
</div>
</div>
