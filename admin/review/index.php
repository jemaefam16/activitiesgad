<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Evaluations</h3>
        <div class="card-tools">
                <a href="javascript:void(0)" id="printButton" class="btn btn-flat btn-primary no-print"><span class="fas fa-print"></span> Print</a>
            </div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
        <table class="table table-hover table-bordered" id="list">
            <colgroup>
                <col width="10%">
                <col width="10%">
                <col width="25%">
                <col width="15%">
                <col width="30%">
                <col width="10%">
            </colgroup>
            <thead>
                <tr style="text-align:center">
                    <th>No.</th>
                    <th>Date/Time</th>
                    <th>Details</th>
                    <th>Rate</th>
                    <th>Evaluation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody style="text-align:center">
                <?php 
                $i=1;
                    $qry = $conn->query("SELECT r.*,concat(u.firstname,' ',u.lastname) as name, p.title FROM `rate_review` r inner join users u on .u.id = r.user_id inner join `activities` p on p.id = r.activity_id order by unix_timestamp(r.date_created) desc ");
                    while($row= $qry->fetch_assoc()):
                        $row['review'] = strip_tags(stripslashes(html_entity_decode($row['review'])));
                ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                        <td>
                            <p class="m-0"><b>User:</b> <?php echo  ucwords($row['name']) ?></p>
                            <p class="m-0"><b>Activity:</b> <?php echo  ucwords($row['title']) ?></p>
                        </td>
                        <td><p class="truncate-1 m-0"><?php echo $row['rate'] ?></p></td>
                        <td><p class="truncate-1 m-0" title="<?php echo $row['review'] ?>"><?php echo $row['review'] ?></p></td>
                        <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
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
			_conf("Are you sure to delete this feedback permanently?","delete_review",[$(this).attr('data-id')])
		})
        
		$('.table').dataTable();
	})
	function delete_review($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_review",
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
