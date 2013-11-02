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
		$this->load->model("board/board_vo");
		$this->load->model('board/board_user_vo');
		$this->load->model("board/board_dao");
		$this->load->model("board/board_delegate");
		$this->load->model("Utils");
		$this->load->model("Result");
	}

	public function index()
	{
		
	}
		
	public function save()
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
		$userBoardId = 0;
		
		if(isset($data->userBoardId))
			$userBoardId = $data->userBoardId;
		
		if(isset($data->id))
			$task->id = $data->id;
		
		if(isset($data->name))
			$task->name = $data->name;
			
		if(isset($data->boardTaskId))
			$task->boardTaskId = $data->boardTaskId;
			
		if(isset($data->status))
			$task->status = $data->status;
			
		if(isset($data->sortOrder))
			$task->sortOrder = $data->sortOrder;	
		
		$result = $taskDelegate->saveTaskForBoard($task, $userBoardId);

		$viewData["json"] = $result;
		
		$this->load->view('json_display', $viewData);
	}
	
	public function fetch()
	{
		$taskDelegate = new task_delegate();
		return $taskDelegate->fetch();		
	}
	
	
	public function delete($boardTaskId)
	{
		$taskDelegate = new task_delegate();
		$result = $taskDelegate->delete($boardTaskId);
		$viewData["json"] = $result;
		
		$this->load->view('json_display', $viewData);	
	}
	
	public function fetchTasksForuserBoardId($userBoardId)
	{
		$taskDelegate = new task_delegate();
		$result = $taskDelegate->getTasksForUserBoardId($userBoardId);
				
		$viewData["json"] = $result;
		
		$this->load->view('json_display', $viewData);	
	}
	
	
}
?>