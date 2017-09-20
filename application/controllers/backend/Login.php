<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller{
	public function memberLogin()
	{
		$tests = array('test'=>true);
		echo json_encode($tests);
	}
}