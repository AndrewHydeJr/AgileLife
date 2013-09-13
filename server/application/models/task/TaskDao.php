<?
class TaskDao extends BaseDao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "Task";
    }

	public function save($task)
	{				
		$result = 0;
		$task->dateUpdated = time();
		
		if($task->guid)		
			$result = $task = $this->update($task);
		else
			$result = $this->insert($task);
			
		return $result;
	}
	
	public function insert($task)
	{		
		$task->guid = Utils::getGUID();
		$task->dateCreated = time();

		
		$result = new Result();
		$result->status = $this->db->insert($this->tableName, $this->getDataFromObject($task));
		$result->data = $task;
	
		return $result;
	}
	
	public function update($task)
	{		
		$this->db->where('guid', $task->guid);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($task));
		$result->data = $task;
		
		return $result;
	}
	
	public function getDataFromObject($object)
	{
		$data = array(			
			'guid' => $object->guid,			
			'dateUpdated' => $object->dateUpdated
            );
           
        if($object->id)
        	$data['id'] = $object->id;
		if($object->name)
			$data['name'] = $object->name;
        if($object->dateCreated)
        	$data['dateCreated'] = $object->dateCreated;
        if($object->deleted)
        	$data['deleted'] = $object->deleted;
            
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
	
	public function delete($guid)
	{
		$task = new TaskVo();
		$task->guid = $guid;
		$task->deleted = 1;
		$task->dateUpdated = time();
		
		$this->db->where('guid', $task->guid);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($task));
		$result->data = $task;

		return $result;
		
	}

}
?>