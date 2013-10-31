<?php
class task_delegate extends base_delegate
{
	public function __construct() 
	{		
		parent::__construct();

    }
    
    public function saveTaskForBoard($task, $boardUserId)
	{
		$taskDao = new task_dao();
		$result = $taskDao->save($task);
		$task->id = $result->data->id; 
			
		$taskBoard = new task_board_vo();
		$taskBoard->id = $task->taskBoardId;
		$taskBoard->boardUserId = $boardUserId;
		$taskBoard->taskId = $task->id;
		$taskBoard->status = $task->status;		
		$taskBoard->sortOrder = $task->sortOrder;		
		
		$resultTaskBoard = $taskDao->saveTaskBoard($taskBoard);
		$task->taskBoardId = $resultTaskBoard->data->id;
		
		$result = $task;
		
		return $result;	
	}	

    
}
?>