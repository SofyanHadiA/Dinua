<form method="POST" action="<?php echo base_url(); ?>admin/adminpage/savefilter">
<div>
    <h3>Forbiden Words Setting</h3>
    <input type="submit" value="Simpan" /> <br />
    <i>*format : word1;word2;word3</i><hr class="space" />
    <div style="float: left;">
        <h4>- Kategori 1 (Sangat dilarang)</h4>
            <div><textarea name="words1" ><?php echo $category1 ?></textarea></div>
    </div>
    <div>
        <h4>- Kategori 2 (Dengan sensor)</h4>
            <div><textarea name="words2" ><?php echo $category2 ?></textarea></div>
    </div>
</div>
</form>