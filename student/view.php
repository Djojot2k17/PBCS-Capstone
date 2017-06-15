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
	$title_data = $title['project_name'];
	$scope_data = $scope['scope'];
	$plan_data = array($concept, $design, $technical, $test);

?>
<h1 class="text-center">UNDER CONSTRUCTION!</h1>
<div class="container">
 <a href="dashboard.php" class="btn btn-lg btn-default">Back to the dashboard</a>
</div>
<?php include '../includes/footer.php'; ?>