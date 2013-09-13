<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class board extends CI_Controller {

	function board(){
		parent::__construct();
		$this->load->model("BaseVo");
		$this->load->model("BaseDao");
		$this->load->model("board/BoardVo");		
		$this->load->model("board/BoardDao");
		$this->load->model("Utils");
		$this->load->model("Result");
	}

	public function index()
	{
		//$this->load->view('welcome_message');
		
		
	}
	
	
	public function save($board=null)
	{		
		$boardDao = new BoardDao();
		if($board)
		{
			return $boardDao->save($board);
		}
		else
		{
			//get values from post params
		}
		
	}
	
	public function saveTest($create=1)
	{
		$board = 0;
		if($create)
		{
			$board = new BoardVo();		
			$board->name = "this is a board";			
		}
		else
		{
			$board = new BoardVo();		
			$board->guid = "{AE7D169A-70C1-D224-024F-23B7BBE168C1}";
			$board->name = "this is an updated board!!";
		}
		
		$result = $this->save($board);
		return $result;
	}	
	
	public function fetch()
	{
		$boardDao = new BoardDao();
		return $boardDao->fetch();		
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
		$boardDao = new BoardDao();
		return $boardDao->delete($guid);
	}
	
	public function deleteTest()
	{
		return $this->delete("{AE7D169A-70C1-D224-024F-23B7BBE168C1}");
	}
	
	public function saveBoardToUserId($userId, $board)
	{
		$boardDao->saveBoardToUserId($userId, $board);
	}
}