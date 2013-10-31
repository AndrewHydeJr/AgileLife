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
	
	
}
?>