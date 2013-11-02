<?php
class UserVo extends baseVo
{
	public $name;
	public $boards;
	
	
	public function __construct()
	{
		parent::__construct();
		$this->boards = array();
    } 
	
	public function addBoard($board)
	{
		array_push($this->boards, $board);
	}
	
	
	
}
?>