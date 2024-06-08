<?php 
Class suminsured extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getsuminsuredById($req) 
	{
		$key = $this->config->config['cKey']."_suminsured_detail".$req['siId'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from suminsureds where siId=".$req['siId']);
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
	public function deletesuminsuredById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from suminsureds where siId = ".$req['siId']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_suminsureds");
			$this->mc->memcached->delete($this->config->config['cKey']."_suminsured_detail".$req['siId']);
			$status = true;
		}
		return $status;
	}
	
	public function updatesuminsuredById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["siName"])) $set .= "siName=".$this->db->escape($req["siName"]).",";
		// if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update suminsureds set ".$setValue." where siId = ".$req['siId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_suminsureds");
				$this->mc->memcached->delete($this->config->config['cKey']."_suminsured_detail".$req['siId']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertsuminsuredById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO suminsureds(siName) VALUES (".$this->db->escape($req["siName"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_suminsureds");
			$status = true;
		}
		return $status;
	}
	public function getsuminsureds() 
	{
		$key = $this->config->config['cKey']."_suminsureds";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from suminsureds");
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