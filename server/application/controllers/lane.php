<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lane extends CI_Controller {

	function lane(){
		parent::__construct();
		$this->load->model("BaseVo");
		$this->load->model("BaseDao");
		$this->load->model("lane/LaneVo");		
		$this->load->model("lane/LaneDao");
		$this->load->model("Utils");
		$this->load->model("Result");
	}

	public function index()
	{
		//$this->load->view('welcome_message');
		
		
	}
	
	
	public function save($lane=null)
	{		
		$laneDao = new LaneDao();
		if($lane)
		{
			return $laneDao->save($lane);
		}
		else
		{
			//get values from post params
		}
		
	}
	
	public function saveTest($create=1)
	{
		$lane = 0;
		if($create)
		{
			$lane = new LaneVo();		
			$lane->name = "this is a lane";			
		}
		else
		{
			$lane = new LaneVo();		
			$lane->guid = "{AE7D169A-70C1-D224-024F-23B7BBE168C1}";
			$lane->name = "this is an updated lane!!";
		}
		
		$result = $this->save($lane);
		return $result;
	}	
	
	public function fetch()
	{
		$laneDao = new LaneDao();
		return $laneDao->fetch();		
	}
	
	public function fetchTest()
	{
		$result = $this->fetch();

		if ($result->data->num_rows() > 0)
		{
		   foreach ($result->data->result() as $row)
		   {
		      echo $row->name;
		      echo $row->dateUpdated;
		      echo $row->guid;
		      echo "<br><br>";
		   }
		}
	}
	
	public function delete($guid)
	{
		$laneDao = new LaneDao();
		return $laneDao->delete($guid);
	}
	
	public function deleteTest()
	{
		return $this->delete("{AE7D169A-70C1-D224-024F-23B7BBE168C1}");
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */