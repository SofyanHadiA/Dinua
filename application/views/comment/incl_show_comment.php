<!--INPUT COMMENT--!>
<?php
function writeComment($tid,$type){
    $tid  = $this->encrypt->encode($tid);
    $type = $this->encrypt->encode('S');
    $tid  = urlencode($tid);
    $type = urlencode($type);
?>

<div id="input-comment-area-<?php echo $id_inc ?>" class="input-comment-area" style="padding:5px; min-height: 30px; width: 100%; background:#f2f2f2;" class="ui-corner-all">
    <a id="link-start-comment-<?php echo $id_inc ?>" onclick="commentStart('<?php echo $id_inc ?>','<?php echo ($tid); ?>','<?php echo($type); ?>')">Komentari</a> 
</div>
<?php
	}
?>