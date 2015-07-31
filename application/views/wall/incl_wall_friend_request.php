<?php
        if($friendStatus=='RQ'){?>
            <div id="request-friend-wraper">
                <p class="bold cl_blue">Menunggu Konfirmasi</p>
            </div>
        <?php }
        else if($friendStatus=='RQd'){?>
            <div id="request-friend-wraper">
                <button class="btn-request-friend" onclick="requestFriend('<?php echo($profile['id_encrypt']); ?>')">Terima Permintaan</button>
                <button class="btn-request-friend" onclick="requestIgnore('<?php echo($profile['id_encrypt']); ?>')">Abaikan Permintaan</button>
            </div>
            <script type="text/javascript">
                 function requestFriend(tid){
                    $.ajax({
                    type: "POST", 
                    url : "<?php echo base_url();?>friend/request/acc",
                    cache: false,
                    dataType : "json",
                    data : 'tid='+tid,
                    success: function(data){
                        $('#request-friend-wraper').html(data);
                        }
                    });
                 }
                 
                 function requestIgnore(tid){
                    $.ajax({
                    type: "POST", 
                    url : "<?php echo base_url();?>friend/request/ignore",
                    cache: false,
                    dataType : "json",
                    data : 'tid='+tid,
                    success: function(data){
                        $('#request-friend-wraper').html(data);
                        }
                    });
                 }
            </script>
        <?php }
        else if($friendStatus==false ){?>
        <div id="request-friend-wraper">
            <button class="btn-request-friend" onclick="requestFriend('<?php echo($profile['id_encrypt']); ?>')">Tambahkan Jadi Teman</button>
        </div>
            <script type="text/javascript">
                 function requestFriend(tid){
                    $.ajax({
                    type: "POST", 
                    url : "<?php echo base_url();?>friend/request",
                    cache: false,
                    dataType : "json",
                    data : 'tid='+tid,
                    success: function(data){
                        $('#request-friend-wraper').html(data);
                        }
                    });
                 };
            </script>
            <?php
        }
        else if($friendStatus=='Y'){?>
        <div id="request-friend-wraper">
            <button class="btn-request-friend" onclick="deleteFriend('<?php echo($profile['id_encrypt']); ?>')">Hapus Pertemanan</button>
        </div>
        <script type="text/javascript">
                 function deleteFriend(tid){
                    $.ajax({
                    type: "POST", 
                    url : "<?php echo base_url();?>friend/delete",
                    cache: false,
                    dataType : "json",
                    data : 'tid='+tid,
                    success: function(data){
                        $('#request-friend-wraper').html(data);
                        }
                    });
                 };
          </script>
        <?php
        }
      ?>  