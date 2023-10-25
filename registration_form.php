<?php
require_once('config.php');
$registrationFormVisible = true; // Initialize the variable as true

if (isset($_GET['activity_id'])) {
    // Check if the user is already registered for this activity
    $user_id = $_settings->userdata('id');
    $activity_id = $_GET['activity_id'];

    $existing_registration = $conn->query("SELECT * FROM registration_list WHERE user_id = $user_id AND activity_id = $activity_id");

    if ($existing_registration->num_rows > 0) {
        // You is already registered, hide the registration form
        $registrationFormVisible = false;
        $registrationMessage = "You are already registered for this activity.";
    }
}
?>

<div class="container-fluid">
<?php if ($registrationFormVisible): ?>
    <form action="" id="registration-form">
        <div class="form-group">
            <input name="activity_id" type="hidden" value="<?php echo $_GET['activity_id'] ?>" >

            <div class="form-group">
    <label class="control-label">Address:</label>
    <input type="text" class="form-control form-control-sm form" name="address" required>
</div>
<div class="form-group">
    <label class="control-label">Contact</label>
    <input type="text" class="form-control form-control-sm form" name="contact" required>
</div>
<div class="form-group">
    <label class="control-label">Gender:</label>
    <div class="form-check">
        <input type="radio" class="form-check-input" name="gender[]" value="Male" required>
        <label class="form-check-label">Male</label>
    </div>
    <div class="form-check">
        <input type="radio" class="form-check-input" name="gender[]" value="Female" required>
        <label class="form-check-label">Female</label>
    </div>
    <div class="form-check">
        <input type="radio" class="form-check-input" name="gender[]" value="LGBTQA" required>
        <label class="form-check-label">LGBTQA</label>
    </div>
    <div><br>
    <label class="control-label">Please Select Group Where You Belong:</label>
    <div class="form-dropdown">
        <select class="form-dropdown-option" name="category[]" required>
            <option value="Solo Parent">Solo Parent</option>
            <option value="PWD">PWD</option>
            <option value="ERPAT">ERPAT</option>
            <option value="Women">Women</option>
            <option value="Children">Children</option>
            <option value="Senior Citizen">Senior Citizen</option>
        </select>
    </div>
</div>

    <div><br>
    <label class="control-label">Schedule:</label>
   <input type="date" class='form form-control' required   name='schedule'>
</div><br>
<div class="form-group">
    <label class="control-label">Status:</label>
   <div class="form-check">
        <input type="checkbox" class="form-check-input" name="status[]" value="Done" required>
        <label class="form-check-label">Done</label>
    </div>
        </div>
    </form>
    <?php else: ?>
        <div class="alert alert-dark">
    <p><?php echo $registrationMessage; ?></p></div>
<?php endif; ?>
</div>
<script>
    $(function(){
    $('#registration-form').submit(function(e){
        e.preventDefault();
        start_loader();

        console.log($(this).serialize());

        $.ajax({
            url: _base_url_+"classes/Master.php?f=act_registration",
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
                    alert_toast("Registration Successfully sent.");
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
