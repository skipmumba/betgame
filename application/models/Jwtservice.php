<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'/vendor/autoload.php');
use \Firebase\JWT\JWT;
use Carbon\Carbon;
class jwtservice extends CI_Model 
{
	public $keys;
	public function __construct()
    	{
        	parent::__construct();
        	$this->keys = $this->config->item('encryption_key');
   	}
	public function setToken($id)
	{
		$timeNow = time('Asia/Bangkok');
		$timeExpire = intval($timeNow)+20;
		$token = array(
		    "code" => $id,
		    "create" => $timeNow,
		    "expire" => $timeExpire,
		    "role" => "user",
		);
		$jwt = JWT::encode($token,$this->keys);
		return $jwt;
	}
	public function getToken()
	{
		$headers = apache_request_headers();
		if($headers['Authorization'])
		{
			$decoded = JWT::decode($headers['Authorization'],$this->keys, array('HS256'));
			if($decoded)
			{
				$expireTime = intval($decoded->create)+10;
				if($timeNow = time('Asia/Bangkok') < $expireTime) //i dont use the expire token because it is a trick for prevent hackers
				{
					// echo 'expire Now';
					return false;
				}
				else 
				{
					// echo 'no expire';
					return true;
				}
				
			}
			else 
			{
				echo 'wrong';
			}
		}
		else 
		{
			echo 'no Authorization';
		}
		// print_r($headers['Authorization']);
		// $aa=$headers['Authorization'];
		// if($aa)
		// {
		// 	print_r($decoded);
		// }
		// $s = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImNoYXJlZWYiLCJhZG1pbiI6dHJ1ZX0.gJjlmHel4UhPFO4v42dXKUP-KkCN6P8ymoBr1cAyuGc';
		// $decoded = JWT::decode($aa,'secrets', array('HS256'));
		// print_r($decoded);
		
	}
}