<?php
class user_vo extends base_vo
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