<?php
require_once('config.php');
$attendanceFormVisible = false; // Initialize the variable as false

if (isset($_GET['activity_id'])) {
    // Check if the user is already attended for this activity
    $user_id = $_settings->userdata('id');
    $activity_id = $_GET['activity_id'];

    $existing_attendance = $conn->query("SELECT * FROM attendance_list WHERE user_id = $user_id AND activity_id = $activity_id");

    if ($existing_attendance->num_rows == 0) {
        // The user is not yet attended, check if they are registered
        $registration_query = $conn->query("SELECT * FROM registration_list WHERE user_id = $user_id AND activity_id = $activity_id");

        if ($registration_query->num_rows > 0) {
            // User is registered, display the attendance form
            $attendanceFormVisible = true;
        } else {
            $attendanceMessage = "You must register first to fill out this form.";
        }
    } else {
        $attendanceMessage = "You already attended for this activity.";
    }
}
?>

<div class="container-fluid">
<?php if ($attendanceFormVisible): ?>
    <form action="" id="attendance-form">
        <?php
        $registration_query = $conn->query("SELECT r.*, CONCAT(u.firstname, ' ', u.lastname) AS name FROM registration_list r JOIN users u ON r.user_id = u.id WHERE r.user_id = $user_id AND r.activity_id = $activity_id");
        $registeredUser = $registration_query->fetch_assoc();
        ?>
        <div class="form-group">
        <input name="activity_id" type="hidden" value="<?php echo $_GET['activity_id'] ?>" >
        <input name="user_id" type="hidden" value="<?php echo $registeredUser['user_id'] ?>" >

        <label class="control-label">Name:</label>
            <input type="text" class="form-control form-control-sm form" name="name" value="<?php echo $registeredUser['name']; ?>" readonly>

            <label class="control-label">Address:</label>
            <input type="text" class="form-control form-control-sm form" name="address" value="<?php echo $registeredUser['address']; ?>" readonly>

            <label class="control-label">Gender:</label>
            <input type="text" class="form-control form-control-sm form" name="gender" value="<?php echo $registeredUser['gender']; ?>" readonly>

            <label class="control-label">Group Belong:</label>
            <input type="text" class="form-control form-control-sm form" name="category" value="<?php echo $registeredUser['category']; ?>" readonly>

            <label class="control-label">Contact:</label>
            <input type="text" class="form-control form-control-sm form" name="address" value="<?php echo $registeredUser['contact']; ?>" readonly>

            <label class="control-label">Status:</label>
<input type="text" class="form-control form-control-sm form" name="status" value="<?php echo ($registeredUser['status'] == 'done') ? 'Done' : 'Not Done'; ?>" readonly>


           <div class="form-group">
    <label class="control-label">Status:</label>
   <div class="form-check">
        <input type="checkbox" class="form-check-input" name="status[]" value="Present" required>
        <label class="form-check-label">Present</label>
    </div>
            <label class="control-label">Attendance Date:</label>
            <input type="date" class='form form-control' required   name='attendance_date'>
</div>
    </form>
<?php else: ?>
    <div class="alert alert-dark">
    <p><?php echo $attendanceMessage; ?></p></div>
<?php endif; ?>
</div>
<script>
    document.getElementById("attendanceFormButton").addEventListener("click", function() {
        document.getElementById("attendanceFormPopup").style.display = "block";
    });
</script>

<script>
    $(function(){
        $('#attendance-form').submit(function(e){
            e.preventDefault();
            start_loader();
    
            console.log($(this).serialize());
    
            $.ajax({
                url: _base_url_+"classes/Master.php?f=act_attendance",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: resp => {
                    if (typeof resp === 'object' && resp.status === 'success') {
                        alert_toast("Attendance Successfully sent.");
                        $('.modal').modal('hide');
                    } else {
                        console.log(resp);
                        alert_toast("An error occurred", 'error');
                    }
                    end_loader();
                }
            });
        });
    });
</script>
