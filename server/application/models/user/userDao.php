<?php
class UserDao extends BaseDao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "User";
		$this->userBoardTable = "UserBoard";
    }

	public function save($user)
	{				
		$result = 0;
		$user->dateUpdated = time();
		if($user->id)
			$result = $user = $this->update($user);
		else
			$result = $this->insert($user);

		return $result;
	}
	
	public function insert($user)
	{		
		$user->dateCreated = time();

		
		$result = new Result();
		
		$this->db->trans_start();
				
		$result->status = $this->db->insert($this->tableName, $this->getDataFromObject($user));
		$user->id = $this->db->insert_id();
		
		$this->db->trans_complete();

		$result->data = $user;
	
		return $result;
	}
	
	public function update($user)
	{		
		$this->db->where('id', $user->id);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($user));
		$result->data = $user;
		
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
		$result = new Result();
		
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
	
	public function fetchById($userId)
	{
		$result = new Result();
		$userQuery = $this->db->get_where($this->tableName, array('id' => $userId), 1);
		$user = new UserVo();
		
		if ($userQuery->num_rows() >0)
		{
			$userDao = new UserDao();
			foreach ($userQuery->result() as $row)
			{				
				$user = $userDao->setBaseProperties($user, $row);
				$user->name = $row->name;
				$user->boards = $this->fetchBoardsByUserId($user->id);
				break;
			}
		}
		return $user;
	}
	
	public function fetchBoardsByUserId($userId)
	{
		$boards = array();
		$boardQuery = $this->db->query(
										"SELECT b.id, ub.id as boardUserId, b.id, b.name, b.createdBy, b.dateCreated, b.updatedBy, b.dateUpdated, b.deleted ".
										"FROM board b INNER JOIN UserBoard ub on b.id = ub.boardId ".
										"AND ub.userId = ".$userId
										);
										
		if ($boardQuery->num_rows() > 0)
		{
			foreach ($boardQuery->result() as $boardRow)
			{
				$board = new BoardVo();
				$board = $this->setBaseProperties($board, $boardRow);
				$board->name = $boardRow->name;				
				$board->tasks = $this->fetchTasksByBoardId($board->id);
				$board->boardUserId = $boardRow->boardUserId;
				array_push($boards, $board);			
			}
		}
		
		return $boards;
	}
	
	public function fetchTasksByBoardId($boardId)
	{
		$tasks = array();
		$tasksQuery = $this->db->query(
										"SELECT t.id, bt.id as taskBoardId, t.name, t.createdBy, t.dateCreated, t.updatedBy, t.dateUpdated, ".
										"t.deleted, bt.status, bt.sortOrder ".
										"FROM Task t INNER JOIN BoardTask bt on t.id = bt.taskId ".
										"AND bt.boardId = ".$boardId
										);
		
		if($tasksQuery->num_rows() > 0)
		{			
			foreach($tasksQuery->result() as $taskRow)
			{
				$task = new TaskVo();
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
	
	public function delete($id)
	{
		$user = new UserVo();
		$user->id = $id;
		$user->deleted = 1;
		$user->dateUpdated = time();
		
		$this->db->where('id', $user->id);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($user));
		$result->data = $user;

		return $result;
		
	}

}
?>