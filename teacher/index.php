<?php
	require_once '../config/init.php'; 
	include '../includes/head.php';
	include 'includes/navigation.php';
	
	//var_dump($_SESSION);
	$students_query = $db->query("SELECT * FROM users WHERE permissions = 'student'");
	$student_results = mysqli_fetch_all($students_query);
	//echo '<pre>'; print_r($student_results);
	//var_dump($student_info);
	if (isset($_GET['student'])) {
		$student = sanitize($_GET['student']);
		$work_title_query = $db->query("SELECT * FROM project_title WHERE student_id = $student");
		$work_title_results = mysqli_fetch_assoc($work_title_query);
		//var_dump($work_title_results);
		$work_client_query = $db->query("SELECT * FROM client_info WHERE student_id = $student");
		$work_client_results = mysqli_fetch_assoc($work_client_query);
		//var_dump($work_client_results);
		$work_student_query = $db->query("SELECT * FROM your_info WHERE student_id = $student");
		$work_student_results = mysqli_fetch_assoc($work_student_query);
		//Get the first and last name to populate student name in teacher comments
		$name_query = $db->query("SELECT first_name, last_name FROM your_info WHERE student_id = $student");
		$nameResult = mysqli_fetch_assoc($name_query);
		$name = $nameResult['first_name'].' '.$nameResult['last_name'];
		//var_dump($name);
		//var_dump($work_student_results);
		$work_student_scope_query = $db->query("SELECT * FROM project_scope WHERE student_id = $student");
		$work_student_scope_results = mysqli_fetch_assoc($work_student_scope_query);
		$images = explode(',', $work_student_scope_results['image']);
		$work_student_plan_query = $db->query("SELECT * FROM milestones WHERE student_id = $student");
		$milestones_json = mysqli_fetch_assoc($work_student_plan_query);
		$concept = json_decode($milestones_json['concept'],true);
		$design = json_decode($milestones_json['design'],true);
		$technical = json_decode($milestones_json['technical'],true);
		$test = json_decode($milestones_json['test'],true);
		//var_dump($student[1]);
	}

	// COMMENT SECTION
	$section = (isset($_POST['section'])?$_POST['section']:'');
	$comment = (isset($_POST['section_text'])?sanitize($_POST['section_text']):'');
	$teacher_id = $_SESSION['dbuser'];
	$teacher_query = $db->query("SELECT first_name, last_name FROM users WHERE id = $teacher_id");
	$teacher_results = mysqli_fetch_assoc($teacher_query);
	$teacher_name = $teacher_results['first_name'].' '.$teacher_results['last_name'];
	//var_dump($teacher_name);
	$student_id = (isset($_GET['student'])?$_GET['student']:'');
	if ($_POST) {
		if ($student == NULL || empty($comment)) {
			$_SESSION['error_flash'] = 'Error. You know what went wrong. Stop testing me.';
			header('Location: index.php'); 
		}	else {
			$insert_comment = "INSERT INTO teacher_comments (teacher_id, teacher_name, student_id, student_name, section, comment) VALUES ($teacher_id, '$teacher_name', $student_id, '$name', '$section', '$comment')";
			$db->query($insert_comment);
			//print_r($insert_comment);
			$_SESSION['success_flash'] = 'Comment Added.';
			header('Location: index.php');
		}
	}



