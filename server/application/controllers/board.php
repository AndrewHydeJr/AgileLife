<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class board extends CI_Controller {

	function board(){
		parent::__construct();		
		$this->load->model("base_vo");
		$this->load->model("base_dao");
		$this->load->model("base_delegate");
		$this->load->model("error/generic_error_vo");
		$this->load->model("user/user_vo");
		$this->load->model("user/user_dao");
		$this->load->model("board/board_vo");
		$this->load->model('board/board_user_vo');
		$this->load->model("board/board_dao");
		$this->load->model("board/board_delegate");
		$this->load->model("task/task_vo");		
		$this->load->model("task/task_dao");
		$this->load->model("utils");
		$this->load->model("result");
	}

	public function index()
	{

	}
		
	public function save()
	{
		$boardDelegate = new board_delegate();
		$jsonData = $this->input->get_post("jsonData");
		$data = json_decode($jsonData);

		if($data == "")
		{
			$viewData["error"] = new generic_error_vo();
			$viewData["error"]->setMessage("invalidJson");
			$this->load->view('error/error', $viewData);	
			return;
		}
				
		$board = new board_vo();		
		$userId = 0;
		
		if(isset($data->userId))
			$userId = $data->userId;
		
		if(isset($data->userBoardId))
			$board->userBoardId = $data->userBoardId;
		
		if(isset($data->id))
			$board->id = $data->id;
		
		if(isset($data->name))
			$board->name = $data->name;
			
		$result = $boardDelegate->saveUserBoard($userId, $board);

		$viewData["json"] = $result;
		
		$this->load->view('json_display', $viewData);		
	}
		
	public function fetch()
	{
		$boardDelegate = new board_delegate();
		return $boardDelegate->fetch();		
	}
	
	public function delete($userBoardId)
	{
		$boardDelegate = new board_delegate();
		$result = $boardDelegate->deleteUserBoard($userBoardId);
		
		$data["json"] = $result;
		
		$this->load->view('json_display', $data);
	}
	
	public function fetchBoardsForUserId($userId)
	{
		$boardDelegate = new board_delegate();
		$boards = $boardDelegate->getBoardsForUserId($userId);
		
		$data["json"] = $boards;
		
		$this->load->view('json_display', $data);
	}
	
			
}