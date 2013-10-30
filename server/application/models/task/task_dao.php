<?php
class task_dao extends base_dao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "task";
		$this->taskBoardTable = "board_task";
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
	
	public function saveTaskBoard($taskBoard)
	{
		if($taskBoard->id)
			$result = $this->updateTaskBoard($taskBoard);
		else
			$result = $this->insertTaskBoard($taskBoard);
		
		return $result;
	}
	
	public function updateTaskBoard($taskBoard)
	{
		$result = new result();
		$result->status = $this->db->update($this->taskBoardTable, $this->getDataFromTaskBoard($taskBoard));
		$result->data = $taskBoard;
	}
	
	public function insertTaskBoard($taskBoard)
	{
		$taskBoard->dateCreated = time();
		$result = new result();
		
		$this->db->trans_start();
		$result->status = $this->db->insert($this->taskBoardTable, $this->getDataFromTaskBoard($taskBoard));		
		$taskBoard->id = $this->db->insert_id();
		$this->db->trans_complete();	
		
		$result->data = $taskBoard;
				
		return $result;
	}
	
	public function getDataFromTaskBoard($object)
	{
		$data = $this->getBaseDataFromObject($object);
		if($object->boardId)
			$data['boardId'] = $object->boardId;
		if($object->taskId)
			$data['taskId'] = $object->taskId;
		if($object->status)
			$data['status'] = $object->status;
		if($object->sortOrder)
			$data['sortOrder'] = $object->sortOrder;
		
		return $data;
	}

}
?>