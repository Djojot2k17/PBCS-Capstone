<?php
	require_once '../config/init.php';
	include '../includes/head.php'; 
	include '../includes/navigation.php';

if (isset($_GET['add']) || isset($_GET['edit'])) {
	$user_id = $_SESSION['dbuser'];
	//create concept array and fill it with inputs
	$concept = array();
	$concept_milestone = ((isset($_POST['concept_milestone'])?sanitize($_POST['concept_milestone']):''));
	$concept_due_date = date_create(((isset($_POST['concept_due_date'])?$_POST['concept_due_date']:'')));
	$concept_due_date = date_format($concept_due_date, 'F j, Y');
	//var_dump($concept_due_date);
	$concept_deliverables = ((isset($_POST['concept_deliverables'])?sanitize($_POST['concept_deliverables']):''));
	$concept_fee = ((isset($_POST['concept_fee'])?sanitize($_POST['concept_fee']):''));
	//var_dump($concept_fee);
	$concept[] .= $concept_milestone;
	$concept[] .= $concept_due_date;
	$concept[] .= $concept_deliverables;
	$concept[] .= $concept_fee;
	//create design array and fill it with inputs
	$design = array();
	$design_milestone = ((isset($_POST['design_milestone'])?sanitize($_POST['design_milestone']):''));
	$design_due_date = date_create(((isset($_POST['design_due_date'])?$_POST['design_due_date']:'')));
	$design_due_date = date_format($design_due_date, 'F j, Y');
	$design_deliverables = ((isset($_POST['design_deliverables'])?sanitize($_POST['design_deliverables']):''));
	$design_fee = ((isset($_POST['design_fee'])?sanitize($_POST['design_fee']):''));
	$design[] .= $design_milestone;
	$design[] .= $design_due_date;
	$design[] .= $design_deliverables;
	$design[] .= $design_fee;
	//create technical array and fill it with inputs
	$technical = array();
	$technical_milestone = ((isset($_POST['technical_milestone'])?sanitize($_POST['technical_milestone']):''));
	$technical_due_date = date_create(((isset($_POST['technical_due_date'])?$_POST['technical_due_date']:'')));
	$technical_due_date = date_format($technical_due_date, 'F j, Y');
	$technical_deliverables = ((isset($_POST['technical_deliverables'])?sanitize($_POST['technical_deliverables']):''));
	$technical_fee = ((isset($_POST['technical_fee'])?sanitize($_POST['technical_fee']):''));
	$technical[] .= $technical_milestone;
	$technical[] .= $technical_due_date;
	$technical[] .= $technical_deliverables;
	$technical[] .= $technical_fee;
	//create test array and fill it with inputs
	$test = array();
	$test_milestone = ((isset($_POST['test_milestone'])?sanitize($_POST['test_milestone']):''));
	$test_due_date = date_create(((isset($_POST['test_due_date'])?$_POST['test_due_date']:'')));
	$test_due_date = date_format($test_due_date, 'F j, Y');
	$test_deliverables = ((isset($_POST['test_deliverables'])?sanitize($_POST['test_deliverables']):''));
	$test_fee = ((isset($_POST['test_fee'])?sanitize($_POST['test_fee']):''));
	$test[] .= $test_milestone;
	$test[] .= $test_due_date;
	$test[] .= $test_deliverables;
	$test[] .= $test_fee;
	if (isset($_GET['edit'])) {
		$edit_id = (int)$_GET['edit'];
		//query database to pre fill inputs
		$preSql = $db->query("SELECT * FROM milestones WHERE id = $edit_id");
		$preResults = mysqli_fetch_assoc($preSql);
		//get fieldset
		$concept_pre = json_decode($preResults['concept'],true);
		//format date to prepopulate input type date
		$concept_date = date_create($concept_pre[1]);
		$concept_pre[1] = date_format($concept_date, 'Y-m-d');
		//next fieldset
		$design_pre = json_decode($preResults['design'],true);
		$design_date = date_create($design_pre[1]);
		$design_pre[1] = date_format($design_date, 'Y-m-d');
		//next fieldset
		$technical_pre = json_decode($preResults['technical'],true);
		$technical_date = date_create($technical_pre[1]);
		$technical_pre[1] = date_format($technical_date, 'Y-m-d');
		//next fieldset
		$test_pre = json_decode($preResults['test'],true);
		$test_date = date_create($test_pre[1]);
		$test_pre[1] = date_format($test_date, 'Y-m-d'); 
		//print_r($design_pre);
	}
	if ($_POST) {
		$concept_json = json_encode($concept);
		$design_json = json_encode($design);
		$technical_json = json_encode($technical);
		$test_json = json_encode($test);
		//insert into database WHEN YOU INSERT YOU DON'T NEED THE DAMN WHERE CLAUSE
		$insertQuery = ("INSERT INTO milestones (concept, design, technical, test, student_id)
								VALUES ('{$concept_json}', '{$design_json}', '{$technical_json}', '{$test_json}', $user_id)");
	if (isset($_GET['edit'])) {
		$insertQuery = "UPDATE milestones
											SET concept = '{$concept_json}',
											design = '{$design_json}',
											technical = '{$technical_json}',
											test = '{$test_json}',
											student_id = $user_id
											WHERE id = $edit_id";
		}
		$db->query($insertQuery);
		$_SESSION['success_flash'] = 'Congratulations, you just completed your plan and milestones!';
		header('Location: dashboard.php');
		//print_r($insertQuery);
	}
	?>
	<h1 class="text-center"><?=((isset($_GET['edit'])?'Edit ':''));?>Work Plan and Milestones</h1>
	<hr class="container">
	<div class="plan-container">
		<h4>This is the planning phase.</h4>
		<p>The form below outlines the work process phases, milestones, due dates, deliverables and fees needed to complete this project. This four phase process begins at the concept phase where everything is planned, then the design phase where look and feel (artwork) is produced, next is the technical phase where design is given life, and finally the testing phase where everything is thoroughly tested and reviewed. This process is designed to ensure project efficiency.</p><br>
		<form action="plan_and_milestones.php?<?=((isset($_GET['edit']))?'edit='. $edit_id : 'add='.$user_id);?>" method="post" class="plan-form">
			<div class="form-group">
			<!-- CONCEPT PHASE -->
				<legend class="bg-info">Concept Phase</legend>
				<div class="col-md-3">
					<label for="concept_milestone">Milestone: </label>
					<input class="form-control" type="text" name="concept_milestone" value="<?= ((isset($concept_pre[0])?$concept_pre[0]:$concept_milestone));?>">
				</div>
				<div class="col-md-3">
					<label for="concept_due_date">Due Date: </label>
					<input class="form-control" type="date" name="concept_due_date" id="concept_date" value="<?= ((isset($concept_pre[1])?$concept_pre[1]:$concept_due_date));?>">
				</div>
				<div class="col-md-3">
					<label for="concept_deliverables">Deliverables: </label>
					<input class="form-control" type="text" name="concept_deliverables" value="<?= ((isset($concept_pre[2])?$concept_pre[2]:$concept_deliverables));?>">
				</div>
				<div class="col-md-3">
					<label for="concept_fee">Fee: </label>
					<input class="form-control" type="text" name="concept_fee" value="<?= ((isset($concept_pre[3])?$concept_pre[3]:$concept_fee));?>"><br>
				</div>
				<legend></legend>
			</div>				
			<div class="form-group">
				<!-- DESIGN PHASE -->
				<legend class="bg-success">Design Phase</legend>
				<div class="col-md-3">
					<label for="design_milestone">Milestone: </label>
					<input class="form-control" type="text" name="design_milestone" value="<?= ((isset($design_pre[0])?$design_pre[0]:$design_milestone));?>">
				</div>
				<div class="col-md-3">
					<label for="design_due_date">Due Date: </label>
					<input class="form-control" type="date" name="design_due_date" id="design_date" value="<?= ((isset($design_pre[1])?$design_pre[1]:$design_due_date));?>">
				</div>
				<div class="col-md-3">
					<label for="design_deliverables">Deliverables: </label>
					<input class="form-control" type="text" name="design_deliverables" value="<?= ((isset($design_pre[2])?$design_pre[2]:$design_deliverables));?>">
				</div>
				<div class="col-md-3">
					<label for="design_fee">Fee: </label>
					<input class="form-control" type="text" name="design_fee" value="<?= ((isset($design_pre[3])?$design_pre[3]:$design_fee));?>"><br>
				</div>
				<legend></legend>
			</div>
			<div class="form-group">
				<!-- TECHNICAL PHASE -->
				<legend class="bg-warning">Technical Phase</legend>
				<div class="col-md-3">
					<label for="technical_milestone">Milestone: </label>
					<input class="form-control" type="text" name="technical_milestone" value="<?= ((isset($technical_pre[0])?$technical_pre[0]:$technical_milestone));?>">
				</div>
				<div class="col-md-3">
					<label for="technical_due_date">Due Date: </label>
					<input class="form-control" type="date" name="technical_due_date" id="technical_date" value="<?= ((isset($technical_pre[1])?$technical_pre[1]:$technical_due_date));?>">
				</div>
				<div class="col-md-3">
					<label for="technical_deliverables">Deliverables: </label>
					<input class="form-control" type="text" name="technical_deliverables" value="<?= ((isset($technical_pre[2])?$technical_pre[2]:$technical_deliverables));?>">
				</div>
				<div class="col-md-3">
					<label for="technical_fee">Fee: </label>
					<input class="form-control" type="text" name="technical_fee" value="<?= ((isset($technical_pre[3])?$technical_pre[3]:$technical_deliverables));?>"><br>
				</div>
				<legend></legend>
			</div>
			<div class="form-group">
			<!-- TEST PHASE -->				
			<legend class="bg-danger">Test Phase</legend>
				<div class="col-md-3">
					<label for="test_milestone">Milestone: </label>
					<input class="form-control" type="text" name="test_milestone" value="<?= ((isset($test_pre[0])?$test_pre[0]:$test_milestone));?>">
				</div>
				<div class="col-md-3">
					<label for="test_due_date">Due Date: </label>
					<input class="form-control" type="date" name="test_due_date" id="test_date" value="<?= ((isset($test_pre[1])?$test_pre[1]:$test_due_date));?>">
				</div>
				<div class="col-md-3">
					<label for="test_deliverables">Deliverables: </label>
					<input class="form-control" type="text" name="test_deliverables" value="<?= ((isset($test_pre[2])?$test_pre[2]:$test_deliverables));?>">
				</div>
				<div class="col-md-3">
					<label for="test_fee">Fee: </label>
					<input class="form-control" type="text" name="test_fee" value="<?= ((isset($test_pre[3])?$test_pre[3]:$test_fee));?>"><br>
				</div>
				<legend></legend>	
			</div>
			<input type="submit" value="Submit" class="btn btn-success pull-right">
		</form>
		<a href="dashboard.php" class="btn btn-default pull-right">Cancel</a>
	</div>
<?php } ?>
<?php include '../includes/footer.php'; ?>