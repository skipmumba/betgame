<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class news extends CI_Controller{
	public function __construct()
	{
		// $this->load->library('session');
		 parent::__construct();
	}
	public function index()
	{
		echo 123;
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
	public function updateNew($id)
	{
		$post = json_decode(file_get_contents('php://input'), true);
		if(isset($post))
		{
			$this->db->set('news_subject', $post['sub']);
			$this->db->set('news_textarea', $post['text']);
			$this->db->where('news_id', $id);
			$this->db->update('news'); 
			echo json_encode(array('status'=>"succ"));
		}
	}
	public function delNew($id)
	{
		$this->db->delete('news', array('news_id' => $id));
		echo json_encode(array('status'=>"succ"));
	}
	public function insert()
	{
		$post = json_decode(file_get_contents('php://input'), true);

		if(isset($post))
		{

			$data = array(
	        'news_subject' => $post['sub'],
	        'news_textarea' =>  $post['text'],
			);

			if($this->db->insert('news', $data))
			{
				echo json_encode(array('status'=>'succ'));
			}
			else 
			{
				echo json_encode(array('status'=>'no'));
			}

		}

	}
}