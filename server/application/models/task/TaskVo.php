<?
class TaskVo extends BaseVo
{
	public $name;
	public $status;
	public $sortOrder;
	public $taskBoardId;
		
	public function __construct() 
	{
		parent::__construct();
		$this->status = 0;
		$this->sortOrder = 0;
    } 
}
?>