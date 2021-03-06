<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qwarehouse_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}
//sub status
	function getSubjectStatus($str)
	{
		switch ($str) {
			case 'true':
				return '<i class="text-green fa fa-circle jtooltip" title="have subject"></i>';
				break;

			case 'false':
				return '<i class="fa fa-circle-o jtooltip" title="No subject"></i>';
				break;

			default:
				break;
		}
		return "";
	}

//sub list
	function getSubjectList($keyword='', $perpage=0, $offset=0)
	{
		$fields = array(
			'subject_id', 'code', 'name', 'shortname', 'description',
			'status', 'isHasQuestion(subject_id) as hasQuestion',
		);
		// $cause = array('role' => 'admin');

		if ($perpage=='') $perpage=0;
		if ($offset=='') $offset=0;
		settype($offset, "integer");
		settype($perpage, "integer");

		if ($perpage > 0) $this->db->limit($perpage, $offset);
		$query = $this->db
			->select($fields)
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->get('subjects')
			->result_array();
			// die($this->db->last_query());
		return $query;
	}

	function countSubjectList($keyword='')
	{
		$fields = array(
			'count(*) as scount'
		);
		$query = $this->db
			->select($fields)
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->get('subjects')
			->row_array();
		return $query['scount'];
	}

	function getChapterList($subject_id)
	{
		$cause = array('subject_id' => $subject_id);
		$query = $this->db
			->get_where('chapter', $cause)
			->result_array();
		return $query;
	}

	function addChapter($subject_id, $chapterName)
	{
		$data = array(
			'name' => $chapterName,
			'subject_id' => $subject_id,
		);
		$this->db->trans_start();
			$chins = $this->db->insert('Chapter', $data);
			$newid = $this->db->insert_id();
			$errno = $this->db->_error_number();
		$this->db->trans_complete();

		return array(
			'result' => $chins,
			'id' => $newid,
			'errno' => $errno
		);
	}

	function renChapter($chapter_id, $chapterName)
	{
		$data = array(
			'name' => $chapterName,
		);
		$chupd = $this->db
							->where('chapter_id', $chapter_id)
							->update('Chapter', $data);
		return $this->db->_error_number();
	}

	function delChapter($chapter_id)
	{

		$cause = array('questions.chapter_id' => $chapter_id);
		$this->db->trans_start();
			$countChapter = $this->db
				->select("count(questions.chapter_id) as c")
				->join('questions', 'Chapter.chapter_id = questions.chapter_id', 'LEFT')
				->get_where('Chapter', $cause)
				->row_array();
			$errno = $this->db->_error_number();
		$this->db->trans_complete();

		if ($errno == 0)
		{
			if (intval($countChapter['c']) > 0)
			{
				return array(
					'result' => "Error, can't delete.",
					'msg' => "Cannot delete chapter because of an error",
					'errno' => 0
				);
			}
			else
			{
				$this->db->trans_start();
					$delCh = $this->db->delete('Chapter', array('chapter_id' => $chapter_id));
					$errno = $this->db->_error_number();
				$this->db->trans_complete();
				if ($errno == 0)
				{
					return array(
						'result' => "deleted",
						'msg' => "Chapter deleted successfully",
						'errno' => 0
					);
				}
				else
				{
					return array(
						'result' => "Error, db",
						'msg' => "Database error: " . $errno,
						'errno' => $errno
					);
				}
			}
		}
		else
		{
			return array(
				'result' => "Error, db",
				'msg' => "Database error : " . $errno,
				'errno' => $errno
			);
		}

		$data = array(
			'name' => $chapterName,
		);
		$chupd = $this->db
							->where('chapter_id', $chapter_id)
							->update('Chapter', $data);
		return $this->db->_error_number();
	}
//add question
	function addQuestion($chapter_id, $dataQuestion, $dataQuestionDetail)
	{
		$hasError = false;
		$newqdid = -1;
		$dataQuestion['chapter_id'] = $chapter_id;
		$this->db->trans_begin();
			$qins = $this->db->insert('Questions', $dataQuestion);
			$newid = $this->db->insert_id();
			$errno = $this->db->_error_number();

			$dataQuestionDetail['question_id'] = $newid;
			switch ($dataQuestion['type']) {
				case 'choice':
					$qdins = $this->db->insert('Question_choice', $dataQuestionDetail);
					$newqdid = $this->db->insert_id();
					break;

				case 'numeric':
					$qdins = $this->db->insert('Question_numerical', $dataQuestionDetail);
					$newqdid = $this->db->insert_id();
					break;

				case 'boolean':
					$qdins = $this->db->insert('Question_boolean', $dataQuestionDetail);
					$newqdid = $this->db->insert_id();
					break;

				case 'matching': // Not yet Implemented !!!!
					$qdins = $this->db->insert('Question_matching', $dataQuestionDetail);
					$newqdid = $this->db->insert_id();
					break;

				default:
					$hasError = true;
					$this->db->trans_rollback();
					return array(
						'result' => 'failed',
						'errno' => $errno
					);
					break;
			}
		if (! $hasError) $this->db->trans_commit();
		return array(
			'result' => 'completed',
			'id' => $newid,
			'errno' => $errno
		);
	}

	function QuestionList($keyword='',$chapter_id, $perpage=0, $offset=0)
	{
		if ($perpage=='') $perpage=0;
		if ($offset=='') $offset=0;
		settype($offset, "integer");
		settype($perpage, "integer");

		if ($perpage > 0) $this->db->limit($perpage, $offset);
		$this->db->order_by('question_id','desc');
		$query = $this->db
			// ->select($fields)
			->like("CONCAT(question)",$keyword,'both')
			->get_where('question_list', array('chapter_id'=>$chapter_id))
			->result_array();
			// die($this->db->last_query());
		return $query;
	}

	function countQuestionList($keyword='',$chapter_id)
	{
		$fields = array(
			'count(*) as qcount'
		);
		$this->db->order_by('question_id','desc');
		$query = $this->db
			->select($fields)
			->like("CONCAT(question)",$keyword,'both')
			->get_where('question_list', array('chapter_id'=>$chapter_id))
			->row_array();
			// die($this->db->last_query());
		return $query['qcount'];
	}

}

/* End of file qwarehouse_model.php */
/* Location: ./application/models/qwarehouse_model.php */