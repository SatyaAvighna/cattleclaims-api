<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

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
		$this->load->model('common');
		$this->load->model('role');
	}
	public function index()
	{
		$arry = array();
		$arry['list'] = $this->common->getRoles();
		$arry['status'] = "success";
		$arry['message'] = "Role retrieved successfully.";	
		echo json_encode($arry);
	}
	public function add()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Name is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		$data['sId'] =  $this->encryption->decrypt($data['sId']);
		if(!empty($data['rName']))
		{
			$arry['message'] = "Landing Page is mandatory.";
            if($data['lPage']!="")
            {
                $arry['message'] = "Role Data is mandatory.";
				$rData = json_decode($data['rData']);
                if(!empty($rData))
                {
                    $arry['message'] = "Something went wrong.";
                    $result = $this->role->insertRoleById($data);	
                    if($result)
                    {
                        $arry['status'] = "success";
                        $arry['message'] = "Role created successfully.";	
                    }
                }
            }
		}
		echo json_encode($arry);
	}
	public function retrive()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Id is mandatory.";
		$data =$this->input->post();
		if(!empty($data['rId']))
		{
			$lists = $this->role->getRoleById($data['rId']);
			$arry['status'] = "success";
			$arry['message'] ="Role retrieved successfully.";	
		}
		$arry["detail"] = $lists;
		echo json_encode($arry);
	}
	public function update()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		$data['sId'] =  $this->encryption->decrypt($data['sId']);
		if(!empty($data['rId']))
		{
            $arry['message'] = "Name is mandatory.";
			if(!empty($data['rName']))
			{
				$arry['message'] = "Landing Page is mandatory.";
				if($data['lPage']!="")
				{
					$arry['message'] = "Role Data is mandatory.";
					$rData = json_decode($data['rData']);
					if(!empty($rData))
					{
                        $arry['message'] = "Something went wrong.";
                        $result = $this->role->updateRoleById($data);	
                        if($result)
                        {
                            $arry['status'] = "success";
                            $arry['message'] = "Role updated successfully.";	
                        }
                    }
                }
			}
		}
		echo json_encode($arry);
	}
	
	public function delete()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		$data['sId'] =  $this->encryption->decrypt($data['sId']);
		if(!empty($data['rId']))
		{	
			$arry['message'] = "Something went wrong.";	
			$result = $this->role->deleteRoleById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Role deleted successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function all()
	{
		$arry = array();
		$arry['list'] = $this->common->getRoles();
		$arry['status'] = "success";
		$arry['message'] = "Role retrieved successfully.";	
		echo json_encode($arry);
	}
	public function updatestatus()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		$data['sId'] =  $this->encryption->decrypt($data['sId']);
		if(!empty($data['rId']))
		{
			$result = $this->role->updateRoleStatusById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Role updated successfully.";	
			}
		}
		echo json_encode($arry);
	}
}
