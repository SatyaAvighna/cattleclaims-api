<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'vendor/autoload.php';
class Cattles extends CI_Controller {

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
		$this->load->model('cattle');
	}
	public function index()
	{
		$arry = array();
		$arry['list'] = $this->common->getCattles();
		$arry['status'] = "success";
		$arry['message'] = "Cattle retrieved successfully.";	
		echo json_encode($arry);
	}
	public function add()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Cattle is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		// $data['sId'] =  $this->encryption->decrypt($data['uId']);
        // cattle,tagnumber,breed,gender,age,sumInsured,earTag,lSidePath,rSidePath,vPath
		$cId = 0;
		$proposalId = 0;
		if(!empty($data['animalType']))
		{
			$arry['message'] = "Tag Number is mandatory.";
            if($data['tagnumber']!="")
            {
                $arry['message'] = "Breed is mandatory.";
                if($data['breed']!="")
                {
                    $arry['message'] = "Gender is mandatory.";
                    if($data['gender']!="")
                    {
                        $arry['message'] = "Age is mandatory.";
                        if($data['age']!="")
                        {
                            $arry['message'] = "Sum Insured is mandatory.";
                            if($data['sumInsured']!="")
                            {
								$arry['message'] = "Owner ID is mandatory.";
								if($data['ownerId']!="")
								{
									$arry['message'] = "Cattle exists with Ear Tag.";
									$result = $this->cattle->insertCattleById($data);	
									if($result['cId']>0)
									{
										$arry['status'] = "success";
										$arry['message'] = "Cattle created successfully.";	
										$cId = $result['cId'];
										$proposalId = $result['proposalId'];
									}
								}
                            }
                        }
                    }
                }
            }
		}
		$arry['cId'] = $cId;
		$arry['proposalId'] = $proposalId;
		echo json_encode($arry);
	}
	public function verifyEartag()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "EarTag is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		if(!empty($data['tagnumber']))
		{
			$arry['message'] = "Cattle exists with Ear Tag.";
			$result = $this->cattle->getCattleByEarTag($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Cattle not exists with Ear Tag.";	
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
		if(!empty($data['cId']))
		{
			$lists = $this->cattle->getCattleById($data['cId']);
			$arry['status'] = "success";
			$arry['message'] ="Cattle retrieved successfully.";	
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
		// $data['sId'] =  $this->encryption->decrypt($data['uId']);
		if(!empty($data['cId']))
		{
			if(!empty($data['cattle']))
			{
				$arry['message'] = "Tag Number is mandatory.";
				if($data['tagnumber']!="")
				{
					$arry['message'] = "Breed is mandatory.";
					if($data['breed']!="")
					{
						$arry['message'] = "Gender is mandatory.";
						if($data['gender']!="")
						{
							$arry['message'] = "Age is mandatory.";
							if($data['age']!="")
							{
								$arry['message'] = "Sum Insured is mandatory.";
								if($data['sumInsured']!="")
								{
									$arry['message'] = "No change in the params.";
									$result = $this->cattle->updateCattleById($data);	
									if($result)
									{
										$arry['status'] = "success";
										$arry['message'] = "Cattle updated successfully.";	
									}
								}
							}
						}
					}
				}
			}
		}
		echo json_encode($arry);
	}
	
	public function updateearTagPath()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Cattle Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		if(!empty($data['cId']))
		{
            // cattle,tagnumber,breed,gender,age,sumInsured,earTag,lSidePath,rSidePath,vPath
            $data['earTag'] = "";
			$arry['message'] = "No change in the params.";
			// print_r($_FILES);
            if(!empty($_FILES)) 
            {
                if(isset($_FILES['earTag'])) $data['earTag'] = $this->uploadfiles($_FILES,"earTag",$data['cId']);
            }
			if(empty($data['earTag']))  $arry['message'] = "Ear tag file is mandatory.";
            $result = $this->cattle->updateCattleById($data);	
            if($result)
            {
                $arry['status'] = "success";
                $arry['message'] = "Cattle updated successfully.";	
				if(isset($_FILES['earTag'])) $arry['earTag'] = $data['earTag'];
            }
		}
		echo json_encode($arry);
	}
	public function updatelSidePath()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Cattle Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		if(!empty($data['cId']))
		{
            // cattle,tagnumber,breed,gender,age,sumInsured,earTag,lSidePath,rSidePath,vPath
            $data['lSidePath'] = "";
			$arry['message'] = "No change in the params.";
            if(!empty($_FILES)) 
            {
                if(isset($_FILES['lSidePath'])) $data['lSidePath'] = $this->uploadfiles($_FILES,"lSidePath",$data['cId']);
            }
			if(empty($data['lSidePath']))  $arry['message'] = "Cattle left side file is mandatory.";
            $result = $this->cattle->updateCattleById($data);	
            if($result)
            {
                $arry['status'] = "success";
                $arry['message'] = "Cattle updated successfully.";	
				if(isset($_FILES['lSidePath'])) $arry['lSidePath'] = $data['lSidePath'];
            }
		}
		echo json_encode($arry);
	}
	public function updaterSidePath()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Cattle Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		if(!empty($data['cId']))
		{
            // cattle,tagnumber,breed,gender,age,sumInsured,earTag,lSidePath,rSidePath,vPath
            $data['rSidePath'] = "";
			$arry['message'] = "No change in the params.";
			// print_r($_FILES);
            if(!empty($_FILES)) 
            {
                if(isset($_FILES['rSidePath'])) $data['rSidePath'] = $this->uploadfiles($_FILES,"rSidePath",$data['cId']);
            }
			if(empty($data['rSidePath']))  $arry['message'] = "Cattle right side file is mandatory.";
            $result = $this->cattle->updateCattleById($data);	
            if($result)
            {
                $arry['status'] = "success";
                $arry['message'] = "Cattle updated successfully.";	
				if(isset($_FILES['rSidePath'])) $arry['rSidePath'] = $data['rSidePath'];
            }
		}
		echo json_encode($arry);
	}
	public function updatevideoPath()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Cattle Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		if(!empty($data['cId']))
		{
            // cattle,tagnumber,breed,gender,age,sumInsured,earTag,lSidePath,rSidePath,vPath
            $data['vPath'] = "";
			$arry['message'] = "No change in the params.";
			// print_r($_FILES);
            if(!empty($_FILES)) 
            {
                if(isset($_FILES['vPath'])) $data['vPath'] = $this->uploadfiles($_FILES,"vPath",$data['cId']);
            }
			if(empty($data['vPath']))  $arry['message'] = "Video file is mandatory.";
            $result = $this->cattle->updateCattleById($data);	
            if($result)
            {
                $arry['status'] = "success";
                $arry['message'] = "Cattle updated successfully.";	
				if(isset($_FILES['vPath'])) $arry['vPath'] = $data['vPath'];
            }
		}
		echo json_encode($arry);
	}
	public function updateVdCertificate()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Cattle Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		if(!empty($data['cId']))
		{
            // cattle,tagnumber,breed,gender,age,sumInsured,earTag,lSidePath,rSidePath,vPath,vdcPath
            $data['vdcPath'] = "";
			$arry['message'] = "No change in the params.";
			// print_r($_FILES);
            if(!empty($_FILES)) 
            {
                if(isset($_FILES['vdcPath'])) $data['vdcPath'] = $this->uploadfiles($_FILES,"vdcPath",$data['cId']);
            }
			if(empty($data['vdcPath']))  $arry['message'] = "Video file is mandatory.";
            $result = $this->cattle->updateCattleById($data);	
            if($result)
            {
                $arry['status'] = "success";
                $arry['message'] = "Cattle updated successfully.";	
				if(isset($_FILES['vdcPath'])) $arry['vdcPath'] = $data['vdcPath'];
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
		// $data['sId'] =  $this->encryption->decrypt($data['uId']);
		if(!empty($data['cId']))
		{	
			$arry['message'] = "Cattle delete failed.";	
			$result = $this->cattle->deleteCattleById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Cattle deleted successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function all()
	{
		$arry = array();
		$arry['list'] = $this->common->getCattles();
		$arry['status'] = "success";
		$arry['message'] = "Cattle retrieved successfully.";	
		echo json_encode($arry);
	}
	public function updatestatus()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		// $data['sId'] =  $this->encryption->decrypt($data['uId']);
		if(!empty($data['cId']))
		{
			$result = $this->cattle->updateCattleStatusById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Cattle updated successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function uploadfiles($files,$fname,$cId)
	{
		$lPath = '';
        if(is_uploaded_file($files[$fname]['tmp_name']))
        {
            $sourcePath = $files[$fname]['tmp_name'];
            $path_parts = pathinfo($files[$fname]['name']);
            $lPath = "uploads/cattles";
            if(!file_exists($lPath)) mkdir($lPath, 0777);
			$lPath = "uploads/cattles/".$cId;
            if(!file_exists($lPath)) mkdir($lPath, 0777);
            $lPath .= "/".$fname."_".time()."_".$files[$fname]['name'];
            $targetPath = './'.$lPath;
            if(move_uploaded_file($sourcePath,$targetPath))
            {
                // pass;
            }
        }
		return $lPath;
	}
	public function getPremiums()
	{
		$arry = array();
		$inputs =$this->input->post();
		// sumInsured,animalType,breed,gender,age
		$arry['message'] = "Cattle Id is mandatory.";
		$arry['quotes'] = [];
		if(!empty($inputs['proposalId']))
		{	
			$arry['message'] = "Invalid Proposal Id.";	
			$data = $this->cattle->getCattleDetailsBypId($inputs['proposalId']);
			// print_r($data);
			$result = $this->cattle->getQuotes($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Quotes Retrieved successfully.";	
				$arry['quotes'] = $result;
			}
		}
		echo json_encode($arry);
	}
	public function getMedicalqns()
	{
		$arry = array();
		$data =$this->input->post();
		// sumInsured,animalType,breed,gender,age
		$arry['message'] = "Base Procuct Id is mandatory.";
		$arry['medicalqns'] = [];
		if(!empty($data['baseproductId']))
		{	
			$arry['message'] = "Invalid Product Id.";	
			$result = $this->cattle->getMedicalqns($data['baseproductId']);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Medicalqns Retrieved successfully.";	
				$arry['medicalqns'] = $result;
			}
		}
		echo json_encode($arry);
	}
	public function getSuminsureds()
	{
		$arry = array();
		$data =$this->input->post();
		// sumInsured,animalType,breed,gender,age
		// $arry['message'] = "Something went wrong.";	
		$arry['list'] = array();
		$result = $this->cattle->getSuminsureds();	
		if($result)
		{
			$arry['status'] = "success";
			$arry['message'] = "Suminsured Retrieved successfully.";	
			$arry['list'] = $result;
		}
		echo json_encode($arry);
	}
	public function getAnmlAddlqns()
	{
		$arry = array();
		$data =$this->input->post();
		// sumInsured,animalType,breed,gender,age
		$arry['message'] = "Base Procuct Id is mandatory.";
		$arry['medicalqns'] = [];
		if(!empty($data['baseproductId']))
		{	
			$arry['message'] = "Invalid Product Id.";	
			$result = $this->cattle->getAnimalqns($data['baseproductId']);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Medicalqns Retrieved successfully.";	
				$arry['medicalqns'] = $result;
			}
		}
		echo json_encode($arry);
	}
	public function updatemedicalqns()
	{
		$arry = array();
		$arry['status'] = "error";
		$data = $this->input->post();
		$arry['message'] = "Proposal Id is mandatory.";
		// $data['proposalId'] = base64_decode($data['proposalId']);
		if(!empty($data['proposalId']))
		{	
			$qnss = json_decode($data['qns']);
			foreach($qnss as $qns)
			{
				$input = array();
				$input['proposalId'] = $data['proposalId'];
				foreach($qns as $key=>$val)
				{
					$input[$key] = $val;
				}
				$result = $this->cattle->insertCattleMedicalQns($input);
				if($result)
				{
					$arry['status'] = "success";
					$arry['message'] = "Data Updated successfully.";
				}
			}
		}
		echo json_encode($arry);
	}
	public function updatevdmedicalqns()
	{
		$arry = array();
		$arry['status'] = "error";
		$data = $this->input->post();
		$arry['message'] = "Proposal Id is mandatory.";
		// $data['proposalId'] = base64_decode($data['proposalId']);
		if(!empty($data['proposalId']))
		{	
			$qnss = json_decode($data['qns']);
			foreach($qnss as $qns)
			{
				$input = array();
				$input['proposalId'] = $data['proposalId'];
				foreach($qns as $key=>$val)
				{
					$input[$key] = $val;
				}
				$result = $this->cattle->insertCattleVdMedicalQns($input);
				if($result)
				{
					$arry['status'] = "success";
					$arry['message'] = "Data Updated successfully.";
				}
			}
		}
		echo json_encode($arry);
	}
	public function getPolicyPdf()
	{
		$arry = array();
		$arry['status'] = "error";
		$data = $this->input->post();
		$arry['message'] = "Cattle Id is mandatory.";
		$arry['pdfPath'] = "";
		// $data['proposalId'] = base64_decode($data['proposalId']);
		if(!empty($data['cId']))
		{	
			$pdfPath = $this->getPolicyPdfPath($data['cId']);
			$data['pdfPath'] = $pdfPath;
			$result = $this->cattle->updateCattleById($data);
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Pdf retrieved successfully.";
				$arry['pdfPath'] = $pdfPath;
			}
		}
		echo json_encode($arry);
	}
	// public function getPolicyPdf1()
	// {
	// 	$arry = array();
	// 	$arry['status'] = "error";
	// 	$data = $this->input->get();
	// 	$arry['message'] = "Cattle Id is mandatory.";
	// 	$arry['pdfPath'] = "";
	// 	if(!empty($data['cId']))
	// 	{	
	// 		$pdfPath = $this->getPolicyPdfPath1($data['cId']);
	// 		$data['pdfPath'] = $pdfPath;
	// 		$result = $this->cattle->updateCattleById($data);
	// 		if($result)
	// 		{
	// 			$arry['status'] = "success";
	// 			$arry['message'] = "Pdf retrieved successfully.";
	// 			$arry['pdfPath'] = $pdfPath;
	// 		}
	// 	}
	// 	echo json_encode($arry);
	// }
	public function getPolicyPdfPath($proposalId)
	{
		
		$data = array();
		$data['cattle'] = $this->cattle->getCattleById($proposalId);
		$reports1 = $this->load->view('pdf-generation',$data,true);
		$mpdf = new \Mpdf\Mpdf(array('setAutoTopMargin' => 'pad','pad' => "20"));
		$mpdf->AddPage("P",'','','','',18,18,15,15,15,15);
		$mpdf->WriteHTML($reports1,\Mpdf\HTMLParserMode::HTML_BODY);
		$lPath = "uploads/pdfPaths/";
		if(!file_exists($lPath)) mkdir($lPath, 0777);
		$lPath = "uploads/pdfPaths/".$proposalId;
		if(!file_exists($lPath)) mkdir($lPath, 0777);
		$lPath .= "/pdf_".time()."_".$proposalId."_".time().".pdf";
		$targetPath = './'.$lPath;
		$mpdf->Output($targetPath, 'F');
		return base_url().$lPath;
	}
	
	// public function getPolicyPdfPath1($proposalId)
	// {
		// $sourcePath = 'uploads/sample-cattle.pdf';
		// // $sourcePath = $files[$fname]['tmp_name'];
		// $lPath = "";
		// // $path_parts = pathinfo($sourcePat);
		// $lPath = "uploads/pdfPaths";
		// if(!file_exists($lPath)) mkdir($lPath, 0777);
		// $lPath = "uploads/pdfPaths/".$proposalId;
		// if(!file_exists($lPath)) mkdir($lPath, 0777);
		// $lPath .= "/".time().".pdf";
		// $targetPath = './'.$lPath;
		// if(copy($sourcePath,$targetPath))
		// {
		// 	// pass;
		// }
		// return base_url().$lPath; 
	// }
}
