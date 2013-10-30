<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jsonTest extends CI_Controller 
{

	function jsonTest()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}
	
	function jsonForm()
	{
		$this->load->helper('form');
		$this->load->view('jsonTest/json_form');
	}
	
	function runJsonTest()
	{
		$path = $this->input->post("path");
		$jsonData = $this->input->post("jsonData");
		
		switch($path)
		{
			case "/save/user":
				//echo "saving the user <br> <br>";
				$this->session->set_flashdata('jsonData', $jsonData);
				redirect("/save/user/testJson/save", 'location');		
			break;
		}
		
		//
		
		//echo $jsonData;exit;
		//redirect("/".$path, 'location');

	}
	
}
?>