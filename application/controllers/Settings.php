<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

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
		$this->load->model('setting');
	}
	public function index()
	{
		$arry = array();
		$arry['list'] = $this->common->getSettings();
		$arry['status'] = "success";
		$arry['message'] = "Setting retrieved successfully.";	
		echo json_encode($arry);
	}
	public function add()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Name is mandatory.";
		$data =$this->input->post();
		if(!empty($data['settingsName']))
		{
			$arry['message'] = "Something went wrong.";
			$session = $this->session->userdata('logged_in');
			$data['eId'] = $session['eId'];
			$result = $this->setting->insertSettingById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Setting created successfully.";	
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
		if(!empty($data['sId']))
		{
			$lists = $this->setting->getSettingById($data['sId']);
			$arry['status'] = "success";
			$arry['message'] ="Setting retrieved successfully.";	
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
		if(!empty($data['sId']))
		{
			$arry['message'] = "Setting is mandatory.";
			if(!empty($data['settingsName']))
			{
				$arry['message'] = "Something went wrong.";	
				$result = $this->setting->updateSettingById($data);	
				if($result)
				{
					$arry['status'] = "success";
					$arry['message'] = "Setting updated successfully.";	
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
		if(!empty($data['sId']))
		{	
			$arry['message'] = "Something went wrong.";	
			$result = $this->setting->deleteSettingById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Setting deleted successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function all()
	{
		$arry = array();
		$arry['list'] = $this->common->getSettings();
		$arry['status'] = "success";
		$arry['message'] = "Setting retrieved successfully.";	
		echo json_encode($arry);
	}
}
