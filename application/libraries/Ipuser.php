<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ipuser 
{
	
    function real_ip()
  	{
   		$ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
  	}
  	function checkip($code)
  	{
  		$this->db->from('member');
		$this->db->where('member_code',$code);
		$query = $this->db->get();
		foreach ($query->result() as $row)
		{
			if($row->member_ip == $this->ipuser->real_ip())
				echo 'ok';
			else 
				echo 'no';
		}
  	}

}