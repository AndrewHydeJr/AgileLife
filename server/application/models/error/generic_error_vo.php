<?php
class generic_error_vo extends base_vo
{
	public $messages;
	public $name;
	public $code;
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->messages = array(
			"invalidJson" => "Invalid JSON :("
		);
		 

    } 
	
	public function setMessage($key)
	{
		$this->message = $this->messages[$key];
	}
	 
}
?>