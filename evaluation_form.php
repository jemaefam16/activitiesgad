<style>
    #uni_modal .modal-content > .modal-footer {
        display: none;
    }

    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    .rating-box {
        position: relative;
        background: #fff;
        padding: 25px 50px 35px;
        border-radius: 25px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
    }

    .rating-box header {
        font-size: 22px;
        color: #dadada;
        font-weight: 500;
        margin-bottom: 20px;
        text-align: center;
    }

    .rating-box .stars {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .stars i {
        color: #e6e6e6;
        font-size: 35px;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .stars i.active {
        color: orange;
    }
</style>

<?php
require_once('config.php');
$evaluationFormVisible = false;
$evaluationMessage = '';
$evaluationAlreadySubmitted = false; // Initialize the flag for previous evaluation as false

if (isset($_GET['activity_id'])) {
    $user_id = $_settings->userdata('id');
    $activity_id = $_GET['activity_id'];

    $registration_query = $conn->query("SELECT * FROM registration_list WHERE user_id = $user_id AND activity_id = $activity_id");
    $attendance_query = $conn->query("SELECT * FROM attendance_list WHERE user_id = $user_id AND activity_id = $activity_id");

    if ($registration_query->num_rows > 0 && $attendance_query->num_rows > 0) {
        // Both registration and attendance are completed, so check if an evaluation has been submitted
        $evaluation_check_query = $conn->query("SELECT * FROM rate_review WHERE user_id = $user_id AND activity_id = $activity_id");

        if ($evaluation_check_query->num_rows > 0) {
            // Evaluation is already submitted, so set the flag to true
            $evaluationAlreadySubmitted = true;
            
            // Display an error message
            $evaluationMessage = "You have already submitted your evaluation for this activity.";
        } else {
            // Evaluation has not been submitted, so allow the user to evaluate
            $evaluationFormVisible = true;
        }
    } else {
        $evaluationMessage = "You need to complete registration and attendance to evaluate this activity.";
    }
}
?>

<div class="container-fluid">
    <?php if ($evaluationFormVisible): ?>
        <form action="" id="rate-review">
            <input name="activity_id" type="hidden" value="<?php echo $_GET['activity_id'] ?>">
            <div class="form-group">
                <label for="" class="control-label">Rate:</label>
                <input type="hidden" name="rate" id="rate" value="0">
                <div class="rating-box">
                    <header stle="color:black;">How was your experience?</header>
                    <div class="stars" >
                        <i class="fas fa-star" data-value="1"></i>
                        <i class="fas fa-star" data-value="2"></i>
                        <i class="fas fa-star" data-value="3"></i>
                        <i class="fas fa-star" data-value="4"></i>
                        <i class="fas fa-star" data-value="5"></i>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="review" class="control-label">Evaluation:</label>
                <textarea name="review" id="review" cols="30" rows="10" class="form form-control" required placeholder="Please evaluate the activity."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submit" onclick="$('#uni_modal form').submit()" style=" background-color:blue;">Submit</button>
                <button type="button" class="btn btn-danger" id="cancel" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-dark">
            <?php echo $evaluationMessage; ?>
        </div>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left:83%">Close</button></button>
    <?php endif; ?>
</div>
<script>
    const stars = document.querySelectorAll(".stars i");
    const rateInput = document.getElementById("rate");

    stars.forEach((star) => {
        star.addEventListener("click", () => {
            const value = parseInt(star.getAttribute("data-value"));
            rateInput.value = value;
            stars.forEach((s, index) => {
                if (index < value) {
                    s.classList.add("active");
                } else {
                    s.classList.remove("active");
                }
            });
        });
    });

    $(function () {
    $('#rate-review').submit(function (e) {
        e.preventDefault();
        const reviewTextarea = document.getElementById("review");

        // Check if the evaluation is already submitted
        const submitted = <?php echo $evaluationAlreadySubmitted ? 'true' : 'false'; ?>;

        if (reviewTextarea.value.trim() === "") {
            // Trigger the validation modal
            $('#validationModal').modal('show');
            return; // Prevent form submission if textarea is empty
        }
        if (submitted) {
            // Display a message to inform the user that the evaluation is already submitted
            $('#evaluationSubmittedModal').modal('show');
            return; // Prevent form submission if evaluation is already submitted
        }
            start_loader();

            // Add the selected rating to the form data
            const formData = new FormData(this);
            formData.append('rate', $('input[name="rate"]').val());

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=rate_review",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", "error");
                    end_loader();
                },
                success: function (resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        alert_toast("Rate and Evaluation Successfully submitted.");
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        console.log(resp);
                        alert_toast("An error occurred", "error");
                        end_loader();
                    }
                }
            });
        });
    });
</script>
