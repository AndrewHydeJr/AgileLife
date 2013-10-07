<?
class TaskVo extends BaseVo
{
	public $name;
	public $status;
	public $priority;
		
	public function __construct() 
	{
		parent::__construct();
		$this->status = 0;
		$this->priority = 0;
    } 
	
	
	
}
?>