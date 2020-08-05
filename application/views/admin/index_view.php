<!-- Begin content -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<ol class="breadcrumb">
		<li class="active">Quizmate</li>
	</ol>
	<h2>Quizmate </h2>
<?php
	echo "Please login, ".$this->session->userdata('fullname').
	br().
	"Birth Date: ".$this->session->userdata('birth').br().
	"Gender: ".$this->session->userdata('gender').br(3);

	echo anchor('auth/logout', 'Sign Out');
?>
</div>
<!-- End content -->