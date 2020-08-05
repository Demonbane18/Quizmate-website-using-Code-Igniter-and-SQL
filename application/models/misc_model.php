<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Misc_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
	}

	function getClassName()
	{
		return $this->router->class;
	}

	function getMethodName()
	{
		return $this->router->method;
	}

	function listActive($page='')
	{
		if ($page == $this->getMethodName())
		{
			return ' class="active"';
		} else {
			return "";
		}
	}

	function listCActive($page='',$useclass=true,$direction='')
	{
		$result = '';

		switch ($direction) {
			case 'start':
				$result = $this->startsWith($this->getClassName(),$page);
				break;

			case 'end':
				$result = $this->endsWith($this->getClassName(),$page);
				break;

			default:
				$result = ($page == $this->getClassName()?true:false);
				break;
		}

		if ($result)
		{
			return ($useclass?' class="active"':'active');
		} else {
			return "";
		}
	}

	function listCActiveAry($items,$useclass=true)
	{
		if ($this->isInClass($items))
		{
			return ($useclass?' class="active"':'active');
		}
		else
		{
			return "";
		}
	}

	function isInClass($items)
	{
		return in_array($this->getClassName(), $items);
	}

	function btnActive($compare1,$compare2,$classAttr='btn btn-default')
	{
		if ($compare1 == $compare2)
		{
			return $classAttr . " active";
		} else {
			return $classAttr;
		}
	}

	function getRoleTextTh($strRole)
	{
		switch ($strRole) {
			case 'admin':
				return "admin";
				break;
			case 'teacher':
				return "teacher";
				break;
			case 'student':
				return "student";
				break;

			default:
				return "none";
				break;
		}
	}
	//short text func
	function getShortText($str,$len=100)
	{
		if (strlen($str) > $len)
		{
			return mb_substr($str, 0, $len, 'UTF-8').' ...';
		}
		else
		{
			return $str;
		}
	}


	function getHref($uri = '')
	{
		if ( ! is_array($uri))
		{
			$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
		}
		else
		{
			$site_url = site_url($uri);
		}
		return $site_url;
	}

	function getErrorDesc($errno,$mode='')
	{
		switch ($errno) {
			case 1062:
				if ($mode=="user")
					return "Username is taken";
				else
					return "Duplicate";
				break;

			default:
				return "";
				break;
		}
	}
//tags
	function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	function endsWith($haystack, $needle)
	{
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}
		return (substr($haystack, -$length) === $needle);
	}

	function PaginationInit($baseurl, $total=0, $perpage=25, $numlink=3, $configadd='')
	{
		if ($total == "") $total=0;
		if ($perpage == "") $perpage=25;

		$config['base_url'] = base_url().$this->config->item('index_page').'/'.$baseurl;
		$config['total_rows'] = $total;
		$config['per_page'] = $perpage;
		$config['num_links'] = $numlink;
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'p';
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '«';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '»';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '›';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '‹';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		if (is_array($configadd))
		{
			$config = array_replace($config, $configadd);
		}

		return $this->pagination->initialize($config);
	}
	function PageOffset($perpage, $page=1)
	{
		if ($page=='') $page = 1;
		return ($page-1) * $perpage;
	}
//log session
	function doLog($action,$uid='')
	{
		$logData = array(
			'uid' => ($uid!='')?$uid:($this->session->userdata('uid')!="")?$this->session->userdata('uid'):'-1',
			'action' => $action,
			'ipaddress' => $_SERVER['REMOTE_ADDR'],
			'iphostname' => GetHostByName($_SERVER['REMOTE_ADDR']),
			'iplocal' => isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:'',
			'useragent' => $this->input->user_agent()
		);
		$this->db->insert('log_usage', $logData);
	}
