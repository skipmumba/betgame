<?php 
class modelsendbet extends CI_Model
{
	public function __construct()
 	{
 		parent::__construct();
 	}
 	public function insert_bet($data)
 	{
 	
		$this->db->insert_batch('userbet', $data);
 	}
}