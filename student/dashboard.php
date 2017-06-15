<?php 
	require_once '../config/init.php';
	include '../includes/head.php';
	include '../includes/navigation.php';
 
	//get user and the info they provided
	$user_id = $_SESSION['dbuser'];
	//get project title
	$title_query = "SELECT * FROM project_title WHERE student_id = '$user_id'";
	$title_result = $db->query($title_query);
	$title = mysqli_fetch_assoc($title_result);
	//get prepared for info
	$prepared_for_query = "SELECT * FROM client_info WHERE student_id = '$user_id'";
	$prepared_for = $db->query($prepared_for_query);
	$pfor = mysqli_fetch_assoc($prepared_for);
	//get prepared by info
	$prepared_by_query = "SELECT * FROM your_info WHERE student_id = '$user_id'";
	$prepared_by = $db->query($prepared_by_query);
	$pby = mysqli_fetch_assoc($prepared_by);
	//var_dump($pby);
	//get scope
	$scope_query = "SELECT * FROM project_scope WHERE student_id = '$user_id'";
	$scope_result = $db->query($scope_query);
	$scope = mysqli_fetch_assoc($scope_result);
	$scope_image = $scope['image'];
	$images = explode(',', $scope_image);
	//var_dump($images);
	//get milestones
	$milestones_query = "SELECT * FROM milestones WHERE student_id = '$user_id'";
	$milestones_results = $db->query($milestones_query);
	$milestones_json = mysqli_fetch_assoc($milestones_results);
	$concept = json_decode($milestones_json['concept'],true);
	$design = json_decode($milestones_json['design'],true);
	$technical = json_decode($milestones_json['technical'],true);
	$test = json_decode($milestones_json['test'],true);
	//check if the forms have been filled
	if ($title == '') {
		$title_panel_state = 'danger';
		$title_data = 'You still haven\'t completed this section';
	} else {
		$title_panel_state = 'success';
		$title_data = $title['project_name'];
	}
		if ($scope == '') {
		$scope_panel_state = 'danger';
		$scope_data = 'You still haven\'t completed this section';
	} else {
		$scope_panel_state = 'success';
		$scope_data = $scope['scope'];
		//var_dump($scope);
	}
	if ($milestones_json == '') {
		$plan_panel_state = 'danger';
		$plan_data = 'You still haven\'t completed this section';
	} else {
		$plan_panel_state = 'success';
		$plan_data = array($concept, $design, $technical, $test);
	}
	//View Teacher Comments
	$title_comment_query = $db->query("SELECT * FROM teacher_comments WHERE student_id = $user_id AND section = 'title'");
	$title_comment_results = mysqli_fetch_all($title_comment_query);
	//var_dump($title_comment_results);
	$scope_comment_query = $db->query("SELECT * FROM teacher_comments WHERE student_id = $user_id AND section = 'scope' OR section = 'wireframes'");
	$scope_comment_results = mysqli_fetch_all($scope_comment_query);
	//var_dump($title_comment_results);
	$plan_comment_query = $db->query("SELECT * FROM teacher_comments WHERE student_id = $user_id AND section = 'plan'");
	$plan_comment_results = mysqli_fetch_all($plan_comment_query);
	//var_dump($title_comment_results);


