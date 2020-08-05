<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parteditor_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

	function getQuestionList($chapterid, $subjectId, $paperId, $qtype='all')
	{

		if ($qtype == 'all' or $qtype == '') $qqtype = "";
		else $qqtype = "and type = '$qtype'";

		$query = $this->db->query("SELECT * FROM `question_list` 
		where `chapter_id` in (SELECT chapter_id from chapter where subject_id = $subjectId) 
		and question_id not in ( SELECT question_id FROM question_detail_list qd where qd.paper_id = $paperId) 
		and chapter_id = $chapterid $qqtype 
		ORDER BY `question_id` ASC")->result_array();

		return $query;
	}

	function getQuestionDetailList($partid)
	{
		$query = $this->db
			->select('*')
			->from('question_detail_list')
			->where(array(
				//'paper_id' => $paperid,
				'part_id' => $partid,
				'status !=' => 'inactive'
			))
			->get()
			->result_array();
		return $query;
	}

	function addQuestionDetail($questionData)
	{
		// add inuse to question
		$this->db->update('Questions', array('status' => 'inuse'), 
			array('question_id'=>$questionData['question_id']));
		$query = $this->db
			->insert('Exam_Papers_Detail', $questionData);
		return $query;
	}
//order questions
	function reorderQuestions($questionData)
	{
		foreach ($questionData as $key => $value) {
			$query = $this->db->update('Exam_Papers_Detail', array('no'=>$key+1), array('question_id'=>$value));
		}
		// No checking yet
		return 0;
	}
//remove
	function removeQuestion($questionId,$partid,$paperid)
	{
		$this->db->delete('Exam_Papers_Detail',
				array(
					'question_id' => $questionId,
					'part_id' => $partid,
					'paper_id' => $paperid
				));

		// No checking yet
		return 0;
	}

	function getChapterList($subjectId)
	{
		$query = $this->db
			->select('*')
			->get_where('Chapter', array('subject_id' => $subjectId))
			->result_array();
		return $query;
	}

	function buildChapterOptions($subjectId)
	{
		$chapterList = $this->getChapterList($subjectId);
		foreach ($chapterList as $item) {
			$options[$item['chapter_id']] = $item['name'];
		}
		if (!isset($options))
			$options[''] = "-- No chapter -- ";
		return $options;
	}

}

/* End of file parteditor_model.php */
/* Location: ./application/models/parteditor_model.php */