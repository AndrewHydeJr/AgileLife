<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {

	function user(){
		parent::__construct();
		$this->load->model("BaseVo");
		$this->load->model("BaseDao");
		$this->load->model("user/UserVo");		
		$this->load->model("user/UserDao");
		$this->load->model("Utils");
		$this->load->model("Result");
	}

	public function index()
	{
		//$this->load->view('welcome_message');
		
		
	}
	
	
	public function save($user=null)
	{		
		$userDao = new UserDao();
		if($user)
		{
			return $userDao->save($user);
		}
		else
		{
			//get values from post params
		}
		
	}
	
	public function saveTest($create=1)
	{
		$user = 0;
		if($create)
		{
			$user = new UserVo();		
			$user->name = "do something awesome";			
		}
		else
		{
			$user = new UserVo();		
			$user->guid = "{9BEFE6A4-C0D3-71F7-31A3-020035E39C4C}";
			$user->name = "code";
		}
		
		$result = $this->save($user);
		return $result;
	}	
	
	public function fetch()
	{
		$userDao = new UserDao();
		return $userDao->fetch();		
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
		$userDao = new UserDao();
		return $userDao->delete($guid);
	}
	
	public function deleteTest()
	{
		return $this->delete("{66D3CDC3-5799-791D-CB66-6D20CDC39427}");
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */