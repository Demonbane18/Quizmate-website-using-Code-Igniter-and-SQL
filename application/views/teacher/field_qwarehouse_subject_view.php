<!-- Begin content -->
<!-- Right side column contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="fa fa-briefcase"></span> <?php echo $pagetitle;?>
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('teacher', '<i class="fa fa-dashboard"></i> Main Page');?></li>
			<li><?php echo anchor('teacher/qwarehouse', 'Quiz Bank');?></li>
			<li class="active"><?php echo $pagetitle;?></li>
		</ol>
	</section>
	<section class="content">
		<h4 class="page-header">
			<small><?php echo $pagesubtitle;?></small>
		</h4>

		<?php
		$attr = array(
			'name' => 'course',
			'role' => 'form',
			'method' => 'post'
			);
		echo form_open($formlink, $attr);
		?>
		<div class="row">
			<div class="col-md-6 col-lg-6 col-md-offset-3">
<?php
if (isset($msg_error))
{
	echo <<<EOL
<div class="alert alert-danger hidden-xs alert-dismissable" style="min-width: 343px">
	<i class="fa fa-ban"></i>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<b>Error</b> : $msg_error
</div>
<div class="alert alert-danger visible-xs alert-dismissable">
	<i class="fa fa-ban"></i>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<b>Error</b> : $msg_error
</div>
EOL;
	}
?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<!-- Begin box -->
				<div class="box nav-tabs-custom" style="border: none;">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#basic" data-toggle="tab">Basic</a></li>
						<li><a href="#chapter" data-toggle="tab">Chapter</a></li>
						<li><?php echo anchor('teacher/qwarehouse/viewq/'.$subjectInfo['code'], 'Question');?></li>
					</ul>
					<!-- Tab Basic -->
					<div class="tab-content">
						<div class="box-body tab-pane active" id="basic">
							<div class="form-group<?php if(form_error('subjectid')) echo ' has-error';?>">
								<?php
								echo form_label('Subject code', 'subjectid');
								echo "<div id=\"subjectcodename\">$subjectInfo[code] - $subjectInfo[name]</div>";
								?>
							</div>
							<div class="form-group<?php if(form_error('subjectid')) echo ' has-error';?>">
								<?php
								echo form_label('Subject Initials', 'Subject Initials');
								echo "<div id=\"subjectshortname\">$subjectInfo[shortname]</div>";
								?>
							</div>
							<div class="form-group<?php if(form_error('description')) echo ' has-error';?>">
								<label>Course Description</label>
								<div id="subjectDesc" class="text-justify">
									<?php echo (isset($subjectInfo['description'])?$subjectInfo['description']:'');?>
								</div>
							</div>
						</div>
						<!-- Tab Chapter -->
						<div class="box-body tab-pane" id="chapter">
							<div class="row">
								<div class="col-md-12 text-center">
									<h3 class="">Chapters</h3>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-12">
									<div class="callout callout-info">
										<h4>Tips</h4>
										<p class="text-justify">This section is for grouping each quiz or question For convenient use later</p>
									</div>
								</div>
								<div class="col-lg-8 col-md-12 pull-right">
									<ul id="chapterList" class="list-group">
										<?php
											foreach ($chapterList as $item) {
												echo "<li class=\"list-group-item\" data-chapter-id=\"$item[chapter_id]\">
												<span class=\"badge\"></span>
												<div class=\"optionlinks\">
													<a href=\"#edit\">
														<i class=\"fa fa-edit\"></i>
													</a>
													<a href=\"#remove\" class=\"text-danger\">
														<i class=\"glyphicon glyphicon-remove\"></i>
													</a>
												</div>
												<h4 class=\"list-group-item-heading\">$item[name]</h4>
												<div class=\"item-group-item-text\">$item[description]</div>
												</li>";
											}
										?>
									</ul>

									<div class="input-group">
										<input id="chapterName" class="form-control" maxlength="40" placeholder="">
										<div class="input-group-btn">
											<button id="chapterAdd" class="btn btn-success"><i class="fa fa-plus"></i></button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Questions tab -->
						<div class="box-body tab-pane" id="questions">
							
						</div>
					</div>
					<div class="box-footer text-right">
					<?php
					?>
					</div>
				</div>
				<!-- End BasicInfo -->
			</div>
		</div>
		<?php form_close(); ?>
<!-- End content -->