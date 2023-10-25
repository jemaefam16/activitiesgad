<style>
    @media print {
        .no-print, .dataTables_paginate {
            display: none;
        }
    }
</style>
<?php
$activity_id = isset($_GET['eid'])? $_GET['eid'] : '';
$selectedGender = isset($_GET['gender']) ? $_GET['gender'] : 'all';
?>
<style>
.alert{
 border: 1px solid #f9000059;
 background-color: #f9000059
}
</style>
<div class="col-md-12">
 <div class="card card-outline card-primary">
  <div class="card-body">
   <form action="" id="filter-frm">
   <div class="col-md-12">
    <div class="row">
     <div class="col-sm-3">
      <div class="form-group" style="font-size:16px;">
       <label for="activity_id">Activity</label>
       <select name="activity_id" id="activity_id" class="custom-select custom-select-sm select2">
        <?php
         $activity= $conn->query("SELECT * FROM activities order by title asc");
         while($row=$activity->fetch_assoc()):
          if(empty($activity_id))
          $event_id = $row['id'];
        ?>
        <option value="<?php echo $row['id'] ?>" <?php echo $activity_id == $row['id'] ? 'selected' : '' ?>><?php echo(ucwords($row['title'])) ?></option>
       <?php endwhile; ?>
       </select>
      </div>
     </div>
     <div class="col-sm-3">
     <label for="gender">Gender</label>
<select name="gender" id="gender" class="custom-select custom-select-sm select2">
    <option value="all" <?php echo $selectedGender === 'all' ? 'selected' : '' ?>>All</option>
    <option value="male" <?php echo $selectedGender === 'male' ? 'selected' : '' ?>>Male</option>
    <option value="female" <?php echo $selectedGender === 'female' ? 'selected' : '' ?>>Female</option>
    <option value="lgbtqa" <?php echo $selectedGender === 'lgbtqa' ? 'selected' : '' ?>>LGBTQA</option>
</select>
         </div>
     <div class="col-sm-2 text-center">
         <button class="btn btn-lg btn-primary mt-4"><i class="fa fa-filter"></i> Filter</button>
         <a href="javascript:void(0)" id="printButton" class="btn btn-lg btn-success mt-4"><span class="fas fa-print"></span> Print</a>
      </div>
     </div>
   </div>
   </form>
   <hr class="border-primary">
   <div id="report-tbl-holder">
    <h4 class="text-center">Report</h4>
    <hr>
    <?php
    
$activity_id = isset($_GET['eid']) ? $_GET['eid'] : '';

// Define default values for activity details
$title = '';
$event_location = '';

if (!empty($activity_id)) {
    $qry = $conn->query("SELECT * FROM activities where id = '$activity_id'");
    if ($qry && $qry->num_rows > 0) {
        $activity = $qry->fetch_assoc();
        $title = $activity['title'];
        $event_location = $activity['event_location'];
    
    } else {
        // Handle the case when the activity with the given ID is not found
    }
}
?>
    <div class="callout">
    <div class="row">
        <div class="col-md-6">
            <dl>
                <dt>Activity Title:</dt>
                <dd><?php echo $title ?></dd>
            </dl>
            <dl>
                <dt>Location:</dt>
                <dd><?php echo $event_location ?></dd>
            </dl>
        </div>
    </div>
 <div>
