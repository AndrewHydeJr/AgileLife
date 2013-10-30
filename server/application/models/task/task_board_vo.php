<?php
class task_board_vo extends base_vo
{
	public $boardId;
	public $taskId;
	public $status;
	public $sortOrder;	
	
	public function __construct() 
	{
		parent::__construct(); 
		$this->tasks = array();
    } 
	
	
	
}
?>