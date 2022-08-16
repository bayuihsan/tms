<?php include'db_connect.php' ?>
<div class="col-lg-6">
	<div class="card">
		<div class="card-body">
			<small id="#msg"></small>
			<form action="" id="manage_role">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Akses Menu</label>
							<select name="type" id="menu" class="custom-select custom-select-sm">
								 <?php
							          $qry = $conn->query("SELECT * FROM tabel_menu
							                               WHERE is_active = 1 and parent = 0 ");
							          while($row= $qry->fetch_assoc()):
							            // echo var_dump($qry);
							      ?>
								<option <?php echo 'value="'.$row['id_menu'].'"'; ?>> 
									<?php echo $row['nama_menu']; ?>
							    </option>
       				 				  <?php endwhile; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="" class="control-label">User Role</label>
							<select name="type" id="type" class="custom-select custom-select-sm">
								 <?php
							          $qry = $conn->query("SELECT * FROM par_user_role
							                               WHERE is_active = 1 and id_role !=1 ");
							          while($row= $qry->fetch_assoc()):
							            // echo var_dump($qry);
							      ?>
								<option <?php echo 'value="'.$row['id_role'].'"'; ?>> 
									<?php echo $row['nama_role']; ?>
							    </option>
       				 				  <?php endwhile; ?>
							</select>
						</div>
					</div>
				</div>
			</form>
			<div class="col-lg-12" style="margin-left: -6px">
					<button class="btn btn-primary mr-2" onclick="saveRole()" >Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=role'">Cancel</button>
				</div>
		</div>
	</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>

	
	function saveRole(){
	    	start_load();
			var id_menu = $('#menu').val();
			var id_tabel_role = $('#type').val();
			$.ajax({
			url:'ajax.php?action=save_role',
			data: {id_menu:id_menu,id_tabel_role:id_tabel_role},
		    method: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=role')
					},750)
				}else{
					alert_toast('Failed save data.',"Failed");
				}
			    end_load()

			}
		})
	}
	
</script>