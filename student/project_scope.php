<?php
require_once '../config/init.php';
include '../includes/head.php'; 
include '../includes/navigation.php';

$db_path = '';
$user_id = $_SESSION['dbuser'];
$project_scope = ((isset($_POST['project_scope'])?sanitize($_POST['project_scope']):''));
$saved_image = '';
if (isset($_GET['add']) || isset($_GET['edit'])) {
	if (isset($_GET['edit'])) {
		$edit_id = (int)$_GET['edit'];
		$scope_edit = $db->query("SELECT * FROM project_scope WHERE id= '$edit_id'");
		$scope_results = mysqli_fetch_assoc($scope_edit);	
		if (isset($_GET['delete_image'])) {
			$imgi = (int)$_GET['imgi'] -1;
			$images = explode(',',$scope_results['image']);
			$image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgi];
			unlink($image_url);
			unset($images[$imgi]);
			$imageString = implode(',',$images);
			$db->query("UPDATE project_scope SET image = '$imageString' WHERE id = '$edit_id'");
			header('Location: project_scope.php?edit='.$edit_id);
		}
		$saved_image = (($scope_results['image'] != '')?$scope_results['image']:'');
			//var_dump($saved_image);
		$db_path = $saved_image;
	}		 
	if ($_POST) {
		//var_dump($_FILES);
		//create errors array
		$errors = array();
		//check that all fields are filled
		$photoName = array();
		$tmpLoc = array(); 	
		$allowed = array('png', 'jpg', 'jpeg', 'gif');
		$upload_location = array();
		//check uploaded files and upload paths
		$photoCount = count($_FILES['photo']['name']);
		if ($photoCount > 0) {
			for ($i=0; $i < $photoCount; $i++) {
		  		//var_dump($photoCount); 	 	
				$name = $_FILES['photo']['name'][$i];
		 		//var_dump($name);
				$name_array = explode('.' , $name);
		 	 	//var_dump($name_array);
				$filename = $name_array[0];
				$file_extension = $name_array[1];
			 	//var_dump($file_extension);
				$mime = explode('/', $_FILES['photo']['type'][$i]);
				$mime_type = $mime[0];
				$mime_extension = $mime[1];
				$tmpLoc[] = $_FILES['photo']['tmp_name'][$i];
				$fileSize = $_FILES['photo']['size'][$i];
				$upload_name = md5(microtime().$i).'.'.$file_extension;
				$upload_location[] = BASEURL.'student/wireframe_images/'.$upload_name;
				if($i != 0){
					$db_path .= ',';
				}
				$db_path .= '/php/capstone/student/wireframe_images/'.$upload_name;

			 	//check for errors and limits
				if ($mime_type != 'image') {
					$errors[] = 'The file must be an image';
				}
				if ($fileSize > 10000000) {
					$errors[] = 'The file must be less than 10MB';
				}
				if ($file_extension != $mime_extension && ($mime_extension == 'jpeg' && $file_extension != 'jpg')) {
					$errors[] = 'File extension does not match the file';
				}
				if (!in_array($file_extension, $allowed)) {
					$errors[] = 'The file extension must be a png, jpg, jpeg, or gif file';
				}
			}
		}
		if (!empty($errors)) {
			echo display_errors($errors);
		} else {
			//update database
			if ($photoCount > 0) {
				for ($i=0; $i < $photoCount; $i++) { 
					move_uploaded_file($tmpLoc[$i], $upload_location[$i]);
				}

			}
			$insertSql = "INSERT INTO project_scope (scope, image, student_id) VALUES ('$project_scope', '$db_path', $user_id)";		
			if (isset($_GET['edit'])) {
				$insertSql = "UPDATE project_scope 
				SET scope = '$project_scope', 
				image = '$db_path', 
				student_id = '$user_id' 
				WHERE id = '$edit_id'";
				//var_dump($insertSql);
			}
			$db->query($insertSql);
			$_SESSION['success_flash'] = 'Congratulations, you just completed your project scope!';
			header('Location: dashboard.php');
			//var_dump($insertSql);
		}
	}
	?>
	<h1 class="text-center"><?=((isset($_GET['edit'])?'Edit ':''));?> Project Scope</h1>
	<hr class="container">
	<div class="scope-container">
		<div class="col-md-4">
			<h4>Describe your project in three or four paragraphs.</h4>
			<p>You <b>must</b> include the following:</p>
			<ul>
				<li>Description of functionality/interactivity</li>
				<li>Description of what programming will be involved</li>
				<li>Description of database functionality</li>
				<li>Description of marketability and intended audience</li>
				<li>Estimate of time and cost</li>
			</ul>
			<p>Remember to keep it simple and for now, don't worry too much about making it fancy.</p>
		</div>
		<form action="project_scope.php?<?=((isset($_GET['edit'])?'edit='.$edit_id:'add='.$user_id));?>" method="POST" enctype="multipart/form-data">
			<div class="form-group col-md-8">
				<label for="project_scope">Project Scope: </label>
				<textarea class="form-control" name="project_scope" id="project_scope" rows="10"><?= ((isset($scope_results['scope']))?$scope_results['scope']:'')?></textarea>
			</div>
			<div class="form-group col-md-4">
				<h3 class="text-center">Wireframes</h3>
				<p>Here's where you'll upload images of your wireframes.</p>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-folder-open"></i></span>
					<input type="file" name="photo[]" id="photo" class="form-control btn btn-default" multiple>
				</div>
			</div>
			<div class="form-group col-md-8">
				<div>
					<?php if ($saved_image != '') : ?>
						<?php
						$imgi = 1;
						$images = explode(',',$saved_image);?>
						<?php foreach($images as $image): ?>
							<div class="col-md-2">
								<img src="<?=$image?>" class="img-responsive wireframe_photo" alt="saved_image">
								<a href="project_scope.php?delete_image=1&edit=<?=$edit_id?>&imgi=<?=$imgi;?>" class="text-danger">Delete Image</a>
							</div>
							<?php 
							$imgi++;
							endforeach; 
							?>
						<?php endif ?>
					</div>
				</div>
				<div class="clearfix"></div>
				<hr>
				<input type="submit" value="Submit" class="btn btn-success pull-right">
		</form>
		<a href="dashboard.php" class="btn btn-default pull-right">Cancel</a>			
	</div>
<?php } ?>
<?php include '../includes/footer.php'; ?>