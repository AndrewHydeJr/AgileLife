<?php
class board_dao extends base_dao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "board";		
		$this->boardUserTable = "user_board";
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
	
	// BOARD USER
	public function saveBoardForUser($boardUser)
	{
		if($boardUser->id)
			$result = $this->updateBoardUser($boardUser);
		else
			$result = $this->insertBoardUser($boardUser);
		return $result;
	}
	
	public function updateBoardUser($boardUser)
	{
		$result = new result();
		$result->status = $this->db->update($this->boardUserTable, $this->getDataFromBoardUser($boardUser));
		
		$result->data = $boardUser;
	}
	
	public function insertBoardUser($boardUser)
	{
		$boardUser->dateCreated = time();
		
		$result = new result();
		$this->db->trans_start();
		$result->status = $this->db->insert($this->boardUserTable, $this->getDataFromBoardUser($boardUser));		
		$boardUser->id = $this->db->insert_id();
		$this->db->trans_complete();
		
		$result->data = $boardUser;
		
		return $result;
	}
	
	public function getDataFromBoardUser($object)
	{
		$data = $this->getBaseDataFromObject($object);
		if($object->userId)
			$data['userId'] = $object->userId;
		if($object->boardId)
			$data['boardId'] = $object->boardId;			
		
		return $data;
	}
	
	public function getTasksForBoardUserId($boardUserId)
	{
		$tasks = array();

		$tasksQuery = $this->db->query(
										"SELECT t.id, bt.id as taskBoardId, t.name, t.createdBy, ".
										"t.dateCreated, t.updatedBy, t.dateUpdated, ".
										"t.deleted, bt.status, bt.sortOrder ".
										"FROM Task t INNER JOIN board_task bt on t.id = bt.taskId ".
										"AND bt.boardUserId = ".$boardUserId
										);
		
		if($tasksQuery->num_rows() > 0)
		{			
			foreach($tasksQuery->result() as $taskRow)
			{
				$task = new task_vo();
				$task = $this->setBaseProperties($task, $taskRow);
				$task->name = $taskRow->name;
				$task->status = $taskRow->status;
				$task->sortOrder = $taskRow->sortOrder;
				$task->taskBoardId = $taskRow->taskBoardId;
				array_push($tasks, $task);
			}
		}
		return $tasks;
	}
	
		
	
}
?>