?>
<div class="col-md-8 pull-right">
	<div class="row">
		<h1 class="text-center" id="top">Teacher Dashboard</h1>
		<hr>
		<div class="container">
			<form action="index.php?student=<?=$student?>" method="get" class="form-inline" id="student-work-form">
				<div class="form-group">
					<label for="student">Choose a student: </label>
					<select name="student" id="student" class="form-control">
					<?php foreach ($student_results as $student): ?>
						<option value="<?=$student[0];?>"><?=$student[1].' '.$student[2] ;?></option>
					<?php endforeach; ?>
					<input type="submit" value="View Work" class="btn btn-default">
					</select>
				</div>	
			</form>
			<hr>
			<?php if(isset($_GET['student'])) : ?>		
				<h3 class="text-center">Proposal Title</h3>
				<h4 class="text-center"><?=$work_title_results['project_name'];?></h4><br>
				<table class="table">
					<tr>
						<td>Prepared For: <?=$work_client_results['name'];?></td>
						<td>Prepared By: <?=$work_student_results['first_name'].' '.$work_student_results['last_name'];?></td>
					</tr>
					<tr>
						<td>Client Title: <?=$work_client_results['title'];?></td>
						<td>Telephone: <?=$work_student_results['telephone'];?></td>
					</tr>
					<tr>
						<td>Company Name: <?=$work_client_results['company_name'];?></td>
						<td>Fax: <?=(($work_student_results['fax'] != '')?$work_student_results['fax']:'None');?></td>
					</tr>
					<tr>
						<td>
							Company Address: <address><?=$work_client_results['company_address_line1'];?><br>
							<?=(($work_client_results['company_address_line2'] !='')?$work_client_results['company_address_line2']:'');?><br>
							<?=$work_client_results['company_city'].' '.$work_client_results['company_state'].', '.$work_client_results['company_zip'];?></address>
						</td>
						<td>Address: <address><?=$work_student_results['address_line1'];?><br>
							<?=(($work_student_results['address_line2'] !='')?$work_client_results['company_address_line2']:'');?><br>
							<?=$work_student_results['city'].' '.$work_student_results['state'].', '.$work_student_results['zip_code'];?></address></td>
					</tr>
				</table>
				<hr>
				<h3 class="text-center" id="scope">Project Scope</h3>
				<hr>
				<p><?=nl2br($work_student_scope_results['scope'])?></p>
				<hr>
				<h3 class="text-center" id="wireframes">Wireframe Images</h3>
				<hr>
				<?php foreach ($images as $key => $image): ?>
					<div class="col-sm-4">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal<?=$key;?>"><img src="<?=$image?>" alt="" class="wireframe_photo img-responsive"></button>
						<!-- Modal -->
						<div id="myModal<?=$key;?>" class="modal fade" role="dialog">
						  <div class="modal-dialog">
						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Wireframe <?=$key+1;?></h4>
						      </div>
						      <div class="modal-body">
						        <img src="<?=$image?>" alt="" class="img-responsive">
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						      </div>
						    </div>
						  </div>
						</div>							
					</div>
				<?php endforeach ?>
				<div class="clearfix"></div>
				<hr>
				<h3 class="text-center" id="milestones">Work Plan and Milestones</h3>
				<hr>
				<h4 class="text-center"><u>Concept</u></h4>
				<table class="table">
					<thead>
						<th>Milestone</th>
						<th>Due Date</th>
						<th>Deliverables</th>
						<th>Fee</th>
					</thead>
					<tbody>
						<tr>
							<td><?=$concept[0]?></td>
							<td><?=$concept[1]?></td>
							<td><?=$concept[2]?></td>
							<td><?=$concept[3]?></td>
						</tr>
					</tbody>
				</table>
				<hr>
				<h4 class="text-center"><u>Design</u></h4>
				<table class="table">
					<thead>
						<th>Milestone</th>
						<th>Due Date</th>
						<th>Deliverables</th>
						<th>Fee</th>
					</thead>
					<tbody>
						<tr>
							<td><?=$design[0]?></td>
							<td><?=$design[1]?></td>
							<td><?=$design[2]?></td>
							<td><?=$design[3]?></td>
						</tr>
					</tbody>
				</table>
				<hr>
				<h4 class="text-center"><u>Technical</u></h4>
				<table class="table">
					<thead>
						<th>Milestone</th>
						<th>Due Date</th>
						<th>Deliverables</th>
						<th>Fee</th>
					</thead>
					<tbody>
						<tr>
							<td><?=$technical[0]?></td>
							<td><?=$technical[1]?></td>
							<td><?=$technical[2]?></td>
							<td><?=$technical[3]?></td>
						</tr>
					</tbody>
				</table>
				<hr>
				<h4 class="text-center"><u>Test</u></h4>
				<table class="table">
					<thead>
						<th>Milestone</th>
						<th>Due Date</th>
						<th>Deliverables</th>
						<th>Fee</th>
					</thead>
					<tbody>
						<tr>
							<td><?=$test[0]?></td>
							<td><?=$test[1]?></td>
							<td><?=$test[2]?></td>
							<td><?=$test[3]?></td>
						</tr>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
		<hr id="comment">
		<div class="container">
			<h3>Comments</h3>
			<p>Select a section where you would like to leave a comment.</p>
			<form action="index.php?student=<?=(isset($_GET['student'])?$_GET['student']:'')?>" method="post">
				<div class="form-group">
					<label for="student_name">Student Name: </label>
					<input type="text" value="<?=((isset($name)?$name:''));?>" class="form-control" id="student_name" name="student_name" readonly><br>
					<label for="section">Section: </label>
					<select name="section" id="section" class="form-control">
						<option value="title">Proposal Title</option>
						<option value="scope">Project Scope</option>
						<option value="wireframes">Wireframe Images</option>
						<option value="plan">Work Plan and Milestones</option>
					</select>
				</div>
				<div class="form-group">
					<label for="section_text">Comment:</label>
					<textarea name="section_text" id="section_text" rows="10" class="form-control" placeholder="Here you can provide feedback to your students. Please don't leave it blank!"></textarea>
				</div>
				<input type="submit" value="Submit" class="btn btn-default">
			</form>
		</div>
	</div>
</div>
<?php 
	include 'includes/leftbar.php';
	include '../includes/footer.php'; 
?>