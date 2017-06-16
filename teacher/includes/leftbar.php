<?php

//$comments_query = $db->query("SELECT * FROM teacher_comments");
//$comments_results = mysqli_fetch_all($comments_query);
//echo '<pre>';
//print_r($comments_results);

// define how many results you want per page
$results_per_page = 5;
// find out the number of results stored in database
$sql="SELECT * FROM teacher_comments";
$result = $db->query($sql);
$number_of_results = mysqli_num_rows($result);
//var_dump($number_of_results);
// determine number of total pages available
$number_of_pages = ceil($number_of_results/$results_per_page);
// determine which page number visitor is currently on
if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = sanitize($_GET['page']);
}
// determine the sql LIMIT starting number for the results on the displaying page
$this_page_first_result = ($page-1)*$results_per_page;
// retrieve selected results from database and display them on page
$sql="SELECT * FROM teacher_comments ORDER BY id DESC LIMIT " . $this_page_first_result . ',' .  $results_per_page;
$result = $db->query($sql);
//var_dump($result);

?>
<div id="comment-table">
	<h1 class="text-center">Teacher Comments</h1>
	<hr>
	<p>Last 5 comments shown</p>
	<table class="table text-center">	
		<thead>
			<th class="text-center">#</th>
			<th class="text-center">Student</th>
			<th class="text-center">Section</th>
			<th class="text-center">Comment</th>
		</thead>
		<tbody>
		<?php while($row = mysqli_fetch_array($result)) : ?>
			<tr>
				<td><?=$row['id']?></td>
				<td><?=$row['student_name'];?></td>
				<td><?=$row['section']?></td>
				<td><?=nl2br($row['comment'])?></td>
			</tr>
		</tbody>
	<?php endwhile; ?>
	</table>
	<hr>
	<div class="col-md-12 buttons">
		<div class="col-md-2">
			<a href="index.php?student=<?=((isset($_GET['student'])?sanitize($_GET['student']):''));?>&page=<?=(($page == 1)?'1':$page-1);?>" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span></a>
		</div>
		<div class="col-md-8">
			<?php 		
				for ($page=1;$page<=$number_of_pages;$page++) {
	  				echo '<a href="index.php?student='.((isset($_GET['student'])?sanitize($_GET['student']):'')).'&page=' . $page . '" class="btn btn-default">' . $page . '</a> ';
				}
				$page = isset($_GET['page']); 
			?>
		</div>
		<div class="col-md-2">
			<a href="index.php?student=<?=((isset($_GET['student'])?sanitize($_GET['student']):''));?>&page=<?=$page+1;?>" class="btn btn-default"><span class="glyphicon glyphicon-chevron-right"></span></a>
		</div>
	</div>
</div>
	