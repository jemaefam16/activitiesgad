<?php 
if(isset($_GET['id'])){
    $activities = $conn->query("SELECT * FROM `activities` where md5(id) = '{$_GET['id']}'");
    if($activities->num_rows > 0){
        foreach($activities->fetch_assoc() as $k => $v){
            $$k = $v;
        }
    }
$review = $conn->query("SELECT r.*,concat(firstname,' ',lastname) as name FROM `rate_review` r inner join users u on r.user_id = u.id where r.activity_id='{$id}' order by unix_timestamp(r.date_created) desc ");
$review_count =$review->num_rows;
$rate = 0;
$feed = array();
while($row= $review->fetch_assoc()){
    $rate += $row['rate'];
    if(!empty($row['review'])){
        $row['review'] = stripslashes(html_entity_decode($row['review']));
        $feed[] = $row;
    }
}
if($rate > 0 && $review_count > 0)
$rate = number_format($rate/$review_count,0,"");
$files = array();
if(is_dir(base_app.'uploads/activity_'.$id)){
    $ofile = scandir(base_app.'uploads/activity_'.$id);
    foreach($ofile as $img){
        if(in_array($img,array('.','..')))
        continue;
        $files[] = validate_image('uploads/activity_'.$id.'/'.$img);
    }
}
}
?>
<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div id="tourCarousel"  class="carousel slide" data-ride="carousel" data-interval="3000">
                    <div class="carousel-inner h-100">
                        <?php foreach($files as $k => $img): ?>
                        <div class="carousel-item  h-100 <?php echo $k == 0? 'active': '' ?>">
                            <img class="d-block w-100  h-100" src="<?php echo $img ?>" alt="">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="w-100">
                    <hr class="border-warning">
                    <h5>Ratings (<?php echo $review_count ?>)</h5>
                    <div>
                        <div class="stars">
                                <input disabled class="star star-5" id="star-5" type="radio" name="star" <?php echo $rate == 5 ? "checked" : '' ?>/> <label class="star star-5" for="star-5"></label> 
                                <input disabled class="star star-4" id="star-4" type="radio" name="star" <?php echo $rate == 4 ? "checked" : '' ?>/> <label class="star star-4" for="star-4"></label> 
                                <input disabled class="star star-3" id="star-3" type="radio" name="star" <?php echo $rate == 3 ? "checked" : '' ?>/> <label class="star star-3" for="star-3"></label> 
                                <input disabled class="star star-2" id="star-2" type="radio" name="star" <?php echo $rate == 2 ? "checked" : '' ?>/> <label class="star star-2" for="star-2"></label> 
                                <input disabled class="star star-1" id="star-1" type="radio" name="star" <?php echo $rate == 1 ? "checked" : '' ?>/> <label class="star star-1" for="star-1"></label> 
                        </div>
                    </div>
                    <hr>
                    <div class="w-100 d-flex justify-content-between">
    <span class="rounded-5 btn-lg btn-sm btn-primary d-flex align-items-center justify-content-center" style="width:18%; text-align:center;">
        <i class="fa-solid fa-lock-close"></i>
        <span class="ml-1" style="font-weight: bold; color: white; font-size: 22px;"><?php echo($label) ?></span>
    </span>
    <?php
    if ($label === "Open") {
        echo '<button class="btn btn-lg btn-warning" type="button" id="registration" style="background-color:#3ECF7; font-weight: bold; color: white; font-size: 22px; width: 100%; text-align: center;">Register Now</button>';
    } else {
        echo '<span style="font-weight: bold; color: black; font-size: 22px;text-align:center">Registration is currently closed.</span>';
    }
    ?>
</div>
<div class="w-100 d-flex justify-content-between" style="margin-top:10px;">
    <span class="rounded-5 btn-lg btn-sm btn-primary d-flex align-items-center justify-content-center" style="background-color: blue; width: 18%; text-align: center;">
        <i class="fa-solid fa-lock-close"></i>
        <span class="ml-1" style="font-weight: bold; color: white; font-size: 22px;"><?php echo($attendance_status) ?></span>
    </span>
    <?php
    if ($attendance_status === "Open") {
        echo '<button class="btn btn-lg btn-warning" type="button" id="attendance" style="background-color: blue; font-weight: bold; color: white; font-size: 22px; width: 100%; text-align: center;">Attendance Now</button>';
    } else {
        echo '<span style="font-weight: bold; color: black; font-size: 22px;text-align:center">Attendance is currently closed.</span>';
    }
    ?>
</div>

<div class="w-100 d-flex justify-content-between" style="margin-top:10px;">
    <span class="rounded-5 btn-lg btn-sm btn-primary d-flex align-items-center justify-content-center" style="background-color: red; width: 18%; text-align: center;">
        <i class="fa-solid fa-lock-close"></i>
        <span class="ml-1" style="font-weight: bold; color: white; font-size: 22px;"><?php echo($evaluation_status) ?></span>
    </span>
    <?php
    if ($attendance_status === "Open") {
        echo '<button class="btn btn-lg btn-warning" type="button" id="evaluation" style="background-color: red; font-weight: bold; color: white; font-size: 22px; width: 100%; text-align: center;">Evaluation Now</button>';
    } else {
        echo '<span style="font-weight: bold; color: black; font-size: 22px;text-align:center">Evaluation is currently closed.</span>';
    }
    ?>
</div>

                </div>
            </div>
            <div class="col-md-7">
                <h3><?php echo $title ?></h3>
                <hr class="border-warning">
                <small class='text-muted'>Location: <?php echo $event_location ?></small>
                <h4>Details</h4>
                <div><?php echo stripslashes(html_entity_decode($description)) ?></div>
                <hr>
                <h5>Evaluations (<?php echo count($feed) ?>)</h5>
                <hr class="border-primary">
                <?php foreach($feed as $r): ?>
                <div class="w-100 d-flex justify-content-between  align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo validate_image('assets/img/user.jpg') ?>" class="border mr-3 review-user-avatar" alt="">
                        <span><?php echo $r['name'] ?></span>
                    </div>
                    <span class='text-muted'><?php echo date("Y-m-d H:i A",strtotime($r['date_created'])) ?></span>
                </div>
                <div class="w-100 review-feedback">
                    <?php echo $r['review'] ?>
                </div>
                <hr class='border-light'>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('#registration').click(function(){
            if("<?php echo $_settings->userdata('id') ?>" > 0)
                uni_modal("Registration Form","registration_form.php?activity_id=<?php echo $id ?>");
            else
                uni_modal("","login.php","large");
        })
    })
    $(function(){
        $('#attendance').click(function(){
            if("<?php echo $_settings->userdata('id') ?>" > 0)
                uni_modal("Attendance Form","attendance_form.php?activity_id=<?php echo $id ?>");
            else
                uni_modal("","login.php","large");
        })
    })
    $(function(){
        $('#evaluation').click(function(){
            if("<?php echo $_settings->userdata('id') ?>" > 0)
                uni_modal("Evaluation Form","evaluation_form.php?activity_id=<?php echo $id ?>");
            else
                uni_modal("","login.php","large");
        })
    })
</script>