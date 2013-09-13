<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class task extends CI_Controller {

	function task(){
		parent::__construct();
		$this->load->model("BaseVo");
		$this->load->model("BaseDao");
		$this->load->model("task/TaskVo");		
		$this->load->model("task/TaskDao");
		$this->load->model("Utils");
		$this->load->model("Result");
	}

	public function index()
	{
		//$this->load->view('welcome_message');
		
		
	}
	
	
	public function save($task=null)
	{		
		$taskDao = new TaskDao();
		if($task)
		{
			return $taskDao->save($task);
		}
		else
		{
			//get values from post params
		}
		
	}
	
	public function saveTest($create=1)
	{
		$task = 0;
		if($create)
		{
			$task = new TaskVo();		
			$task->name = "this is a task";			
		}
		else
		{
			$task = new TaskVo();		
			$task->guid = "{AE7D169A-70C1-D224-024F-23B7BBE168C1}";
			$task->name = "this is an updated task!!";
		}
		
		$result = $this->save($task);
		return $result;
	}	
	
	public function fetch()
	{
		$taskDao = new TaskDao();
		return $taskDao->fetch();		
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
		$taskDao = new TaskDao();
		return $taskDao->delete($guid);
	}
	
	public function deleteTest()
	{
		return $this->delete("{AE7D169A-70C1-D224-024F-23B7BBE168C1}");
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */