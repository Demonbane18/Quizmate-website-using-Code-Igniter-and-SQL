<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userimporter_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');

	}
//get file name
	public function getMimetype($filename)
	{
		if(function_exists('mime_content_type')){ 
			$mimetype = mime_content_type($filename); 
			return $mimetype; 

		}elseif(function_exists('finfo_open')){ 
			$finfo = finfo_open(FILEINFO_MIME); 
			$mimetype = finfo_file($finfo, $filename); 
			finfo_close($finfo); 
			return $mimetype; 
		}elseif(array_key_exists($ext, $mime_types)){ 
			return $mime_types[$ext]; 
		}else { 
			return 'application/octet-stream'; 
		} 
	}

	public function ImportUsersFromFile($file, $group, $options = array())
	{
		# Check MIME-TYPE
		$mimetype = $this->getMimetype($file);
		$ext = "";
		//excel insert
		switch ($mimetype) {
			case 'application/vnd.ms-excel':
				# XLS
				$ext = "xls";
				$this->load->library('xlsreader');
				$this->xlsreader->setOutputEncoding('UTF-8');
				$this->xlsreader->read($file);
				break;

			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
				# XLSX
				$ext = "xlsx";
				$this->load->library('simplexlsx', array('filename' => $file));
				break;

			case 'text/csv':
			case 'text/plain':
				# CSV
				$ext = "csv";
				$this->load->library('csvreader', array('filename' => $file));
				break;
			
			default:
				# The required file format is not available.
				return "Incorrect or corrupted file format";
				break;
		}

		$options['ext'] = $ext;

		switch ($group) {
			case 'admin':
				return $this->ImportAdminUsers($options);
				break;
			
			case 'teacher':
				return $this->ImportTeacherUsers($options);
				break;

			case 'student':
				return $this->ImportStudentUsers($options);
				break;

			default:
				return false;
				break;
		}
	}

	private function ImportAdminUsers($options = array())
	{
		
	}

	private function ImportTeacherUsers($options = array())
	{

	}

	private function ImportStudentUsers($options = array())
	{

		switch ($options['ext']) {
			case 'xlsx':
				list($cols,) = $this->simplexlsx->dimension();

				// $studentData = array();
				foreach( $this->simplexlsx->rows() as $k => $r) {
					if ($k == 0) continue; // skip first row
					if (isset($r[0]))
					{
						if ($r[0] != '' && is_numeric($r[0]))
						{
							$userData = array(
								'username' => (isset($r[0])) ? $r[0] : '',
								'password' => md5($r[0]),
								'role' => 'student'
							);
							$studentItem = array(
								'stu_id' => (isset($r[0])) ? $r[0] : '',
								'title' => (isset($r[1])) ? $r[1] : '',
								'name' => (isset($r[2])) ? $r[2] : '',
								'lname' => (isset($r[3])) ? $r[3] : '',
								'gender' => ($r[1]=="Mr.")?'male':'female',
								'fac_id' => (isset($r[4])) ? $r[4] : '',
								'branch_id' => (isset($r[5])) ? $r[5] : '',
								'idcard' => (isset($r[6])) ? $r[6] : '',
								'year' => (isset($r[7])) ? $r[7] : ''
							);
							// array_push($studentData, $studentItem); 
							$result = $this->Users->addUser("students", $userData, $studentItem);
							if ($result != 0)
							{
								return $result; //returns DB error 
							}
						}
					}
				}#end foreach

				error_reporting($err_report_setting);
				return 0; // no error
				break;

			case 'xls':
				# Set PHP Notice 
				$err_report_setting = error_reporting();
				error_reporting(E_ERROR | E_WARNING | E_PARSE);
				ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);

				#Make Instance shorten
				$xls = $this->xlsreader;

				$r = $xls->sheets[0]['cells'];
				for ($i = 1; $i <= $xls->sheets[0]['numRows']; $i++) {
					if ($i == 1) continue; // skip first row
					if (isset($r[$i][1]))
					{

						if ($r[$i][1] != '' && is_numeric($r[$i][1]))
						{
							$userData = array(
								'username' => $r[$i][1],
								'password' => md5($r[$i][1]),
								'role' => 'student'
							);
							$studentItem = array(
								'stu_id' => $r[$i][1],
								'title' => $r[$i][2],
								'name' => $r[$i][3],
								'lname' => $r[$i][4],
								'gender' => ($r[$i][2]=="Mr")?'male':'female',
								'fac_id' => $r[$i][5],
								'branch_id' => $r[$i][6],
								'idcard' => $r[$i][7],
								'year' => $r[$i][8]
							);

							$result = $this->Users->addUser("students", $userData, $studentItem);
							if ($result != 0)
							{
								return $result; //return DB error code
							}
						}
					}
				}#end foreach

				error_reporting($err_report_setting);
				return 0; // no error
				break;
            //csv file
			case 'csv':
				$csv = $this->csvreader;
				$csvdata = $csv->toArrayUTF8();
				
				foreach ($csvdata as $r) {
					if (isset($r[0]))
					{
						if ($r[0] != '' && is_numeric($r[0]))
						{
							$userData = array(
								'username' => $r[0],
								'password' => md5($r[0]),
								'role' => 'student'
							);
							$studentItem = array(
								'stu_id' => $r[0],
								'title' => $r[1],
								'name' => $r[2],
								'lname' => $r[3],
								'gender' => ($r[1]=="Mr.")?'male':'female',
								'fac_id' => $r[4],
								'branch_id' => $r[5],
								'idcard' => $r[6],
								'year' => $r[7]
							);
							$result = $this->Users->addUser("students", $userData, $studentItem);
							if ($result != 0)
							{
								return $result; //return DB error code
							}
						}
					}
				}#end foreach

				return 0; // no error
				break;
			
			default:
				# code...
				break;
		}

		return -1; // error code do nothing
	}

}

/* End of file userimporter_model.php */
/* Location: ./application/models/userimporter_model.php */