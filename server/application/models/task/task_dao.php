<?php
class task_dao extends base_dao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "task";
		$this->boardTaskTable = "board_task";
    }

	public function save($task)
	{				
		$result = 0;
		$task->dateUpdated = time();
		
		if($task->id)		
			$result = $this->update($task);
		else
			$result = $this->insert($task);
			
		return $result;
	}
	
	public function insert($task)
	{		
		$task->dateCreated = time();
		
		$result = new result();
		$this->db->trans_start();
		$result->status = $this->db->insert($this->tableName, $this->getDataFromObject($task));		
		$task->id = $this->db->insert_id();
		$this->db->trans_complete();
		
		$result->data = $task;
	
		return $result;
	}
	
	public function update($task)
	{		
		$this->db->where('id', $task->id);
		$result = new result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($task));
		$result->data = $task;
		
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
		$task = new task_vo();
		$task->id = $id;
		$task->deleted = 1;
		$task->dateUpdated = time();
		
		$this->db->where('id', $task->id);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($task));
		$result->data = $task;

		return $result;		
	}
	
	public function deleteBoardTask($id)
	{
		$taskBoard = new task_board_vo();
		$taskBoard->id = $id;
		$taskBoard->deleted = 1;
		$taskBoard->dateUpdated = time();

		$this->db->where('id', $taskBoard->id);
		$result = new Result();
		$result->status = $this->db->update($this->boardTaskTable, $this->getDataFromBoardTask($taskBoard));
		$result->data = $taskBoard;

		return $result;		
	}
	
	public function saveBoardTask($taskBoard)
	{
		if($taskBoard->id)
			$result = $this->updateBoardTask($taskBoard);
		else
			$result = $this->insertBoardTask($taskBoard);
		
		return $result;
	}
	
	public function updateBoardTask($taskBoard)
	{
		$result = new result();
		$result->status = $this->db->update($this->boardTaskTable, $this->getDataFromBoardTask($taskBoard));
		$result->data = $taskBoard;
	}
	
	public function insertBoardTask($taskBoard)
	{
		$taskBoard->dateCreated = time();
		$result = new result();

		$this->db->trans_start();

		$result->status = $this->db->insert($this->boardTaskTable, $this->getDataFromBoardTask($taskBoard));		
		$taskBoard->id = $this->db->insert_id();
		$this->db->trans_complete();	
		
		$result->data = $taskBoard;
				
		return $result;
	}
	
	public function getDataFromBoardTask($object)
	{
		$data = $this->getBaseDataFromObject($object);
		if($object->userBoardId)
			$data['userBoardId'] = $object->userBoardId;
		if($object->taskId)
			$data['taskId'] = $object->taskId;
		if($object->status)
			$data['status'] = $object->status;
		if($object->sortOrder)
			$data['sortOrder'] = $object->sortOrder;
		
		return $data;
	}
	
	public function getTasksForUserBoardId($userBoardId)
	{
		$tasks = array();

		$tasksQuery = $this->db->query(
										"SELECT t.id, bt.id as boardTaskId, t.name, t.createdBy, ".
										"t.dateCreated, t.updatedBy, t.dateUpdated, ".
										"bt.deleted, bt.status, bt.sortOrder ".
										"FROM Task t INNER JOIN board_task bt on t.id = bt.taskId ".
										"AND bt.userBoardId = ".$userBoardId.
										" AND (bt.deleted is NULL || bt.deleted = 0)"
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
				$task->boardTaskId = $taskRow->boardTaskId;
				array_push($tasks, $task);
			}
		}
		return $tasks;
	}

}
?>