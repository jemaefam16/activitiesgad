<?php
// Define a function to get the status label based on the status value
function getStatusLabel($status) {
    return $status ? 'Done' : 'Not Done';
}

// Define a function to get the attendance label based on the attendance status
function getAttendanceLabel($attendanceStatus) {
    return $attendanceStatus ? 'Present' : 'Not Present';
}

// Define a function to get the evaluation label based on the evaluation status
function getEvaluationLabel($user_id, $activity_id, $conn) {
    $evaluationStatus = 'Not Evaluated';
    $evaluationCheckQuery = $conn->query("SELECT * FROM rate_review WHERE user_id = '$user_id' AND activity_id = '$activity_id'");
    if ($evaluationCheckQuery->num_rows > 0) {
        $evaluationStatus = 'Evaluated';
    }
    return $evaluationStatus;
}

// Define a function to get the certificate label based on various conditions
function getCertificateLabel($registrationStatus, $attendanceStatus, $evaluationStatus) {
    if ($registrationStatus === 'done') {
        if ($attendanceStatus && $evaluationStatus === 'Evaluated') {
            return 'Issue Certificate';
        } else {
            return 'No Certificate';
        }
    } else {
        return 'Not Applicable';
    }
}


if ($conn) {
    $user_id = $_settings->userdata('id');

    $sql = "SELECT r.*, p.title AS activity_title, t.status AS attendance_status, u.firstname, u.lastname, r.gender, r.contact, r.address
    FROM registration_list r
    LEFT JOIN activities p ON p.id = r.activity_id
    LEFT JOIN attendance_list t ON r.user_id = t.user_id AND r.activity_id = t.activity_id
    LEFT JOIN users u ON u.id = r.user_id
    WHERE r.user_id = '$user_id'
    ORDER BY r.date_created DESC";

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch user data once

       // Display user information without space between labels and data
        echo '<p style="margin-top: 120px; margin-bottom:0; padding: 0;"><strong>Name:</strong> ' . ucwords($row['firstname'] . ' ' . $row['lastname']) . '</p>';
        echo '<p style="margin: 0; padding: 0;"><strong>Gender:</strong> ' . ucwords($row['gender']) . '</p>';
        echo '<p style="margin: 0; padding: 0;"><strong>Group Belong:</strong> ' . ucwords($row['category']) . '</p>';
        echo '<p style="margin: 0; padding: 0;"><strong>Contact:</strong> ' . $row['contact'] . '</p>';
        echo '<p style="margin: 0; padding: 0;"><strong>Address:</strong> ' . $row['address'] . '</p>';
        echo '<hr>';


        // Start the table for the main report and add columns
        echo '<table class="table table-stripped text-dark" style="width: 100%;">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>No.</th>';
        echo '<th>Date/Time</th>';
        echo '<th>Activity</th>';
        echo '<th>Registration Status</th>';
        echo '<th>Attendance Status</th>';
        echo '<th>Evaluation Status</th>';
        echo '<th>Issue Certificate</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1; // Initialize row number

        do {
            echo '<tr>';
            echo '<td>' . $i++ . '</td>';
            echo '<td>' . date("Y-m-d H:i", strtotime($row['date_created'])) . '</td>';
            echo '<td>' . $row['activity_title'] . '</td>';
            echo '<td>' . getStatusLabel($row['status']) . '</td>'; // Replace with a function to get status label
            echo '<td>' . getAttendanceLabel($row['attendance_status']) . '</td>'; // Replace with a function to get attendance label
            echo '<td>' . getEvaluationLabel($row['user_id'], $row['activity_id'], $conn) . '</td>'; // Replace with a function to get evaluation label
            echo '<td>' . getCertificateLabel($row['status'], $row['attendance_status'], getEvaluationLabel($row['user_id'], $row['activity_id'], $conn)) . '</td>'; // Replace with a function to get certificate label
            echo '</tr>';
        } while ($row = $result->fetch_assoc());

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No records found.';
    }
} else {
    echo 'Database connection error.';
}
?>

<!-- Add a Print button to print the report -->
<br>
<button class="btn btn-lg btn-danger" onclick="window.print()" style="height:40px; width:95px; text-align:center;margin-left:90%;">Print</button>
</div>
</div>
</div>
