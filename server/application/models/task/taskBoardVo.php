<?
class TaskBoardVo extends BaseVo
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