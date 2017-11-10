<?php
class skrill extends CI_Controller 
{
	public function __construct()
	{
	   	parent::__construct();
	    //Codeigniter : Write Less Do More
	}
	public function index()
	{
		$this->load->view('test');
	}
}