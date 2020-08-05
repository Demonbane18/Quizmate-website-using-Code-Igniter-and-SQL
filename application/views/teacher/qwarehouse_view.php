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
			<li><?php echo anchor('teacher', '<i class="fa fa-dashboard"></i> Main Page');?></li>
			<li><?php echo anchor('teacher/qwarehouse', 'Quiz bank');?></li>
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
		echo '<form method="post" enctype="multipart/form-data">';
		?>
<div class="row <?php if($this->session->flashdata('noAnim')) echo "animate-fade-up";?>">
	<div class="col-md-12">
		<div class="box box-info nav-tabs-custom">
			<ul class="nav nav-tabs  pull-right">
				<li class="dropdown pull-right">
					<a href="#" class="text-muted" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li><?php echo anchor('teacher/reqcourse', 'Request Subject');?></li>
					</ul>
				</li>
				<li class="pull-left header">
					<i class="glyphicon glyphicon-th"></i> Quiz according to courses
				</li>
			</ul>
			<div class="tab-content">
				<!-- Search Box -->
				<div class="box-body">
					<div class="row">
						<?php
						$attr = array(
							'name' => 'mycourses',
							'class' => 'form-inline searchform',
							'role' => 'search',
							'method' => 'get'
							);
						echo form_open('teacher/qwarehouse', $attr); ?>
							<div class="col-xs-6"></div>
							<div class="col-sm-6">
								<div class="col-xs-6 col-sm-6 col-md-6 text-right" style="padding-right: 0;">
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
											'class="form-control input-sm" onchange="submitFrm(document.forms.mycourses)"');
											?>
									</label>
								</div>
								<div class="input-group input-group-sm col-xs-6 col-sm-6 col-lg-6 pull-right">
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
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped table-hover rowclick">
					<thead>
						<tr>
							<th>Status</th>
							<th style="width: 79px;">Subject Code</th>
							<th style="width: 25%;">Name</th>
							<th style="width: 88px;">Initials</th>
							<th>Descripton</th>
						</tr>
					</thead>
					<tbody>
					<?php
					//subject table
						if (($subjectlist)) {
							foreach ($subjectlist as $item) {
								echo "
								<tr href=\"".$this->misc->getHref('teacher/qwarehouse/view')."/$item[code]\">
								<td class=\"status\">".$this->qwh->getSubjectStatus($item['hasQuestion']).
								"</td>
								<td>$item[code]</td>
								<td>$item[name]</td>
								<td>$item[shortname]</td>
								<td class=\"hidden-xs\">".$this->misc->getShortText(strip_tags($item['description']))."</td>
								</tr>
								";
							}
						} else {
							echo "<tr class='warning'><td colspan='7' class='text-center'>Data not found</td></tr>";
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
	<script>
	function submitFrm(frm) {
		frm.submit();
	}</script>
<!-- End content -->