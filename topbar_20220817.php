<!-- Navbar -->
<?php include'db_connect.php' ?>
  <nav class="main-header navbar navbar-expand">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <?php if(isset($_SESSION['login_id'])): ?>
      <li class="nav-item">
        <!-- <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a> -->
      </li>
    <?php endif; ?>
      <li>
        <!-- <a class="nav-link text-white"  href="./" role="button"> <large><b><?php echo $_SESSION['system']['name'] ?></b></large></a> -->
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt" style="color: grey"></i>
        </a>
      </li>
     <li class="nav-item dropdown">
            <a class="nav-link"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
              <span>
                <div class="d-felx badge-pill">
                  <?php 
                 
                  $user = $conn->query("SELECT * FROM users where id =".$_SESSION['login_id']);
                  foreach($user->fetch_array() as $k =>$v){
                    $meta[$k] = $v;
                       }
                  ?>
                 <?php
                 if (str_contains($meta['avatar'],'avatar')) {
                 ?>
                 <span class="fa fa-user mr-2" style="color: grey">
                 <?php
                 }else{
                  ?>
                  <span class="mr-2" style="color: grey">
                     <img src="<?php echo isset($meta['avatar']) ? 'assets/uploads/'.$meta['avatar'] :'' ?>" height="30px" width="35px"
                     style="border-radius: 100% 100%;margin-top: -5px">
                  </span>
                  <?php
                 }
                 ?>
                  <span><b><?php echo ucwords($_SESSION['login_firstname']) ?></b></span>
                  <span class="fa fa-angle-down ml-2" style="color: grey"></span>
                </div>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
              <a class="dropdown-item" href="javascript:void(0)" id="manage_account"><i class="fa fa-cog"></i> Manage Account</a>
              <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
            </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <script>
     $('#manage_account').click(function(){
        uni_modal('Manage Account','manage_user.php?id=<?php echo $_SESSION['login_id'] ?>')
      })
  </script>

  <style type="text/css">
  
  </style>
