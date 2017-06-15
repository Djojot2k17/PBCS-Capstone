<?php
require_once '../config/init.php';
include '../includes/head.php'; 
include '../includes/navigation.php';

if (isset($_GET['add']) || isset($_GET['edit'])) {
	$edit_id = (int)isset($_GET['edit']);
	//var_dump($edit_id);
	//proposal title
	$project_title = ((isset($_POST['project_title'])?$_POST['project_title']:''));
	//prepared for
	$client_name = ((isset($_POST['client_name'])?$_POST['client_name']:''));
	$client_title = ((isset($_POST['client_title'])?$_POST['client_title']:''));
	$client_company_name = ((isset($_POST['client_company_name'])?$_POST['client_company_name']:''));
	$client_company_address_line1 = ((isset($_POST['client_company_address_line1'])?$_POST['client_company_address_line1']:''));
	$client_company_address_line2 = ((isset($_POST['client_company_address_line2'])?$_POST['client_company_address_line2']:''));
	//var_dump($client_company_address_line2);
	$client_company_city = ((isset($_POST['client_company_city'])?$_POST['client_company_city']:''));
	$client_company_state = ((isset($_POST['client_company_state'])?$_POST['client_company_state']:''));
	$client_company_zip = ((isset($_POST['client_company_zip'])?$_POST['client_company_zip']:''));
	$start_date = date_create(((isset($_POST['start_date'])?$_POST['start_date']:'')));
	$start_date = date_format($start_date, 'F j, Y');
	//prepared by
	$your_first_name = ((isset($_POST['your_first_name'])?$_POST['your_first_name']:''));
	$your_last_name = ((isset($_POST['your_last_name'])?$_POST['your_last_name']:''));
	$your_address_line1 = ((isset($_POST['your_address_line1'])?$_POST['your_address_line1']:''));
	$your_address_line2 = ((isset($_POST['your_address_line2'])?$_POST['your_address_line2']:''));
	$your_city = ((isset($_POST['your_city'])?$_POST['your_city']:''));
	$your_state = ((isset($_POST['your_state'])?$_POST['your_state']:''));
	$your_zip = ((isset($_POST['your_zip'])?$_POST['your_zip']:''));
	$your_telephone = ((isset($_POST['your_telephone'])?$_POST['your_telephone']:''));
	$your_fax = ((isset($_POST['your_fax'])?$_POST['your_fax']:''));
	$your_email = ((isset($_POST['your_email'])?$_POST['your_email']:''));
	//prepopulate fields based on user login info
	$user_id = $_SESSION['dbuser'];
	$preSql = $db->query("SELECT * FROM users WHERE id = $user_id");
	$pre_results = mysqli_fetch_assoc($preSql);
	//var_dump($pre_results);
	$pre1Sql = $db->query("SELECT * FROM your_info WHERE id = $user_id");
	$pre1_results = mysqli_fetch_assoc($pre1Sql);
	//print_r($pre1_results);
	$start = date_create($pre1_results['start_date']);
	$pre1_results['start_date'] = date_format($start, 'Y-m-d');
	$pre2Sql = $db->query("SELECT * FROM client_info WHERE id = $user_id");
	$pre2_results = mysqli_fetch_assoc($pre2Sql);
	$pre3Sql = $db->query("SELECT * FROM project_title WHERE id = $user_id");
	$pre3_results = mysqli_fetch_assoc($pre3Sql);
	if ($_POST) {
		$errors = array();
		if (!empty($errors)) {
			// display errors
			echo display_errors($errors);
		} else {
			if (isset($_GET['add'])) {
			// insert into database
				$titleSql = "INSERT INTO project_title (project_name, student_id) VALUES ('$project_title', '$user_id')";
				$db->query($titleSql);
				$clientSql = "INSERT INTO client_info (name, title, company_name, company_address_line1, company_address_line2, company_city, company_state, company_zip, student_id) VALUES ('$client_name', '$client_title', '$client_company_name', '$client_company_address_line1', '$client_company_address_line2', '$client_company_city', '$client_company_state', '$client_company_zip', $user_id)";
				$db->query($clientSql);
				$yourSql = "INSERT INTO your_info (first_name, last_name, telephone, fax, address_line1, address_line2, city, state, zip_code, email, start_date, student_id) VALUES ('$your_first_name', '$your_last_name', '$your_telephone', '$your_fax', '$your_address_line1', '$your_address_line2', '$your_city', '$your_state', '$your_zip', '$your_email', '$start_date', $user_id)";
				$db->query($yourSql);
				$_SESSION['success_flash'] = 'You have just completed the first part of your proposal!';
				header('Location: dashboard.php');
				//print_r($yourSql);
			}
				if (isset($_GET['edit'])) {
					// update title in database CAREFUL WITH THE GODDAMN PARENTHESES!!!!!!
				$titleSql = "UPDATE project_title SET project_name = '$project_title', student_id = '$user_id' WHERE id = '$edit_id'";
				$db->query($titleSql);
				//update client_info in database
				$clientSql = "UPDATE client_info 
											SET name = '$client_name', 
													title = '$client_title', 
													company_name = '$client_company_name', 
													company_address_line1 = '$client_company_address_line1', 
													company_address_line2 = '$client_company_address_line2', 
													company_city = '$client_company_city', 
													company_state = '$client_company_state', 
													company_zip = '$client_company_zip', 
													student_id = '$user_id' 
											WHERE id = '$edit_id'";
				$db->query($clientSql);
				// update your_info in database
				$yourSql = "UPDATE your_info 
										SET first_name = '$your_first_name', 
												last_name = '$your_last_name', 
												telephone = '$your_telephone', 
												fax = '$your_fax', 
												address_line1 = '$your_address_line1', 
												address_line2 = '$your_address_line2', 
												city = '$your_city', 
												state = '$your_state', 
												zip_code = '$your_zip', 
												email = '$your_email', 
												start_date = '$start_date', 
												student_id = '$user_id' 
										WHERE id = '$edit_id'";
				$db->query($yourSql);
				$_SESSION['success_flash'] = 'Project Heading updated.';
				header('Location: dashboard.php');
				//print_r($yourSql);
				}				
			}
		}
		//print_r($project_title);
	?>
	<h1 class="text-center"><?=((isset($_GET['edit'])?'Edit ':''));?>Capstone Proposal Heading</h1>
	<hr class="container">
	<form action="project_title.php?<?=((isset($_GET['edit']))?'edit='. $edit_id : 'add='.$user_id);?>" method="post" id="title-form">	
		<div class="form-group">
			<label for="project_title">Project Title: </label>
			<input class="form-control" type="text" name="project_title" id="project_title" value="<?=(($pre3_results['project_name'] != '')?$pre3_results['project_name']:$project_title);?>">
		</div>
		<div class="col-md-6">
			<legend>Prepared For</legend>
			<div class="form-group">
				<label for="client_name">Client Name: </label>
				<input class="form-control" type="text" name="client_name" id="client_name" value="<?=(($pre2_results['name'] != '')?$pre2_results['name']:$client_name);?>">
			</div>
			<div class="form-group">
				<label for="client_title">Client Title: </label>
				<input class="form-control" type="text" name="client_title" id="client_title" value="<?=(($pre2_results['title'] != '')?$pre2_results['title']:$client_title);?>">
			</div>
			<div class="form-group">
				<label for="client_company_name">Client Company Name: </label>
				<input class="form-control" type="text" name="client_company_name" id="client_company_name" value="<?=(($pre2_results['company_name'] != '')?$pre2_results['company_name']:$client_company_name);?>">
			</div>
			<div class="form-group">
				<label for="client_company_address">Client Company Address: </label>
				<input class="form-control" type="text" name="client_company_address_line1" value="<?=(($pre2_results['company_address_line1'] != '')?$pre2_results['company_address_line1']:$client_company_address_line1);?>" placeholder="Address Line 1">
				<input class="form-control" type="text" name="client_company_address_line2" value="<?=(($pre2_results['company_address_line2'] != '')?$pre2_results['company_address_line2']:$client_company_address_line2);?>" placeholder="Address Line 2">
				<input class="form-control" type="text" name="client_company_city" value="<?=(($pre2_results['company_city'] != '')?$pre2_results['company_city']:$client_company_city);?>" placeholder="City">
				<input class="form-control" type="text" name="client_company_state" value="<?=(($pre2_results['company_state'] != '')?$pre2_results['company_state']:$client_company_state);?>" placeholder="State: FL">
				<input class="form-control" type="text" name="client_company_zip" value="<?=(($pre2_results['company_zip'] != '')?$pre2_results['company_zip']:$client_company_zip);?>" placeholder="Zip Code">
			</div>
			<div class="form-group">
				<label for="start_date">Start Date: </label>
				<input class="form-control" type="date" name="start_date" id="start_date" value="<?=(($pre1_results['start_date'] != '')?$pre1_results['start_date']:$start_date);?>">
			</div>
		</div>
		<div class="col-md-6">
			<legend>Prepared By</legend>
			<div class="form-group">
				<label for="your_first_name">Your First Name: </label>
				<input class="form-control" type="text" name="your_first_name" value="<?=(($pre_results['first_name'] != '')?$pre_results['first_name']:$your_first_name);?>">
			</div>
			<div class="form-group">
				<label for="your_last_name">Your Last Name: </label>
				<input class="form-control" type="text" name="your_last_name" value="<?=(($pre_results['last_name'] != '')?$pre_results['last_name']:$your_last_name);?>">
			</div>
			<div class="form-group col-md-6">
				<label for="your_telephone">Your Telephone: </label>
				<input class="form-control" type="tel" name="your_telephone" value="<?=(($pre_results['phone_number'] != '')?$pre_results['phone_number']:$your_telephone);?>">
			</div>
			<div class="form-group col-md-6">
				<label for="your_fax">Your Fax: </label>
				<input class="form-control" type="tel" name="your_fax" value="<?=(($pre1_results['fax'] != '')?$pre1_results['fax']:$your_fax);?>">
			</div>
			<div class="form-group">
				<label for="your_address_line1">Your Address: </label>
				<input class="form-control" type="text" name="your_address_line1" value="<?=(($pre1_results['address_line1'] != '')?$pre1_results['address_line1']:$your_address_line1);?>" placeholder="Address Line 1">
				<input class="form-control" type="text" name="your_address_line2" value="<?=(($pre1_results['address_line2'] != '')?$pre1_results['address_line2']:$your_address_line2);?>" placeholder="Address Line 2">
				<input class="form-control" type="text" name="your_city" value="<?=(($pre1_results['city'] != '')?$pre1_results['city']:$your_city);?>" placeholder="City">
				<input class="form-control" type="text" name="your_state" value="<?=(($pre1_results['state'] != '')?$pre1_results['state']:$your_state);?>" placeholder="State">
				<input class="form-control" type="text" name="your_zip" value="<?=(($pre1_results['zip_code'] != '')?$pre1_results['zip_code']:$your_zip);?>" placeholder="Zip Code">
			</div>
			<div class="form-group">
				<label for="your_email">Your Email: </label>
				<input class="form-control" type="text" name="your_email" value="<?=(($pre_results['email'] != '')?$pre_results['email']:$your_email);?>">
			</div>
		</div>
		<input type="submit" name="submit" class="btn btn-success pull-right" value="Submit">
	</form>
	<a href="dashboard.php" class="btn btn-default pull-right">Cancel</a>
<?php } ?>
<?php include '../includes/footer.php'; ?>