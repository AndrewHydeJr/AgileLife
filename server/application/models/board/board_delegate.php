<?php
class board_delegate extends base_delegate
{
	public function __construct() 
	{		
		parent::__construct();

    }
    
    public function saveUserBoard($userId, $board)
	{		
		$userDao = new user_dao();
		$boardDao = new board_dao();
		
		$result = $boardDao->save($board);
	
		$board->id = $result->data->id;

		$boardUser = new board_user_vo();
		$boardUser->userId = $userId;
		$boardUser->boardId = $board->id;
		$result = $boardDao->saveUserBoard($boardUser);			
		
		$board->userBoardId = $result->data->id;
		
		return $board;
	}
	
	public function getBoardsForUserId($userId)
    {
	    $boardDao = new board_dao();
		return $boardDao->getBoardsForUserId($userId);
    }
    
    public function fetch()
	{
		$boardDao = new BoardDao();
		return $boardDao->fetch();		
	}
	
	public function delete($id)
	{
		$boardDao = new board_dao();
		return $boardDao->delete($id);
	}
	
	public function deleteUserBoard($userBoardId)
	{
		$boardDao = new board_dao();
		return $boardDao->deleteUserBoard($userBoardId);
	}
    
}
?>