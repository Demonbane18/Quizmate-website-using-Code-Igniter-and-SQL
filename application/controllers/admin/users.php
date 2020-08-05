<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->library('pagination');

		// Permissions List for this Class
		$perm = array('admin');
		// Check
		if ($this->Users->_checkLogin())
		{
			if ( ! $this->Users->_checkRole($perm)) redirect('main');
		} else {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$this->viewgroup();
	}

	function viewgroup($group='')
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		$this->session->set_flashdata('noAnim', true);
		if ($group=='') $group="all";
		$data['group'] = $group;

		// Set Default Per page
		$data['perpage'] = '10';
		if ($this->input->get('perpage')!='') $data['perpage'] = $this->input->get('perpage');

		if ($group=='all' || $group=='admin')
		{
			$data['total'] = $this->Users->countUsersByGroup('admin', $this->input->get('q'));
			$data['adminlist'] = $this->Users->getUsersByGroup('admin', $this->input->get('q'),
				$data['perpage'],
				$this->misc->PageOffset($data['perpage'],$this->input->get('p')));
			$this->misc->PaginationInit(
				'admin/users/viewgroup/admin?perpage='.
				$data['perpage'].'&q='.$this->input->get('q'),
				$data['total'],$data['perpage']);
			$data['paginAdmin'] = $this->pagination->create_links();
		}
		if ($group=='all' || $group=='teacher')
		{
			$data['total'] = $this->Users->countUsersByGroup('teacher', $this->input->get('q'));
			$data['teacherlist'] = $this->Users->getUsersByGroup('teacher',$this->input->get('q'),
				$data['perpage'],
				$this->misc->PageOffset($data['perpage'],$this->input->get('p')));
			$this->misc->PaginationInit(
				'admin/users/viewgroup/teacher?perpage='.
				$data['perpage'].'&q='.$this->input->get('q'),
				$data['total'],$data['perpage']);
			$data['paginTeacher'] = $this->pagination->create_links();
		}
		if ($group=='all' || $group=='student')
		{
			$data['total'] = $this->Users->countUsersByGroup('student', $this->input->get('q'));
			$data['studentlist'] = $this->Users->getUsersByGroup('student',$this->input->get('q'),
				$data['perpage'],
				$this->misc->PageOffset($data['perpage'],$this->input->get('p')));
			$this->misc->PaginationInit(
				'admin/users/viewgroup/student?perpage='.
				$data['perpage'].'&q='.$this->input->get('q'),
				$data['total'],$data['perpage']);
			$data['paginStudent'] = $this->pagination->create_links();
		}

		$this->load->view('admin/users_view',$data);
		$this->load->view('admin/t_footer_view');
	}

	function adduser($group='')
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		$data['pagetitle'] = "Add user";

		if ($this->input->post('submit'))
		{
			# on Submit
			switch ($group) {
				case 'admin':
					$data['formlink'] = 'admin/users/adduser/admin';
					$data['pagetitle'] = "Add user";
					$data['pagesubtitle'] = "Admin";
					$data['permtxt'] = "Admin";

					$this->form_validation->set_rules('username', 'Username', 'required|trim');
					$this->form_validation->set_rules('password', 'Password', 'required|callback__password_check['.$this->input->post('passwordconfirm').']');
					$this->form_validation->set_rules('passwordconfirm', 'Password', 'required|callback__password_check['.$this->input->post('password').']');
					$this->form_validation->set_rules('fname', 'Name', 'required|trim');
					$this->form_validation->set_rules('surname', 'Last Name', 'required|trim');
					$this->form_validation->set_message('required', 'You must fill out %s');
					if ($this->form_validation->run())
					{
						# Form check completed
						$userData['username'] = $this->input->post('username');
						$userData['password'] = md5($this->input->post('password'));
						$userData['role'] = "admin";
						$adminData['name'] = $this->input->post('fname');
						$adminData['lname'] = $this->input->post('surname');
						$adminData['email'] = $this->input->post('email');
						if (($result = $this->Users->addUser("admins", $userData, $adminData))==0)
						{
							# Added success
							$this->session->set_flashdata('msg_info',
								'Update '.$userData['username'].' Successful');

							//$this->users();
							redirect('admin/users');
						}
						else
						{
							# Failed
							$this->session->set_flashdata('msg_error',
								'Something went wrong cannot add '.$userData['username'].' taken<br>'.$this->misc->getErrorDesc($result,'user'));
							//$this->users();
							redirect('admin/users');
						}
					}
					else
					{
						// Set user data form
						$data['userData'] = array(
							'username' => $this->input->post('username'),
							'name' => $this->input->post('name'),
							'lname' => $this->input->post('surname'),
							'email' => $this->input->post('email'),
						);
						$data['msg_error'] = 'Check if information is correct';
						$this->load->view('admin/userfield_admin_view', $data);
					}

					break;

				case 'teacher':
					$data['formlink'] = 'admin/users/adduser/teacher';
					$data['pagesubtitle'] = "Teacher";
					$this->form_validation->set_rules('username', 'Username', 'required|trim');
					$this->form_validation->set_rules('password', 'Password', 'required|callback__password_check['.$this->input->post('passwordconfirm').']');
					$this->form_validation->set_rules('passwordconfirm', 'Password', 'required|callback__password_check['.$this->input->post('password').']');
					$this->form_validation->set_rules('fname', 'Name', 'required|trim');
					$this->form_validation->set_rules('surname', 'Last Name', 'required|trim');
					$this->form_validation->set_rules('faculty', 'Faculty', 'required');
					$this->form_validation->set_message('required', 'You must fill out %s');
					if ($this->form_validation->run())
					{
						# Form check completed
						$userData['username'] = $this->input->post('username');
						$userData['password'] = md5($this->input->post('password'));
						$userData['role'] = "teacher";
						$teacherData['name'] = $this->input->post('fname');
						$teacherData['lname'] = $this->input->post('surname');
						$teacherData['email'] = $this->input->post('email');
						$teacherData['fac_id'] = $this->input->post('faculty');

						if ($this->Users->addUser("teachers", $userData, $teacherData))
						{
							# Added success
							$this->session->set_flashdata('msg_info',
								'Update '.$userData['username'].' Successful');
							redirect('admin/users');
						} else {
							# Failed
							$this->session->set_flashdata('msg_error',
								'Something is wrong cannot add '.$userData['username'].' taken');
							redirect('admin/users');
						}
					}
					else
					{
						$data['userData'] = array(
							'username' => set_value('username'),
							'name' => set_value('fname'),
							'lname' => set_value('surname'),
							'birth' => set_value('birth'),
							'gender' => set_value('gender'),
							'year' => set_value('year'),
							'fac_id' => set_value('faculty'),
							//'branch_id' => set_value('branch'),
							'email' => set_value('email'),
						);
						$data['msg_error'] = 'Check if information is correct';
						$this->load->view('admin/userfield_teacher_view', $data);
					}
					break;

				case 'student':
					$data['formlink'] = 'admin/users/adduser/student';
					$data['pagesubtitle'] = "Students";
					$this->form_validation->set_rules('username', 'Username', 'required|trim');
					$this->form_validation->set_rules('password', 'Password', 'required|callback__password_check['.$this->input->post('passwordconfirm').']');
					$this->form_validation->set_rules('passwordconfirm', 'Password', 'required|callback__password_check['.$this->input->post('password').']');
					$this->form_validation->set_rules('fname', 'First Name', 'required|trim');
					$this->form_validation->set_rules('surname', 'Last Name', 'required|trim');
					$this->form_validation->set_rules('birth', 'Birth date', 'required');
					$this->form_validation->set_rules('gender', 'Gender', 'required');
					$this->form_validation->set_rules('year', 'Year', 'required|trim');
					$this->form_validation->set_rules('faculty', 'Faculty', 'required');
					$this->form_validation->set_rules('branch', 'Branch', 'required');
					$this->form_validation->set_message('required', 'You must fill out %s');
					if ($this->form_validation->run())
					{
						# Form check completed
						$userData['username'] = $this->input->post('username');
						$userData['password'] = md5($this->input->post('password'));
						$userData['role'] = "student";
						$studentData['stu_id'] = $this->input->post('username');
						//$studentData['title'] = $this->input->post('title');
						$studentData['name'] = $this->input->post('fname');
						$studentData['lname'] = $this->input->post('surname');
						$studentData['email'] = $this->input->post('email');
						$studentData['birth'] = $this->input->post('birth');
						$studentData['gender'] = ($this->input->post('gender')=="male"?"male":"female");
						$studentData['year'] = $this->input->post('year');
						$studentData['fac_id'] = $this->input->post('faculty');
						$studentData['branch_id'] = $this->input->post('branch');

						$result = $this->Users->addUser("students", $userData, $studentData);

						if ($result == 0)
						{
							# Added success
							$this->session->set_flashdata('msg_info',
								'Add '.$userData['username'].' Successful');
							redirect('admin/users');
						} else {
							# Failed
							$this->session->set_flashdata('msg_error',
								'Something is wrong cannot add '.$userData['username'].' taken<br>'.$result);
							redirect('admin/users');
						}
					}
					else
					{
						// Set user data form
						$data['userData'] = array(
							'username' => set_value('username'),
							'name' => set_value('fname'),
							'lname' => set_value('surname'),
							'birth' => set_value('birth'),
							'gender' => set_value('gender'),
							'year' => set_value('year'),
							'fac_id' => set_value('faculty'),
							'branch_id' => set_value('branch'),
							'email' => set_value('email'),
						);
						$data['msg_error'] = 'Check if the information is correct';
						$this->load->view('admin/userfield_student_view', $data);
					}
					break;

				default:
					# code...
					break;
			}
		} else {
			# Add data
			switch ($group) {
				case 'admin':
					$data['formlink'] = 'admin/users/adduser/admin';
					$data['pagetitle'] = "Add user";
					$data['pagesubtitle'] = "Admin";
					$data['permtxt'] = "Admin";

					// Set user data form
					$data['userData'] = array(
						'username' => set_value('username'),
						'name' => set_value('name'),
						'lname' => set_value('surname'),
						'email' => set_value('email'),
					);
					$this->load->view('admin/userfield_admin_view', $data);
					break;

				case 'teacher':
					$data['formlink'] = 'admin/users/adduser/teacher';
					$data['pagetitle'] = "Add user";
					$data['pagesubtitle'] = "Teacher";
					$data['permtxt'] = "Teacher";

					// Set user data form
					$data['userData'] = array(
						'username' => set_value('username'),
						'name' => set_value('name'),
						'lname' => set_value('surname'),
						'email' => set_value('email'),
						'fac_id' => set_value('faculty'),
					);
					$this->load->view('admin/userfield_teacher_view', $data);
					break;

				case 'student':
					$data['formlink'] = 'admin/users/adduser/student';
					$data['pagetitle'] = "Add user";
					$data['pagesubtitle'] = "Student";
					$data['permtxt'] = "Student";

					// Set user data form
					$data['userData'] = array(
						'username' => set_value('username'),
						'name' => set_value('name'),
						'lname' => set_value('surname'),
						'birth' => set_value('birth'),
						'gender' => set_value('gender'),
						'year' => set_value('year'),
						'fac_id' => set_value('faculty'),
						'branch_id' => set_value('branch'),
						'email' => set_value('email'),
					);
					$this->load->view('admin/userfield_student_view', $data);
					break;

				default:
					# code...
					break;
			}

		}
		$this->load->view('admin/t_footer_view');
	}

	function view($uid='')
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');
		$role = $this->Users->getUserRoleById($uid);
		$data['userData'] = $this->Users->getUserInfoById($uid,$role);
		$data['formlink'] = 'admin/users/view/'.$data['userData']['id'];
		$data['pagetitle'] = "User information".' '.$data['userData']['name'].
													' '.$data['userData']['lname'];
		$data['pagesubtitle'] = ' ('.$this->misc->getRoleTextTh($data['userData']['role']).')';


		if ($this->input->post('submit'))
		{
			$this->edit($uid, $data);
		}
		else
		{
			switch ($role) {
				case 'admin':
					$data['permtxt'] = "Admin";
					$this->load->view('admin/userfield_admin_view', $data);
					break;

				case 'teacher':
					$data['permtxt'] = "Teacher";
					$this->load->view('admin/userfield_teacher_view', $data);
					break;

				case 'student':
					$data['permtxt'] = "Teacher";
					$this->load->view('admin/userfield_student_view', $data);
					break;

				default:
					# code...
					break;
			}
		}
		$this->load->view('admin/t_footer_view');
	}

	function edit($uid, $viewData)
	{
		$role = $this->Users->getUserRoleById($uid);
		switch ($role) {
			case 'admin':
				$this->form_validation->set_rules('fname', 'Name', 'required');
				$this->form_validation->set_rules('surname', 'Last Name', 'required');
				$this->form_validation->set_rules('password', 'Password', 'callback__password_check['.$this->input->post('passwordconfirm').']');
				$this->form_validation->set_rules('passwordconfirm', 'Password', 'callback__password_check['.$this->input->post('password').']');
				$this->form_validation->set_message('required', 'You must fill out %s');
				if ($this->form_validation->run())
				{

					# Form check completed
					//$userData['username'] = $this->input->post('username');
					if ($this->input->post('password')) $userData['password'] = md5($this->input->post('password'));
					if ($this->input->post('status')) $userData['status'] = ($this->input->post('status')=="active"?"active":"inactive");
					//$userData['role'] = "admin";
					$adminData['name'] = $this->input->post('fname');
					$adminData['lname'] = $this->input->post('surname');
					$adminData['email'] = $this->input->post('email');

					if (($result = $this->Users->updateUser('admins', $userData, $adminData, $uid))==0)
					{
						# Added success
						$this->session->set_flashdata('msg_info',
							'แก้ไข '.$userData['username'].' เรียบร้อย');

						redirect('admin/users');
					}
					else
					{
						# Failed
						$this->session->set_flashdata('msg_error',
							'Something is wrong cannot add '.$userData['username'].' taken<br>'.$this->misc->getErrorDesc($result,'user'));
						//$this->users();
						redirect('admin/users');
					}
				}
				else
				{
					// Set user data form
					$data['userData'] = array(
						'username' => $viewData['userData']['username'],
						'name' => $this->input->post('fname'),
						'lname' => $this->input->post('surname'),
						'email' => $this->input->post('email'),
					);
					$data['msg_error'] = 'Check if the information is correct';
					$this->load->view('admin/userfield_admin_view', array_merge($viewData,$data));
				}
				break;

			case 'teacher':
				$this->form_validation->set_rules('password', 'Password', 'callback__password_check['.$this->input->post('passwordconfirm').']');
				$this->form_validation->set_rules('passwordconfirm', 'Password', 'callback__password_check['.$this->input->post('password').']');
				$this->form_validation->set_rules('fname', 'First Name', 'required|trim');
				$this->form_validation->set_rules('surname', 'Last Name', 'required|trim');
				$this->form_validation->set_rules('faculty', 'Faculty', 'required');
				$this->form_validation->set_message('required', 'You must fill out %s');
				if ($this->form_validation->run())
				{
					# Form check completed
					if ($this->input->post('password')) $userData['password'] = md5($this->input->post('password'));
					if ($this->input->post('status')) $userData['status'] = ($this->input->post('status')=="active"?"active":"inactive");
					$teacherData['name'] = $this->input->post('fname');
					$teacherData['lname'] = $this->input->post('surname');
					$teacherData['email'] = $this->input->post('email');
					$teacherData['fac_id'] = $this->input->post('faculty');

					if (($result = $this->Users->updateUser('teachers', $userData, $teacherData, $uid))==0)
					{
						# Added success
						$this->session->set_flashdata('msg_info',
							'Update '.$userData['username'].' Successful');

						redirect('admin/users');
					}
					else
					{
						# Failed
						$this->session->set_flashdata('msg_error',
							'Something is wrong cannot add '.$userData['username'].' taken<br>'.$this->misc->getErrorDesc($result,'user'));
						//$this->users();
						redirect('admin/users');
					}
				}
				else
				{
					$data['userData'] = array(
						'username' => $viewData['userData']['username'],
						'name' => $this->input->post('fname'),
						'lname' => $this->input->post('surname'),
						'email' => $this->input->post('email'),
						'fac_id' => $this->input->post('faculty')
					);
					$data['msg_error'] = 'Check if the information is correct';
					$this->load->view('admin/userfield_teacher_view', array_merge($viewData,$data));
				}
				break;

			case 'student':
				$this->form_validation->set_rules('password', 'Password', 'callback__password_check['.$this->input->post('passwordconfirm').']');
				$this->form_validation->set_rules('passwordconfirm', 'Password', 'callback__password_check['.$this->input->post('password').']');
				$this->form_validation->set_rules('fname', 'First Name', 'required|trim');
				$this->form_validation->set_rules('surname', 'Last Name', 'required|trim');
				$this->form_validation->set_rules('gender', 'Gender', 'required');
				$this->form_validation->set_rules('year', 'Year', 'required|trim');
				$this->form_validation->set_rules('faculty', 'Faculty', 'required');
				$this->form_validation->set_rules('branch', 'Branch', 'required');
				$this->form_validation->set_message('required', 'You must fill out %s');

				if ($this->form_validation->run())
				{
					# Form check completed
					if ($this->input->post('password')) $userData['password'] = md5($this->input->post('password'));
					if ($this->input->post('status')) $userData['status'] = ($this->input->post('status')=="active"?"active":"inactive");
					$studentData['stu_id'] = $this->input->post('username');
					//$studentData['title'] = $this->input->post('title');
					$studentData['name'] = $this->input->post('fname');
					$studentData['lname'] = $this->input->post('surname');
					$studentData['email'] = $this->input->post('email');
					$studentData['birth'] = ($this->input->post('birth')!=''?$this->input->post('birth'):null);
					$studentData['gender'] = ($this->input->post('gender')=="male"?"male":"female");
					$studentData['year'] = $this->input->post('year');
					$studentData['fac_id'] = $this->input->post('faculty');
					$studentData['branch_id'] = $this->input->post('branch');

					if (($result = $this->Users->updateUser('students', $userData, $studentData, $uid))==0)
					{
						# Added success
						$this->session->set_flashdata('msg_info',
							'Update '.$userData['username'].' Successful');

						redirect('admin/users');
					}
					else
					{
						# Failed
						$this->session->set_flashdata('msg_error',
							'Something is wrong cannot add '.$userData['username'].' taken<br>'.$this->misc->getErrorDesc($result,'user'));
						//$this->users();
						redirect('admin/users');
					}
				}
				else
				{
					$data['userData'] = array(
						'username' => $viewData['userData']['username'],
						'stu_id' => $this->input->post('username'),
						'title' => $this->input->post('title'),
						'name' => $this->input->post('fname'),
						'lname' => $this->input->post('surname'),
						'email' => $this->input->post('email'),
						'birth' => $this->input->post('birth'),
						'gender' => $this->input->post('gender'),
						'year' => $this->input->post('year'),
						'fac_id' => $this->input->post('faculty'),
						'branch_id' => $this->input->post('branch')
					);
					$data['msg_error'] = 'Check if the information is correct';
					$this->load->view('admin/userfield_student_view', array_merge($viewData,$data));
				}
				break;

			default:

				break;

		}
	}
	//password check
	function _password_check($str, $strcmp)
	{
		if ($str != $strcmp)
		{
			$this->form_validation->set_message('_password_check', 'Passwords do not match');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function import($group='student')
	{
		if (! ($group == 'admin' || $group == 'teacher' || $group == 'student'))
		{
			redirect('admin/users/import');
			return;
		}

		$this->load->model('userimporter_model', 'uimporter');

		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		$data['pagetitle'] = "Import User";
		$data['pagesubtitle'] = $this->misc->getRoleTextTh($group);

		if (isset($_FILES['file'])) {
			$result = $this->uimporter->ImportUsersFromFile($_FILES['file']['tmp_name'], $group);
			//$result = 0; # for Testing
			if ($result === 0)
				$data['msg_info'] = "The list has been imported into the database successfully!";
			else
				$data['msg_err'] = "Error! $result";
		}
		$this->load->view('admin/usersimport_view', $data);
		$this->load->view('admin/t_footer_view');

	}

}

/* End of file users.php */
/* Location: ./application/controllers/users.php */