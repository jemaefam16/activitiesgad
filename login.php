<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
</style>
<div class="container-fluid" id="login-page">
    <h3 class="float-left">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </h3>
    <div class="row">
        <div class="col-lg-5 border-right d-flex justify-content-center align-items-center">
        <div class="image-container" style="width: 100%; height: 100%;">
            <img src="assets/img/logo.png" alt="Image Alt Text" style="width: 100%; height: 100%;">
        </div>
        </div>
        <div class="col-lg-7"><br><br><br>
            <h3 class="text-center">Login</h3>
            <hr>
            <form action="" id="login-form">
                <div class="form-group">
                    <label for="" class="control-label">Username</label>
                    <input type="text" class="form-control form" name="username" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control form" name="password" required>
                </div>
                <div class="form-group d-flex justify-content-center">
                <button class="btn btn-primary btn-lg" style="width: 50%; background-color: blue;">Login</button>
                </div>
                <div class="form-group d-flex justify-content-end">
                    <label for="" class="control-label">No account yet?&nbsp;&nbsp;</label>
                    <button id="show-registration-form" class="btn btn-primary btn-lg" style="width: 25%; background-color: red;">Sign up</button>
                </div>
            </form>

            <div class="form-group d-flex justify-content-end">
            <a href="admin/login.php" class="btn btn-primary btn-lg" style="width: 25%; background-color:#7707C4;">Admin Login</a>
            </div>
        </div>
    </div>
</div>

<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
    .account-container .row:last-child {
    display: none;
}
</style>
<div class="container-fluid" id="registration-form" style="display: none;">
    <h3 class="float-left">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </h3>
    <div class="row">
        <div class="col-lg-5 border-right d-flex justify-content-center align-items-center">
        <div class="image-container" style="width: 100%; height: 100%;">
            <img src="assets/img/logo.png" alt="Image Alt Text" style="width: 100%; height: 100%;">
        </div>
        </div>
        <div class="col-lg-7">
        <h3 class="text-center">Create Account</h3>
        <hr class='border-primary'>
            <form action="" id="registration">
                <div class="form-group">
                    <label for="" class="control-label">Firstname</label>
                    <input type="text" class="form-control form-control-sm form" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Lastname</label>
                    <input type="text" class="form-control form-control-sm form" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Username</label>
                    <input type="text" class="form-control form-control-sm form" name="username" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control form-control-sm form" name="password" required>
                </div>
                <div class="form-group d-flex justify-content-end">
                <button class="btn btn-primary btn-lg" style="width: 50%; background-color: blue;">Register</button>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    $(function(){
        $('#registration').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=register",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        alert_toast("Account succesfully registered",'success')
                        setTimeout(function(){
                            location.reload()
                        },2000)
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text(resp.msg)
                        $('#registration').prepend(_err_el)
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
        $('#login-form').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Login.php?f=login_user",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        alert_toast("Login Successfully",'success')
                        setTimeout(function(){
                            location.reload()
                        },2000)
                    }else if(resp.status == 'incorrect'){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text("Incorrect Credentials.")
                        $('#login-form').prepend(_err_el)
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
    })

document.getElementById("show-registration-form").addEventListener("click", function() {
    var loginForm = document.getElementById("login-page");
    var registrationForm = document.getElementById("registration-form");
    var adminlogin = document.getElementById("admin_login");
    
    if (registrationForm.style.display === "none") {
        registrationForm.style.display = "block";
        loginForm.style.display = "none"; // Hide the login form
    } else {
        registrationForm.style.display = "none";
        loginForm.style.display = "block"; // Show the login form
    }
});

</script>



