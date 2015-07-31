<div id="right-menu">

    <div>
    <h4><h3 class="cl_red">Perhatian!</h3>
        Dinua saat ini hanya untuk kepentingan riset yang bertujuan untuk 
        membantu siswa SLTP dan SLTA meenggunakan <i>Social Network</i>  yang positif<hr />
        Dimohon untuk tidak memasukan data penting, rahasia ataupun semacamnya,
        karena masih terdapat banyak sekali kekurangan, dan celah keamanan
        <hr />
        Jika anda memutuskan untuk mendaftar demi kepentingan riset dimohon untuk 
        mengirimkan kritik, saran dan informasi penting lainnya di dinding Dinua anda.
    </h4>
    </div>
<hr />
<div class="ui-corner-all margin-bottom-10px padd_5px bold cl_blue title">Sponsor</div>
<a href="http://www.stmikbumigora.ac.id" ><div id="home_top_logo_stmik" class="span-2"></div><div>STMIK BUMIGORA MATARAM - www.stmikbumigora.ac.id</div></a>
<hr />
<div class="ui-corner-all margin-bottom-10px padd_5px bold cl_blue title">Teman yang mungkin Kamu kenal</div>
<div>
<?php foreach($sugestedList as $rows){ ?>
    <div>
    <a href="<?php echo(base_url().'wall/friend?fid='.$rows['id']) ?>">
        <div class="photo-profile-small-70px margin-bottom-10px" style="background-image: url('<?php echo base_url().$rows['avatar'].'/avatar-70px.jpg';?>');"></div>
        <label class="cl_blue"><?php echo $rows['realname'];?></label><br />
        <label class="cl_blue"><?php echo $rows['city'];?></label><br />
        <label class="cl_blue"><?php echo $rows['country'];?></label><br />
    </a>
    </div>
<?php } ?>
</div>
<hr />
<div class="ui-corner-all margin-bottom-10px padd_5px bold cl_blue title">Inspiring People</div>
<div>
    <a href="" title="no-photo"> Agus Pribadi, S.T,M.Sc - Dosen STMIK Bumigora - No Data</a>
</div>

</div>
<style type="text/css">
<!--
	#right-menu .title{
        background-color: #fff; width: 95%; text-align: center;
    }
-->
</style>