<!-- Begin content -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="glyphicon glyphicon-send"></span> <?php echo $pagetitle;?>
			<small><?php echo $pagesubtitle;?></small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('admin', '<i class="fa fa-dashboard"></i> Main Page');?></li>
			<li><?php echo anchor('admin/users', 'User Management');?></li>
			<li class="active"><?php echo $pagetitle;?></li>
		</ol>
	</section>
	<section class="content">
		<h4 class="page-header">
			<small></small>
		</h4>

		<?php
		if (isset($msg_error)) {

			echo "
			<script>
			Messenger.options = {
				extraClasses: 'messenger-fixed messenger-on-top',
				theme: 'bootstrap'
			}
			Messenger().post({
				message: '".$msg_error."',
				type: 'danger',
				hideAfter: 7,
				showCloseButton: true
			});
			</script>";
		}
		$attr = array(
			'role' => 'form',
			'method' => 'post'
			);
		//echo form_open($formlink, $attr);
		echo '<form method="post" enctype="multipart/form-data">';
		?>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
				<?php if (isset($msg_info)) { ?>
				<div class="alert alert-success" style="min-width: 343px">
					<i class="fa fa-check"></i>
					<?=$msg_info?>
				</div>
				<?php } ?>
				<?php if (isset($msg_err)) { ?>
				<div class="alert alert-danger" style="min-width: 343px">
					<i class="fa fa-ban"></i>
					<?=$msg_err?>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				<!-- Begin Uploadbox: excel files -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">
							Upload
						</h3>
					</div>
					<div class="box-body">
						<div class="callout callout-info">
							<h4><i class="fa fa-info"></i> Tips:</h4>
							<p>Import can be imported using the data file format as follows<br>
								<ul>
									<li>Excel 2003 <a href="files/ex1.xls"><b>(.XLS)</b></a></li>
									<li>Excel 2007+ <a href="files/ex2.xlsx"><b>(.XLSX)</b></a></li>
									<li>comma-separated values <a href="files/ex3.csv"><b>(.CSV)</b></a></li>
								</ul>
								Click on the file format to preview the formatting of rows and columns.
							</p>
						</div>
						<div class="form-group<?php if(form_error('file')) echo ' has-error';?>">
							<?php 
							echo form_label('File list <span class="text-danger">*</span>', 'file');
							echo '<input type="file" name="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/csv">';
							echo form_error('file', '<span class="label label-danger">', '</span>');
							?>
						</div>
					</div>
					<div class="box-footer text-right">
					<?php
					echo form_submit('submit', 'Import data', 'class="btn btn-primary"');
					?>
					</div>
				</div>
			</div>
		<!-- End Upload form -->
		</div>
	
		<?php form_close(); ?>
<!-- End content -->