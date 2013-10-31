<?php
class user_delegate extends base_delegate
{
	public function __construct() 
	{		
		parent::__construct();
		$this->userDao = new user_dao();
    }
    
    public function getBoardsForUserId($userId)
    {
	    return $this->userDao->getBoardsForUserId($userId);
    }

    
}
?>