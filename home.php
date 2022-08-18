<?php include('db_connect.php') ?>
<?php
$twhere ="";
if($_SESSION['login_type'] != 1)
  $twhere = " ";
?>
<!-- Info boxes -->
 <div class="col-12" id="date" style="margin-left: -5px">

</div>
 <div class="col-12" style="padding-top: 10px;margin-left: -5px">
          <div class="card">
            <div class="card-body">
              Welcome <?php echo $_SESSION['login_name'] ?>!
            </div>
          </div>
  </div>
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
        <div class="col-md-8">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Project Progress</b>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0 table-hover">
                <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>Project</th>
                  <th>Progress</th>
                  <th>Status</th>
                  <th></th>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
                $where = "";
                if($_SESSION['login_type'] == 2){
                  $where = " where manager_id = '{$_SESSION['login_id']}' ";
                }elseif($_SESSION['login_type'] == 3){
                  $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
                }
                $qry = $conn->query("SELECT * FROM project_list $where order by name asc");
                while($row= $qry->fetch_assoc()):
                  $prog= 0;
                $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
                $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
                $prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
                $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;
                if($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
                if($prod  > 0  || $cprog > 0)
                  $row['status'] = 2;
                else
                  $row['status'] = 1;
                elseif($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
                $row['status'] = 4;
                endif;
                  ?>
                  <tr>
                      <td>
                         <?php echo $i++ ?>
                      </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['name']) ?>
                          </a>
                          <br>
                          <small>
                              Due: <?php echo date("Y-m-d",strtotime($row['end_date'])) ?>
                          </small>
                      </td>
                      <td class="project_progress">
                          <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                              </div>
                          </div>
                          <small>
                              <?php echo $prog ?>% Complete
                          </small>
                      </td>
                      <td class="project-state">
                          <?php
                            if($stat[$row['status']] =='Pending'){
                              echo "<span class='badge badge-secondary'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Started'){
                              echo "<span class='badge badge-primary'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='On-Progress'){
                              echo "<span class='badge badge-info'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='On-Hold'){
                              echo "<span class='badge badge-warning'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Over Due'){
                              echo "<span class='badge badge-danger'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Done'){
                              echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
                            }
                          ?>
                      </td>
                      <td>
                        <a class="btn btn-primary btn-sm" href="./index.php?page=view_project&id=<?php echo $row['id'] ?>">
                              <i class="fas fa-folder">
                              </i>
                              View
                        </a>
                      </td>
                  </tr>
                <?php endwhile; ?>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
        </div>
        <div class="col-md-4">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
              <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                  <h3><?php echo $conn->query("SELECT * FROM project_list $where")->num_rows; ?></h3>

                  <p>Total Projects</p>
                </div>
                <div class="icon">
                  <i class="fa fa-layer-group" style="color: #7fa99b"></i>
                </div>
              </div>
            </div>
             <div class="col-12 col-sm-6 col-md-12">
              <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                  <h3><?php echo $conn->query("SELECT t.*,p.name as pname,p.start_date,p.status as pstatus, p.end_date,p.id as pid FROM task_list t inner join project_list p on p.id = t.project_id $where2")->num_rows; ?></h3>
                  <p>Total Tasks</p>
                </div>
                <div class="icon">
                  <i class="fa fa-tasks" style="color: #007bff"></i>
                </div>
              </div>
            </div>
         </div>
        </div>
      </div>

      <!-- dash task -->
      <div class="row" style="margin-left: 2px">
        <div class="col-md-7">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
              <a style="float: right;font-size: 15px; margin-top: 15px;color: #3884e9" id="seeAll" href="./index.php?page=task_list">See All</a> 
              <h4 id="task">Task For Today </h4>
              <?php
                $date = date('Y-m-d');
                $i = -1;
                // $type = array('',"Admin","Project Manager","Employee");
                $qry = $conn->query("SELECT a.*, b.`name`, b.`start_date`,b.`end_date` FROM task_list a 
                                      LEFT JOIN project_list b
                                      ON a.`project_id` = b.id 
                                     -- WHERE b.start_date = '".$date."' 
                                     $where
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
                  <div class="small-box shadow-sm border" >
                    <div class="row">
                      <div class="col-sm" style="width: 100px" <?php echo 'id="marks'.$i.'"'; ?>>
                        
                      </div>
                      <div class="col-sm-10">
                        <div class="inner" style="margin-top: 5px">
                          <h5><strong><?php echo $row['name']; ?></strong></h5>
                          <p><?php echo $row['description']; ?></p>
                        </div>
                        <span style="color: grey;font-size: 12px" >end date: <?php echo $row['end_date']; ?></span>
                      </div>
                      <div class="col-sm-1" >
                        <!-- <div class="icon"> -->
                          <!-- <p><?php echo $row['status']; ?></p> -->
                          <!-- <i class="fa fa-check-circle"></i> -->
                        <!-- </div> -->
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
        <div class="col-md-1">
          
        </div>
        <div class="col-md-4">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
              <h4 id="task">Statistics Task</h4>
            </div>
          </div>
          <div class="row">
             <div class="col-6 col-sm-6 col-md-6">
                 <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                      <h3><?php echo $conn->query("SELECT a.*, b.`name`, b.`start_date`,b.`end_date` FROM task_list a 
                                                  LEFT JOIN project_list b
                                                  ON a.`project_id` = b.id WHERE a.status = 2 $where")->num_rows; ?></h3>
                      <p>On Progress</p>
                    </div>
                  <div class="icon">
                    <i class="fa fa-bars" style="color: #17a2b8"></i>
                  </div>
                </div>  
              <!-- </div> -->
            </div>
             <div class="col-6 col-sm-6 col-md-6">
                 <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                      <h3><?php echo $conn->query("SELECT a.*, b.`name`, b.`start_date`,b.`end_date` FROM task_list a 
                                                  LEFT JOIN project_list b
                                                  ON a.`project_id` = b.id WHERE a.status = 3 $where")->num_rows; ?></h3>
                      <p>Finished</p>
                    </div>
                  <div class="icon">
                    <i class="fa fa-check-circle" style="color: green"></i>
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
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <canvas id="myChart"></canvas>
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
    $.get("http://localhost:8080/tms/taskData.php",function(qry){
      // alert(qry['JUMLAH_UNDONE'])
      var isi_labels = ['On-Progress','Finished'];
      var isi_data=[qry['JUMLAH_UNDONE'],qry['JUMLAH_DONE']];
      var TotalJml = 0;
      var ctx = document.getElementById('myChart').getContext('2d');

      var myPieChart = new Chart(ctx, {
          //chart akan ditampilkan sebagai pie chart
          type: 'pie',
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
</style>