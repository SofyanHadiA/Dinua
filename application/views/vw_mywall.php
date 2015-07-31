<script type="text/javascript">
// Pre Variables
var wall_owner_id = '<?php echo $id_wall_owner_encrypted; ?>';
var avatar = '<?php echo(base_url().$user_profile['avatar'].'avatar-30px.jpg'); ?>';
$(document).ready(function(event){
    getStatus();
})
</script>

<?php include('menu/incl_slider.php') ?>

<div id="container" class="ui-corner-all" style="margin-top: 50px">
<?php require_once($content['leftmenu']); ?>
         
<?php //---------------------- Profile------------------------?>

<div id="wall-content">
    <hr class="space"/>
    <h2 class="bold"><?php echo($profile['realname']); ?></h2> 
      
    <?php include('wall/incl_wall_friend_request.php'); // tanda status pertemanan?>
         
    <hr />
    <?php include('wall/incl_wall_profile.php'); // rincian mengenai profile?>     
      
<?php	//---------------------- Status------------------------?>

    <?php   
    if($canPostStatus==true){ 
        echo('<hr />');
        include('status/incl_input_status.php'); // Status Input
        include('comment/incl_input_comment.php');// Comment Input 
    } 
    ?>    

<div id="status-box" class="status_box">        
    <div id="new-status" style="display : none;"></div>
       </div>
      <hr  class="space" />
      <hr />
    
	<a id="get-older-status">
        <div class="loading-scroll ui-corner-all">Kiriman Terdahulu</div>
    </a>
     
</div>


<?php include('menu/incl_rightmenu.php'); ?>
      
<hr class="space" />
</div>
<div><?php include_once('menu/incl_chatbar.php');?></div>
</div>