<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class task extends CI_Controller {

	function task(){
		parent::__construct();

		$this->load->model("base_vo");
		$this->load->model("base_dao");
		$this->load->model("base_delegate");
		$this->load->model("task/task_vo");		
		$this->load->model("task/task_dao");
		$this->load->model("task/task_delegate");
		$this->load->model("task/task_board_vo");
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
	
	public function saveToBoard()
	{
		$taskDelegate = new task_delegate();
		$jsonData = $this->input->get_post("jsonData");
		$data = json_decode($jsonData);

		if($data == "")
		{
			$viewData["error"] = new generic_error_vo();
			$viewData["error"]->setMessage("invalidJson");
			$this->load->view('error/error', $viewData);	
			return;
		}
		
		$task = new task_vo();		
		$boardId = 0;
		
		if(isset($data->boardId))
			$task->boardId = $data->boardId;
		
		if(isset($data->id))
			$task->id = $data->id;
		
		if(isset($data->name))
			$task->name = $data->name;
			
		if(isset($data->taskBoardId))
			$task->taskBoardId = $data->taskBoardId;
			
		if(isset($data->status))
			$task->status = $data->status;
			
		if(isset($data->sortOrder))
			$task->sortOrder = $data->sortOrder;	
		
		$result = $taskDelegate->saveTaskForBoard($task, $boardId);

		$viewData["json"] = $result;
		
		$this->load->view('json_display', $viewData);		
	}
	
	
}
?>