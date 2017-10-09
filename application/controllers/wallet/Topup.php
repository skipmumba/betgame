<?php
ini_set('display_errors', 1);
include_once('manager/TrueWallet.php');
class topup extends CI_Controller 
{
	public function index()
	{
		if(isset($_GET['phone']))
		{
			$phone = $_GET['phone'];
			$referCodeUser = $_GET['refer'];
			if(ctype_digit($phone))
			{
				$newPhone = 0;
				$newPhone.= $phone[1];
				$newPhone.= $phone[2];
				$newPhone.= '-';
				$newPhone.= $phone[3];
				$newPhone.= $phone[4];
				$newPhone.= $phone[5];
				$newPhone.= '-';
				$newPhone.= $phone[6];
				$newPhone.= $phone[7];
				$newPhone.= $phone[8];
				$newPhone.= $phone[9];

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
							if($value->text5Th == $newPhone && $value->text3En == 'creditor')
							{
								$getFullReport = $wallet->get_report($value->reportID);
								$referOrigin = $getFullReport->section4->column2->cell1->value.'<br>';
								$FoundIt = $this->get_report($referCodeUser,$referOrigin);
								if($FoundIt == true)
								{
									break;
								}
							}
						}

						if($FoundIt)
						{
							echo json_encode(array('status'=>'ok'));
						}
						else
						{
							echo json_encode(array('status'=>'error'));
						}

					}
				}
				else 
				{

				}
			}
			else 
			{
				echo json_encode(array('status'=>'error'));
			}
		}
		else 
		{
			echo json_encode(array('status'=>'error'));
		}
	
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