<div id="info-top">
<div id="info-logo"></div>
</div>
<div id="info_mid" align="center">
<div>
<hr/>
    <h1 class="cl_blue"><?php echo $message ?></h1> 
        <?php
        if (!empty($error)){
        echo('<div class="large">');
        foreach($error as $key=>$value){
            echo ("$value <br />");
        }
        echo('</div>');
        }
        echo('<br/><h3>'.$info.'</h3>');
        ?>    
</div>
</div>
<div id="home_btm" style="position:absolute; bottom:5px; width: 100%;">
dinua for Indonesia | Sofyan Hadi A - 2012 <br /> 
| powered with : Codeigniter, jQuery, jQuery UI, jQuery Tools, BluePrint, ImageMagick |
</div>