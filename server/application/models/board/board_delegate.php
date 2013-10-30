<?php
class board_delegate extends base_delegate
{
	public function __construct() 
	{		
		parent::__construct();

    }
    
    public function saveBoardForUser($userId, $board)
	{

		if($board)
		{

			$userDao = new user_dao();
			$boardDao = new board_dao();
			$result = $boardDao->save($board);
		
			$board->id = $result->data->id;
			
			$boardUser = new board_user_vo();
			$boardUser->id = $board->boardUserId;
			$boardUser->userId = $userId;
			$boardUser->boardId = $board->id;
			
			$result = $boardDao->saveBoardForUser($boardUser);
			
			return $result;
		}
		else
		{
			echo "sad face";
		}
			
	}
    
}
?>