<?php 
Class vdcertificate extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getvdcertificateById($req) 
	{
		$key = $this->config->config['cKey']."_vdcertificate_detail".$req['vdcertificate_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from vdcertificate where vdcertificate_Id=".$req['vdcertificate_Id']);
			foreach($query->result() as $row)
			{
				foreach($row as $clumn_name=>$clumn_value)
				{
					$arry[$clumn_name] = $clumn_value;
				}
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function deletevdcertificateById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from vdcertificate where vdcertificate_Id = ".$req['vdcertificate_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_vdcertificate");
			$this->mc->memcached->delete($this->config->config['cKey']."_vdcertificate_detail".$req['vdcertificate_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updatevdcertificateById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["iD"])) $set .= "iD=".$this->db->escape($req["iD"]).",";if(!empty($req["earTagNo"])) $set .= "earTagNo=".$this->db->escape($req["earTagNo"]).",";if(!empty($req["animalType"])) $set .= "animalType=".$this->db->escape($req["animalType"]).",";if(!empty($req["breed"])) $set .= "breed=".$this->db->escape($req["breed"]).",";if(!empty($req["gender"])) $set .= "gender=".$this->db->escape($req["gender"]).",";if(!empty($req["age"])) $set .= "age=".$this->db->escape($req["age"]).",";if(!empty($req["contagiousDiseaseHistory"])) $set .= "contagiousDiseaseHistory=".$this->db->escape($req["contagiousDiseaseHistory"]).",";if(!empty($req["dateOfLastVaccination"])) $set .= "dateOfLastVaccination=".$this->db->escape($req["dateOfLastVaccination"]).",";if(!empty($req["riskLevel"])) $set .= "riskLevel=".$this->db->escape($req["riskLevel"]).",";if(!empty($req["healthLevel"])) $set .= "healthLevel=".$this->db->escape($req["healthLevel"]).",";if(!empty($req["fitForFurtherConception"])) $set .= "fitForFurtherConception=".$this->db->escape($req["fitForFurtherConception"]).",";if(!empty($req["dateOflastCalving"])) $set .= "dateOflastCalving=".$this->db->escape($req["dateOflastCalving"]).",";if(!empty($req["presentMarketValue"])) $set .= "presentMarketValue=".$this->db->escape($req["presentMarketValue"]).",";if(!empty($req["dummyOne"])) $set .= "dummyOne=".$this->db->escape($req["dummyOne"]).",";if(!empty($req["dummyTwo"])) $set .= "dummyTwo=".$this->db->escape($req["dummyTwo"]).",";if(!empty($req["dummyThree"])) $set .= "dummyThree=".$this->db->escape($req["dummyThree"]).",";if(!empty($req["dummyFour"])) $set .= "dummyFour=".$this->db->escape($req["dummyFour"]).",";if(!empty($req["dummyFive"])) $set .= "dummyFive=".$this->db->escape($req["dummyFive"]).",";if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update vdcertificate set ".$setValue." where vdcertificate_Id = ".$req['vdcertificate_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_vdcertificate");
				$this->mc->memcached->delete($this->config->config['cKey']."_vdcertificate_detail".$req['vdcertificate_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertvdcertificateById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO vdcertificate(iD,earTagNo,animalType,breed,gender,age,contagiousDiseaseHistory,dateOfLastVaccination,riskLevel,healthLevel,fitForFurtherConception,dateOflastCalving,presentMarketValue,dummyOne,dummyTwo,dummyThree,dummyFour,dummyFive,createdBy) VALUES (".$this->db->escape($req["iD"]).",".$this->db->escape($req["earTagNo"]).",".$this->db->escape($req["animalType"]).",".$this->db->escape($req["breed"]).",".$this->db->escape($req["gender"]).",".$this->db->escape($req["age"]).",".$this->db->escape($req["contagiousDiseaseHistory"]).",".$this->db->escape($req["dateOfLastVaccination"]).",".$this->db->escape($req["riskLevel"]).",".$this->db->escape($req["healthLevel"]).",".$this->db->escape($req["fitForFurtherConception"]).",".$this->db->escape($req["dateOflastCalving"]).",".$this->db->escape($req["presentMarketValue"]).",".$this->db->escape($req["dummyOne"]).",".$this->db->escape($req["dummyTwo"]).",".$this->db->escape($req["dummyThree"]).",".$this->db->escape($req["dummyFour"]).",".$this->db->escape($req["dummyFive"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_vdcertificate");
			$status = true;
		}
		return $status;
	}
	public function getvdcertificates() 
	{
		$key = $this->config->config['cKey']."_vdcertificate";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from vdcertificate");
			foreach($query->result() as $row)
			{
				$list= array();
				foreach($row as $clumn_name=>$clumn_value)
				{
					$list[$clumn_name] = $clumn_value;
				}
				$arry[] = $list;
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
} 
?> 