<script>
var edited = new Array;

function startEdit(divId,type){
    if(edited[divId]!=true){
    $.ajax({
			type: 'POST',
			url: 'profile/startedit',
			data: {'type' : type},
            dataType : 'json',
			success: function(data) {
                 $("#profile-input-"+divId).html(data.data);
                 input = new Array;
                 i=0;
                 $.each(data.input, function(index, value) {  
                     input[i] = value;
                     i++;
                 })
                 edited[divId] = true;
                 $("#profile-action-"+divId).append( '<a id="link-save-'+divId+'" onclick="saveEdit(\''+divId+'\',\''+type+'\',\''+input[0]+'\',\''+input[1]+'\',\''+input[2]+'\')">Simpan | </a>'+
                    '<a id="link-cancel-'+divId+'" onclick="cancelEdit(\''+divId+'\')">Batal</a>');          
			}
		})
    }
    $("#link-edit-"+divId).hide();
    $("#link-save-"+divId).show();
    $("#link-cancel-"+divId).show()
    
    $("#profile-data-"+divId).hide();
    $("#profile-input-"+divId).show(); 
};

function cancelEdit(divId){
    $("#link-edit-"+divId).show();
    $("#link-save-"+divId).hide();
    $("#link-cancel-"+divId).hide();
    
    
    $("#profile-data-"+divId).show();
    $("#profile-input-"+divId).hide();  
};

function saveEdit(divId, type, data1, data2, data3){
    data_input = new Array;
    data_input[0] = $("#"+data1).val();
    data_input[1] = $("#"+data2).val();
    data_input[2] = $("#"+data3).val();
    
    $.ajax({
			type: 'POST',
			url: 'profile/save',
			data: {'data' : data_input ,'type':type},
            dataType : 'json',
			success: function(data) {
		      if(data.error !='true'){
                $.each(data, function(index, value) {
                    $("#profile-data-"+divId).text(value);
                })
                $("#profile-data-"+divId).show();
                $("#profile-input-"+divId).hide();
                
                $("#link-edit-"+divId).show();
                $("#link-save-"+divId).hide();
                $("#link-cancel-"+divId).hide();
                
              }else{alert(data.message); } 
			}
    })

};

</script>
<style type="text/css">
<!--
#table-profile tr{
    height: 40px;
    width: 80%;
}

.profile-title{
}

.profile-content{
    max-width: 450px;
}
.profile-action{
    float: right;
}

.profile-input{
    display: none;
}
-->
</style>
<div id="profile-area">
</div>

<div id="content_title" class="cl_orange bold font_16px">Data Tentang Kamu</div>
    <hr class="space" />
    <div style="width:100%;">
    <hr />

<?php
//<table width="500px">
$CI =& get_instance();

$CI->load->library('table');

$tmpl = array (
                    'table_open'          => '<table id="table-profile" border="0" cellpadding="4" cellspacing="0">',
                    
                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'table_close'         => '</table>'
              );

$CI->table->set_template($tmpl);


$title=array(   'Nama Lengkap', 'Email', 'Password', 'Tanggal Lahir','Jenis Kelamin', 
                'Alamat', 'Kota', 'Negara', 'Kelas', 'Sekolah', 'Tentang Kamu');

$index=array(   'realname', 'email', 'password', 'birthday','gender', 
                'address', 'city', 'country', 'occupation', 'work_at', 'about_me');

$count = count($index);
for($i=0;$i<$count;$i++){
    $index_encrypt = $this->encrypt->encode($index[$i]);
    $index_encrypt = urlencode($index_encrypt);
    $cell_title='<div class="profile-title wrapword">'.$title[$i].'</div>';
    
    if(empty($profile[$index[$i]])){
        $profile[$index[$i]]='<span class="cl_gray">Belum Terisi</span>';
    }
    
    $cell_data = '<div id="profile-data-'.$i.'" class="profile-content wrapword">'.$profile[$index[$i]].'</div>';
    $cell_data = $cell_data.'<div id="profile-input-'.$i.'" class="profile-input"></div>';
    
    $cell_action = '<div id="profile-action-'.$i.'" class="profile-action"><a id="link-edit-'.$i.'" onclick="startEdit(\''.$i.'\',\''.$index_encrypt.'\')">Ubah</a></div>';
     
    $CI->table->add_row($cell_title, $cell_data, $cell_action);
}
echo $CI->table->generate();
?>
</table>
</div>