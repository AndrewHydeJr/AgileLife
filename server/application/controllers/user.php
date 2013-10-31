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
	
	public function save($user = null)
	{		
		if(!$user)
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
					if(isset($boardJson->boardUserId))
						$board->boardUserId = $boardJson->boardUserId;
					
					
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
							
							if(isset($taskJson->taskBoardId))
								$task->taskBoardId = $taskJson->taskBoardId;
								
							array_push($board->tasks, $task);
						}
					}
				
					array_push($user->boards, $board);
				}
			}
		}

		$userDao = new user_dao();
		$boardDelegate = new board_delegate();

		$saveResult = $userDao->save($user);
		$user->id = $saveResult->data->id;
		if(count($user->boards))
		{
			foreach($user->boards as $board)
			{
				$saveBoardResult = $boardDelegate->saveBoardForUser($user->id, $board);
				
				if($board->tasks){
					$taskDelegate = new task_delegate();
					foreach($board->tasks as $task)
					{						
						$taskDelegate->saveTaskForBoard($task, $board->boardUserId);
					}	
				}
			}
		}

		$viewData["json"] = $user;
		$this->load->view('json_display', $viewData);
		
		return;			
	}	
	
	public function fetch()
	{
		$userDao = new user_dao();
		$result = $userDao->getAll();
		
		$viewData["json"] = $result->data->result();
		$this->load->view('json_display', $viewData);
	}
	
	public function fetchById($userId)
	{
		$head['title'] = "user detail";
		$userDao = new user_dao();	
		$data["json"] = $userDao->fetchById($userId);
		
		$this->load->view('json_display', $data);
	}
		
	public function delete($id)
	{
		$userDao = new user_dao();
		$user = $userDao->delete($id);
		
		$data["json"] = $userDao->fetchById($userId);
		
		$this->load->view('json_display', $data);
	}
	
	public function fetchBoardsForUserId($userId)
	{

		$boards = $this->userDelegate->getBoardsForUserId($userId);
		
		$data["json"] = $boards;
		
		$this->load->view('json_display', $data);
	}
		
}
