<?php 
Class proposaldetails extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getproposaldetailsById($req) 
	{
		$key = $this->config->config['cKey']."_proposaldetails_detail".$req['proposaldetails_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from proposaldetails where proposaldetails_Id=".$req['proposaldetails_Id']);
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
	public function deleteproposaldetailsById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from proposaldetails where proposaldetails_Id = ".$req['proposaldetails_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_proposaldetails");
			$this->mc->memcached->delete($this->config->config['cKey']."_proposaldetails_detail".$req['proposaldetails_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updateproposaldetailsById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["insurerLogo"])) $set .= "insurerLogo=".$this->db->escape($req["insurerLogo"]).",";if(!empty($req["insurerName"])) $set .= "insurerName=".$this->db->escape($req["insurerName"]).",";if(!empty($req["premium"])) $set .= "premium=".$this->db->escape($req["premium"]).",";if(!empty($req["sumInsured"])) $set .= "sumInsured=".$this->db->escape($req["sumInsured"]).",";if(!empty($req["proposalId"])) $set .= "proposalId=".$this->db->escape($req["proposalId"]).",";if(!empty($req["policyNo"])) $set .= "policyNo=".$this->db->escape($req["policyNo"]).",";if(!empty($req["dummyOne"])) $set .= "dummyOne=".$this->db->escape($req["dummyOne"]).",";if(!empty($req["dummyTwo"])) $set .= "dummyTwo=".$this->db->escape($req["dummyTwo"]).",";if(!empty($req["dummyThree"])) $set .= "dummyThree=".$this->db->escape($req["dummyThree"]).",";if(!empty($req["dummyFour"])) $set .= "dummyFour=".$this->db->escape($req["dummyFour"]).",";if(!empty($req["dummyFive"])) $set .= "dummyFive=".$this->db->escape($req["dummyFive"]).",";if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update proposaldetails set ".$setValue." where proposaldetails_Id = ".$req['proposaldetails_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_proposaldetails");
				$this->mc->memcached->delete($this->config->config['cKey']."_proposaldetails_detail".$req['proposaldetails_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertproposaldetailsById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO proposaldetails(insurerLogo,insurerName,premium,sumInsured,proposalId,policyNo,dummyOne,dummyTwo,dummyThree,dummyFour,dummyFive,createdBy) VALUES (".$this->db->escape($req["insurerLogo"]).",".$this->db->escape($req["insurerName"]).",".$this->db->escape($req["premium"]).",".$this->db->escape($req["sumInsured"]).",".$this->db->escape($req["proposalId"]).",".$this->db->escape($req["policyNo"]).",".$this->db->escape($req["dummyOne"]).",".$this->db->escape($req["dummyTwo"]).",".$this->db->escape($req["dummyThree"]).",".$this->db->escape($req["dummyFour"]).",".$this->db->escape($req["dummyFive"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_proposaldetails");
			$status = true;
		}
		return $status;
	}
	public function getproposaldetailss() 
	{
		$key = $this->config->config['cKey']."_proposaldetails";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from proposaldetails");
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