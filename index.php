<?php
	session_start();
	require_once ("db_connect.php");
	
	if(isset($_SESSION['duplicate'])){
		echo "Duplicate Task error";
	}
?>
<!DOCTYPE html>
<html>
  <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
      <title>Todo Application | Live Project</title>
      <link rel="stylesheet" href="css/main.css" />
  </head>
  <body>
    <div id="task-page">
        <div class="task-container">
            <div class="task-header">
                <h2>Todo list</h2>
            </div>
            <ul id="taskArea">
				<?php
					if($connect){ // Main connect check start
						
						//Delete logic
						if(isset($_GET['delete'])){
							$sql = "DELETE FROM task WHERE id = " . $_GET['delete'];
							
							$result = mysqli_query($connect, $sql);
							
							if($result){
								header ("Location: /todo2");
							} else {
								echo "Error " . mysqli_error($connect);
							}
							
						}
						
						//Create query
						$sql = "SELECT * FROM task ORDER BY id DESC";
						
						$result = mysqli_query($connect, $sql);
						
						if (mysqli_num_rows($result) > 0) {// Num row check start
							while($row = mysqli_fetch_assoc($result)) { //While start
				?>
							<li>                  
							  <table>
								<tr>
								  <td style="width: 85%;">
									<?php echo "" . $row['name'] ; ?>
								  </td>
								  <td style="width: 7%;">
									<a href="?edit=<?php echo '' . $row['id']; ?>">Edit</a>
								  </td>
								  <td style="width: 8%;">
									<a href="?delete=<?php echo '' . $row['id']; ?>">Delete</a>
								  </td>
								</tr>
							  </table>                  
							</li>
				<?php
							} // end while loop
						} // Num row check End
				?>
				
			</ul>
			
				<?php
					if(!isset($_GET['edit'])){//Check if edit parameter is not present
				?>
            
				<form action="save.php" method="post" id="taskForm" name="taskForm" nameForm="taskForm">
					<div class="form-group">
						<div class="input-group clearfix">
							<input type="text" name="task_title" placeholder="Type a task..."
								   autocomplete="off" class="form-control" required/>
							<button type="submit" class="primary" name="submit">Save</button>
						</div>
					</div>
				</form>
			
			<?php
					}//Check if edit parameter is not present
					
							//Edit logic load data in form field
							if(isset($_GET['edit'])){//Chek edit param
								//Create query
								$sql = "SELECT name FROM task WHERE id = " . $_GET['edit'];
								
								$result = mysqli_query($connect, $sql);
								
								if (mysqli_num_rows($result) > 0) {// Num row check start
									while($row = mysqli_fetch_assoc($result)) { //While start
			?>
										<form action="save.php?update=<?php echo '' . $_GET['edit']; ?>" method="post" id="taskForm" name="taskForm" nameForm="taskForm">
											<div class="form-group">
												<div class="input-group clearfix">
													<input type="text" name="task_title" placeholder="Type a task..." value="<?php echo '' . $row['name']; ?>"
														   autocomplete="off" class="form-control" required/>
													<button type="submit" class="primary" name="submit">Save</button>
												</div>
											</div>
										</form>
			<?php
									}// Num row check END
								}// Num row check End
							} // Check edit param end
					} // Main connect check END
			?>
			
        </div>
    </div>
  </body>
</html>