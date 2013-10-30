<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class board extends CI_Controller {

	function board(){
		parent::__construct();		
		$this->load->model("base_vo");
		$this->load->model("base_dao");
		$this->load->model("base_delegate");
		$this->load->model("error/generic_error_vo");
		$this->load->model("user/user_vo");
		$this->load->model("user/user_dao");
		$this->load->model("board/board_vo");
		$this->load->model('board/board_user_vo');
		$this->load->model("board/board_dao");
		$this->load->model("board/board_delegate");
		$this->load->model("task/task_vo");		
		$this->load->model("task/task_dao");
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
	
	public function saveForUser()
	{
		$boardDelegate = new board_delegate();
		$jsonData = $this->input->get_post("jsonData");
		$data = json_decode($jsonData);

		if($data == "")
		{
			$viewData["error"] = new generic_error_vo();
			$viewData["error"]->setMessage("invalidJson");
			$this->load->view('error/error', $viewData);	
			return;
		}
				
		$board = new board_vo();		
		$userId = 0;
		
		if(isset($data->userId))
			$userId = $data->userId;
		
		if(isset($data->boardUserId))
			$board->boardUserId = $data->boardUserId;
		
		if(isset($data->id))
			$board->id = $data->id;
		
		if(isset($data->name))
			$board->name = $data->name;
			

		$board = $boardDelegate->saveBoardForUser($userId, $board);
		
		$viewData["board"] = $board;
		
		$this->load->view('board/board_detail', $viewData);
		
	}
		
	public function fetch()
	{
		$boardDao = new BoardDao();
		return $boardDao->fetch();		
	}
	
	public function delete($id)
	{
		$boardDao = new board_dao();
		return $boardDao->delete($id);
	}
	
	public function saveTaskForBoard($task, $boardId)
	{
		if($boardId)
		{
			$taskDao = new task_dao();			
			$result = $taskDao->save($task);
			$task->id = $result->data->id;
			
			$boardDao = new board_dao();
			$result = $taskDao->saveTaskBoard($task, $boardId);
			
			return $result;
		}

	}	
			
}