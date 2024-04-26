<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentgateway extends CI_Controller {

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
		$this->load->model('gateway');
	}
	public function index()
	{
		$arry = array();
		// $arry['list'] = $this->common->getOwners();
		$arry['status'] = "success";
		$arry['message'] = "Paymentgateway retrieved successfully.";	
		echo json_encode($arry);
	}
	// public function add()
	// {
	// 	$arry = array();
	// 	$arry['status'] = "error";
	// 	$arry['message'] = "Name is mandatory.";
	// 	$data =$this->input->post();
	// 	$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
	// 	// print_r($data);
	// 	// $data['sId'] =  $this->encryption->decrypt($data['sId']);
	// 	$oId = 0;
    //     // oName,oMobile,oAadhar,oAddress,oPincode,oDistrict,oState
	// 	if(!empty($data['oName']))
	// 	{
	// 		$arry['message'] = "Mobile is mandatory.";
    //         if($data['oMobile']!="")
    //         {
    //             $arry['message'] = "Aadhar is mandatory.";
    //             if($data['oAadhar']!="")
    //             {
    //                 $arry['message'] = "Address is mandatory.";
    //                 if($data['oAddress']!="")
    //                 {
    //                     $arry['message'] = "Pincode is mandatory.";
    //                     if($data['oPincode']!="")
    //                     {
    //                         $arry['message'] = "District is mandatory.";
    //                         if($data['oDistrict']!="")
    //                         {
    //                             $arry['message'] = "State is mandatory.";
    //                             if($data['oState']!="")
    //                             {
    //                                 $arry['message'] = "Something went wrong.";
    //                                 $result = $this->owner->insertOwnerById($data);	
    //                                 if($result)
    //                                 {
    //                                     $arry['status'] = "success";
    //                                     $arry['message'] = "Owner created successfully.";
	// 									$oId = $result;	
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
	// 	}
	// 	$arry['oId'] = $oId;		
	// 	echo json_encode($arry);
	// }
	// public function retrive()
	// {
	// 	$arry = array();
	// 	$arry['status'] = "error";
	// 	$arry['message'] = "Id is mandatory.";
	// 	$data =$this->input->post();
	// 	if(!empty($data['oId']))
	// 	{
	// 		$lists = $this->owner->getOwnerById($data['oId']);
	// 		$arry['status'] = "success";
	// 		$arry['message'] ="Owner retrieved successfully.";	
	// 	}
	// 	$arry["detail"] = $lists;
	// 	echo json_encode($arry);
	// }
	// public function update()
	// {
	// 	$arry = array();
	// 	$arry['status'] = "error";
	// 	$arry['message'] = "Id is mandatory.";
	// 	$data =$this->input->post();
	// 	$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
	// 	//$data['sId'] =  $this->encryption->decrypt($data['sId']);
	// 	if(!empty($data['oId']))
	// 	{
    //         $arry['message'] = "Name is mandatory.";
    //         if(!empty($data['oName']))
    //         {
    //             $arry['message'] = "Mobile is mandatory.";
    //             if($data['oMobile']!="")
    //             {
    //                 $arry['message'] = "Aadhar is mandatory.";
    //                 if($data['oAadhar']!="")
    //                 {
    //                     $arry['message'] = "Address is mandatory.";
    //                     if($data['oAddress']!="")
    //                     {
    //                         $arry['message'] = "Pincode is mandatory.";
    //                         if($data['oPincode']!="")
    //                         {
    //                             $arry['message'] = "District is mandatory.";
    //                             if($data['oDistrict']!="")
    //                             {
    //                                 $arry['message'] = "State is mandatory.";
    //                                 if($data['oState']!="")
    //                                 {
    //                                     $arry['message'] = "Something went wrong.";
    //                                     $result = $this->owner->updateOwnerById($data);	
    //                                     if($result)
    //                                     {
    //                                         $arry['status'] = "success";
    //                                         $arry['message'] = "Owner updated successfully.";	
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
	// 	}
	// 	echo json_encode($arry);
	// }
	
	// public function delete()
	// {
	// 	$arry = array();
	// 	$arry['status'] = "error";
	// 	$arry['message'] = "Id is mandatory.";
	// 	$data =$this->input->post();
	// 	$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
	// 	// $data['sId'] =  $this->encryption->decrypt($data['sId']);
	// 	if(!empty($data['oId']))
	// 	{	
	// 		$arry['message'] = "Something went wrong.";	
	// 		$result = $this->owner->deleteOwnerById($data);	
	// 		if($result)
	// 		{
	// 			$arry['status'] = "success";
	// 			$arry['message'] = "Owner deleted successfully.";	
	// 		}
	// 	}
	// 	echo json_encode($arry);
	// }
	// public function all()
	// {
	// 	$arry = array();
	// 	$arry['list'] = $this->common->getOwners();
	// 	$arry['status'] = "success";
	// 	$arry['message'] = "Owner retrieved successfully.";	
	// 	echo json_encode($arry);
	// }
	// public function updatestatus()
	// {
	// 	$arry = array();
	// 	$arry['status'] = "error";
	// 	$arry['message'] = "Id is mandatory.";
	// 	$data =$this->input->post();
	// 	$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
	// 	// $data['sId'] =  $this->encryption->decrypt($data['sId']);
	// 	if(!empty($data['oId']))
	// 	{
	// 		$result = $this->owner->updateOwnerStatusById($data);	
	// 		if($result)
	// 		{
	// 			$arry['status'] = "success";
	// 			$arry['message'] = "Owner updated successfully.";	
	// 		}
	// 	}
	// 	echo json_encode($arry);
	// }
}
