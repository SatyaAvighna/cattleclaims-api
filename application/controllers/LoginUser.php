<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginUser extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('common');
		$this->load->model('user');
		$this->load->model('role');
	}
	public function index()
	{
		$data = array();
		$data['status'] = 'error';
		$loggedin = array();
		$message = 'Wrong username or password';
		
		if(!empty($this->input->post('username')) && !empty($this->input->post('password')))
		{
			$message = 'Wrong username or password';
			$ldata = array('username'=>$this->input->post('username'),'password'=>$this->input->post('password'));
			$login = $this->common->loginUser($ldata);
			if ($login!=false)
			{
				$loggedin = array();
				foreach($login[0] as $column_name=>$column_value)
				{
					$loggedin[$column_name] =$column_value;
				}
				$this->encryption->initialize(
					array(
					  'driver' => 'openssl',
					  'cipher' => 'aes-256',
					  'mode' => 'ctr'
					));
				$sessionId = $this->encryption->encrypt($loggedin['uId']);
				// $loggedin['sessionId'] =  $sessionId;
				// echo $loggedin['sessionId'];
				//$this->session->set_userdata($loggedin['sessionId'], $loggedin);
				$message = 'Logged successfully..';
				$data['status'] = 'success';
				$data['sessionId'] = $sessionId;
			}
		}
		// echo "sessionId";
		$data['message'] = $message;
		$data['detail'] = $loggedin;
		echo json_encode($data);
	}

	public function changePwd()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		$data['uId'] =  $this->encryption->decrypt($data['uId']);
		if(!empty($data['uId']))
		{
            $arry['message'] = "Old Password is mandatory.";
			if(!empty($data['oldpassword']))
			{
				$arry['message'] = "New Password is mandatory.";
				if($data['newpassword']!="")
				{
					$arry['message'] = "Something went wrong.";
					$result = $this->user->updatePasswordById($data);	
					if($result)
					{
						$arry['status'] = "success";
						$arry['message'] = "Password updated successfully.";	
					}
                }
			}
		}
		echo json_encode($arry);
	}
}
