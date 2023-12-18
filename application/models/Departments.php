<?php 
Class departments extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getdepartmentsById($req) 
	{
		$key = $this->config->config['cKey']."_departments_detail".$req['departments_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from departments where departments_Id=".$req['departments_Id']);
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
	public function deletedepartmentsById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from departments where departments_Id = ".$req['departments_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_departments");
			$this->mc->memcached->delete($this->config->config['cKey']."_departments_detail".$req['departments_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updatedepartmentsById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["Department"])) $set .= "Department=".$this->db->escape($req["Department"]).",";
		if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update departments set ".$setValue." where departments_Id = ".$req['departments_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_departments");
				$this->mc->memcached->delete($this->config->config['cKey']."_departments_detail".$req['departments_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertdepartmentsById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO departments(Department,createdBy) VALUES (".$this->db->escape($req["Department"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_departments");
			$status = true;
		}
		return $status;
	}
	public function getdepartmentss() 
	{
		$key = $this->config->config['cKey']."_departments";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from departments");
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