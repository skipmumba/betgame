<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class news extends CI_Controller{
	public function __construct()
	{
	   	parent::__construct();
	    //Codeigniter : Write Less Do More
	}
	public function listNews()
	{
		$query = $this->db->get('news');
		echo json_encode($query->result());
	}
	public function getNews($id)
	{
		$query = $this->db->get_where('news', array('news_id' => $id));
		echo json_encode($query->result());
	}
}