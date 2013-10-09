<?
class BoardDao extends BaseDao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "Board";		
		$this->boardUserTable = "UserBoard";
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

		$result = new Result();
		
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
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($board));
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
		$board = new BoardVo();
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
	public function saveBoardUser($boardUser)
	{
		if($boardUser->id)
			$result = $this->updateBoardUser($boardUser);
		else
			$result = $this->insertBoardUser($boardUser);
		return $result;
	}
	
	public function updateBoardUser($boardUser)
	{
		$result = new Result();
		$result->status = $this->db->update($this->boardUserTable, $this->getDataFromBoardUser($boardUser));
		
		$result->data = $boardUser;
	}
	
	public function insertBoardUser($boardUser)
	{
		$boardUser->dateCreated = time();

		$result = new Result();
		$result->status = $this->db->insert($this->boardUserTable, $this->getDataFromBoardUser($boardUser));
		
		$query = $this->db->get_where($this->boardUserTable, array('id' => $boardUser->id), 1, 0);
		if($query->num_rows())
		{
			$row = $query->row();
			$boardUser->id = $row->id;
		}
		
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
	
		
	
}
?>