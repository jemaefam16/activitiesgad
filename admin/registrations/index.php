<style>
    @media print {
        .no-print, .dataTables_paginate {
            display: none;
        }
    }
</style>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Registration</h3>
        <div class="card-tools">
        <a href="javascript:void(0)" id="printButton" class="btn btn-lg btn-success mt-4"><span class="fas fa-print"></span> Print</a>
            </div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
        <table class="table table-hover table-bordered" id="list">
            <colgroup>
                <col width="5%">
                <col width="10">
                <col width="15">
                <col width="25">
                <col width="20">
                <col width="5">
                <col width="5">
                <col width="5">
                <col width="5">
                <col width="5">
                <col width="5">
            </colgroup>
            <thead>
                <tr style="text-align:center">
                    <th>No.</th>
                    <th>Date/Time</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Group Belong</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Activity</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody style="text-align:center">
                <?php 
                $i=1;
                    $qry = $conn->query("SELECT r.*,a.title,concat(u.firstname,' ',u.lastname) as name FROM registration_list r inner join `activities` a on a.id = r.activity_id inner join users u on u.id = r.user_id order by date(r.date_created) desc ");
                    while($row= $qry->fetch_assoc()):
                ?>
<tr>
    <td><?php echo $i++ ?></td>
    <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
    <td><b><?php echo $row['name'] ?><b></td>
    <td>
    <?php
    $gender = $row['gender'];

        if ($gender === 'Male') {
        echo 'Male';
        } elseif ($gender === 'Female') {
         echo 'Female';
        } elseif ($gender === 'LGBTQA') {
        echo 'LGBTQA';
        }
        ?>
    </td>
    <td>
    <?php
    $category = $row['category'];

        if ($category === 'Solo Parent') {
        echo 'Solo Parent';
        } elseif ($category === 'PWD') {
         echo 'PWD';
        } elseif ($category === 'ERPAT') {
        echo 'ERPAT';
        } elseif ($category === 'Women') {
        echo 'Women';
        } elseif ($category === 'Children') {
        echo 'Children';
        } elseif ($category === 'None') {
            echo 'None';
            }
        ?>
    </td>
    <td><?php echo $row['contact'] ?></td>
    <td><?php echo $row['address'] ?></td>
    <td><?php echo $row['title'] ?></td>
    <td><?php echo date('F j, Y', strtotime($row['schedule'])) ?></td>
    <td>
    <?php
        // Display "Done" if the status is "done"
        $status = $row['status'];
        if ($status === 'done') {
            echo 'Done';
        } else {
            // Display a checkbox if the status is not "done"
            echo '<input type="checkbox" name="status" value="checked" ' . ($status === 'checked' ? 'checked' : '') . '>';
        }
        ?>
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
    </div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this registration permanently?","delete_registration",[$(this).attr('data-id')])
		})
        $('.view_data').click(function(){
            uni_modal("Registration Information","registrations/view.php?id="+$(this).attr('data-id'))
        })
		$('.table').dataTable();
	})
	function delete_registration($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_registration",
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
