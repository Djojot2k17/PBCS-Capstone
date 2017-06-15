<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="../index.php" class="navbar-brand">PBCS</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-right">
				<!-- Menu Items -->
				<li><a href="../student/dashboard.php">Dashboard</a></li>	
				<li><a href="../student/project_title.php?<?= ((isset($_SESSION['dbuser'])?'edit='.$_SESSION['dbuser']:'add='.$_SESSION['dbuser']));?>">Project Title</a></li>
				<li><a href="../student/project_scope.php?<?= ((isset($_SESSION['dbuser'])?'edit='.$_SESSION['dbuser']:'add='.$_SESSION['dbuser']));?>">Project Scope</a></li>
				<li><a href="../student/plan_and_milestones.php?<?= ((isset($_SESSION['dbuser'])?'edit='.$_SESSION['dbuser']:'add='.$_SESSION['dbuser']));?>">Plan and Milestones</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?=$user_data['first_name'];?><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="../logout.php">Log Out</a></li>
					</ul>
				</li>			
			</ul>
		</div>
	</div>
</nav>