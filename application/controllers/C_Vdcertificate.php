<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Vdcertificate extends CI_Controller {

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
		$this->load->model('vdcertificate');
	}
	public function index()
	{
		$arry = array();
		$vdcertificate = $this->vdcertificate->getvdcertificates();
		$arry['status'] = "success";
		$arry['message'] = "Entry retrieved successfully.";	
		$arry['list'] = $vdcertificate;
		echo json_encode($arry);
	}
	public function add()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Something went Wrong.";
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		$data['sId'] =  $this->encryption->decrypt($data['sId']);
		$result = $this->vdcertificate->insertvdcertificateById($data);	
		if($result)
		{
			$arry['status'] = "success";
			$arry['message'] = "Entry created successfully.";	
		}
		echo json_encode($arry);
	}
	public function retrive()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Id is mandatory.";
		if(!empty($data['vdcertificate_Id']))
		{
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			$lists = $this->vdcertificate->getvdcertificateById($data);	
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
		if(!empty($data['vdcertificate_Id']))
		{
			$arry['message'] = "Something went wrong.";	
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			$result = $this->vdcertificate->updatevdcertificateById($data);	
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
		if(!empty($data['vdcertificate_Id']))
		{
			$arry['message'] = "Something went wrong.";	
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			$result = $this->vdcertificate->deletevdcertificateById($data);	
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
		$vdcertificate = $this->vdcertificate->getvdcertificates();
		$arry['status'] = "success";
		$arry['message'] = "Entry retrieved successfully.";	
		$arry['list'] = $vdcertificate;
		echo json_encode($arry);
	}
}
