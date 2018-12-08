<?php
	session_start();
	
	require_once ("db_connect.php");
	if($connect){
		if(!isset($_GET['update'])){
			$task = $_POST['task_title'];
			
			//Check query if the task with same name already exists
			$sql = "SELECT * FROM task WHERE name = '$task'";
			$result = mysqli_query($connect, $sql);
			if (mysqli_num_rows($result) > 0) {// Num row check start
				$_SESSION['duplicate'] = true;
				header ("Location: /todo2");
			} else {
				//Insert new record
				$sql = "INSERT INTO task (name) VALUES ('$task')";
				
				$result = mysqli_query($connect, $sql);
				
				if($result){
					header ("Location: /todo2");
				} else {
					echo "Error " . mysqli_error($connect);
				}	
			}
					
		}	else {
			$task = $_POST['task_title'];
			//Update existing record
			$sql = "UPDATE task SET name = '$task' WHERE id = " . $_GET['update'];
			
			$result = mysqli_query($connect, $sql);
			
			if($result){
				header ("Location: /todo2");
			} else {
				echo "Error " . mysqli_error($connect);
			}	
		}
		
	} else {
		echo "Error " . mysqli_error($connect);
	}
	
	session_destroy();
?>