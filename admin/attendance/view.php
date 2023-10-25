<?php
include '../../config.php';
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT t.*, a.title, CONCAT(u.firstname, ' ', u.lastname) as name, 
    CONCAT('Gender: ', r.gender,'<br>Group Belong: ', r.category, '<br>Contact: ', r.contact, '<br>Address: ', r.address, '<br>Status: ', r.status) AS registration_data
    FROM attendance_list t
    INNER JOIN `activities` a ON a.id = t.activity_id 
    INNER JOIN users u ON u.id = t.user_id 
    INNER JOIN registration_list r ON t.user_id = r.user_id
    WHERE t.id = '{$_GET['id']}'");


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
<p><b>Attendee:</b> <?php echo $name ?></p>
<p><b>Activity:</b> <?php echo $title ?></p>
<p><b>Registration Details:</b> <br><?php echo $registration_data ?></p>
<p><b>Schedule:</b> <?php echo date("F d, Y", strtotime($attendance_date)) ?></p>
<p><b>Status:</b>   <?php 
        $status = $status;
        if ($status === 'Present') {
            echo 'Present';
        } else {
            // Display a checkbox if the status is not "done"
            echo '<input type="checkbox" name="status" value="checked" ' . ($status === 'checked' ? 'checked' : '') . '>';
        }
       
?>
<div class="modal-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">Back</button>
</div>
