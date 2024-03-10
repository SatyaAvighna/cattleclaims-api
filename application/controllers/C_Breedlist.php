<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class breedlist extends CI_Controller {

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
		$this->load->model('breedlist');
	}
	public function index()
	{
		$arry = array();
		$breedlist = $this->breedlist->getbreedlists();
		$arry['status'] = "success";
		$arry['message'] = "Entry retrieved successfully.";	
		$arry['list'] = $breedlist;
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
		$result = $this->breedlist->insertbreedlistById($data);	
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
		if(!empty($data['breedlist_Id']))
		{
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			$lists = $this->breedlist->getbreedlistById($data);	
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
		if(!empty($data['breedlist_Id']))
		{
			$arry['message'] = "Something went wrong.";	
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			$result = $this->breedlist->updatebreedlistById($data);	
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
		if(!empty($data['breedlist_Id']))
		{
			$arry['message'] = "Something went wrong.";	
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			$result = $this->breedlist->deletebreedlistById($data);	
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
		$breedlist = $this->breedlist->getbreedlists();
		$arry['status'] = "success";
		$arry['message'] = "Entry retrieved successfully.";	
		$arry['list'] = $breedlist;
		echo json_encode($arry);
	}
}
