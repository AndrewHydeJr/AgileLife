<?
class BoardVo extends BaseVo
{
	public $name;
	public $tasks;
	
	
	public function __construct() 
	{
		parent::__construct(); 
		$this->tasks = array();
    } 
	
	
	
}
?>