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
		$timeExpire = intval($timeNow)+3600;
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
		if($headers['Authorization'] != '')
		{
			$decoded = JWT::decode($headers['Authorization'],$this->keys, array('HS256'));
			if($decoded)
			{
				$expireTime = intval($decoded->create)+3600;
				if($timeNow = time('Asia/Bangkok') > $expireTime) //i dont use the expire token because it is a trick for prevent hackers
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
				return false;
			}
		}
		else 
		{
			return false;
		}
		
	}
}