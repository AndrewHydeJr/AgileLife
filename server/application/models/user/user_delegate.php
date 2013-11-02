<?php
class user_delegate extends base_delegate
{
	public function __construct() 
	{		
		parent::__construct();
		$this->userDao = new user_dao();
    }
    
    public function save($user)
    {
	    $userDao = new user_dao();
	    $result = $userDao->save($user);
	    $user->id = $result->data->id;
	    
		if(count($user->boards))
		{
			$boardDelegate = new board_delegate();
			foreach($user->boards as $board)
			{
				$saveBoardResult = $boardDelegate->saveUserBoard($user->id, $board);
				
				if($board->tasks){
					$taskDelegate = new task_delegate();
					foreach($board->tasks as $task)
					{						
						$taskResult = $taskDelegate->saveTaskForBoard($task, $board->userBoardId);
						$task->boardTaskId = $taskResult->boardTaskId;
					}	
				}
			}
		}
		    
	    return $user;
    }

	public function fetch()
	{
		$userDao = new user_dao();
		$result = $userDao->getAll();
		
		return $result->data->result();
	}
	
	public function fetchById($userId)
	{
		$head['title'] = "user detail";
		$userDao = new user_dao();	
		
		$user = $userDao->fetchById($userId);
		$boardDao = new board_dao();
		if($user->id)		
			$user->boards = $boardDao->getBoardsForUserId($user->id);
		
		return $user;	
	}
		
	public function delete($id)
	{
		$userDao = new user_dao();
		$user = $userDao->delete($id);
		
		return  $userDao->fetchById($id);
	}
    
}
?>