<?php
     if ($conn) {
      // Construct the SQL query based on the selected activity
      $sql = "SELECT r.*, CONCAT(u.firstname, ' ', u.lastname) AS name, r.gender, r.address, r.contact,
      t.status AS attendance_status
      FROM registration_list r
      INNER JOIN users u ON u.id = r.user_id
      LEFT JOIN attendance_list t ON r.user_id = t.user_id AND r.activity_id = t.activity_id
      WHERE r.activity_id = '{$activity_id}'";
     
      // Check if a specific gender is selected, and include it in the query if not "all"
      if ($selectedGender !== 'all') {
       $sql .= " AND r.gender = '{$selectedGender}'";
      }
     
      $sql .= " ORDER BY r.id ASC";
     
      $result = $conn->query($sql);

        if ($result) {
            $i = 1; // Initialize $i here

            // Start the table
            echo '<table id="report-tbl" class="table table-stripped table-bordered">';
            echo '<thead>';
            echo '<tr style="text-align: center">';
            echo '<th>No.</th>';
            echo '<th>Date/Time</th>';
            echo '<th>Name</th>';
            echo '<th>Gender</th>';
            echo '<th>Address</th>';
            echo '<th>Contact</th>';
            echo '<th> Registration Status</th>';
            echo '<th> Attendance Status</th>';
            echo '<th> Evaluation Status</th>';
            echo '<th> Issue Certificate</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            if ($result->num_rows <= 0) {
                echo '<tr><th class="text-center" colspan="6">No Data.</th></tr>';
            } else {
			while ($row = $result->fetch_assoc()) {
			// Check if the user has an evaluation status for the activity
			$evaluationStatus = 'Not Evaluated'; // Default status
			$evaluationCheckQuery = $conn->query("SELECT * FROM rate_review WHERE user_id = '{$row['user_id']}' AND activity_id = '{$activity_id}'");
			    if ($evaluationCheckQuery->num_rows > 0) {
				    $evaluationStatus = 'Evaluated'; // User has evaluated
					}
																	
			$issueCertificateChecked = false; // Initialize the checkbox as unchecked by default

			// Check if the user has "done" status in registration
			if ($row['status'] === 'done') {
   		     // Check if the user is present in attendance_list
   			if ($row['attendance_status']) {
        	// Check if the user has evaluated the activity in rate_review
        	if ($evaluationStatus === 'Evaluated') {
         	$issueCertificateChecked = true; // All conditions met, checkbox checked
        	}
    }
}
                    echo '<tr style="text-align: center">';
                    echo '<td class="text-center">' . $i++ . '</td>';
                    echo '<td>' . date("M d, Y h:i A", strtotime($row['date_created'])) . '</td>';
                    echo '<td>' . ucwords($row['name']) . '</td>';
                    echo '<td>' . ucwords($row['gender']) . '</td>';
                    echo '<td>' . ucwords($row['address']) . '</td>';
                    echo '<td>' . ucwords($row['contact']) . '</td>';
                    echo '<td>' . ucwords($row['status']) . '</td>';
                    echo '<td>' . ($row['attendance_status'] ? 'Present' : 'Not Present') . '</td>';
					echo '<td>' . $evaluationStatus . '</td>'; 
					$checkboxStyle = $issueCertificateChecked ? 'style="color: red;"' : '';
                    $checkboxIcon = $issueCertificateChecked ? '<i class="fas fa-check"></i>' : ''; // 
                    $checkboxInput = $issueCertificateChecked ? 'style="display: none;"' : ''; // Hide the checkbox input when checked
                    echo '<td><label ' . $checkboxStyle . '><input type="checkbox" ' . $checkboxInput . ($issueCertificateChecked ? 'checked' : '') . ' disabled>' . $checkboxIcon . '</label></td>';
                    echo '</tr>';
                }
            }

												echo '</tbody>';
												echo '</table>';
                        } else {
												echo 'Query error: ' . $conn->error;
								}
				} else {
								echo 'Query error: ' . $conn->error;
				}
				?>

<noscript>
  <style>
   table{
    border-collapse:collapse;
    width: 100%;
   }
   tr,td,th{
    border:1px solid black;
   }
   td,th{
    padding: 3px;
   }
   .text-center{
    text-align: center;
   }
   .text-right{
    text-align: right;
   }
   p{
    margin: unset;
   }
   .alert{
    border: 1px solid #f9000059;
    background-color: #f9000059
   }
  </style>
 </noscript>
	</div>
</div> 
		</div>
		<div>
 <script>
   $(document).ready(function () {
        $('#printButton').click(function () {
            window.print();
        });
    });
  $(document).ready(function () {
    $('.select2').select2();
    $('#filter-frm').submit(function (e) {
        e.preventDefault();

        // Get the selected values for activity and gender
        var activityId = $('#activity_id').val();
        var gender = $('#gender').val();

        // Construct the URL with both activity and gender parameters
        var filterUrl = _base_url_ + 'admin/?page=reports&eid=' + activityId;

        // Append the gender parameter if it's not "all"
        if (gender !== 'all') {
            filterUrl += '&gender=' + gender;
        }

        // Redirect to the filtered URL
        location.replace(filterUrl);
    });
});

 </script>

