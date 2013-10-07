<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class board extends CI_Controller {

	function board(){
		parent::__construct();
		$this->load->model("baseVo");
		$this->load->model("baseDao");
		$this->load->model("board/boardVo");		
		$this->load->model("board/boardDao");
		$this->load->model("task/taskVo");		
		$this->load->model("task/taskDao");
		$this->load->model("utils");
		$this->load->model("result");
	}

	public function index()
	{
		//$this->load->view('welcome_message');
		
		
	}
	
	
	public function save($board=null)
	{		
		$boardDao = new BoardDao();
		if($board)
		{
			return $boardDao->save($board);
		}
		else
		{
			//get values from post params
		}
		
	}

	public function saveTest($create=1)
	{
		$board = 0;
		if($create)
		{
			$board = new BoardVo();		
			$board->name = "this is a board";			
		}
		else
		{
			$board = new BoardVo();		
			$board->guid = "{AE7D169A-70C1-D224-024F-23B7BBE168C1}";
			$board->name = "this is an updated board!!";
		}
		
		$result = $this->save($board);
		return $result;
	}	
	
	public function fetch()
	{
		$boardDao = new BoardDao();
		return $boardDao->fetch();		
	}
	
	public function fetchTest()
	{
		$result = $this->fetch();

		if ($result->data->num_rows() > 0)
		{
		   foreach ($result->data->result() as $row)
		   {
		      echo $row->name;
		      echo $row->dateUpdated;
		      echo $row->guid;
		      echo "<br><br>";
		   }
		}
	}
	
	public function delete($guid)
	{
		$boardDao = new BoardDao();
		return $boardDao->delete($guid);
	}
	
	public function deleteTest()
	{
		return $this->delete("{AE7D169A-70C1-D224-024F-23B7BBE168C1}");
	}
	
	public function saveTaskForBoard($task, $boardId)
	{
		if($boardId)
		{
			$taskDao = new TaskDao();			
			$result = $taskDao->save($task);
			$task->id = $result->data->id;
			
			$boardDao = new BoardDao();
			$result = $boardDao->saveTaskForBoard($task, $boardId);
			
			return $result;
		}

	}	
	
	public function saveTaskForBoardTest()
	{
		$boardId = 21;
		$task = new TaskVo();
		$task->name = "do something awesome.";
		$result = $this->saveTaskForBoard($task, $boardId);
	}
		
}