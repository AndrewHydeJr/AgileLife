<?
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
		
		if($user->guid)		
			$result = $user = $this->update($user);
		else
			$result = $this->insert($user);
			
		return $result;
	}
	
	public function insert($user)
	{		
		$user->guid = Utils::getGUID();
		$user->dateCreated = time();

		
		$result = new Result();
		$result->status = $this->db->insert($this->tableName, $this->getDataFromObject($user));
		
		$query = $this->db->get_where($this->tableName, array('guid' => $user->guid), 1, 0);
		if($query->num_rows())
		{
			$row = $query->row();
			$user->id = $row->id;
		}
		
		$result->data = $user;
	
		return $result;
	}
	
	public function update($user)
	{		
		$this->db->where('guid', $user->guid);
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
										"SELECT b.id, b.guid, b.name, b.createdBy, b.dateCreated, b.updatedBy, b.dateUpdated, b.deleted ".
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
				array_push($boards, $board);			
			}
		}
		
		return $boards;
	}
	
	public function fetchTasksByBoardId($boardId)
	{
		$tasks = array();
		$tasksQuery = $this->db->query(
										"SELECT t.id, t.guid, t.name, t.createdBy, t.dateCreated, t.updatedBy, t.dateUpdated, t.deleted, bt.status, bt.priority ".
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
				$task->priority = $taskRow->priority;
				array_push($tasks, $task);
			}
		}
		return $tasks;
	}
	
	public function delete($guid)
	{
		$user = new UserVo();
		$user->guid = $guid;
		$user->deleted = 1;
		$user->dateUpdated = time();
		
		$this->db->where('guid', $user->guid);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($user));
		$result->data = $user;

		return $result;
		
	}
	
	public function saveBoardForUser($board, $userId)
	{
		$data = array(
		   'userId' => $userId ,
		   'boardId' => $board->id
		);
		$result = new Result();
		$result->status = $this->db->insert($this->userBoardTable, $data);
		$result->data = 0;
		return $result;
	}


}
?>