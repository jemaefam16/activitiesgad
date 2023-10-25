<section class="page-section bg-dark" id="home">
	<div class="container">
		<h2 class="text-center">View Activities</h2>
	<div class="d-flex w-100 justify-content-center">
		<hr class="border-warning" style="border:3px solid" width="15%">
	</div>
	<div class="w-100">
		<?php
		$activities = $conn->query("SELECT * FROM `activities` order by rand() ");
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
			<div class="card d-flex w-100 rounded-0 mb-3 activity-item">
				<img class="card-img-top" src="<?php echo validate_image($cover) ?>" alt="<?php echo $row['title'] ?>" height="200rem" style="object-fit:cover">
				<div class="card-body">
				<h5 class="card-title truncate-1"><?php echo $row['title'] ?></h5>
				<div class=" w-100 d-flex justify-content-start">
				<form action="">
					<div class="stars stars-small">
							<input disabled class="star star-5" id="star-5" type="radio" name="star" <?php echo $rate == 5 ? "checked" : '' ?>/> <label class="star star-5" for="star-5"></label> 
							<input disabled class="star star-4" id="star-4" type="radio" name="star" <?php echo $rate == 4 ? "checked" : '' ?>/> <label class="star star-4" for="star-4"></label> 
							<input disabled class="star star-3" id="star-3" type="radio" name="star" <?php echo $rate == 3 ? "checked" : '' ?>/> <label class="star star-3" for="star-3"></label> 
							<input disabled class="star star-2" id="star-2" type="radio" name="star" <?php echo $rate == 2 ? "checked" : '' ?>/> <label class="star star-2" for="star-2"></label> 
							<input disabled class="star star-1" id="star-1" type="radio" name="star" <?php echo $rate == 1 ? "checked" : '' ?>/> <label class="star star-1" for="star-1"></label> 
					</div>
				</form>
				</div>
				<p class="card-text truncate"><?php echo $row['description'] ?></p>
				<div class="w-100 d-flex justify-content-between">
					<span class="rounded-4 btn btn-lg btn-sm btn-primary" style="background-color:blue;border-radius: 10px;"></><i class="fa-solid fa-lock-close"i><?php echo($row['label']) ?></span>
					<a href="./?page=view_activity&id=<?php echo md5($row['id']) ?>" class="rounded-4 btn btn-sm btn-lg btn-warning" style="background-color:#1D8348;boreder-radius:10px;">View Activity <i class="fa fa-arrow-right"></i></a>
				</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
	
	</div>
</section>