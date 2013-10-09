<?
class BaseDao extends CI_Model
{
	public $tableName;
	
	public function __construct() 
	{

    }
    
    public function setBaseProperties($object, $row)
    {	    
		$object->id = $row->id;
		$object->createdBy = $row->createdBy;
		$object->dateCreated = $row->dateCreated;
		$object->updatedBy = $row->updatedBy;
		$object->dateUpdated = $row->dateUpdated;
		$object->deleted = $row->deleted;
		
		return $object;
    }
    
    public function getBaseDataFromObject($object)
	{           
        $data = array();
        if($object->id)
        	$data['id'] = $object->id;
        if($object->createdBy)
        	$data['createdBy'] = $object->createdBy;        
        if($object->dateCreated)
        	$data['dateCreated'] = $object->dateCreated;
		if($object->updatedBy)
        	$data['updatedBy'] = $object->updatedBy;
        if($object->dateUpdated)
        	$data['dateUpdated'] = $object->dateUpdated;
        if($object->deleted)
        	$data['deleted'] = $object->deleted;
            
		return $data;
	}

    
}
?>