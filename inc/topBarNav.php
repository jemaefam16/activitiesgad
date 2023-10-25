 <!-- Navigation-->
 <!-- jQuery (required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (required) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

 <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
            <div class="container-fluid">
                <a class="navbar-brand" href="#page-top"><span class="text-warning" style="font-size:25px;color:#CF9FFF">MSWDO CORCUERA, ROMBLON</span></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="<?php echo $page !='home' ? './':''  ?>" style="font-size:18px;">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="./?page=activities" style="font-size:18px;">Activities</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $page !='home' ? './':''  ?>#docu" style="font-size:18px;">Documents</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $page !='home' ? './':''  ?>#about" style="font-size:18px;">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $page !='home' ? './':''  ?>#videos" style="font-size:18px;">Videos</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $page !='home' ? './':''  ?>#contact" style="font-size:18px;">MSWDO Staff</a></li>
                        <?php if(isset($_SESSION['userdata'])): ?>
                          <li class="nav-item"><a class="nav-link" href="./?page=my_account" style="font-size:18px;"><i class="fa fa-user" style="font-size:18px;"></i> Hi, <?php  echo $_settings->userdata('firstname') ?>!</a></li>
                          <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fa fa-sign-out-alt" style="font-size:20px;"></i></a></li>
                        <?php else: ?>
                          <li class="nav-item"><a class="nav-link" href="javascript:void(0)" id="login_btn" style="font-size:18px;">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    
<script>
$(function(){
    $('#login_btn').click(function(){
        uni_modal("","login.php","large");
    });

    $('#navbarResponsive').on('show.bs.collapse', function () {
        $('#mainNav').addClass('navbar-shrink');
    });

    $('#navbarResponsive').on('hidden.bs.collapse', function () {
        if ($('body').offset().top == 0) {
            $('#mainNav').removeClass('navbar-shrink');
        }
    });
});
</script>