<!-- Begin content -->
<div class="span12">
	<h2>Quizmate</h2>
<?php
	echo "Login, ".$this->session->userdata('fullname').
	br().
	"Birthdate: ".$this->session->userdata('birth').br().
	"Gender: ".$this->session->userdata('gender').br(3);

	echo anchor('auth/logout', 'Log out');
?>
</div>
<!-- End content -->