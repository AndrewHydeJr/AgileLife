<?php
class user_dao extends base_dao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "user";
		$this->userBoardTable = "user_board";
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
		$result = new result();
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
	
	public function getAll()
	{
		$result = new result();
		
		$query = $this->db->get($this->tableName);
		$result->data = $query;
		if ($query->num_rows() > 0)
			$result->status = 1;
		else
			$result->status = 0;
		
		return $result;
	}
	
	public function fetchById($userId)
	{
		$result = new result();
		$userQuery = $this->db->get_where($this->tableName, array('id' => $userId), 1);
		$user = new user_vo();
		
		if ($userQuery->num_rows() >0)
		{
			$userDao = new user_dao();
			foreach ($userQuery->result() as $row)
			{				
				$user = $userDao->setBaseProperties($user, $row);
				$user->name = $row->name;				
				break;
			}
		}
		return $user;
	}
	
	public function delete($id)
	{
		$user = new user_vo();
		$user->id = $id;
		$user->deleted = 1;
		$user->dateUpdated = time();
		
		$this->db->where('id', $user->id);
		$result = new result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($user));
		$result->data = $user;

		return $result;
		
	}

}
?>