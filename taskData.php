<?php
	include'db_connect.php';
	session_start();
    header("Content-Type: text/json");

    //the data format your question mentioned
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
    $qry = $conn->query("SELECT 
                        CONVERT((SELECT COUNT(*) FROM task_list WHERE STATUS = 3)/MAX(task_list.ID)*100,INT) AS JUMLAH_DONE,
                        CONVERT((SELECT COUNT(*) FROM task_list WHERE STATUS != 3)/MAX(task_list.ID)*100,INT) AS JUMLAH_UNDONE
                        FROM task_list INNER JOIN project_list 
                        ON task_list.`project_id` = project_list.`id` $where")->fetch_assoc();

    echo json_encode($qry);
    // $chartQuery = "SELECT 
				// 		(SELECT COUNT(*) FROM task_list WHERE STATUS = 3)/MAX(task_list.ID) AS JUMLAH_DONE,
				// 		(SELECT COUNT(*) FROM task_list WHERE STATUS != 3)/MAX(task_list.ID) AS JUMLAH_UNDONE
				// 		FROM task_list INNER JOIN project_list 
				// 		ON task_list.`project_id` = project_list.`id` ";
    // $chartQueryRecords = mysqli_query($conn,$chartQuery);
?>