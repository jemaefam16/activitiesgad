<?php
include '../../config.php';
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `users` where id = '{$_GET['id']}' ");
    foreach($qry->fetch_assoc() as $k => $v){
        $$k = $v;
    }
    $conn->query("UPDATE `users` set `status` = 0 where id = '{$_GET['id']}' ");

}
?>
<style>
    #uni_modal .modal-content>.modal-footer{
        display:none;
    }
</style>
<p><b>First Name</b> <?php echo ucwords($firstname) ?></p>
<p><b>Last Name</b> <?php echo $lastname ?></p>
<p><b>Username</b> <?php echo $username ?></p>
<div class="modal-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>

<script>
    $(function(){
        $('#user-status').submit(function(e){
            e.preventDefault();
            start_loader()
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_user",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        location.reload()
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                    }
                    end_loader()
                }
            })
        })
    })
</script>