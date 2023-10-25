<style>
  .info-box {
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    background-color: #CC9DEF;
  }
</style>
<div class="container">
  <h1>Welcome to <?php echo $_settings->info('name') ?></h1>
  <hr>
  <section class="content">
    <div class="row">
      <div class="col-12 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Activities</span>
            <span class="info-box-number">
              <?php echo $conn->query("SELECT * FROM activities")->num_rows; ?>
            </span>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-male"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Male Users</span>
            <span><?php echo $conn->query("SELECT * FROM registration_list WHERE gender = 'Male'")->num_rows; ?></span>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-female"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Female Users</span>
            <span><?php echo $conn->query("SELECT * FROM registration_list WHERE gender = 'Female'")->num_rows; ?></span>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-transgender"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">LGBTQA</span>
            <span><?php echo $conn->query("SELECT * FROM registration_list WHERE gender = 'LGBTQA'")->num_rows; ?></span>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Registered Users</span>
            <span class="info-box-number"> <?php echo $conn->query("SELECT * FROM users")->num_rows; ?></span>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-address-book"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Attendees</span>
            <span class="info-box-number"> <?php echo $conn->query("SELECT * FROM attendance_list")->num_rows; ?></span>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-3">
        <div class="info-box mb-1" style="display: flex; justify-content: space-between;">
          <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file"></i></span>
          <div class="info-box-content">
            <p class="info-box-number">Documents: <?php echo $conn->query("SELECT * FROM documents")->num_rows; ?>
            Videos: <?php echo $conn->query("SELECT * FROM video")->num_rows; ?></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-bullhorn"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Announcements</span>
            <span class="info-box-number"> <?php echo $conn->query("SELECT * FROM announcement")->num_rows; ?></span>
          </div>
        </div>
      </div>
    </div>
<br>
    <div class="container">
      <?php 
        $files = array();
        $activities = $conn->query("SELECT * FROM `activities` order by rand() ");
        while($row = $activities->fetch_assoc()){
          if(!is_dir(base_app.'uploads/activity_'.$row['id']))
            continue;
          $fopen = scandir(base_app.'uploads/activity_'.$row['id']);
          foreach($fopen as $fname){
            if(in_array($fname,array('.','..')))
              continue;
            $files[]= validate_image('uploads/activity_'.$row['id'].'/'.$fname);
          }
        }
      ?>
      <div id="tourCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner h-100">
          <?php foreach($files as $k => $img): ?>
            <div class="carousel-item h-100 <?php echo $k == 0? 'active': '' ?>">
              <img class="d-block w-100 h-100" src="<?php echo $img ?>" alt="">
            </div>
          <?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" ariahidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </section>
</div>
