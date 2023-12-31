<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Announcements</h3>
		<div class="card-tools">
			<a href="?page=announcement/manage" class="btn btn-lg btn-primary"><span class="fas fa-plus"></span>  Create New</a>
			<a href="javascript:void(0)" id="printButton" class="btn btn-lg btn-success no-print"><span class="fas fa-print"></span> Print</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="35%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>No.</th>
						<th>Date Created</th>
						<th>About</th>
						<th>Announcements</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `announcement` order by date(date_created) desc ");
						while($row = $qry->fetch_assoc()):
                            $row['announcements'] = strip_tags(stripslashes(html_entity_decode($row['announcements'])));
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['about'] ?></td>
							<td ><p class="truncate-1 m-0"><?php echo $row['announcements'] ?></p></td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success">Done</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Upcoming</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=announcement/manage&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
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
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this announcement permanently?","delete_announcement",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_announcement($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_announcement",
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
