<script type="text/javascript">
// Pre Variables
var wall_owner_id = '<?php echo $id_wall_owner_encrypted; ?>';
var avatar = '<?php echo(base_url().$user_profile['avatar'].'avatar-30px.jpg'); ?>';
</script>

<?php include_once('menu/incl_slider.php') ?>

<div id="container" class="ui-corner-all" style="margin-top: 50px">
<div style="width: 50%">
<?php include_once('menu/incl_leftmenu.php'); ?>
</div>
<div style="background: white; float: left; width: 65%; height: auto; padding: 20px 20px 25px 20px;" >      
            <?php include_once($content['content']); ?> 
</div>
    
<?php include_once('menu/incl_rightmenu.php'); ?>    

<hr  class="space" />
</div>
<div><?php include_once('menu/incl_chatbar.php');?></div>