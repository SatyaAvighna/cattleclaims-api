<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
		// Your own constructor code
		//$this->load->model('common');
		$this->load->model('user');
	}
	public function index()
	{
		$arry = array();
		$users = $this->users->getusers();
		$arry['status'] = "success";
		$arry['message'] = "Entry retrieved successfully.";	
		$arry['list'] = $user;
		echo json_encode($arry);
	}
	public function add()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "EmailId is mandatory.";
		// fName,lName,gender,dob,doj,dor,bloodGroup,pan,dId,dsId,mobile,aMobile,cPerson,rId,address,aProof,panProof,roId,rmId,rvmId,etId,eId,password,emailId,createdBy
		if(!empty($data['emailId']))
		{
			$arry['message'] = "First name is mandatory.";
			if(!empty($data['fName']))
			{
				$arry['message'] = "Last name is mandatory.";
				if(!empty($data['lName']))
				{
					$arry['message'] = "Password is mandatory.";
					if(!empty($data['password']))
					{
						$arry['message'] = "Mobile is mandatory.";
						if(!empty($data['mobile']))
						{
							$arry['message'] = "Something went Wrong.";
                            $this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
                            $data['sId'] =  $this->encryption->decrypt($data['uId']);
                            $result = $this->user->insertuserById($data);	
                            if($result)
                            {
                                $arry['status'] = "success";
                                $arry['message'] = "Entry created successfully.";	
                            }
						}
					}
				}
			}
		}
		echo json_encode($arry);
	}
	public function uploadfiles($files,$name)
	{
		$lPath = '';
        if(is_uploaded_file($files[$name]['tmp_name']))
        {
            $sourcePath = $files[$name]['tmp_name'];
            $path_parts = pathinfo($files[$name]['name']);
            $lPath = "uploads/user".$name;
            if(!file_exists($lPath)) mkdir($lPath, 0777);
            $lPath .= "/".$files[$name]['name'];
            $targetPath = './'.$lPath;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                // pass;
            }
        }
		return $lPath;
	}
	public function retrive()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Id is mandatory.";
		$lists = array();
		if(!empty($data['uId']))
		{
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['uId']);
			$lists = $this->user->getuserById($data['uId']);	
			$arry['status'] = "success";
			$arry['message'] = "Entryretrieved successfully.";	
		}
		$arry["detail"] = $lists;
		echo json_encode($arry);
	}
	public function update()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Id is mandatory.";
		if(!empty($data['uId']))
		{
			$arry['message'] = "Something went wrong.";	
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['uId']);
			$result = $this->user->updateuserById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Entry updated successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function delete()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Id is mandatory.";
		if(!empty($data['uId']))
		{
			$arry['message'] = "Something went wrong.";	
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['ssId'] =  $this->encryption->decrypt($data['uId']);
			$result = $this->user->deleteuserById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Entry deleted successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function list()
	{
		$arry = array();
		$user = $this->user->getusers();
		$arry['status'] = "success";
		$arry['message'] = "Entry retrieved successfully.";	
		$arry['list'] = $user;
		echo json_encode($arry);
	}
	public function forgotpassword()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "mail id is mandatory.";
		$inputs = $this->input->post();
		if(!empty($inputs['emailId']))
		{ 
			$inputs['mailId'] = $inputs['emailId'];
			$arry['message'] = "User not exists.";	
			$result = $this->user->forgotUserById($inputs);
			if($result)
			{
				$inputs['subject'] =  "Forgot password mail from Apnapolicy";
				$arry['status'] = "success";
				$arry['message'] = "Mail sent successfully.";	
				$merged_arr = array_merge($inputs,$result);
				// $merged_arr['password1'] = $password;
				$this->sendmail('forgotPassword',$merged_arr);	
			}
		}
		echo json_encode($arry);
	}
	public function sendmail($template,$data)
	{
		$this->email->clear();
		$this->load->config('email');
		$config['mailtype'] = "html";
		$this->email->initialize($config);
		$this->email->from('support@apnapolicy.co.in', 'Forgot Password Notification');
		$this->email->to($data['mailId']);
		//print_r($data);
		$htmlMessage = $this->load->view($template, $data, true);
		//echo $htmlMessage;
		$this->email->subject($data['subject']);
		$this->email->message($htmlMessage);
		if ($this->email->send()) {
			echo 'Your email was sent.';
		} else {
			show_error($this->email->print_debugger());
		}
		ob_clean();
		return true;
	}
}
