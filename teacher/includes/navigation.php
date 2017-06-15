<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="index.php" class="navbar-brand">PBCS</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-right">
				<!-- Menu Items -->
				<li><a href="#top">Project Title</a></li>	
				<li><a href="#scope">Project Scope</a></li>
				<li><a href="#wireframes">Project Wireframes</a></li>
				<li><a href="#milestones">Plan and Milestones</a></li>
				<li><a href="#comment">Comment</a></li>
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