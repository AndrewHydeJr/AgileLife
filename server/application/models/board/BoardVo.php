<?
class BoardVo extends BaseVo
{
	public $name;
	public $tasks;
	public $boardUserId;
	
	
	public function __construct() 
	{
		parent::__construct(); 
		$this->tasks = array();
    } 
	
	
	 
}
?>