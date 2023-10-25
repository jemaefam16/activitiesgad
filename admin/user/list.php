<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Registered Users</h3>
        <div class="card-tools">
        <a href="javascript:void(0)" id="printButton" class="btn btn-lg btn-success mt-4"><span class="fas fa-print"></span> Print</a>
            </div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
        <table class="table table-stripped text-dark">
            <colgroup>
                <col width="10%">
                <col width="20%">
                <col width="25%">
                <col width="25%">
                <col width="10%">
            </colgroup>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i=1;
                    $qry = $conn->query("SELECT * FROM `users` order by date(date_updated) desc ");
                    while($row= $qry->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $row['firstname'] ?></td>
                        <td><?php echo $row['lastname'] ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td class="text-center status">
                            <?php if($row['status'] == 0): ?>
                                <span class="badge badge-warning">Registered</span>
                            <?php elseif($row['status'] == 1): ?>
                                <span class="badge badge-success">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-file text-primary"></span> View</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this user permanently?","delete_user",[$(this).attr('data-id')])
		})
        $('.view_data').click(function(){
            uni_modal("User","user/view.php?id="+$(this).attr('data-id'))
            $(this).closest('tr').find('.status').html('<span class="badge badge-success">Registered</span>')
        })
		$('.table').dataTable();
	})
	function delete_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_user",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>

    <script>
        $(document).ready(function(){
            $('#printButton').click(function() {
                window.print();
            });
        });
    </script>
