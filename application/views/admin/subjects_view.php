<!-- Begin content -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<span class="glyphicon glyphicon-book"></span> Manage subjects
			<small>Subject Management</small>
		</h1>
		<ol class="breadcrumb">
			<li><?php echo anchor('admin', '<i class="fa fa-dashboard"></i> Main Page');?></li>
			<li class="active">Manage subjects</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<h4 class="page-header">
			<small>Basic information of the Course</small>
		</h4>

	<?php
	if ($this->session->flashdata('msg_info')) {

		echo "
		<script>
		Messenger.options = {
			extraClasses: 'messenger-fixed messenger-on-top',
			theme: 'bootstrap'
		}
		Messenger().post({
			message: '".$this->session->flashdata('msg_info')."',
			type: 'info',
			hideAfter: 7,
			showCloseButton: true
		});
</script>";

}
if ($this->session->flashdata('msg_error')) {
	echo '
	<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>ผิดพลาด!</strong> '.$this->session->flashdata('msg_error').'</div>';
	echo "
	<script>
	Messenger.options = {
		extraClasses: 'messenger-fixed messenger-on-top',
		theme: 'bootstrap'
	}
	Messenger().post({
		message: '".$this->session->flashdata('msg_error')."',
		type: 'danger',
		hideAfter: 7,
		showCloseButton: true
	});
</script>";
}

?>
<div class="row <?php if($this->session->flashdata('noAnim')) echo "animate-fade-up";?>">
	<div class="col-md-12">
		<div class="box box-info nav-tabs-custom">
			<ul class="nav nav-tabs  pull-right">
				<li class="dropdown pull-right">
					<a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li><?php echo anchor('admin/subjects/add', 'Add');?></li>
					</ul>
				</li>
				<li class="pull-left header">
					<i class="glyphicon glyphicon-th"></i> Subjects
				</li>
			</ul>
			<div class="tab-content">
				<!-- Search Box -->
				<div class="box-body">
					<div class="row">
						<?php
						$attr = array(
							'name' => 'searchsubject',
							'class' => 'form-inline searchform',
							'role' => 'search',
							'method' => 'get'
							);
						echo form_open('admin/subjects', $attr); ?>
							<div class="col-xs-6 col-sm-5" style="z-index:500;">
								<label for="faculty" class="hidden-xs visible-md-inline-block visible-lg-inline-block">Faculty-Branch </label>
								<label><?php 
									$options = array(
										'all',
										
										
									);
									echo form_dropdown('faculty', $options, 'default', 'id="faculty" class="form-control input-sm"');
							?></label>
							</div>
							<div class="col-sm-7 ">
								<div class="col-sm-6 col-md-6 text-right" style="padding-right: 0;">
									<label>Item/Page</label>
									<label>	
										<?php
										$attr_pp = array(
											'10' => '10',
											'25' => '25',
											'50' => '50',
											'100' => '100'
											);
										if ($this->input->get('perpage')) $perpage = $this->input->get('perpage');
										//else $perpage = '25';
										echo form_dropdown('perpage', 
											$attr_pp, 
											$perpage, 
											'class="form-control input-sm" onchange="submitFrm(document.forms.searchsubject)"');
											?>
									</label>
								</div>
								<div class="input-group input-group-sm col-sm-6 col-lg-6 pull-right">
									<?php
									echo form_input(array(
										'id'=>'searchtxt',
										'name'=>'q',
										'type'=>'text',
										'class'=>'form-control input-sm',
										'value'=>$this->input->get('q'),
										'placeholder'=>'Search'
										));
									?>
									<span class="input-group-btn">
										<button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
						<?php echo form_close();?>
					</div>
				</div>
				<!-- /Search box -->
				<div class="box-body no-padding">
					<table class="table table-striped table-hover rowclick">
						<thead>
							<tr>
								<th style="width: 79px;">Subject Code</th>
								<th style="width: 25%;">Name</th>
								<th style="width: 88px;">Initials</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
						<?php
							if (($subjectlist)) {
								foreach ($subjectlist as $item) {
									echo "
									<tr href=\"".$this->misc->getHref('admin/subjects/view')."/$item[code]\">
									<td>$item[code]</td>
									<td>$item[name]</td>
									<td>$item[shortname]</td>
									<td>".$this->misc->getShortText(strip_tags($item['description']))."</td>
									</tr>
									";
								}
							} else {
								echo "<tr class='warning'><td colspan='4' class='text-center'>No Data found</td></tr>";
							}
							
						?>				
						</tbody>
					</table>
				</div>
				<div class="box-footer clearfix">
					<?php echo $pagin;?>
				</div>
			</div>
		</div>
	</div>
	<script>
	function submitFrm(frm) {
		frm.submit();
	}</script>
<!-- End content