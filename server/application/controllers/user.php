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
		$this->load->model("task/taskVo");
		$this->load->model("task/taskDao");
		$this->load->model("utils");
		$this->load->model("result");
		$this->load->helper('form');
	}

	public function index()
	{
		//$this->load->view('welcome_message');
		
		
	}
	
	public function save($user = null)
	{		
		if(!$user)
		{
			$jsonData = $this->input->get_post("jsonData");
			
			$data = json_decode($jsonData);
			
			$user = new UserVo();
			$user->name = $data->name;
			if(count($data->boards))
			{
				foreach($data->boards as $boardJson)
				{
					$board = new BoardVo();
					$board->name = $boardJson->name;
					
					if(count($boardJson->tasks))
					{
						foreach($boardJson->tasks as $taskJson)
						{
							$task = new TaskVo();
							$task->name = $taskJson->name;
							$task->status = $taskJson->status;
							$task->priority = $taskJson->priority;
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
		
		return  $user;			
	}	

	public function saveTest($create=1)
	{
		$user = 0;
		if($create)
		{
			$user = new UserVo();		
			$user->name = "do something awesome";			
		}
		else
		{
			$user = new UserVo();		
			$user->guid = "{9BEFE6A4-C0D3-71F7-31A3-020035E39C4C}";
			$user->name = "code";
		}
		
		$result = $this->save($user);
		return $result;
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
		$userDao = new UserDao();
		return $userDao->delete($guid);
	}
	
	public function deleteTest()
	{
		return $this->delete("{66D3CDC3-5799-791D-CB66-6D20CDC39427}");
	}
	
	//board for user
	public function saveBoardForUser($userId, $board)
	{
		
		if($board)
		{
			$userDao = new UserDao();
			$boardDao = new BoardDao();
			$result = $boardDao->save($board);
			$board->id = $result->data->id;
			$result = $userDao->saveBoardForUser($board, $userId);
			
			return $result;
		}
		
	}
	
	public function saveBoardForUserTest()
	{
		$userId = 25;
		$board = new BoardVo();
		$board->name = "chris's board.";
		$result = $this->saveBoardForUser($userId, $board);
	}
	
	
	//task for board
	public function saveTaskForBoard($task, $boardId)
	{
		$taskDao = new TaskDao();
		$result = $taskDao->save($task);
		$task->id = $result->data->id;
		
		$boardDao = new BoardDao();
		$result = $boardDao->saveTaskForBoard($task,$boardId);
			
	}
	
	
	
}
