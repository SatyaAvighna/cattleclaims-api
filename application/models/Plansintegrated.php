<?php 
Class plansintegrated extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getplansintegratedById($req) 
	{
		$key = $this->config->config['cKey']."_plansintegrated_detail".$req['plansintegrated_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from plansintegrated where plansintegrated_Id=".$req['plansintegrated_Id']);
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
	public function deleteplansintegratedById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from plansintegrated where plansintegrated_Id = ".$req['plansintegrated_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_plansintegrated");
			$this->mc->memcached->delete($this->config->config['cKey']."_plansintegrated_detail".$req['plansintegrated_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updateplansintegratedById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["insurerName"])) $set .= "insurerName=".$this->db->escape($req["insurerName"]).",";
		if(!empty($req["insurerLogo"])) $set .= "insurerLogo=".$this->db->escape($req["insurerLogo"]).",";
		if(!empty($req["sumInsured"])) $set .= "sumInsured=".$this->db->escape($req["sumInsured"]).",";
		if(!empty($req["animalType"])) $set .= "animalType=".$this->db->escape($req["animalType"]).",";
		if(!empty($req["breed"])) $set .= "breed=".$this->db->escape($req["breed"]).",";
		if(!empty($req["gender"])) $set .= "gender=".$this->db->escape($req["gender"]).",";
		if(!empty($req["age"])) $set .= "age=".$this->db->escape($req["age"]).",";
		if(!empty($req["premium"])) $set .= "premium=".$this->db->escape($req["premium"]).",";
		if(!empty($req["risk"])) $set .= "risk=".$this->db->escape($req["risk"]).",";
		if(!empty($req["dummyOne"])) $set .= "dummyOne=".$this->db->escape($req["dummyOne"]).",";
		if(!empty($req["dummyTwo"])) $set .= "dummyTwo=".$this->db->escape($req["dummyTwo"]).",";
		if(!empty($req["dummyThree"])) $set .= "dummyThree=".$this->db->escape($req["dummyThree"]).",";
		if(!empty($req["dummyFour"])) $set .= "dummyFour=".$this->db->escape($req["dummyFour"]).",";
		if(!empty($req["dummyFive"])) $set .= "dummyFive=".$this->db->escape($req["dummyFive"]).",";
		if(!empty($req["baseproductId"])) $set .= "baseproductId=".$this->db->escape($req["baseproductId"]).",";
		if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update plansintegrated set ".$setValue." where plansintegrated_Id = ".$req['plansintegrated_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_plansintegrated");
				$this->mc->memcached->delete($this->config->config['cKey']."_plansintegrated_detail".$req['plansintegrated_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertplansintegratedById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO plansintegrated(insurerName,insurerLogo,sumInsured,animalType,breed,gender,age,premium,risk,dummyOne,dummyTwo,dummyThree,dummyFour,dummyFive,baseproductId,createdBy) VALUES (".$this->db->escape($req["insurerName"]).",".$this->db->escape($req["insurerLogo"]).",".$this->db->escape($req["sumInsured"]).",".$this->db->escape($req["animalType"]).",".$this->db->escape($req["breed"]).",".$this->db->escape($req["gender"]).",".$this->db->escape($req["age"]).",".$this->db->escape($req["premium"]).",".$this->db->escape($req["risk"]).",".$this->db->escape($req["dummyOne"]).",".$this->db->escape($req["dummyTwo"]).",".$this->db->escape($req["dummyThree"]).",".$this->db->escape($req["dummyFour"]).",".$this->db->escape($req["dummyFive"]).",".$this->db->escape($req["baseproductId"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_plansintegrated");
			$status = true;
		}
		return $status;
	}
	public function getplansintegrateds() 
	{
		$key = $this->config->config['cKey']."_plansintegrated";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from plansintegrated");
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