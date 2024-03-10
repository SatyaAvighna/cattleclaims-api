<?php 
Class sampleclaim extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getsampleclaimById($req) 
	{
		$key = $this->config->config['cKey']."_sampleclaim_detail".$req['sampleclaim_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from sampleclaim where sampleclaim_Id=".$req['sampleclaim_Id']);
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
	public function deletesampleclaimById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from sampleclaim where sampleclaim_Id = ".$req['sampleclaim_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_sampleclaim");
			$this->mc->memcached->delete($this->config->config['cKey']."_sampleclaim_detail".$req['sampleclaim_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updatesampleclaimById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["claim"])) $set .= "claim=".$this->db->escape($req["claim"]).",";if(!empty($req["cattledate"])) $set .= "cattledate=".$this->db->escape($req["cattledate"]).",";if(!empty($req["enterdata"])) $set .= "enterdata=".$this->db->escape($req["enterdata"]).",";if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update sampleclaim set ".$setValue." where sampleclaim_Id = ".$req['sampleclaim_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_sampleclaim");
				$this->mc->memcached->delete($this->config->config['cKey']."_sampleclaim_detail".$req['sampleclaim_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertsampleclaimById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO sampleclaim(claim,cattledate,enterdata,createdBy) VALUES (".$this->db->escape($req["claim"]).",".$this->db->escape($req["cattledate"]).",".$this->db->escape($req["enterdata"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_sampleclaim");
			$status = true;
		}
		return $status;
	}
	public function getsampleclaims() 
	{
		$key = $this->config->config['cKey']."_sampleclaim";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from sampleclaim");
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