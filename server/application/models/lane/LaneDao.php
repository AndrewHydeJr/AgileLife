<?
class LaneDao extends BaseDao
{
	public function __construct() 
	{		
		parent::__construct();
		$this->tableName = "Lane";
    }

	public function save($lane)
	{				
		$result = 0;
		$lane->dateUpdated = time();
		
		if($lane->guid)		
			$result = $lane = $this->update($lane);
		else
			$result = $this->insert($lane);
			
		return $result;
	}
	
	public function insert($lane)
	{		
		$lane->guid = Utils::getGUID();
		$lane->dateCreated = time();

		
		$result = new Result();
		$result->status = $this->db->insert($this->tableName, $this->getDataFromObject($lane));
		$result->data = $lane;
	
		return $result;
	}
	
	public function update($lane)
	{		
		$this->db->where('guid', $lane->guid);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($lane));
		$result->data = $lane;
		
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
		$lane = new LaneVo();
		$lane->guid = $guid;
		$lane->deleted = 1;
		$lane->dateUpdated = time();
		
		$this->db->where('guid', $lane->guid);
		$result = new Result();
		$result->status = $this->db->update($this->tableName, $this->getDataFromObject($lane));
		$result->data = $lane;

		return $result;
		
	}

}
?>