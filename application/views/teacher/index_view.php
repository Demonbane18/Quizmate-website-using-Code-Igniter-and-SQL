<!-- Begin content for greeting-->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h2>Hello <?php echo $this->session->userdata('fullname');?></h2>
<?php
	echo "Faculty: ".$this->session->userdata('faculty').br();

?>
</div>
<!-- End content -->