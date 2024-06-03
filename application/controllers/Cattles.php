<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
									$arry['message'] = "Something went wrong.";
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
									$arry['message'] = "Something went wrong.";
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
	
	public function updatePaths()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Cattle Id is mandatory.";
		// $arry['earTag'] = "";
		// $arry['lSidePath'] = "";
		// $arry['rSidePath'] = "";
		// $arry['vPath'] = "";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		// $data['sId'] =  $this->encryption->decrypt($data['uId']);
		// print_r($data);
		// print_r($_FILES);
		if(!empty($data['cId']))
		{
            // cattle,tagnumber,breed,gender,age,sumInsured,earTag,lSidePath,rSidePath,vPath
            $data['earTag'] = "";
            $data['lSidePath'] = "";
            $data['rSidePath'] = "";
            $data['vPath'] = "";
            if(!empty($_FILES)) 
            {
                if(isset($_FILES['earTag'])) $data['earTag'] = $this->uploadfiles($_FILES,"earTag",$data['cId']);
                if(isset($_FILES['lSidePath'])) $data['lSidePath'] = $this->uploadfiles($_FILES,"lSidePath",$data['cId']);
                if(isset($_FILES['rSidePath'])) $data['rSidePath'] = $this->uploadfiles($_FILES,"rSidePath",$data['cId']);
                if(isset($_FILES['vPath'])) $data['vPath'] = $this->uploadfiles($_FILES,"vPath",$data['cId']);
            }
            $arry['message'] = "Something went wrong.";
            $result = $this->cattle->updateCattleById($data);	
            if($result)
            {
                $arry['status'] = "success";
                $arry['message'] = "Cattle updated successfully.";	
				if(isset($_FILES['earTag'])) $arry['earTag'] = $data['earTag'];
				if(isset($_FILES['lSidePath'])) $arry['lSidePath'] = $data['lSidePath'];
				if(isset($_FILES['rSidePath'])) $arry['rSidePath'] = $data['rSidePath'];
				if(isset($_FILES['vPath'])) $arry['vPath'] = $data['vPath'];
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
			$arry['message'] = "Something went wrong.";	
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
            $lPath .= "/".$files[$fname]['name'];
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
			$arry['message'] = "Something went wrong.";	
			$data = $this->cattle->getCattleDetailsBypId($inputs['proposalId']);
			// print_r($data);
			$result = $this->cattle->getQuotes($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Quotes Retirved successfully.";	
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
			$arry['message'] = "Something went wrong.";	
			$result = $this->cattle->getMedicalqns($data['baseproductId']);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Medicalqns Retirved successfully.";	
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
		$arry['message'] = "Base Procuct Id is mandatory.";
		$arry['list'] = [];
		$result = $this->cattle->getSuminsureds();	
		if($result)
		{
			$arry['status'] = "success";
			$arry['message'] = "Suminsured Retirved successfully.";	
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
			$arry['message'] = "Something went wrong.";	
			$result = $this->cattle->getMedicalqns($data['baseproductId']);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Medicalqns Retirved successfully.";	
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
}
