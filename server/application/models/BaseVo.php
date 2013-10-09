<?
class BaseVo
{
	public $id;
	public $createdBy;
	public $dateCreated;
	public $updatedBy;
	public $dateUpdated;
	public $deleted;
	
	public function __construct() 
	{
		$this->deleted = 0;
    } 

}
?>