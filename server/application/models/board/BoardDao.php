<?
class BoardDao extends BaseDao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "Board";
    }

	public function save($board)
	{				
		$result = 0;
		$board->dateUpdated = time();
		
		if($board->guid)		
			$result = $board = $this->update($board);
		else
			$result = $this->insert($board);
			
		return $result;
	}
	
	public function insert($board)
	{		
		$board->guid = Utils::getGUID();
		$board->dateCreated = time();

		
		$result = new Result();
		$result->status = $this->db->insert($this->tableName, $this->getDataFromObject($board));
		$result->data = $board;
	
		return $result;
	}
	
	public function update($board)
	{		
		$this->db->where('guid', $board->guid);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($board));
		$result->data = $board;
		
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
		$board = new BoardVo();
		$board->guid = $guid;
		$board->deleted = 1;
		$board->dateUpdated = time();
		
		$this->db->where('guid', $board->guid);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($board));
		$result->data = $board;

		return $result;
		
	}
	
	public function saveBoardToUserId($userId, $board)
	{
		//if !board id then save board
		
		//insert row into UserBoard
	}

}
?>