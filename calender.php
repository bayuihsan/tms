<?php include'db_connect.php' ?>
    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-9" style="background-color: #FFCB42">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <div class="cardt rounded-0 shadow">
                    <div class="card-header bg-gradient bg-primary text-light">
                        <h5 class="card-title">Schedule Form</h5>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="save_schedule.php" method="post" id="schedule-form">
                                <input type="hidden" name="id" value="">
                                <div class="form-group mb-2">
                                    <label for="title" class="control-label">Title</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="description" class="control-label">Description</label>
                                    <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="start_datetime" class="control-label">Start</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="end_datetime" class="control-label">End</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="title" class="control-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1">Pending</option>
                                        <option value="2">Progress</option>
                                        <option value="3">Done</option>
                                    </select>
                                </div>
                                <div class="form-group mb-2" style="display: none">
                                    <label for="id_user" class="control-label">id_user</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="id_user" id="id_user" 
                                    <?php echo 'value="'.$_SESSION['login_id'].'"'; ?>>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <button class="btn btn-primary btn-sm rounded-0" type="submit" id="save" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                            <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->
    <div class="modal" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Title</dt>
                            <dd id="title" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Description</dt>
                            <dd id="description" class=""></dd>
                            <dt class="text-muted">Start</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">End</dt>
                            <dd id="end" class=""></dd>
                            <dt class="text-muted">Status</dt>
                            <dd id="status" class="fw-bold fs-4"></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" onclick="hide()" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->


<?php 
// var_dump($_SESSION['login_id']);
$schedules = $conn->query("SELECT * FROM `schedule_list` where id_user = '".$_SESSION['login_id']."'");
$sched_res = [];
while($row= $schedules->fetch_assoc()):
    $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
endwhile;
?>
<?php 
if(isset($conn)) $conn->close();
?>
<script type="text/javascript">
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
  
</script>
<script type="text/javascript">
    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];
    $(function() {
        if (!!scheds) {
            Object.keys(scheds).map(k => {
                var row = scheds[k];
                if (row.status == 3) {
                    status = '(Done)';
                }else if(row.status == 2){
                    status = '(On-Progress)';
                }else{
                    status = '(Pending)';
                }
                events.push({ id: row.status,id: row.id, title: row.title+' '+status, start: row.start_datetime, end: row.end_datetime });
            })
        }
        var date = new Date()
       
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()



        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next today',
                right: '',
                center: 'title',
            },

            selectable: true,
            themeSystem: 'bootstrap',
            //Random default events
            events: events,
            eventClick: function(info) {
                var _details = $('#event-details-modal')
                var id = info.event.id
                if (scheds[id].status == '1') {
                    scheds[id].status = 'Pending';
                    }else if(scheds[id].status == '2'){
                    scheds[id].status = 'Progress';
                    }else{
                    scheds[id].status = 'Done';
                    }
                if (!!scheds[id]) {
                    _details.find('#title').text(scheds[id].title)
                    _details.find('#description').text(scheds[id].description)
                    _details.find('#start').text(scheds[id].sdate)
                    _details.find('#end').text(scheds[id].edate)
                    _details.find('#status').text(scheds[id].status)
                    _details.find('#edit,#delete').attr('data-id', id)
                    _details.modal('show')
                } else {
                    alert("Event is undefined");
                }
            },
            eventDidMount: function(info) {
                // Do Something after events mounted
            },
            editable: true
        });

        calendar.render();

        // Form reset listener
        $('#schedule-form').on('reset', function() {
            $(this).find('input:hidden').val('')
            $(this).find('input:visible').first().focus()
        })

        // Edit Button
        $('#edit').click(function() {
            var id = $(this).attr('data-id')
            if (!!scheds[id]) {
                var _form = $('#schedule-form');
                if (scheds[id].status == 'Pending') {
                    scheds[id].status = '1';
                    }else if(scheds[id].status == 'Progress'){
                    scheds[id].status = '2';
                    }else{
                    scheds[id].status = '3';
                    }
                console.log(String(scheds[id].start_datetime), String(scheds[id].start_datetime).replace(" ", "\\t"))
                _form.find('[name="id"]').val(id)
                _form.find('[name="title"]').val(scheds[id].title)
                _form.find('[name="description"]').val(scheds[id].description)
                _form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime).replace(" ", "T"))
                _form.find('[name="end_datetime"]').val(String(scheds[id].end_datetime).replace(" ", "T"))
                _form.find('[name="status"]').val(scheds[id].status)
                $('#event-details-modal').modal('hide')
                _form.find('[name="title"]').focus()
            } else {
                alert("Event is undefined");
            }
        })
        

       
    })
</script>
<script type="text/javascript">
     $(document).ready(function(){
      $('#delete').click(function(){
      _conf("Are you sure to delete this schedule?","delete_schedule",[$(this).attr('data-id')])
      })
      // $('.fc-daygrid-event-harness')
       var datas;
       var my_css_class = { backgroundColor : 'red' };
       // var master_title = $(".fc-event-title").html();
       $(".fc-event-title:contains(Done)").append(` <i style="color: green" class="fa fa-check-circle"></i>`);
       $(".fc-event-title:contains(On-Progress)").append(` <i style="color: black" class="fa fa-bars"></i>`);
       $(".fc-event-title:contains(Pending)").append(` <i style="color: orange" class="fa fa-spinner"></i>`);
       // $(".fc-event-title:contains(On-Progress)").css("background-color", "grey");
       // $(".fc-event-title:contains(Pending)").css("background-color", "#F36306");
       // $(".fc-event-time:contains(a)").html("");
       $(".fc-event-time").html("");
       const boxs = document.querySelector('.fc-prev-button');
            boxs.setAttribute('onclick', 'box()');
       const box = document.querySelector('.fc-next-button');
        box.setAttribute('onclick', 'box()');
        const box2 = document.querySelector('.fc-today-button');
        box2.setAttribute('onclick', 'box()');


      })
     function box(){
       
       var my_css_class = { backgroundColor : 'red' };
       $(".fc-event-title:contains(Done)").css("background-color", "green");
       $(".fc-event-title:contains(On-Progress)").css("background-color", "grey");
       $(".fc-event-title:contains(Pending)").css("background-color", "#F36306");
       // $(".fc-event-time:contains(a)").html("");
       $(".fc-event-time").html("");
     }
     


      function delete_schedule($id){
        start_load()
        // alert(id);
        $.ajax({
          url:'ajax.php?action=delete_schedule',
          method:'POST',
          data:{id:$id},
          success:function(resp){
            if(resp==1){
              alert_toast("Data successfully deleted",'success')
              setTimeout(function(){
                location.reload()
              },1500)

            }
          }
        })
      }
      function hide(){
      $('.modal').modal('hide');
    }
</script>
 <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            /*font-family: Apple Chancery, cursive;*/
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }
        table, tbody, td, tfoot, th, thead, tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }
    </style>
