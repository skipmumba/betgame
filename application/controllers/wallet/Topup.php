<?php
ini_set('display_errors', 1);
include_once('manager/TrueWallet.php');
class topup extends CI_Controller 
{
	public function checktop($phoneNumber,$topup,$codeUser)
	{
			if(!is_numeric($codeUser))
			{
				exit("not number");
			}
			if(!is_numeric($phoneNumber))
			{
				exit("not number");
			}
			if(!is_numeric($topup))
			{
				exit("not number");
			}
			$phone = $phoneNumber;
			$walletRefer = $topup;
			if(ctype_digit($phone))
			{
			

				$wallet = new TrueWallet();
				$username = "skipmumba2@gmail.com";
				$password = "reefaut53";
				$wallet->logout();
				if($wallet->login($username,$password))
				{
					if($tran = $wallet->get_transactions())
					{
						$FoundIt = false;
						foreach($tran as $key => $value)
						{
							$getPhone = str_replace('-','',$value->text5Th);
							if($getPhone == $phone && $value->text3En == 'creditor')
							{
								$getFullReport = $wallet->get_report($value->reportID);
								$referOrigin = $getFullReport->section4->column2->cell1->value;
								$getPrice = $getFullReport->amount;
								$FoundIt = $this->get_report($walletRefer,$referOrigin);
								if($FoundIt == true)
								{
									break;
								}
							}
						}

						if($FoundIt)
						{
							if(!$this->usedcode($walletRefer))
							{
								$data = array(
								        'wallet_phone' => $phone,
								        'wallet_usercode' => $codeUser,
								        'wallet_code' => $referOrigin,
								        'wallet_price' => $getPrice,
								);
								if($this->db->insert('walletcode', $data))
								{
									$this->db->set('member_price', "member_price+{$getPrice}", FALSE);
									$this->db->where('member_code', $codeUser);
									if($this->db->update('member'))
									{										
										echo json_encode(array('status'=>'ok','newprice'=>$this->getprice($codeUser)));
									}
									else 
									{
										echo json_encode(array('status'=>'error'));
									}
								}
								else 
								{
									echo json_encode(array('status'=>'dberror'));
								}
							}
							else 
							{
								echo json_encode(array('status'=>'already'));							
							}
							// echo json_encode(array('status'=>'ok'));
						}
						else
						{
							echo json_encode(array('status'=>'error'));
						}

					}
				}
			}
		
	
	}

	public function getprice($code)
	{
		$query = $this->db->get_where('member', array('member_code' => $code));
		foreach ($query->result() as $row)
		{
		        return $row->member_price;
		}
	}

	public function usedcode($walletcode)
	{
		$query = $this->db->get_where('walletcode', array('wallet_code' => $walletcode));
		$found = false;
		foreach ($query->result() as $row)
		{
		        $found = true;
		}
		return $found;
	}
	public function get_report($code,$oricode)
	{
		$code = (int)$code;
		if($code == $oricode)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}

}