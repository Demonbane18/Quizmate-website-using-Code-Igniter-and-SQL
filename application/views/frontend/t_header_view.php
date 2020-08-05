<!doctype html>
<html lang="th">
<head>
	<base href="<?php echo base_url(); ?>">
	<meta charset="utf-8">
	<title>Quizmate</title>
	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
	<!-- iCheck for checkboxes and radio inputs -->
	<link href="vendor/css/iCheck/all.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="vendor/css/messenger.css">
	<link rel="stylesheet" href="vendor/css/messenger-theme-air.css">
	<link href="assets-student/css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
	<!-- header begin -->
	<header>
		<div class="container">
			<div class="row">
				<div class="col-md-12 top">
					<div id="logo">
						<div class="inner">					
							<?php echo anchor('', '<img src="img/logo.png" class="img" alt="logo" height="30" width="120"/>'); ?>
						</div>
					</div>

<?php $this->load->view('frontend/t_nav_view');?>

					<div class="clearfix" style="background-color: #fff;"></div>
				</div>
			</div>
		</div>

	</header>
	<!-- header close -->
<?php
	$subheader['title'] = (isset($title)?$title:'');
	$subheader['subtitle'] = (isset($subtitle)?$subtitle:'');
	if (isset($enableSlider)) $this->load->view('frontend/t_slider_view');
	else $this->load->view('frontend/t_subheader_view', $subheader);

	if ((isset($statbar)?$statbar:false))
	{
?>

	<div class="clearfix"></div>
<?php
	}
?>