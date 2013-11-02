<?php
class task_delegate extends base_delegate
{
	public function __construct() 
	{		
		parent::__construct();

    }
    
    public function save($task)
    {
	    $taskDao = new task_dao();
	    return $taskDao->save($task);
    }
    
    public function saveTaskForBoard($task, $userBoardId)
	{
		$taskDao = new task_dao();
		$result = $taskDao->save($task);
		$task->id = $result->data->id; 
			
		$taskBoard = new task_board_vo();
		$taskBoard->id = $task->boardTaskId;
		$taskBoard->userBoardId = $userBoardId;
		$taskBoard->taskId = $task->id;
		$taskBoard->status = $task->status;		
		$taskBoard->sortOrder = $task->sortOrder;		
		
		$resultTaskBoard = $taskDao->saveBoardTask($taskBoard);
		$task->boardTaskId = $resultTaskBoard->data->id;
		$result = $task;
		
		return $result;	
	}
	
	public function fetch()
	{
		$taskDao = new task_dao();
		return $taskDao->fetch();	
	}
	
	public function delete($boardTaskId)
	{
		$taskDao = new task_dao();
		return $taskDao->deleteBoardTask($boardTaskId);
	}
	
	public function getTasksForUserBoardId($userBoardId)
	{
		$taskDao = new task_dao();
		return $taskDao->getTasksForUserBoardId($userBoardId);
	}

    
}
?>