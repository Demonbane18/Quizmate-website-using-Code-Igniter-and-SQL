<?php
	$attrLabel = array(
		'class' => 'col-sm-3 control-label'
	);

?>
<!-- Begin login -->
<br><br>
<div class="row animate-fade-up">
	<div class="col-sm-4 col-sm-offset-4">
		<div class="panel panel-<?php if(!isset($msg_error)) echo "primary"; else echo "danger";?>">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="
glyphicon glyphicon-th-list"></span>&nbsp;&nbsp;Login</h3>
			</div>
			<div class="panel-body">
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
		'class' => 'form-horizontal',
		'role' => 'form',
		'method' => 'post'
	);
	echo form_open('auth/dologin', $attr);
?>
					<div class="form-group<?php if(form_error('username')) echo ' has-error';?>">
<?php 
	echo form_label('Username', 'username', $attrLabel);
?>
						<div class="col-sm-8">
<?php
	echo form_input(array(
		'id'=>'username',
		'name'=>'username',
		'value'=>set_value('username'),
		'type'=>'text',
		'class'=>'form-control',
		'placeholder'=>'Enter your Username'));
	echo form_error('username', '<span class="label label-danger">', '</span>');
?>
						</div>
					</div>
					<div class="form-group<?php if(form_error('password')) echo ' has-error';?>">
<?php 
	echo form_label('Password', 'password', $attrLabel);
?>
						<div class="col-sm-8">
<?php
	echo form_input(array(
		'id'=>'password',
		'name'=>'password',
		'type'=>'password',
		'class'=>'form-control',
		'placeholder'=>'Enter your password'));
	echo form_error('Enter your password', '<span class="label label-danger">', '</span>');
?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12" style="text-align: center;">
<?php
echo form_submit('submit', 'Login', 'class="btn btn-primary"');
?>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
		<br><br><br><br><br>
	</div>
</div>





<!-- End login -->