<?php 
Class designations extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getdesignationsById($req) 
	{
		$key = $this->config->config['cKey']."_designations_detail".$req['designations_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from designations where designations_Id=".$req['designations_Id']);
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
	public function deletedesignationsById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from designations where designations_Id = ".$req['designations_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_designations");
			$this->mc->memcached->delete($this->config->config['cKey']."_designations_detail".$req['designations_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updatedesignationsById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["Designation"])) $set .= "Designation=".$this->db->escape($req["Designation"]).",";
		if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update designations set ".$setValue." where designations_Id = ".$req['designations_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_designations");
				$this->mc->memcached->delete($this->config->config['cKey']."_designations_detail".$req['designations_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertdesignationsById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO designations(Designation,createdBy) VALUES (".$this->db->escape($req["Designation"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_designations");
			$status = true;
		}
		return $status;
	}
	public function getdesignationss() 
	{
		$key = $this->config->config['cKey']."_designations";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from designations");
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