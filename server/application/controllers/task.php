<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class task extends CI_Controller {

	function task(){
		parent::__construct();
		$this->load->model("baseVo");
		$this->load->model("BaseDao");
		$this->load->model("task/TaskVo");		
		$this->load->model("task/TaskDao");
		$this->load->model("Utils");
		$this->load->model("Result");
	}

	public function index()
	{
		
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
	
	public function fetch()
	{
		$taskDao = new TaskDao();
		return $taskDao->fetch();		
	}
	
	
	public function delete($id)
	{
		$taskDao = new TaskDao();
		return $taskDao->delete($id);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */