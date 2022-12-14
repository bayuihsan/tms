  <aside class="main-sidebar  elevation-4">
    <div class="dropdown">
    <img src="assets/images/loginv1.png" height="61px" width="192px" style="margin-left: 10%;position: absolute;margin-top: 10%">
    <?php
    if($_SESSION['login_id']){
      $user = $conn->query("SELECT * FROM users where id =".$_SESSION['login_id']);
      foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
      }
    }
    ?>
    </div>
    <div class="sidebar pb-4 mb-4" style="margin-top: 40%;" id="sidebar">
      <nav class="mt-2">
      <?php
      // echo json_encode($_SESSION);
      ?>
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item dropdown">
          <a href="./" class="nav-link nav-home">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard <?php //echo $_SESSION['login_type']?>
            </p>
          </a>
        </li>  
       <?php
          $qry = $conn->query("SELECT a.*,b.id_tabel_role,c.nama_role from tabel_menu a
                                INNER JOIN tabel_role b on a.id_menu = b.id_menu
                                INNER JOIN par_user_role c on b.id_tabel_role = c.id_role
                                WHERE a.is_active = 1 and a.parent = 0  and b.id_tabel_role = '".$_SESSION['login_type']."'");
          while($row= $qry->fetch_assoc()):
            // echo var_dump($row);die();
        ?>
            <li class="nav-item">
              <a href="<?php echo $row['url']?>" class="nav-link nav-edit_project nav-<?php echo $row['page']?>" tree-item>
                <i class="<?php echo $row['icon']?>"  style="color: <?php '"'.$meta['colorSchema'].'"'?>"></i>
                <p >
                  <?php echo $row['nama_menu']?>
                  <?php if($row['have_child']== 1) { ?>
                  <i class="right fas fa-angle-left"></i>
                  <?php } ?>
                </p>
              </a>
              <?php if($row['have_child']== 1) { ?>
              <ul class="nav nav-treeview">
                <?php
                  $qry2 = $conn->query("SELECT a.*,b.id_tabel_role,c.nama_role from tabel_menu a
                                        INNER JOIN tabel_role b on a.id_menu = b.id_menu
                                        INNER JOIN par_user_role c on b.id_tabel_role = c.id_role
                                        WHERE a.is_active = 1 and a.parent = '".$row['id_menu']."'  and b.id_tabel_role = '".$_SESSION['login_type']."'");
                  while($row2= $qry2->fetch_assoc()):
                    // echo var_dump($qry);
                ?>
                <li class="nav-item">
                  <a href="<?php echo $row2['url']?>" class="nav-link nav-<?php echo $row2['page']?> tree-item">
                    <i class="<?php echo $row2['icon']?>"></i>
                    <p > <?php echo $row2['nama_menu']?></p>
                  </a>
                </li>
                <?php endwhile; ?>
              </ul>
              <?php } ?>
            </li> 
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
    var my_css_class = { backgroundColor : 'white', color : <?php echo '"'.$meta['colorSchema'].'"' ?> };
    $('.nav-item > .nav-link').css(my_css_class);
    $("a").hover(function(){
      $(this).css("background-color", <?php echo '"'.$meta['colorSchema'].'"' ?>);
      }, function(){
      $(this).css("background-color", "white");
    });
  </script>

  <style type="text/css">
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link{
      background-color: white;
      color: #800000 !important;
    }

    #sidebar a:hover{
      color: #800000 !important; 
    }

  </style>