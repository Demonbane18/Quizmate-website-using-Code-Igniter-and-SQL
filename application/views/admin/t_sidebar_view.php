<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="img/avatar5.png" class="img-circle" alt="User Image" />
			</div>
			<div class="pull-left info">
				<p><?php echo $this->session->userdata('fullname');?></p>

				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<!-- search form -->
		<form action="" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search..."/>
				<span class="input-group-btn">
					<button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form>
		<!-- /.search form -->
		<!-- sidebar menu style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li><?php echo $this->misc->listCActive("admin");?>>
				<?php echo anchor('admin', '<i class="fa fa-dashboard"></i> <span>Dashboard</span>');?>
			</li>
			<!-- <li<?php echo $this->misc->listCActive("widgets");?>>
				<?php echo anchor('admin/widgets', '<i class="fa fa-th"></i> <span>Tool</span> <small class="badge pull-right bg-green">new</small>');?>
			</li> -->
			<li class="treeview <?php echo $this->misc->listCActive("report",false,"start");?>">
				<a href="#">
					<i class="fa fa-bar-chart-o"></i>
					<span>Report</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li<?php echo $this->misc->listCActive("reports");?>><?php echo anchor('teacher/reports', '<i class="fa fa-angle-double-right"></i> Quiz');?></li>
				</ul>
			</li>
			<li class="treeview <?php echo $this->misc->listCActiveAry(array("faculty","users","subjects"),false);?>">
				<a href="#">
					<i class="fa fa-laptop"></i>
					<span>Basic Data</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<!-- <li<?php echo $this->misc->listCActive("faculty");?>><?php echo anchor('admin/faculty', '<i class="fa fa-angle-double-right"></i> Faculty Management');?></li> -->
					<li<?php echo $this->misc->listCActive("users");?>><?php echo anchor('admin/users', '<i class="fa fa-angle-double-right"></i> User Management');?></li>
					<li<?php echo $this->misc->listCActive("subjects");?>><?php echo anchor('admin/subjects', '<i class="fa fa-angle-double-right"></i> Manage Subject');?></li>
				</ul>
			</li>
			<li class="treeview <?php echo $this->misc->listCActiveAry(array("courses","examswitch","examreset"),false);?>">
				<a href="#">
					<i class="fa fa-edit"></i> <span>Take a Quiz</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li<?php echo $this->misc->listCActive("courses");?>><?php echo anchor('admin/courses', '<i class="fa fa-angle-double-right"></i> Quiz subject');?></li>
					<li<?php echo $this->misc->listCActive("examswitch");?>><?php echo anchor('admin/courses/add', '<i class="fa fa-angle-double-right"></i> Open Quiz');?></li>
					<!-- <li<?php echo $this->misc->listCActive("examreset");?>><?php echo anchor('admin/examreset', '<i class="fa fa-angle-double-right"></i> Quiz Reset');?></li> -->
			</ul>
			</li>
			<li<?php echo $this->misc->listCActive("qwarehouse");?>>
				<?php echo anchor('teacher/qwarehouse', '<i class="fa fa-edit"></i> <span>Quizzes</span>');?>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>
