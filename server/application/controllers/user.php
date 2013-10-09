<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {

	function user()
	{
		parent::__construct();
		$this->load->model("baseVo");
		$this->load->model("baseDao");
		$this->load->model("user/userVo");		
		$this->load->model("user/userDao");
		$this->load->model("board/boardVo");
		$this->load->model("board/boardDao");
		$this->load->model('board/boardUserVo');
		$this->load->model("task/taskVo");
		$this->load->model("task/taskDao");
		$this->load->model("task/taskBoardVo");
		$this->load->model("utils");
		$this->load->model("result");
		$this->load->helper('form');
		$this->load->helper('url');		
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
			
			$user = new UserVo();
			if(isset($data->id))
				$user->id = $data->id;
			if($data->name)
				$user->name = $data->name;
						
			if(isset($data->boards) && count($data->boards))
			{
				foreach($data->boards as $boardJson)
				{
					$board = new BoardVo();
					
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
							$task = new TaskVo();
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
		
		$userDao = new UserDao();
		
		$saveResult = $userDao->save($user);
		$user->id = $saveResult->data->id;
		if(count($user->boards))
		{
			foreach($user->boards as $board)
			{
				$boardDao = new BoardDao();
				$this->saveBoardForUser($user->id, $board);
				if($board->tasks){
					foreach($board->tasks as $task)
					{
						$taskDao = new TaskDao();
						$this->saveTaskForBoard($task, $board->id);
					}	
				}				
			}
		}

		redirect('/fetch/user/'.$user->id, 'refresh');
		
		return;			
	}	
	
	public function fetch()
	{
		$userDao = new UserDao();
		return $userDao->fetch();
	}
	
	public function fetchById($userId)
	{
		$head['title'] = "user detail";
		
		$userDao = new UserDao();	
		$data["user"] = $userDao->fetchById($userId);
		
		$this->load->view('user/userDetail', $data);
	}
		
	public function delete($id)
	{
		$userDao = new UserDao();
		return $userDao->delete($id);
	}
	
	//USER BOARD
	public function saveBoardForUser($userId, $board)
	{
		if($board)
		{
			$userDao = new UserDao();
			$boardDao = new BoardDao();
			$result = $boardDao->save($board);
			$board->id = $result->data->id;
			
			$boardUser = new BoardUserVo();
			$boardUser->id = $board->boardUserId;
			$boardUser->userId = $userId;
			$boardUser->boardId = $board->id;
			
			$result = $boardDao->saveBoardUser($boardUser);
			
			return $result;
		}		
	}
	

	//BOARD TASK
	public function saveTaskForBoard($task, $boardId)
	{
		$taskDao = new TaskDao();
		$result = $taskDao->save($task);
		$task->id = $result->data->id;
			
		$taskBoard = new TaskBoardVo();
		$taskBoard->id = $task->taskBoardId;
		$taskBoard->boardId = $boardId;
		$taskBoard->taskId = $task->id;
		$taskBoard->status = $task->status;		
		$taskBoard->sortOrder = $task->sortOrder;		
		
		$result = $taskDao->saveTaskBoard($taskBoard);
		
		return $result;	
	}
	
	
	
}
