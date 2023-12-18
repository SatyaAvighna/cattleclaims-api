<?php 
Class employeetype extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getemployeetypeById($req) 
	{
		$key = $this->config->config['cKey']."_employeetype_detail".$req['employeetype_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from employeetype where employeetype_Id=".$req['employeetype_Id']);
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
	public function deleteemployeetypeById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from employeetype where employeetype_Id = ".$req['employeetype_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_employeetype");
			$this->mc->memcached->delete($this->config->config['cKey']."_employeetype_detail".$req['employeetype_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updateemployeetypeById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["EmployeeType"])) $set .= "EmployeeType=".$this->db->escape($req["EmployeeType"]).",";
		if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update employeetype set ".$setValue." where employeetype_Id = ".$req['employeetype_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_employeetype");
				$this->mc->memcached->delete($this->config->config['cKey']."_employeetype_detail".$req['employeetype_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertemployeetypeById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO employeetype(EmployeeType,createdBy) VALUES (".$this->db->escape($req["EmployeeType"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_employeetype");
			$status = true;
		}
		return $status;
	}
	public function getemployeetypes() 
	{
		$key = $this->config->config['cKey']."_employeetype";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from employeetype");
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