?>
<link rel="stylesheet" href="includes/main.css">
<h1 class="text-center"><?= $pby['first_name'].'\'s'.' Capstone Proposal'?></h1>
<hr class="container">
<div class="container">
	<div class="panel-group" id="accordion">
		<div class="panel panel-<?=$title_panel_state;?>">
			<div class="panel-heading clickable">
				<h4 class="panel-title">Project Title</h4>
				<span class="pull-left"><i class="glyphicon glyphicon-minus"></i></span>
			</div>
			<div class="panel-body">
			<?php if($title_panel_state != 'success'): ?>
				<p><?=$title_data;?></p>
			<?php else: ?>
				<table class="table table-condensed table-striped table-bordered text-center" id="title-table">
					<h3 class="text-center">Title: <?= $title_data;?></h3><br>
					<thead>
						<th class="text-center">Prepared By</th>
						<th class="text-center">Prepared For</th>
					</thead>
					<tbody>
						<tr>
							<td>Name: <?= $pby['first_name']. ' ' .$pby['last_name']?></td>
							<td>Name: <?= $pfor['name'];?></td>
						</tr>
						<tr>
							<td>Telephone: <?= $pby['telephone'];?></td>
							<td>Title: <?= $pfor['title'];?></td>
						</tr>
						<tr>
							<td>Fax: <?= (($pby['fax'] == '')?'None':$pby['fax']);?></td>
							<td>Company Name: <?= $pfor['company_name'];?></td>
						</tr>
						<tr>
							<td>
								Address: <?= $pby['address_line1'];?>
								<?= (($pby['address_line2'] == '')?'':'<br>'.$pby['address_line2']);?><br>
								<?= $pby['city']. ' ' .$pby['state']. ', ' .$pby['zip_code'];?>
							</td>
							<td>
								Address: <?= $pfor['company_address_line1'];?>
								<?= (($pfor['company_address_line2'] == '')?'':'<br>'.$pfor['company_address_line2']);?><br>
								<?= $pfor['company_city']. ' ' .$pfor['company_state']. ', ' .$pfor['company_zip'];?>
							</td>
						</tr>
						<tr>
							<td>Email: <?= $pby['email'];?></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<br>
				<p class="text-center">Proposal Started On: <?= $pby['start_date'];?></p>
				<?php endif; ?>
				<hr>
				<div class="col-sm-3">
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#title_modal">View Teacher Comments</button>
							<!-- Modal -->
							<div id="title_modal" class="modal fade" role="dialog">
							  <div class="modal-dialog">
							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Teacher Comments</h4>
							      </div>
							      <div class="modal-body">
							      	<table class="table table-condensed table-bordered text-center">
							      	<thead>
							      		<th class="text-center">#</th>
							      		<th class="text-center">Teacher</th>
							      		<th class="text-center">Section</th>
							      		<th class="text-center">Comment</th>
							      	</thead>
							      	<tbody>
							      	<?php foreach($title_comment_results as $comment) : ?>
							        		<tr>
							        			<td><?=$comment[0];?></td>
							        			<td><?=$comment[2];?></td>
							        			<td><?=$comment[5];?></td>
							        			<td><?=$comment[6];?></td>
							        		</tr> 		
							        <?php endforeach; ?>
							        </tbody>
							        </table>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							      </div>
							    </div>
							  </div>
							</div>							
						</div>
				<?php if($title_panel_state == 'success'): ?>				
					<form action="dashboard.php" method="GET" class="buttons">
						<a href="project_title.php?edit=<?=$user_id;?>" class="btn btn-warning btn-sm pull-right">Edit</a>
					</form>
				<?php else: ?>
					<form action="dashboard.php" method="GET" class="buttons">
						<a href="project_title.php?add=<?=$user_id;?>" class="btn btn-success btn-sm pull-right">Start</a>
					</form>
				<?php endif; ?>
			</div>
		</div>
		<div class="panel panel-<?=$scope_panel_state;?>">
			<div class="panel-heading clickable">
				<h4 class="panel-title">Project Scope</h4>
				<span class="pull-left"><i class="glyphicon glyphicon-minus"></i></span>
			</div>
			<div class="panel-body">
				<?php if($scope_panel_state != 'success'): ?>
					<p><?=$scope_data;?></p>
				<?php else: ?>
				<p><?= nl2br($scope_data); ?></p>
				<hr>
				<h4 class="text-center">Wireframe Images</h4>
				<?php endif; ?>
				<hr>
				<?php if($scope_panel_state == 'success'): ?>				
					<?php foreach ($images as $key => $image): ?>
						<div class="col-sm-3">
							<button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal<?=$key;?>"><img src="<?=$image?>" alt="" class="wireframe_photo img-responsive"></button>
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
					<div class="col-sm-3">
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#scope_modal">View Teacher Comments</button>
							<!-- Modal -->
							<div id="scope_modal" class="modal fade" role="dialog">
							  <div class="modal-dialog">
							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Teacher Comments</h4>
							      </div>
							      <div class="modal-body">
							      	<table class="table table-condensed table-bordered text-center">
							      	<thead>
							      		<th class="text-center">#</th>
							      		<th class="text-center">Teacher</th>
							      		<th class="text-center">Section</th>
							      		<th class="text-center">Comment</th>
							      	</thead>
							      	<tbody>
							      	<?php foreach($scope_comment_results as $comment) : ?>
							        		<tr>
							        			<td><?=$comment[0];?></td>
							        			<td><?=$comment[2];?></td>
							        			<td><?=$comment[5];?></td>
							        			<td><?=$comment[6];?></td>
							        		</tr> 		
							        <?php endforeach; ?>
							        </tbody>
							        </table>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							      </div>
							    </div>
							  </div>
							</div>							
						</div>
					<form action="dashboard.php" method="GET" class="buttons">
						<a href="project_scope.php?edit=<?=$user_id;?>" class="btn btn-warning btn-sm pull-right">Edit</a>
					</form>
				<?php else: ?>
					<form action="dashboard.php" method="GET" class="buttons">
						<a href="project_scope.php?add=<?=$user_id;?>" class="btn btn-success btn-sm pull-right">Start</a>
					</form>
				<?php endif; ?>
			</div>
		</div>
		<div class="panel panel-<?=$plan_panel_state;?>">
			<div class="panel-heading clickable">
				<h4 class="panel-title">Plan and Milestones</h4>
				<span class="pull-left"><i class="glyphicon glyphicon-minus"></i></span>
			</div>
			<div class="panel-body">
				<?php if($plan_panel_state != 'success'): ?>
					<p><?=$plan_data;?></p>
				<?php else: ?>
				<table class="table table-striped table-bordered text-center">
					<h4 class="text-center">Concept Phase</h4>
					<thead>
						<th class="text-center">Milestone</th>
						<th class="text-center">Due Date</th>
						<th class="text-center">Deliverables</th>
						<th class="text-center">Fee</th>
					</thead>
					<tbody>
						<tr>
							<td><?= $plan_data[0][0]; ?></td>
							<td><?= $plan_data[0][1]; ?></td>
							<td><?= $plan_data[0][2]; ?></td>
							<td><?= $plan_data[0][3]; ?></td>
						</tr>
					</tbody>
				</table>
				<hr>
				<table class="table table-striped table-bordered text-center">
					<h4 class="text-center">Design Phase</h4>
					<thead>
						<th class="text-center">Milestone</th>
						<th class="text-center">Due Date</th>
						<th class="text-center">Deliverables</th>
						<th class="text-center">Fee</th>
					</thead>
					<tbody>
						<tr>
							<td><?= $plan_data[1][0]; ?></td>
							<td><?= $plan_data[1][1]; ?></td>
							<td><?= $plan_data[1][2]; ?></td>
							<td><?= $plan_data[1][3]; ?></td>
						</tr>
					</tbody>
				</table>
				<hr>
				<table class="table table-striped table-bordered text-center">
					<h4 class="text-center">Technical Phase</h4>
					<thead>
						<th class="text-center">Milestone</th>
						<th class="text-center">Due Date</th>
						<th class="text-center">Deliverables</th>
						<th class="text-center">Fee</th>
					</thead>
					<tbody>
						<tr>
							<td><?= $plan_data[2][0]; ?></td>
							<td><?= $plan_data[2][1]; ?></td>
							<td><?= $plan_data[2][2]; ?></td>
							<td><?= $plan_data[2][3]; ?></td>
						</tr>
					</tbody>
				</table>
				<hr>
				<table class="table table-striped table-bordered text-center">
					<h4 class="text-center">Test Phase</h4>
					<thead>
						<th class="text-center">Milestone</th>
						<th class="text-center">Due Date</th>
						<th class="text-center">Deliverables</th>
						<th class="text-center">Fee</th>
					</thead>
					<tbody>
						<tr>
							<td><?= $plan_data[3][0]; ?></td>
							<td><?= $plan_data[3][1]; ?></td>
							<td><?= $plan_data[3][2]; ?></td>
							<td><?= $plan_data[3][3]; ?></td>
						</tr>
					</tbody>
				</table>
				<?php endif; ?>
				<hr>
				<div class="col-sm-3">
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#plan_modal">View Teacher Comments</button>
							<!-- Modal -->
							<div id="plan_modal" class="modal fade" role="dialog">
							  <div class="modal-dialog">
							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Teacher Comments</h4>
							      </div>
							      <div class="modal-body">
							      	<table class="table table-condensed table-bordered text-center">
							      	<thead>
							      		<th class="text-center">#</th>
							      		<th class="text-center">Teacher</th>
							      		<th class="text-center">Section</th>
							      		<th class="text-center">Comment</th>
							      	</thead>
							      	<tbody>
							      	<?php foreach($plan_comment_results as $comment) : ?>
							        		<tr>
							        			<td><?=$comment[0];?></td>
							        			<td><?=$comment[2];?></td>
							        			<td><?=$comment[5];?></td>
							        			<td><?=$comment[6];?></td>
							        		</tr> 		
							        <?php endforeach; ?>
							        </tbody>
							        </table>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							      </div>
							    </div>
							  </div>
							</div>							
						</div>
				<?php if($plan_panel_state == 'success'): ?>				
					<form action="dashboard.php" method="GET" class="buttons">
						<a href="plan_and_milestones.php?edit=<?=$user_id;?>" class="btn btn-warning btn-sm pull-right">Edit</a>
					</form>
				<?php else: ?>
					<form action="dashboard.php" method="GET" class="buttons">
						<a href="plan_and_milestones.php?add=<?=$user_id;?>" class="btn btn-success btn-sm pull-right">Start</a>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<br>
	<div class="form-group">
		<a href="view.php" class="btn btn-default btn-md pull-right">View</a>
	</div>
	
</div>


<?php include '../includes/footer.php'; ?>