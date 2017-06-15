<?php

$comments_query = $db->query("SELECT * FROM teacher_comments");
$comments_results = mysqli_fetch_all($comments_query);
//echo '<pre>';
//print_r($comments_results);

?>
<div class="col-md-4" id="comment-table">
	<h1 class="text-center">Teacher Comments</h1>
	<hr>
	<p>Last 5 comments shown</p>
	<table class="table table-condensed">	
		<thead>
			<th>#</th>
			<th>Student</th>
			<th>Section</th>
			<th>Comment</th>
		</thead>
		<tbody>
		<?php foreach($comments_results as $comment) : ?>
			<tr>
				<td><?=$comment[0]?></td>
				<td><?=$comment[4];?></td>
				<td><?=$comment[5]?></td>
				<td><?=nl2br($comment[6])?></td>
			</tr>
		</tbody>
	<?php endforeach; ?>
	</table>
	<hr>
	<p>Figure this pagination stuff out. Maybe play around with the idea of 'choose a student to show the comments made'.</p>
	<div>
		<a href="" class="btn btn-default pull-left"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<a href="" class="btn btn-default pull-right"><span class="glyphicon glyphicon-chevron-right"></span></a>
		<div class="clearfix"></div>
	</div>
</div>
	