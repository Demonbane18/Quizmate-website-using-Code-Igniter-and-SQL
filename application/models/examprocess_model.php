<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examprocess_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

	function getClassName()
	{
		return $this->router->class;
	}

	function getMethodName()
	{
		return $this->router->method;
	}

	function getCorrectAnswer($sco_id)
	{

		$query = $this->db
			->select(array('question_id','sco_id','answer'))
			->where('answer' ,'getAnswer(question_id)', false)
			->where('sco_id' ,$sco_id)
			->get('Answer_Papers');
		//die($this->db->last_query());

		// Count for correct point
		return $query->num_rows();
	}

	/*
	scoreboard
	 */
	function addScoreboard($uid, $courseid, $paperid, $answers, $score=0, $max=null, $min=null)
	{
		$dataScoreboard = array(
			'stu_id' => $uid,
			'course_id' => $courseid,
			'paper_id' => $paperid,
			'Score' => $score,
			'Max' => $max,
			'Min' => $min,
		);
		$query = $this->db->insert('Scoreboard', $dataScoreboard);
		$newid = $this->db->insert_id();

		$answerData = array();
		foreach ($answers as $key => $value) {
			$data = array(
				'question_id' => $key,
				'sco_id' => $newid,
				'answer' => $value,
			);
			array_push($answerData, $data);
		}

		if ($this->addAnswers($answerData))
		{
			$score = $this->getCorrectAnswer($newid);
		}

		$this->db->update('Scoreboard', array('score'=>$score), array('sco_id'=>$newid));

		return $score;
	}

	function addAnswers($data)
	{
		// Check error ??...

		$query = $this->db->insert_batch('Answer_Papers', $data);

		return true;
	}

	function getQuestionCount($paperid)
	{
		$query = $this->db
			->select('count(question_id) as qcount')
			->where('paper_id', $paperid)
			->get('question_detail_list')
			->row_array();
		return $query['qcount'];
	}

}

/* End of file examprocess_model.php */
/* Location: ./application/models/examprocess_model.php */