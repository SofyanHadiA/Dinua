        <div class="wrapword expandable cl_blue"><?php 
            echo 'Tanggal Lahir : '.$profile['birthday'];
            if(!empty($profile['occupation'])) 
                echo ' <br/>Pekerjaan : '.$profile['occupation'].', pada '.$profile['work_at'];
            if(!empty($profile['address'])) 
                echo ' <br/> Alamat : '.$profile['address'].', Kota : '.$profile['city'].', Negara : '.$profile['country'];
            echo '<hr class="space"/>';
            if(!empty($profile['about_me'])){
                echo '<hr/>Tentang saya <br/>'.$profile['about_me'];
            }
        ?></div>
        <?php
        if($owner==true){ // Pengecekan untuk menampilkan tanda tambahkan data diri
        ?>
        <div align="right"><a href="<?php echo(base_url());?>profile.html">+ Ubah Data Diri</a></div>
        <?php
        }
        ?>