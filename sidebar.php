<?php include'db_connect.php' ?>
  <aside class="main-sidebar  elevation-4">
    <div class="dropdown">
   	<!-- <a href="./" class="brand-link">
        <?php if($_SESSION['login_type'] == 1): ?>
        <h3 class="text-center p-0 m-0"><b>ADMIN</b></h3>
        <?php else: ?>
        <h3 class="text-center p-0 m-0"><b>USER</b></h3>
        <?php endif; ?>

    </a> -->
    <img src="assets/images/loginv1.png" height="61px" width="192px" style="margin-left: 10%;position: absolute;margin-top: 10%">

    </div>
    <div class="sidebar pb-4 mb-4" style="margin-top: 40%;" id="sidebar">
      <nav class="mt-2">
       <!-- batas -->
        <!-- <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa fa-th-large"></i>
              <p >
                Dashboard
              </p>
            </a>
          </li>  
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_project nav-view_project">
              <i class="nav-icon fas fa-layer-group"  style="color: grey"></i>
              <p >
                Projects
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if($_SESSION['login_type'] != 3): ?>
              <li class="nav-item">
                <a href="./index.php?page=new_project" class="nav-link nav-new_project tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p >Add New</p>
                </a>
              </li>
            <?php endif; ?>
              <li class="nav-item">
                <a href="./index.php?page=project_list" class="nav-link nav-project_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p >List</p>
                </a>
              </li>
            </ul>
          </li> 
          <li class="nav-item">
                <a href="./index.php?page=task_list" class="nav-link nav-task_list">
                  <i class="fa fa-file nav-icon"></i>
                  <p >Task</p>
                </a>
          </li>
          <?php if($_SESSION['login_type'] != 3): ?>
           <li class="nav-item">
                <a href="./index.php?page=reports" class="nav-link nav-reports">
                  <i class="fas fa-th-list nav-icon"></i>
                  <p >Report</p>
                </a>
          </li>
          <?php endif; ?>
          <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-users"></i>
              <p >
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p >Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p >List</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
        </ul> -->

        <!-- end batas -->
      <?php
      // echo json_encode($_SESSION);
      ?>
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
       <?php
          $i = 1;
          $qry = $conn->query("SELECT a.*,b.id_tabel_role,c.nama_role from tabel_menu a
                                INNER JOIN tabel_role b on a.id_menu = b.id_menu
                                INNER JOIN par_user_role c on b.id_tabel_role = c.id_role
                                WHERE c.is_active = 1 and b.id_tabel_role = '".$_SESSION['login_type']."'");
          while($row= $qry->fetch_assoc()):
        ?>
        <?php
        if ($row['parent'] == '0') {
          if ($row['url'] =="" or $row['url']==null) {
            ?>
            <li class="nav-item dropdown">
              <a href="./" class="nav-link nav-home">
                <i <?php echo 'class="'.$row['icon'].'"'; ?> ></i>
                <p >
                  <?php echo $row['nama_menu']; ?>
                </p>
              </a>
            </li>  
            <?php
          }else if($row['parent'] == '0' and $row['have_child'] == '0'){
            ?>
              <li class="nav-item dropdown">
                <a <?php echo 'href="./index.php?page=dashboard"';?> class="nav-link nav-home">
                  <i <?php echo 'class="'.$row['icon'].'"'; ?>></i>
                  <p >
                    <?php echo $row['nama_menu']; ?>
                  </p>
                </a>
              </li> 
            <?php
          }
        ?>
        <?php
        }else if ( $row['id_menu'] == '9') {
         ?>
           <li class="nav-item">
            <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-users"></i>
              <p >
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p >Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p >List</p>
                </a>
              </li>
            </ul>
          </li>
            <?php
          }else if ($row['id_menu'] == '4') {
           ?>
              <li class="nav-item">
                <a href="#" class="nav-link nav-edit_project nav-view_project">
                  <i class="nav-icon fas fa-layer-group"  style="color: grey"></i>
                  <p >
                    Projects
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <?php if($_SESSION['login_type'] != 3): ?>
                  <li class="nav-item">
                    <a href="./index.php?page=new_project" class="nav-link nav-new_project tree-item">
                      <i class="fas fa-angle-right nav-icon"></i>
                      <p >Add New</p>
                    </a>
                  </li>
                <?php endif; ?>
                  <li class="nav-item">
                    <a href="./index.php?page=project_list" class="nav-link nav-project_list tree-item">
                      <i class="fas fa-angle-right nav-icon"></i>
                      <p >List</p>
                    </a>
                  </li>
                </ul>
              </li> 
         <?php 
        }
        ?>
        <?php endwhile; ?>
      </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
     
  	})
  </script>

  <style type="text/css">
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link{
      background-color: white;
      color: #800000;
    }

    #sidebar a:hover{
      color: #800000 !important; 
    }

  </style>