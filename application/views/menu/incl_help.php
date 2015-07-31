<style type="text/css">
<!--
	#help-area{
	   max-height: 500px;
       
	}
    .accordion{
        max-width: 95%;
    }
-->
</style>

<script type="text/javascript">
    $(function(){
    $("#help-open").click(function(){
        $("#help-area").dialog("open");
    });
    $(".accordion").accordion({ header: "h3" });
    $('#tabs').tabs();

    $("#help-area").dialog({
        title : 'Bantuan Dinua',
        autoOpen: false,
        modal : true,
        width: 900,
        height : 500,
        buttons: {
            "Tutup": function() {
               $(this).dialog("close");
            }
        }
    });
    });
</script>

    <div id="help-area">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Foto</a></li>

                <li><a href="#tabs-2">e-Book</a></li>

                <li><a href="#tabs-3">e-Note</a></li>
            </ul>

            <div id="tabs-1" class="accordion">
                <div class="help-content">
                    <h3><a href="#">Unggah Foto</a></h3>

                    <div>
<ol>
	<li>Untuk melakukan unggah foto silahkan anda mengklik menu <strong>"Foto"</strong> pada menu sebelah kiri jendela anda.</li>
	<li>Pada jendela Foto Album klik tombol <strong>"Buat Album Baru"</strong>, dan masukan <strong>"Nama Album"</strong> serta <strong>"Deskripsi"</strong> album baru yang akan anda buat. Klik <strong>"Simpan"</strong> untuk menyimpan.</li>
    <li>Klik album baru yang anda buat.</li> 
    <li>Pada jendela album baru klik tombol tambah untuk mulai mengunggah.</li>
    <li>Klik tombol pilih berkas untuk mulai mencari berkas.</li>
    <li>Setelah berkas terpilih, klik Upload untuk mengunggah.</li>
    <li>Foto anda telah berhasil diunggah.</li>
</ol>
<em>Catatatan:<br />
Ukuran berkas tidak boleh lebih dari 2MB.<br />
Mohon untuk tidak mengunggah foto yang bernilai negatif, pornografi, kasar dan menghina.</em>
                    </div>
                </div>

                <div>
                    <h3><a href="#">Merubah Foto Profil</a></h3>

                    <div>
<ol>
	<li>Untuk merubah Foto Profil, sebelumnya anda harus mengunggah (upload) foto yang akan anda jadikan foto profil.</li>
    <li>Bukalah foto tersebut dengan mengkliknya.</li>
    <li>Arahkan mouse (cursor) anda ke tengah foto yang tertampil.</li>
    <li>Pada kanan atas foto anda akan muncul tombol <strong>"Jadikan Foto Profil."</strong> Klik tombol tersebut untuk merubah foto profil.</li>
</ol>
<em>Catatatan:<br />
Anda hanya dapat menggunakan foto yang anda unggah, bukan foto teman anda.</em>
                    </div>
                </div>
            </div>

            <div id="tabs-2">
                <h4>Saat Ini e-Book Belum Dapat Digunakan</h4>
            </div>

            <div id="tabs-3">
                Bantua ini Belum Terisi
            </div>
        </div>
    </div>
