<?php 
Class animalquestions extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getanimalquestionsById($req) 
	{
		$key = $this->config->config['cKey']."_animalquestions_detail".$req['animalquestions_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from animalquestions where animalquestions_Id=".$req['animalquestions_Id']);
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
	public function deleteanimalquestionsById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from animalquestions where animalquestions_Id = ".$req['animalquestions_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_animalquestions");
			$this->mc->memcached->delete($this->config->config['cKey']."_animalquestions_detail".$req['animalquestions_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updateanimalquestionsById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["productId"])) $set .= "productId=".$this->db->escape($req["productId"]).",";
		if(!empty($req["qnSetCode"])) $set .= "qnSetCode=".$this->db->escape($req["qnSetCode"]).",";
		if(!empty($req["qnCode"])) $set .= "qnCode=".$this->db->escape($req["qnCode"]).",";
		if(!empty($req["qnDescription"])) $set .= "qnDescription=".$this->db->escape($req["qnDescription"]).",";
		if(!empty($req["qnType"])) $set .= "qnType=".$this->db->escape($req["qnType"]).",";
		if(!empty($req["defaultValue"])) $set .= "defaultValue=".$this->db->escape($req["defaultValue"]).",";
		if(!empty($req["isKnockoutQn"])) $set .= "isKnockoutQn=".$this->db->escape($req["isKnockoutQn"]).",";
		if(!empty($req["acceptedResponses"])) $set .= "acceptedResponses=".$this->db->escape($req["acceptedResponses"]).",";
		if(!empty($req["knockoutResponses"])) $set .= "knockoutResponses=".$this->db->escape($req["knockoutResponses"]).",";
		if(!empty($req["dummyOne"])) $set .= "dummyOne=".$this->db->escape($req["dummyOne"]).",";
		if(!empty($req["dummyTwo"])) $set .= "dummyTwo=".$this->db->escape($req["dummyTwo"]).",";
		if(!empty($req["dummyThree"])) $set .= "dummyThree=".$this->db->escape($req["dummyThree"]).",";
		if(!empty($req["dummyFour"])) $set .= "dummyFour=".$this->db->escape($req["dummyFour"]).",";
		if(!empty($req["dummyFive"])) $set .= "dummyFive=".$this->db->escape($req["dummyFive"]).",";
		if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update animalquestions set ".$setValue." where animalquestions_Id = ".$req['animalquestions_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_animalquestions");
				$this->mc->memcached->delete($this->config->config['cKey']."_animalquestions_detail".$req['animalquestions_Id']);
				if(!empty($req["productId"])) $this->mc->memcached->delete($this->config->config['cKey']."_cattle_aadqn_bpd".$req["productId"]);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertanimalquestionsById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO animalquestions(productId,qnSetCode,qnCode,qnDescription,qnType,defaultValue,isKnockoutQn,acceptedResponses,knockoutResponses,dummyOne,dummyTwo,dummyThree,dummyFour,dummyFive,createdBy) VALUES (".$this->db->escape($req["productId"]).",".$this->db->escape($req["qnSetCode"]).",".$this->db->escape($req["qnCode"]).",".$this->db->escape($req["qnDescription"]).",".$this->db->escape($req["qnType"]).",".$this->db->escape($req["defaultValue"]).",".$this->db->escape($req["isKnockoutQn"]).",".$this->db->escape($req["acceptedResponses"]).",".$this->db->escape($req["knockoutResponses"]).",".$this->db->escape($req["dummyOne"]).",".$this->db->escape($req["dummyTwo"]).",".$this->db->escape($req["dummyThree"]).",".$this->db->escape($req["dummyFour"]).",".$this->db->escape($req["dummyFive"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_animalquestions");
			$this->mc->memcached->delete($this->config->config['cKey']."_cattle_aadqn_bpd".$req["productId"]);
			$status = true;
		}
		return $status;
	}
	public function getanimalquestionss() 
	{
		$key = $this->config->config['cKey']."_animalquestions";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from animalquestions");
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