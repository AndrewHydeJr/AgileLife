<?php
class board_dao extends base_dao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "board";		
		$this->userBoardTable = "user_board";
    }

	public function save($board)
	{
		$result = 0;
		$board->dateUpdated = time();

		if($board->id)		
			$result = $this->update($board);
		else
			$result = $this->insert($board);

		return $result;
	}
	
	public function insert($board)
	{		
		$board->dateCreated = time();

		$result = new result();
		
		$this->db->trans_start();

		$result->status = $this->db->insert($this->tableName, $this->getDataFromObject($board));
		$board->id = $this->db->insert_id();
		$this->db->trans_complete();
		
		$result->data = $board;
	
		return $result;
	}
	
	public function update($board)
	{		
		$this->db->where('id', $board->id);
		$result = new result();  
		$data = $this->getDataFromObject($board);
		$this->db->trans_start();
		$result->status = $this->db->update($this->tableName, $data );
		$this->db->trans_complete();
		$result->data = $board;
		return $result;
	}
	
	public function getDataFromObject($object)
	{
		$data = $this->getBaseDataFromObject($object);
		if($object->name)
			$data['name'] = $object->name; 
		
		return $data;
	}
	
	public function fetch()
	{
		$result = new result();
		
		$query = $this->db->get($this->tableName);
		if ($query->num_rows() > 0)
		{
			$result->data = $query;
			$result->status = 1;
		}
		else
		{
			$result->data = array();
			$result->status = 0;
		}	

		return $result;
	}
	
	public function delete($id)
	{
		$board = new board_vo();
		$board->id = $id;
		$board->deleted = 1;
		$board->dateUpdated = time();
		
		$this->db->where('id', $board->id);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($board));
		$result->data = $board;

		return $result;
		
	}
	
	//USER BOARD
	public function saveUserBoard($boardUser)
	{
		if($boardUser->id)
			$result = $this->updateUserBoard($boardUser);
		else
			$result = $this->insertUserBoard($boardUser);
		return $result;
	}
	
	public function updateUserBoard($boardUser)
	{
		$result = new result();
		$result->status = $this->db->update($this->userBoardTable, $this->getDataFromUserBoard($boardUser));
		
		$result->data = $boardUser;
	}
	
	public function insertUserBoard($boardUser)
	{
		$boardUser->dateCreated = time();
		$result = new result();
		$this->db->trans_start();
		$result->status = $this->db->insert($this->userBoardTable, $this->getDataFromUserBoard($boardUser));		
		$boardUser->id = $this->db->insert_id();
		$this->db->trans_complete();
		
		$result->data = $boardUser;
		
		return $result;
	}
	
	public function getDataFromUserBoard($object)
	{
		$data = $this->getBaseDataFromObject($object);
		if($object->userId)
			$data['userId'] = $object->userId;
		if($object->boardId)
			$data['boardId'] = $object->boardId;			
		
		return $data;
	}
	
	public function getBoardsForUserId($userId)
	{
		$boards = array();
		$boardQuery = $this->db->query(
										"SELECT b.id, ub.id as userBoardId, b.id, b.name, b.createdBy, b.dateCreated, b.updatedBy, b.dateUpdated, ub.deleted ".
										"FROM board b INNER JOIN user_board ub on b.id = ub.boardId ".
										"AND ub.userId = ".$userId.
										" AND (ub.deleted is NULL || ub.deleted = 0)"
										);
										
		if ($boardQuery->num_rows() > 0)
		{
			$taskDao = new task_dao();
			foreach ($boardQuery->result() as $boardRow)
			{
				$board = new board_vo();
				$board = $this->setBaseProperties($board, $boardRow);
				$board->name = $boardRow->name;				
				$board->userBoardId = $boardRow->userBoardId;
				$board->tasks = $taskDao->getTasksForUserBoardId($board->userBoardId);				
				array_push($boards, $board);			
			}
		}
		
		return $boards;
	}

	public function deleteUserBoard($id)
	{
		$board = new board_vo();
		$board->id = $id;
		$board->deleted = 1;
		$board->dateUpdated = time();
		
		$this->db->where('id', $board->id);
		$result = new Result();
		$result->status = $this->db->update($this->userBoardTable, $this->getDataFromObject($board));
		$result->data = $board;

		return $result;
		
	}
		
	
}
?>