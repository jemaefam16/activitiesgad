<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	header.masthead{
		background-image: url('<?php echo validate_image($_settings->info('cover')) ?>') !important;
                
	}
	header.masthead .container{
		background:#0000006b;
	}

        .container {
            background-color: black; 
            color: white; 
            padding: 20px; 
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
		.nav-icon {
		color:black;
		}
                
        #twitch-embed {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
        }
    </style>

<!-- Masthead-->
<header class="masthead">

<div class="container" style="background-color: black; text-align: left;">
    <h3 class="text" style="color:#0881F1">Announcements:</h3>
<?php
// Query the database to retrieve announcements with the "upcoming" status
$query = "SELECT announcements, date_created FROM announcement WHERE status = '2' ORDER BY date_created DESC";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $announcements = $row['announcements'];
        $date_created = $row['date_created'];

        // Format the date
        $formatted_date = date("F j, Y", strtotime($date_created));
								$announcements = html_entity_decode($announcements);


        echo '<div class="announcement">';
        echo '<div>Posted: ' . $formatted_date . '</div>';
        echo '<div>' . $announcements . '</div>';
        echo '</div>';
    }
} else {
    echo "No upcoming announcements.";
}
?>
</div>


	<div class="container">
		<div class="masthead-subheading">Welcome To MSWDO Corcuera, Romblon- Site</div>
		<div class="masthead-heading text-uppercase">Explore our Activities</div>
		<a class="btn btn-primary btn-xl text-uppercase" href="#home" style="font-size:24px;">View Activities</a>
	</div>

</header>
<!-- Services-->
<section class="page-section bg-dark" id="home">
	<div class="container">
		<h2 class="text-center">Activities</h2>
	<div class="d-flex w-100 justify-content-center">
		<hr class="border-warning" style="border:3px solid" width="15%">
	</div>
	<div class="row">
		<?php
		$activities = $conn->query("SELECT * FROM `activities` order by rand() limit 3");
			while($row = $activities->fetch_assoc() ):
				$cover='';
				if(is_dir(base_app.'uploads/activity_'.$row['id'])){
					$img = scandir(base_app.'uploads/activity_'.$row['id']);
					$k = array_search('.',$img);
					if($k !== false)
						unset($img[$k]);
					$k = array_search('..',$img);
					if($k !== false)
						unset($img[$k]);
					$cover = isset($img[2]) ? 'uploads/activity_'.$row['id'].'/'.$img[2] : "";
				}
				$row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));

				$review = $conn->query("SELECT * FROM `rate_review` where activity_id='{$row['id']}'");
				$review_count =$review->num_rows;
				$rate = 0;
				while($r= $review->fetch_assoc()){
					$rate += $r['rate'];
				}
				if($rate > 0 && $review_count > 0)
				$rate = number_format($rate/$review_count,0,"");
		?>
			<div class="col-md-4 p-4 ">
				<div class="card w-100 rounded-0">
					<img class="card-img-top" src="<?php echo validate_image($cover) ?>" alt="<?php echo $row['title'] ?>" height="200rem" style="object-fit:cover">
					<div class="card-body">
					<h5 class="card-title truncate-1 w-100"><?php echo $row['title'] ?></h5><br>
					<div class=" w-100 d-flex justify-content-start">
						<div class="stars stars-small">
								<input disabled class="star star-5" id="star-5" type="radio" name="star" <?php echo $rate == 5 ? "checked" : '' ?>/> <label class="star star-5" for="star-5"></label> 
								<input disabled class="star star-4" id="star-4" type="radio" name="star" <?php echo $rate == 4 ? "checked" : '' ?>/> <label class="star star-4" for="star-4"></label> 
								<input disabled class="star star-3" id="star-3" type="radio" name="star" <?php echo $rate == 3 ? "checked" : '' ?>/> <label class="star star-3" for="star-3"></label> 
								<input disabled class="star star-2" id="star-2" type="radio" name="star" <?php echo $rate == 2 ? "checked" : '' ?>/> <label class="star star-2" for="star-2"></label> 
								<input disabled class="star star-1" id="star-1" type="radio" name="star" <?php echo $rate == 1 ? "checked" : '' ?>/> <label class="star star-1" for="star-1"></label> 
						</div>
                    </div>
    				<p class="card-text truncate"><?php echo $row['description'] ?></p>
					<div class="w-100 d-flex justify-content-end">
						<a href="./?page=view_activity&id=<?php echo md5($row['id']) ?>" class="btn btn-sm btn-lg btn-warning" style="background-color:#1D8348;border-radius:10px;">View Activities <i class="fa fa-arrow-right"></i></a>
					</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
	<div class="d-flex w-100 justify-content-end">
		<a href="./?page=activities" class="btn btn-flat btn-warning mr-4" style="background-color:blue;border-radius:10px;">Explore Activities <i class="fa fa-arrow-right"></i></a>
	</div>
	</div>
</section>

