<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
  ob_start();
  // if(!isset($_SESSION['system'])){

    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  // }
  ob_end_flush();
?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>
<?php include 'header.php' ?>
<body class="">

  <div class="container">
     <div class="row"> 
        <div class="col" id="logo1">
          <img src="assets/images/loginv1.png" height="106px" width="336px" style="margin-top: 40%">
        </div>
        <div class="col" style="background-color: #800000" id="div2">
          <div class="login-box" style="margin-top: 30%;margin-left: 25%">
            <div class="login-logo">
              <a href="#" class="text-white"><b>Log in</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
              <div class="card-body login-card-body">
                <form action="" id="login-form" style="">
                  <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" required placeholder="Email">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" required placeholder="Password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-7">
                      <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <!-- <label for="remember">
                          Remember Me
                        </label> -->
                      </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-5" style="margin-left: 33%;margin-top: -10%">
                      <button type="submit" class="btn  btn-m" style="color: #800000; background-color: white;border-radius: 10px">Lets Start</button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
              </div>
              <!-- /.login-card-body -->
            </div>
          </div>
        </div>
    </div>
  </div>
<!-- /.login-box -->
<script>
  $(document).ready(function(){
    $('#login-form').submit(function(e){
    e.preventDefault()
    start_load()
    if($(this).find('.alert-danger').length > 0 )
      $(this).find('.alert-danger').remove();
    $.ajax({
      url:'ajax.php?action=login',
      method:'POST',
      data:$(this).serialize(),
      error:err=>{
        console.log(err)
        end_load();

      },
      success:function(resp){
        if(resp == 1){
          location.href ='index.php?page=home';
        }else{
          $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
          end_load();
        }
      }
    })
  })
  })
</script>
<?php include 'footer.php' ?>

</body>
<style type="text/css">
  #logo1 {
  display: block;
  /*margin-top: 100%;*/
  height: 758px;
  width: 50%;
  position: absolute;
  overflow: hidden;
}
body{
      margin: 0;
      width: 100%;
}
    #div2 {
            height: 758px;
            width: 50%; //change width to fit your need
            overflow: hidden;
            background-color: blue;
            right:0;
            position: absolute;
        }
    #div1 {
            height: 758px;
            width: 50%; //change width to fit your need
            overflow: hidden;
            background-color: blue;
            right:0;
            position: absolute;
    }
.login-card-body, .register-card-body{
  background-color: #800000;
}

</style>
</html>
