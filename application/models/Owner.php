<?php 
Class Owner extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getOwnerById($oId) 
	{	
		$key = $this->config->config['cKey']."_owner_detail".$oId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select oId,oName,oMobile,oAadhar,oAddress,oPincode,oDistrict,oState from owners where oId=".$oId);
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function deleteOwnerById($req) 
	{
		$status = false;
		$query =  $this->db->query("update owners set oStatus=1 where oId = ".$req['oId']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_owners");
			$this->mc->memcached->delete($this->config->config['cKey']."_owner_detail".$req['oId']);
			$status = true;
		}
		return $status;
	}
	
	public function updateOwnerById($req) 
	{
		$status = false;
		$set = "";
        
		if(!empty($req['oName'])) $set .= "oName=".$this->db->escape($req['oName']).",";
		if(!empty($req['oMobile'])) $set .= "oMobile=".$this->db->escape($req['oMobile']).",";
		if(!empty($req['oAadhar'])) $set .= "oAadhar=".$this->db->escape($req['oAadhar']).",";
		if(!empty($req['oAddress'])) $set .= "oAddress=".$this->db->escape($req['oAddress']).",";
		if(!empty($req['oPincode'])) $set .= "oPincode=".$this->db->escape($req['oPincode']).",";
		if(!empty($req['oDistrict'])) $set .= "oDistrict=".$this->db->escape($req['oDistrict']).",";
		if(!empty($req['oState'])) $set .= "oState=".$this->db->escape($req['oState']).",";
		if(!empty($req['updatedBy'])) $set .= "updatedBy=".$this->db->escape($req['sId']).",";
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			//echo "update owners set ".$setValue." where oId= ".$req['oId'];
			$query =  $this->db->query("update owners set ".$setValue." where oId= ".$req['oId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_owners");
				$this->mc->memcached->delete($this->config->config['cKey']."_owner_detail".$req['oId']);
				$status = true;
			}
		}
		return $status;
	}
	public function insertOwnerById($req) 
	{
		$status = false;
		$favexits = $this->db->query("select oId from owners where oName=".$this->db->escape($req['oName']));
		if($favexits->num_rows() <= 0)
		{
			$query =  $this->db->query("INSERT INTO owners(oName,oMobile,oAadhar,oAddress,oPincode,oDistrict,oState,createdBy) VALUES (".$this->db->escape($req['oName']).",".$this->db->escape($req['oMobile']).",".$this->db->escape($req['oAadhar']).",".$this->db->escape($req['oAddress']).",".$this->db->escape($req['oPincode']).",".$this->db->escape($req['oDistrict']).",".$this->db->escape($req['oState']).",".$req['sId'].")");
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_owners");
				$status = true;
			}
		}
		return $status;
	}
	
	function updateOwneoStatusById($req) 
	{
		$status = false;
		$set = "";
		//cName cPerson cemailId cDesignation cMobile cAddress cPath
		if(!empty($req['oStatus'])) $set .= "oStatus=".$req['oStatus'].",";
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update owners set ".$setValue." where oId = ".$req['oId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_owners");
				$this->mc->memcached->delete($this->config->config['cKey']."_owner_detail".$req['oId']);
				$status = true;
			}
		}
		return $status;
	}
} 
?> 