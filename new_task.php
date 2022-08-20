<?php 
include 'db_connect.php';
// if(isset($_GET['id'])){
// }
?>
<div class="container-fluid">
	<form action="" id="new_task">
		<div class="form-group">
			<label for="">Pilih Project</label>
			
			<select id="project_id" name="project_id" class="form-control">
				<?php 
				$qry = $conn->query("SELECT * FROM project_list");
                while($row= $qry->fetch_assoc()):
				?>

				<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="">Task</label>
			<input type="text" class="form-control form-control-sm" name="task" id="task" required>
		</div>
		<div class="form-group">
			<label for="">Description</label>
			<textarea name="description" id="description" cols="30" rows="10" class="summernote form-control">
			</textarea>
		</div>
		<div class="form-group">
			<label for="">Status</label>
			<select name="status" id="status" class="custom-select custom-select-sm">
				<option value="1">Pending</option>
				<option value="2">On-Progress</option>
			</select>
		</div>
	</form>
</div>

<script>
	$(document).ready(function(){


	$('.summernote').summernote({
        height: 200,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    })

    
   })
     $('#uni_modal form').submit(function(e){
     	e.preventDefault()
    	start_load()
    	var datas = $('#task').val();
    	if (datas == null || datas == "") {
    		alert_toast('task is null',"error");
    		end_load();
    	}else{
    		
	    	$.ajax({
	    		url:'ajax.php?action=add_task',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
				success:function(resp){
					if(resp == 1){
						alert_toast('Data successfully saved',"success");
						setTimeout(function(){
							location.reload()
						},1500)
					}
				}
	    	})
    	}
    })
   
</script>