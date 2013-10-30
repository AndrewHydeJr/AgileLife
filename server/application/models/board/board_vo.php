<?php
class board_vo extends base_vo
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