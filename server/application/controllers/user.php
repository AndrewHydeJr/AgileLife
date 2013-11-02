<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {

	function user()
	{
		parent::__construct();
		$this->load->model("base_vo");
		$this->load->model("base_dao");
		$this->load->model("base_delegate");
		$this->load->model("error/generic_error_vo");
		$this->load->model("user/user_vo");		
		$this->load->model("user/user_dao");
		$this->load->model("user/user_delegate");
		$this->load->model("board/board_vo");
		$this->load->model("board/board_dao");
		$this->load->model('board/board_user_vo');
		$this->load->model("board/board_delegate");
		$this->load->model("task/task_vo");
		$this->load->model("task/task_dao");
		$this->load->model("task/task_board_vo");
		$this->load->model("task/task_delegate");
		$this->load->model("utils");
		$this->load->model("result");
		$this->load->helper('form');
		$this->load->helper('url');
		
		$this->userDelegate = new user_delegate();	
	}

	public function index()
	{
			
	}
	
	public function save()
	{		

		$jsonData = $this->input->get_post("jsonData");

		$data = json_decode($jsonData);
					
		$user = new user_vo();
		if(isset($data->id))
			$user->id = $data->id;
		if($data->name)
			$user->name = $data->name;
		
		if(isset($data->boards) && count($data->boards))
		{
			foreach($data->boards as $boardJson)
			{
				$board = new board_vo();
				
				if(isset($boardJson->id))					
					$board->id = $boardJson->id;
				if(isset($boardJson->name))
					$board->name = $boardJson->name;
				if(isset($boardJson->userBoardId))
					$board->userBoardId = $boardJson->userBoardId;
				
				
				if(isset($boardJson->tasks) && count($boardJson->tasks))
				{
					foreach($boardJson->tasks as $taskJson)
					{
						$task = new task_vo();
						if(isset($taskJson->id))
							$task->id = $taskJson->id;
						
						$task->name = $taskJson->name;
						$task->status = $taskJson->status;
						$task->sortOrder = $taskJson->sortOrder;
						
						if(isset($taskJson->boardTaskId))
							$task->boardTaskId = $taskJson->boardTaskId;
							
						array_push($board->tasks, $task);
					}
				}
			
				array_push($user->boards, $board);
			}
		}

		$userDelegate = new user_delegate();
		$saveResult = $userDelegate->save($user);

		$viewData["json"] = $saveResult;
		$this->load->view('json_display', $viewData);
		
		return;			
	}	
	
	public function fetch()
	{
		$userDelegate = new user_delegate();
		$result = $userDelegate->fetch();
		
		$viewData["json"] = $result;
		$this->load->view('json_display', $viewData);
	}
	
	public function fetchById($userId)
	{
		$head['title'] = "user detail";
				
		$userDelegate = new user_delegate();
		$data["json"] = $userDelegate->fetchById($userId);
		
		$this->load->view('json_display', $data);
	}
		
	public function delete($id)
	{
		$userDelegate = new user_delegate();
		$user = $userDelegate->delete($id);
		
		$data["json"] = $userDelegate->fetchById($id);
		
		$this->load->view('json_display', $data);
	}
	
	
		
}