//date
	function budDateToChrsDate($datee, $delimits = '-', $delimitt = '') {
		if ($datee == "") return "";
		if ($delimitt == '') $delimitt = $delimits;
		list($d, $m, $y) = explode($delimits, $datee);
		$y -= 543;
			return $d . $delimitt . $m . $delimitt . $y;
	}

	function chrsDateToBudDate($datee, $delimits = '-', $delimitt = '') {
		if ($datee == "") return "";
		if ($delimitt == '') $delimitt = $delimits;
		list($y, $m, $d) = explode($delimits, $datee);
		$y += 543;
			return $d . $delimitt . $m . $delimitt . $y;
	}

	function reformatDate($strdate, $mask="d/m/Y", $reverse=false, $delimit='')
	{
		if (!$reverse)
			return date($mask, strtotime($strdate));
		else
		{
			list($y, $m, $d) = explode($delimit, $strdate);
			return date($mask, strtotime($y.'-'.$m.'-'.$d));
		}

	}
//date character
	function getFullDateT($strdate)
	{
		$thai_day_arr=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
		$thai_month_arr=array(
			"0" => "", "1" => "January", "2" => "February", "3" => "March",
			"4" => "April", "5" => "May", "6" => "June",
			"7" => "July", "8" => "August", "9" => "September",
			"10" => "October", "11" => "November", "12" => "December"
		);
		$strdate = strtotime($strdate);
		$ThaiDate = "day".$thai_day_arr[date("w",$strdate)];
		$ThaiDate.= "at ".date("j",$strdate);
		$ThaiDate.= " ".$thai_month_arr[date("n",$strdate)];
		$ThaiDate.= " year".(date("Y",$strdate));
		return $ThaiDate;
	}

	function dateDifference($date_1 , $date_2 )
	{
		$datetime1 = date_create($date_1);
		$datetime2 = date_create($date_2);

		$interval = date_diff($datetime1, $datetime2);

		$unit = array(
			'year' => 'year',
			'month' => 'month',
			'day' => 'day',
			'hours' => 'hours',
			'minutes' => 'minutes',
			'seconds' => 'seconds'
		);
		$text = "";
		if ($interval->y > 0) $text .= " %y $unit[year] ";
		if ($interval->m > 0) $text .= " %m $unit[month] ";
		if ($interval->d > 0) $text .= " %d $unit[day] ";
		if ($interval->h > 0) $text .= " %h $unit[hours]";
		if ($interval->i > 0) $text .= " %i $unit[minutes]";
		if ($interval->s > 0
			&& $interval->i == 0
			&& $interval->h == 0
			&& $interval->d == 0
			&& $interval->m == 0
			&& $interval->y == 0) $text .= " %s $unit[seconds]";

		return $interval->format($text);
	}

	function buildYearOptions($range = '10')
	{
		$startYear = date("Y");
		$year = $startYear;
		for($i = 0;$i < $range;$i++)
		{
			$options[$year] = $year;
			$year--;
		}
		return $options;
	}

	function buildsemesterOptions()
	{
		$options['1'] = "term 1";
		$options['2'] = "term 2";
		return $options;
	}

	function getActiveStatusIcon($str)
	{
		switch ($str) {
			case 'active':
				return '<i class="text-green fa fa-circle jtooltip" title="Enabled"></i>';
				break;

			case 'inactive':
				return '<i class="fa fa-circle-o jtooltip" title="Disabled"></i>';
				break;

			default:
				break;
		}
		return "";
	}
//visible eye
	function getVisibilityStatusIcon($str)
	{
		switch ($str) {
			case 'active':
			case 'visible':
			case 1:
			case '1':
				return '<i class="fa fa-eye jtooltip" title="Visible"></i>';
				break;

			case 'inactive':
			case 'invisible':
			case 0:
			case '0':
				return '<i class="fa fa-eye-slash jtooltip" title="Hide"></i>';
				break;

			default:
				break;
		}
		return "";
	}

}

/* End of file misc.php */
/* Location: ./application/models/misc.php */