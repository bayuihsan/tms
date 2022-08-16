<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<!-- <div class="card-header"> -->
			<div class="row">
				<div class="col-sm-1">
					<a class="btn btn-block btn-sm btn-default btn-flat" style="border-radius: 8px; margin-top: 20px;margin-left: 17px" href="./index.php?page=new_role">Add New <i class="fa fa-plus" style="color: white;background-color: #800000;"></i></a>
				</div>
			</div>
		<!-- </div> -->
		<div class="card-body" style="margin-top: -15px">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Role</th>
						<th>Menu Akses</th>
						<!-- <th>Role</th> -->
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					// $type = array('',"Admin","Project Manager","Employee");
					$qry = $conn->query("SELECT a.*, c.nama_role,b.id_tabel_role FROM tabel_menu a
										INNER JOIN tabel_role b 
										ON a.id_menu = b.id_menu
										INNER JOIN par_user_role c
										ON b.id_tabel_role = c.id_role");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['nama_role']) ?></b></td>
						<td><b><?php echo $row['nama_menu'] ?></b></td>
						<!-- <td><b><?php echo $type[$row['type']] ?></b></td> -->
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="" >
		                      <a class="dropdown-item delete_role" id="delete_role"  <?php echo "onclick='beforeAction(".$row['id_menu'].",".$row['id_tabel_role'].")'";?>>Delete</a>
		                    </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable({
			"bPaginate": false,
		    "bLengthChange": false,
		    "bFilter": true,
		    "bInfo": false,
		    "bAutoWidth": false 
		})
		// $('#delete_role').click(function(){
		// _conf("Are you sure to delete this role akses?","delete_role")
		// })
		})

	function beforeAction($id_menu, $id_tabel_role){
		_conf("Are you sure to delete this role akses?","delete_role",[$id_menu, $id_tabel_role]);
	}

	function delete_role($id_menu,$id_tabel_role){
		start_load();
		$.ajax({
			url:'ajax.php?action=delete_role',
			method:'POST',
			data:{id_menu:$id_menu,id_tabel_role:$id_tabel_role},
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
</script>