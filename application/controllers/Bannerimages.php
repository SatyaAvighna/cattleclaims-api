<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bannerimages extends CI_Controller {

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
		$this->load->model('bannerimage');
	}
	public function index()
	{
		$arry = array();
		$bannerimages = $this->bannerimage->getbannerimagess();
		$arry['status'] = "success";
		$arry['message'] = "Bannerimage retrieved successfully.";	
		$arry['list'] = $bannerimages;
		echo json_encode($arry);
	}
	public function add()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Banner Name is Mandatory.";
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		$data['sId'] =  $this->encryption->decrypt($data['sId']);
		if(!empty($data['bannerName']))
		{
            $data['bannerPath'] = "";
			$arry['message'] = "No change in the params.";
            if(!empty($_FILES)) 
            {
                if(isset($_FILES['bannerPath'])) $data['bannerPath'] = $this->uploadfiles($_FILES,"bannerPath");
            }
			if(empty($data['bannerPath']))  $arry['message'] = "Banner Image is mandatory.";
            $result = $this->bannerimage->insertbannerimagesById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Banner created successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function retrive()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Id is mandatory.";
		if(!empty($data['bannerimages_Id']))
		{
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			$lists = $this->bannerimage->getbannerimagesById($data);	
			$arry['status'] = "success";
			$arry['message'] = "Bannerimageretrieved successfully.";	
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
		if(!empty($data['bannerimages_Id']))
		{
			$arry['message'] = "Banner Name is Mandatory.";	
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			if(!empty($data['bannerName']))
			{
				$data['bannerPath'] = "";
				$arry['message'] = "No change in the params.";
				if(!empty($_FILES)) 
				{
					if(isset($_FILES['bannerPath'])) $data['bannerPath'] = $this->uploadfiles($_FILES,"bannerPath");
				}
				if(empty($data['bannerPath']))  $arry['message'] = "Banner Image is mandatory.";
				$result = $this->bannerimage->updatebannerimagesById($data);	
				if($result)
				{
					$arry['status'] = "success";
					$arry['message'] = "Bannerimage updated successfully.";	
				}
			}
		}
		echo json_encode($arry);
	}
	
	public function uploadfiles($files,$fname)
	{
		$lPath = '';
        if(is_uploaded_file($files[$fname]['tmp_name']))
        {
            $sourcePath = $files[$fname]['tmp_name'];
            $path_parts = pathinfo($files[$fname]['name']);
            $lPath = "uploads/banners";
            if(!file_exists($lPath)) mkdir($lPath, 0777);
			// $lPath = "uploads/banners/".$cId;
            // if(!file_exists($lPath)) mkdir($lPath, 0777);
            $lPath .= "/".time()."_".$files[$fname]['name'];
            $targetPath = './'.$lPath;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                // pass;
            }
        }
		return $lPath;
	}
	public function delete()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Id is mandatory.";
		if(!empty($data['bannerimages_Id']))
		{
			$arry['message'] = "Something went wrong.";	
			// $this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			// $data['sId'] =  $this->encryption->decrypt($data['sId']);
			$result = $this->bannerimage->deletebannerimagesById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Bannerimage deleted successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function list()
	{
		$arry = array();
		$bannerimages = $this->bannerimage->getbannerimagess();
		$arry['status'] = "success";
		$arry['message'] = "Bannerimage retrieved successfully.";	
		$arry['list'] = $bannerimages;
		echo json_encode($arry);
	}
}
