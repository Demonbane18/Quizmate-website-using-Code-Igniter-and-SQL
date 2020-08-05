<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li class="label label-default">General</li>
		<li class="active"><?php echo anchor('teacher', 'General');?></li>
		<li><?php echo anchor('teacher/scoreboard', 'Score Report');?></li>
		<li><?php echo anchor('teacher/log', 'Usage History');?></li>
	</ul>
	<ul class="nav nav-sidebar">
		<li class="label label-default">Manage subjects</li>
		<li><?php echo anchor('teacher/courses', 'Subject taught');?></li>
		<li><?php echo anchor('teacher/reqcourse', 'Request a new subject');?></li>
	</ul>
	<ul class="nav nav-sidebar">
		<li class="label label-default">Quiz Bank</li>
		<li><a href="">Nav item again</a></li>
		<li><a href="">One more nav</a></li>
		<li><a href="">Another nav item</a></li>
	</ul>
</div>