<!--Documents-->
<section class="page-section" id="docu" style="background-color:white">
	<div class="container" style="background-color:black">
		<div class="text-center">
			<h2 class="section-heading text-uppercase">Documents</h2>
		</div>
		<div>
			<div class="card w-100">
				<div class="card-body">

				<div class="container" style="background-color: white; text-align: left;">
    <h3 class="text" style="color:red">Attachments:</h3>
    <?php

    // Query the database to retrieve multiple documents
    $query = "SELECT  upload_path, date_created FROM documents ORDER BY date_created DESC";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $upload_path = $row['upload_path'];
            $date_created = $row['date_created'];

            // Format the date
            $formatted_date = date("F j, Y", strtotime($date_created));
            ?>
          
		<table>
    <thead>
        <tr>
            <th style="color:black">Posted:<?php echo $formatted_date; ?></th><br>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($upload_path) && is_dir(base_app . $upload_path)) {
            $files = scandir(base_app . $upload_path);

            foreach ($files as $doc) {
                if (in_array($doc, array('.', '..'))) {
                    continue;
                }
                ?>
                <tr>
                    <td>
                        <div class="d-flex w-100 file-item">
                            <span class="nav-icon fas fa-file-pdf" style="text-align:left;"><a href="<?php echo base_url . $upload_path . '/' . $doc; ?>" target="_blank" style="color:blue;font-weight:bold;font-size:20px">
                                <?php echo $doc; ?></a></span>
                        </div>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo '<tr><td colspan="2">Directory not found or empty.</td></tr>';
        }
        ?>
    </tbody>
</table>
            <?php
        }
    } else {
        echo "No files available at this time.";
    }
    ?>
</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- About-->
<section class="page-section" id="about" style="background-color:black">
	<div class="container">
		<div class="text-center">
			<h2 class="section-heading text-uppercase">About Us</h2>
		</div>
		<div>
			<div class="card w-100">
				<div class="card-body">
					<?php echo file_get_contents(base_app.'about.html') ?>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Videos-->
<section class="page-section" id="videos" style="background-color:white">
	<div class="container" style="background-color:white">
		<div class="text-center" style="background-color:white">
			<h2 class="section-heading text-uppercase"style="color:black" >MSWDO Videos</h2>
			<h3 class="section-subheading text-muted">Watch our Videos.</h3>
		</div>
   

<!-- Add a placeholder for the Twitch embed -->
<div id="twitch-embed"></div>

<!-- Load the Twitch embed JavaScript file -->
<script src="https://embed.twitch.tv/embed/v1.js"></script>

<!-- Add some spacing between Twitch and the card -->
<div style="margin-top: 10px;"></div>

<!-- Create a Twitch.Embed object that will render within the "twitch-embed" element -->
<script type="text/javascript">
    new Twitch.Embed("twitch-embed", {
        width: 1200,
        height: 500,
        channel: "mswdo1948",
        // Only needed if this page is going to be embedded on other websites
        parent: ["embed.example.com", "othersite.example.com"]
    });
</script>

		<div class="card w-100" style="margin-top:80px; margin-bottom:10px;">
				<div class="card-body">
				<?php
$query = "SELECT id, name FROM video";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $counter = 0; // Initialize a counter
    while ($row = $result->fetch_assoc()) {
        $video_name = $row['name'];
        $video_name_without_extension = pathinfo($video_name, PATHINFO_FILENAME); // Get the name without the extension

        if ($counter % 3 == 0) {
            // Start a new row for every 3 videos
            echo '<div class="row">';
        }
        ?>
        <div class="col-md-4">
            <video width="100%" controls>
                <source src="uploads/<?php echo $video_name; ?>">
            </video>
												<p style="font-style: italic; font-family: 'Times New Roman', Times, serif; color: black;font-size:18px;">
        <?php echo $video_name_without_extension; ?>
        </div>
        <?php
        if ($counter % 3 == 2) {
            // Close the row after every 3 videos
            echo '</div>';
        }
        $counter++;
    }
    // Close any remaining open row
    if ($counter % 3 != 0) {
        echo '</div>';
    }
}
?>
				</div>
			</div>
	</div>
			</section>

<!-- Staff Information -->
<section class="page-section" id="contact" style="background-color: black;">
    <div class="container" style="background-color: white;">
        <div class="text-center" style="background-color: white;">
            <h2 class="section-heading text-uppercase" style="color: black;">MSWDO Staff Information</h2>
            <h3 class="section-subheading text-muted">Contact our staff for inquiries.</h3>
        </div>
        <div class="card w-100">
            <div class="card-body">
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
                        width: 150px; 
                        height: 150px; 
                        object-fit: cover;
                    }
                </style>
                <div class="row">
                <?php
                $query = "SELECT id, name, contact_info, address, photo FROM staff";
                $result = $conn->query($query);
                if ($result && $result->num_rows > 0) {
                    $staffCount = 0;
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $name = $row['name'];
                        $contact_info = $row['contact_info'];
                        $address = $row['address'];
                        $photo = "uploads/" . $row['photo'];
                ?>
                    <div class="col-md-4">
                        <div class="staff-frame" style="background-color: #4b4237;">
														<img class="staff-image" src="<?php echo $photo; ?>" alt="<?php echo $name; ?>" width="100"> <br>
														<p style="margin: 0; padding: 0; color: #ffe4c4; font-weight: bold; text-transform: uppercase; font-size: 19px;">
    												<?php echo $name; ?></p>
                            <p style="margin: 0; padding: 0;color:white;font-family: Arial, Helvetica, sans-serif;"><strong>Contact:</strong> <?php echo $contact_info; ?></p>
                            <p style="margin: 0; padding: 0;color:white;font-family: Arial, Helvetica, sans-serif;"><?php echo $address; ?></p>
                        </div>
                    </div>
                <?php
                    $staffCount++;
                    if ($staffCount % 3 == 0) {
                        // Close the current row and start a new one after every 3 staff members
                        echo '</div><div class="row">';
                    }
                    }
                    if ($staffCount % 3 != 0) {
                        // Close the last row if it doesn't contain 3 staff members
                        echo '</div>';
                    }
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</section>

   
<script>
function displayDocs(input, _this) {
    var docNames = [];
    Object.keys(input.files).map(function (k) {
        docNames.push(input.files[k].name);
    })
};
</script>