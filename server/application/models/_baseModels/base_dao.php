<?
class base_dao extends base_dao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "User";
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

		$result = new result();
		$result->status = $this->db->insert($this->tableName, $this->getDataFromObject($user));
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
		$data = array(			
			'id' => $object->id,			
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