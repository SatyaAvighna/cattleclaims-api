<?php 
Class Gateway extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getPgorders() 
	{	
		$key = $this->config->config['cKey']."_pgorders";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			// pgpgoId,orderId,corderId,coAmount,coreturnUrl,coCurrency,createdOn,pgStatus
			$query =  $this->db->query("select pgoId,orderId,corderId,coAmount,coreturnUrl,coCurrency,pgStatus from pgorders");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getpgorderById($pgoId) 
	{	
		$key = $this->config->config['cKey']."_pgorders_detail".$pgoId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			// pgpgoId,orderId,corderId,coAmount,coreturnUrl,coCurrency,createdOn,pgStatus
			$query =  $this->db->query("select pgoId,orderId,corderId,coAmount,coreturnUrl,coCurrency,pgStatus from pgorders where pgoId=".$pgoId);
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
	public function getpgorderByorderId($orderId) 
	{	
		$key = $this->config->config['cKey']."_pgordersbyorderId_detail".$orderId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			// pgpgoId,orderId,corderId,coAmount,coreturnUrl,coCurrency,createdOn,pgStatus
			$query =  $this->db->query("select pgoId,orderId,corderId,coAmount,coreturnUrl,coCurrency,pgStatus from pgorders where orderId=".$orderId);
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
	public function deletepgorderById($req) 
	{
		$status = false;
		$query =  $this->db->query("update pgorders set pgStatus=1 where pgoId = ".$req['pgoId']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_pgorders");
			$this->mc->memcached->delete($this->config->config['cKey']."_pgorder_detail".$req['pgoId']);
			$status = true;
		}
		return $status;
	}
	
	public function updatepgorderById($req) 
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
			//echo "update pgorders set ".$setValue." where pgoId= ".$req['pgoId'];
			$query =  $this->db->query("update pgorders set ".$setValue." where pgoId= ".$req['pgoId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_pgorders");
				$this->mc->memcached->delete($this->config->config['cKey']."_pgorder_detail".$req['pgoId']);
				$status = true;
			}
		}
		return $status;
	}
	public function updatepgorderByorderId($req) 
	{
		$status = false;
		$set = "";
        // corderId,coAmount,coreturnUrl,coCurrency
		if(!empty($req['corderId'])) $set .= "corderId=".$this->db->escape($req['corderId']).",";
		if(!empty($req['coAmount'])) $set .= "coAmount=".$this->db->escape($req['coAmount']).",";
		if(!empty($req['coreturnUrl'])) $set .= "coreturnUrl=".$this->db->escape($req['coreturnUrl']).",";
		if(!empty($req['coCurrency'])) $set .= "coCurrency=".$this->db->escape($req['coCurrency']).",";
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			//echo "update pgorders set ".$setValue." where pgoId= ".$req['pgoId'];
			$query =  $this->db->query("update pgorders set ".$setValue." where orderId= ".$req['orderId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_pgorders");
				$this->mc->memcached->delete($this->config->config['cKey']."_pgorder_detail".$req['pgoId']);				
				$this->mc->memcached->delete($this->config->config['cKey']."_pgordersbyorderId_detail".$req['orderId']);
				$status = true;
			}
		}
		return $status;
	}
	public function insertpgorderById($req) 
	{
		$pgpgoId = 0;
		// print_r($req);
		$favexits = $this->db->query("select pgoId from pgorders where corderId=".$this->db->escape($req['corderId']));
		if($favexits->num_rows() <= 0)
		{
			$query =  $this->db->query("INSERT INTO pgorders(orderId,corderId,coAmount,coreturnUrl,coCurrency) VALUES (".$this->db->escape($req['orderId']).",".$this->db->escape($req['corderId']).",".$this->db->escape($req['coAmount']).",".$this->db->escape($req['coreturnUrl']).",".$this->db->escape($req['coCurrency']).")");
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_pgorders");
				$pgpgoId = $req['orderId'];
			}
		}
		return $pgpgoId;
	}
	
	function updatepgStatusById($req) 
	{
		$status = false;
		$set = "";
		//cName cPerson cemailId cDesignation cMobile cAddress cPath
		if(!empty($req['pgStatus'])) $set .= "pgStatus=".$req['pgStatus'].",";
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update pgorders set ".$setValue." where pgoId = ".$req['pgoId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_pgorders");
				$this->mc->memcached->delete($this->config->config['cKey']."_pgorder_detail".$req['pgoId']);
				$status = true;
			}
		}
		return $status;
	}
	function updatepgStatusByorderId($req) 
	{
		$status = false;
		$set = "";
		//cName cPerson cemailId cDesignation cMobile cAddress cPath
		if(!empty($req['pgStatus'])) $set .= "pgStatus=".$req['pgStatus'].",";
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update pgorders set ".$setValue." where orderId = ".$req['orderId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_pgorders");
				$this->mc->memcached->delete($this->config->config['cKey']."_pgorder_detail".$req['pgoId']);
				$this->mc->memcached->delete($this->config->config['cKey']."_pgordersbyorderId_detail".$req['orderId']);
				$status = true;
			}
		}
		return $status;
	}
} 
?> 