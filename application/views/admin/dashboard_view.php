<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Dashboard
			<small>Control Panel</small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('admin', '<i class="fa fa-dashboard"></i> Main Page');?></li>
			<li class="active">Dashboard</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3>
							<?=$coursecount?> Subjects
						</h3>
						<p>
							All open subjects
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-bag"></i>
					</div>
					<?php echo anchor('admin/courses', 'Open <i class="fa fa-arrow-circle-right"></i>', 'class="small-box-footer"');?>
				</div>
			</div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<h3>
							<?=$qcount?> Questions
						</h3>
						<p>
							All Quiz Questions
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<?php echo anchor('teacher/qwarehouse', 'Open <i class="fa fa-arrow-circle-right"></i>', 'class="small-box-footer"');?>
				</div>
			</div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3>
							<?=$usercount?> Users
						</h3>
						<p>
							All Users
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<?php echo anchor('admin/users', 'Open <i class="fa fa-arrow-circle-right"></i>', 'class="small-box-footer"');?>
				</div>
			</div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-red">
					<div class="inner">
						<h3>
							<?=$testedcount?> Quizzes
						</h3>
						<p>
							All Quizzes
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-pie-graph"></i>
					</div>
					<?php echo anchor('teacher/reports', 'Open <i class="fa fa-arrow-circle-right"></i>', 'class="small-box-footer"');?>
				</div>
			</div><!-- ./col -->
		</div>
	</section><!-- /.content -->
</aside><!-- /.right-side -->

<!-- End content -->