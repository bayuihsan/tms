<?php include('db_connect.php') ?>
<?php
$twhere ="";
if($_SESSION['login_type'] != 1)
  $twhere = " ";
?>
<!-- Info boxes -->
<?php /*<div class="col-12" id="date" style="margin-left: -5px">

</div>
 <div class="col-12" style="padding-top: 10px;margin-left: -5px">
          <div class="card">
            <div class="card-body">
              Welcome <?php echo $_SESSION['login_name'] ?>!
            </div>
          </div>
  </div>
*/?>
  <hr>
  <?php 

    $where = "";
    if($_SESSION['login_type'] == 2){
      $where = " where manager_id = '{$_SESSION['login_id']}' ";
    }elseif($_SESSION['login_type'] == 3){
      $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
    }
     $where2 = "";
    if($_SESSION['login_type'] == 2){
      $where2 = " where p.manager_id = '{$_SESSION['login_id']}' ";
    }elseif($_SESSION['login_type'] == 3){
      $where2 = " where concat('[',REPLACE(p.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
    }
    ?>
        
      <div class="row">
        
         <?php
         $i=1;
              $qry = $conn->query("SELECT task_list.*,project_list.*,
                                    COUNT(project_id) AS JUMLAH
                                    FROM task_list INNER JOIN project_list 
                                    ON task_list.`project_id` = project_list.`id` 
                                    GROUP BY task_list.project_id
                                    LIMIT 3");
              while($row= $qry->fetch_assoc()):
                // var_dump($row);
          if ($i==1) {
            $warna = '#016738';
          }else if($i==2){
            $warna = '#876445';
          }
          else{
            $warna = '#1877F2';
          }
          ?>
          <div class="small-box shadow-sm border" style="height: 15rem;width: 23rem;margin-right: 30px;margin-left: 10px;background-color: <?php echo $warna; ?>;color: white;border-radius: 10px;" 
           <?php echo 'id="datas'.$i.'"'; ?>>
                <div class="row">
                  <div class="col-sm-10">
                    <div class="inner"  style="padding-left: 10px">
                      <a href="./index.php?page=view_project&id=<?php echo $row['id'] ?>" class="fa fa-bars" style="float: right !important;margin-right: -50px;margin-top: 10px;text-decoration: none;background-color: transparent;color: white"></a>
                        <span class="mr-2" style="color: grey">
                          <?php
                          // $qry = $conn->query("SELECT avatar FROM `users` WHERE id = '".$id[$i]."'");
                          $ids = explode(",", $row['user_ids']);
                          // echo count($ids);
                          for ($z=0; $z <count($ids) ; $z++) { 
                              // echo $z;
                              $user = $conn->query("SELECT avatar FROM users where id ='".$ids[$z]."'");
                              foreach($user->fetch_array() as $k =>$v){
                                $meta[$k] = $v;
                                   }
                            ?>
                            <img <?php echo 'id="ava'.$z.'"'; ?> src="<?php echo isset($meta['avatar']) ? 'assets/uploads/'.$meta['avatar'] :'' ?>" height="50px" width="55px"
                           style="border-radius: 100% 100%;margin-top: 10px">
                          <?php $z=$z; }?>
                           
                        </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                   <div class="col-sm-10">
                    <h4 style="margin-top: 30px;margin-left: 10px">
                      <strong>
                        <?php $name = explode(" ",$row['name']) ;
                         echo $name[0];

                        ?>
                      </strong>
                    </h4>
                    <h4 style="margin-left: 10px">
                       <strong>
                        <?php
                          echo str_replace($name[0],'',$row['name']);
                        ?>
                      </strong>
                    </h4>
                  </div>
                </div>
                <?php
                if (count($name)<=1) {
                  $margin = '65px';
                }else{
                  $margin = '30px';
                }
                ?>
                 <div class="row" style="margin-top: <?php echo $margin; ?>">
                   <div class="col-sm-10">
                    <p style="font-size: 15px;margin-left: 10px;"><strong><?php echo $row['JUMLAH'] ?> Task | <?php echo $row['end_date'] ?></strong></p>
                  </div>
                </div>
                 <div class="row" style="margin-top: -15px;">
                   <div class="col-sm-10">
                    <p><progress id="file" <?php echo "max='".$row['JUMLAH']."'"; ?> 
                    <?php echo "value='".$conn->query("SELECT * FROM task_list 
                                                      WHERE `status` = 3 AND project_id = '".$row['project_id']."' ")->num_rows."'";
                     ?> style="margin-left: 10px;">
                       </progress>
                     </p>
                  </div>
                </div>
                 <?php $i++;?>
                <!-- </div> -->
           </div>  
           <?php endwhile; ?>
      </div>

      <!-- dash task -->
      <div class="row">
        <div class="col-md-7">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-11">
              <a style="float: right;font-size: 15px; margin-top: 15px;color: #3884e9" id="seeAll" href="./index.php?page=task_list">See All</a> 
              <h4 id="task">Task For Today </h4>
              <?php
                $date = date('Y-m-d');
                $i = -1;
                // $type = array('',"Admin","Project Manager","Employee");
                $qry = $conn->query("SELECT a.*, b.`name`, b.`start_date`,b.`end_date` FROM task_list a 
                                      LEFT JOIN project_list b
                                      ON a.`project_id` = b.id 
                                      WHERE b.start_date = '".$date."' 
                                      order by b.start_date desc
                                      limit 3");
                $valQry =$qry->fetch_assoc();
                if ($valQry == null) {
                  echo "<script>
                        document.getElementById('seeAll').style.display = 'none';
                        document.getElementById('task').style.display = 'none';
                       </script>";
                }
                while($row= $qry->fetch_assoc()):
                $i++;
                ?>
                  <div class="small-box shadow-sm border"  style="border-radius: 10px;background-color: white">
                    <div class="row">
                      <div class="col-sm" style="width: 100px" <?php echo 'id="marks'.$i.'"'; ?>>
                        
                      </div>
                      <div class="col-sm-10">
                        <div class="inner" style="margin-top: 5px" >
                          <h5><strong><?php echo $row['name']; ?></strong></h5>
                          <p><?php echo $row['description']; ?></p>
                        </div>
                        <span style="color: grey;font-size: 12px" >end date: <?php echo $row['end_date']; ?></span>
                      </div>
                      <div class="col-sm-1" >
                      
                      </div>
                          <?php 
                            if ($row['status'] == 3) {
                              ?>
                              <i style="margin-top: 25px;" class="fa fa-check-circle"></i>
                              <?php
                            }else if($row['status'] == 2){
                              ?>
                              <i style="margin-top: 25px;" class="fa fa-bars"></i>
                              <?php
                            }else{
                              ?>
                              <i style="margin-top: 25px;" class="fa fa-spinner"></i>
                              <?php
                            }
                          ?>

                    </div>
                  </div>
              <?php endwhile; ?>

              
            </div>
            
         </div>
        </div>
        <div class="col-md-5">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-12" >
              <h4 id="task">Statistics Task</h4>
            </div>
          </div>
          <div class="row">
             <div class="col-6 col-sm-6 col-md-6">
                 <div class="small-box  shadow-sm border"  style="border-radius: 10px;background-color: white">
                    <div class="inner">
                      <h3><?php echo $conn->query("SELECT a.*, b.`name`, b.`start_date`,b.`end_date` FROM task_list a 
                                                  LEFT JOIN project_list b
                                                  ON a.`project_id` = b.id WHERE a.status = 2")->num_rows; ?></h3>
                      <p>On Progress Task</p>
                    </div>
                  <div class="icon">
                  </div>
                </div>  
            </div>
            <div class="col-6 col-sm-6 col-md-6">
                <div class="small-box shadow-sm border"  style="border-radius: 10px;background-color: white">
                  <div class="inner">
                    <h3><?php echo $conn->query("SELECT a.*, b.`name`, b.`start_date`,b.`end_date` FROM task_list a 
                                                LEFT JOIN project_list b
                                                ON a.`project_id` = b.id WHERE a.status = 3")->num_rows; ?></h3>
                    <p>Finished Task</p>
                  </div>
                  <div class="icon">
                  </div>
                </div>  
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
              <h4 id="task">Project Progress</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6 col-md-11">
              <div class="panel panel-primary">
                  <div class="panel-body">
                      <canvas id="myChart"></canvas>
                  </div>
              </div>
            </div>
                            
          </div>
        </div>
      </div>
      <div id="d"></div>
<script type="text/javascript">
  var today = new Date();
  $('#date').html(`<span style="margin-top:-25px;position:absolute;">${today}</span>`)
   $(document).ready(function(){
    // $.get("http://localhost:8080/tms/taskData.php",function(qry){
    $.get("http://localhost/tms/taskData.php",function(qry){
      // alert(qry['JUMLAH_UNDONE'])
      var isi_labels = ['In Progress','Completed'];
      var isi_data=[qry['JUMLAH_UNDONE'],qry['JUMLAH_DONE']];
      var TotalJml = 0;
      var ctx = document.getElementById('myChart').getContext('2d');

      var myPieChart = new Chart(ctx, {
          //chart akan ditampilkan sebagai pie chart
          type: 'doughnut',
          data: {
              //membuat label chart
              labels: isi_labels,
              datasets: [{
                  label: 'Data Task',
                  //isi chart
                  data: isi_data,
                  //membuat warna pada chart
                  backgroundColor: [
                      '#CCE1D7',
                      '#34A853'

                  ],
                  //borderWidth: 0, //this will hide border
              }]
          },
          options: {
              //konfigurasi tooltip
              tooltips: {
                  callbacks: {
                      label: function(tooltipItem, data) {
                          var dataset = data.datasets[tooltipItem.datasetIndex];
                          var labels = data.labels[tooltipItem.index];
                          var currentValue = dataset.data[tooltipItem.index];
                          return labels+": "+currentValue+" %";
                      }
                  }
              }
            }
      });
    })
     var colors = ['#ff0000', '#00ff00', '#0000ff', '#FFFAF0', '#F0E68C','#e0ffcd','#fdffcd','#42b883'];
     for (var i = 0; i < 30; i++) {
     var random_color = colors[Math.floor(Math.random() * colors.length)];
     document.getElementById('marks'+i).style.background = random_color;

     }
   


    })
</script>
<style type="text/css">
  /*@media (min-width: 576px)*/
  .col-sm{
    -ms-flex: 0 0 8.333333% !important;
    flex: 0 0 8.333333% !important;
    max-width: 0.333333% !important;
}
#ava0{
         position: relative;
         top: 0;
         left: 0;
}
#ava1{
         position: absolute;
         left: 60px;
}
#ava2{
         position: absolute;
         left: 100px;
}


</style>