<style>
    @media print {
        .no-print, .dataTables_paginate {
            display: none;
        }
    }
</style>
<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
    </script>
<?php endif; ?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Attendees</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" id="printButton" class="btn btn-lg btn-success mt-4"><span class="fas fa-print"></span> Print</a>
        </div>
    </div>

    <div class="card-body">
    <div class="container-fluid">
        <table class="table table-hover table-bordered" id="list">
            <thead>
                <tr style="text-align:center">
                    <th>No.</th>
                    <th>Date Created</th>
                    <th>Name</th>
                    <th>Registration Details</th>
                    <th>Event</th>
                    <th>Status</th>
                    <th>Attendance Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody style="text-align:center">
                <?php
                $i=1;
                $qry = $conn->query("SELECT t.*, a.title, CONCAT(u.firstname, ' ', u.lastname) AS name,
                                    CONCAT('<strong>Gender:</strong> &nbsp', r.gender,'<br><strong>Group Belong:</strong> &nbsp', r.category, '<br><strong>Contact:</strong>&nbsp', r.contact, '<br><strong>Address:</strong>&nbsp', r.address, '<br><strong>Status:</strong>&nbsp', CONCAT(UCASE(LEFT(r.status, 1)), LCASE(SUBSTRING(r.status, 2)))) AS registration_data
                                    FROM attendance_list t
                                    INNER JOIN `activities` a ON a.id = t.activity_id
                                    INNER JOIN users u ON u.id = t.user_id
                                    INNER JOIN registration_list r ON r.id = t.user_id
                                    ORDER BY DATE(t.date_created) DESC");
                while ($row = $qry->fetch_assoc()):
                ?>
                <tr>
                    <td class="text-center"><?php echo $i++ ?></td>
                    <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                    <td><b><?php echo ucwords($row['name']) ?></b> <span>
                    <td style="text-align:left"><?php echo $row['registration_data'] ?> </td>
                    <td><?php echo ucwords($row['title']) ?></td>
                    <td>
                        <?php
                        // Display "Present" if the status is "done"
                        $status = $row['status'];
                        if ($status === 'Present') {
                            echo 'Present';
                        } else {
                            // Display a checkbox if the status is not "present"
                            echo '<input type="checkbox" name="status" value="checked" ' . ($status === 'checked' ? 'checked' : '') . '>';
                        }
                        ?>
                    </td>
                    <td><?php echo date("Y-m-d", strtotime($row['attendance_date'])) ?></td>
                    <td align="center">
                        <button type="button"
                            class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            Action
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item view_data" href="javascript:void(0)"
                                data-id="<?php echo $row['id'] ?>"><span class="fa fa-file text-primary"></span> View</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item delete_data" href="javascript:void(0)"
                                data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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
    $(document).ready(function () {
        $('.delete_data').click(function () {
            _conf("Are you sure to delete this attendance permanently?", "delete_attendance", [$(this).attr('data-id')])
        })
        $('.view_data').click(function () {
            uni_modal("Attendance Information", "attendance/view.php?id=" + $(this).attr('data-id'))
        })
        $('.table').dataTable();
    })

    function delete_attendance($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_attendance",
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

<script>
    $(document).ready(function () {
        $('#printButton').click(function () {
            window.print();
        });
    });
</script>



