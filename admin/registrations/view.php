<?php
include '../../config.php';
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT r.*,a.title,concat(u.firstname,' ',u.lastname) as name 
    FROM registration_list r inner join `activities` a on a.id = r.activity_id inner join users u on u.id = r.user_id where r.id = '{$_GET['id']}' ");
    foreach($qry->fetch_assoc() as $k => $v){
        $$k = $v;
    }
}
?>
<style>
    #uni_modal .modal-content>.modal-footer{
        display:none;
    }
</style>
<p><b>Name:</b> <?php echo $name ?></p>
<p><b>Gender:</b> <?php echo $gender ?></p>
<p><b>Group Belong:</b> <?php echo $category ?></p>
<p><b>Contact:</b> <?php echo $contact ?></p>
<p><b>Address:</b> <?php echo $address ?></p>
<p><b>Activity:</b> <?php echo $title ?></p>
<p><b>Schedule:</b> <?php echo strftime('%B %e, %Y', strtotime($schedule)) ?></p>
<p><b>Status:</b>   <?php 
        $status = $status;
        if ($status === 'done') {
            echo 'Done';
        } else {
            // Display a checkbox if the status is not "done"
            echo '<input type="checkbox" name="status" value="checked" ' . ($status === 'checked' ? 'checked' : '') . '>';
        }
?>
<div class="modal-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">Back</button>
</div>
