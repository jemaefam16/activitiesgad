<?php
include("db.php");

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'upload') {
        // Handle uploading a new staff member (similar to the existing code)
        if (empty($_FILES['photo']['name'])) {
            $msz = "Please select a staff image to upload.";
        } else {
            $name = $_POST['name'];
            $contact_info = $_POST['contact_info'];
            $address = $_POST['address'];

            $photo_name = $_FILES['photo']['name'];
            $photo_type = $_FILES['photo']['type'];
            $temp_name = $_FILES['photo']['tmp_name'];
            $photo_size = $_FILES['photo']['size'];

            $file_destination = "../uploads/" . $photo_name;

            if (move_uploaded_file($temp_name, $file_destination)) {
                $q = "INSERT INTO staff (name, contact_info, address, photo) VALUES ('$name', '$contact_info', '$address', '$photo_name')";

                if (mysqli_query($conn, $q)) {
                    $success = "Staff added successfully.";
                } else {
                    $failed = "Something went wrong.";
                }
            }
        }}
    }

$q = "SELECT * FROM staff";
$query = mysqli_query($conn, $q);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Information</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <style>
        .staff-frame {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            margin: 10px;
            background-color: #7FC0EC;
        }
        .staff-image {
            display: block;
            margin: 0 auto;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        a.delete_data {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <h1 class="text-center mb-5"><b>Staff Information</b></h1>
        <div class="col-lg-8 m-auto">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label><strong>Staff Name:</strong></label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label><strong>Contact Info:</strong></label>
                    <textarea name="contact_info" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label><strong>Address:</strong></label>
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="form-group">
                    <label><strong>Add a staff photo:</strong></label>
                    <input type="file" name="photo" class="form-control">
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
                <input type="hidden" name="action" value="upload">
                <input type="submit" name="submit" value="Upload" class="btn btn-success"> 
            </form>
        </div>
    </div>

    <div class="container mt-3 mb-3">
        <h1><b>Display All Staff Members</b></h1>
        <hr>
        <div class="row">
            <?php
            if ($query) {
                while ($row = mysqli_fetch_array($query)) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $contact_info = $row['contact_info'];
                    $address = $row['address'];
                    $photo = "../uploads/" . $row['photo'];
                    ?>
                    <div class="col-md-4">
                        <div class="staff-frame" style="background-color: #7FC0EC;">
                            <img class="staff-image" src="<?php echo $photo; ?>" alt="<?php echo $name; ?>" width="100"><br>
                            <p style="margin: 0; padding:0;"><strong>Name:</strong> <?php echo $name; ?></p>
                            <p style="margin: 0; padding:0;"><strong>Contact Info:</strong> <?php echo $contact_info; ?></p>
                            <p style="margin: 0; padding:0;"><strong>Address:</strong> <?php echo $address; ?></p><br>
                            <form action="" method="post">
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
            _conf("Are you sure to delete this staff permanently?", "delete_staff", [$(this).attr('data-id')])
        })

    })

    function delete_staff($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_staff",
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
