<?php
include("db.php");

if (isset($_POST['upload'])) {
    if (empty($_FILES['file']['name'])) {
        $msz = "Please select a video to upload..!";
    } else {
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $temp_name = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];

        $file_destination = "../uploads/" . $file_name;

        if (file_exists($file_destination)) {
            $failed = "A video with the same name already exists.";
        } elseif (move_uploaded_file($temp_name, $file_destination)) {
            $q = "INSERT INTO video (name) VALUES ('$file_name')";

            if (mysqli_query($conn, $q)) {
                $success = "Video uploaded successfully.";
            } else {
                $failed = "Something went wrong??";
            }
        }
    }
}
// Retrieve the list of videos from the database
$q = "SELECT * FROM video";
$query = mysqli_query($conn, $q);
?>



<!DOCTYPE html>
<html>
<head>
    <title>MSWDO Corcuera, Romblon Videos</title>
    <link rel="stylesheet" type="text/css" href="assets/css bootstrap.min.css">
</head>
<body>
    <div class="container mt-3">
        <h1 class="text-center mb-5"><b>MSWDO Corcuera, Romblon Videos</b></h1>
        <div class="col-lg-8 m-auto">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label><strong>Upload a Video:</strong></label>
                    <input type="file" name="file" class="form-control">
                </div>
                <?php if (isset($success)) { ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                <?php } ?>
                <?php if (isset($failed)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $failed; ?>
                    </div>
                <?php } ?>

                <?php if (isset($msz)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $msz; ?>
                    </div>
                <?php } ?>
                <input type="submit" name="upload" value="Upload" class="btn btn-primary ml-3">
            </form>
        </div>
    </div>

    <div class="container mt-3 mb-3">
        <h1><b>Display All Videos</b></h1>
        <hr>

        <div class="row">
    <?php
    if ($query) {
        while ($row = mysqli_fetch_array($query)) {
            $video_name = $row['name'];
            $video_name_without_extension = pathinfo($video_name, PATHINFO_FILENAME); // Get the name without the extension
            ?>
            <div class="col-md-4">&nbsp
                <div class="video-container">
                    <video width="100%" controls>
                        <source src="../uploads/<?php echo $video_name; ?>">
                    </video>
                    <p><?php echo $video_name_without_extension; ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="video_name" value="<?php echo $video_name; ?>">
                        <a class="dropdown-item delete_data" href="javascript:void(0)"
                        data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                    </form>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
    </div>
</body>
</html>

<script>
    $(document).ready(function () {
        $('.delete_data').click(function () {
            _conf("Are you sure to delete this video permanently?", "delete_video", [$(this).attr('data-id')])
        })

    })

    function delete_video($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_video",
            method: "POST",
            data: {
                id: $id
            },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        })
    }
</script>