<script type="text/javascript">
function LimitText(AId,BId)
{
    var e1 = document.getElementById(AId);
    var e2 = document.getElementById(BId);
    var l1 = e1.value.length;
    (l1 > 500)?e1.value = e1.value.substring(0,500):e2.innerHTML = 500 - l1 
}
</script>
<form id="statusPost"  action="<?php echo(base_url()."updatestatus");?>" method="post">
    <div id="status-input-area" class="ui-corner-all"  >
        <a id="togle_status_text" style="font-size: large; font-weight: normal; color: #fff !important;">Tuliskan Sesuatu...</a>
        <div id="wraper_status" style="display: none;text-align: center;">
            <textarea id="status-input" class="cl_blue ui-corner-all"  onkeyup="LimitText('status-input','charleft')" name="status" id="status">Tuliskan Sesuatu...</textarea>
            <input type="hidden" name="tid" value="<?php echo  $this->encrypt->encode($id_wall_owner); ?>" />
            <div style="text-align: left;">
                <div class="span-15">
                    <label style="color: #fff;">Sisa Karater : </label>
                    <label id="charleft" style="color:#fff;font-weight:bold">500</label>
                </div>
          
                <div style="text-align: right; margin: 0 10px 10px 0;">
                    <input id="submit-status" type="submit" name="kirim" value="Kirim" id="kirim"/> 
                    <div id="loading" style="display: none;"><img src="<?php echo base_url();?>images/loading.gif" alt="Mengambil data..." /></div>
                </div>
            </div>
        </div>
    </div>
</form>