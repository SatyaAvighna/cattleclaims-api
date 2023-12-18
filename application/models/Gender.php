<?php 
Class Gender extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getGenderById($req) 
	{
		$key = $this->config->config['cKey']."_gender_detail".$req['gender_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from gender where gender_Id=".$req['gender_Id']);
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
	public function deleteGenderById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from gender where gender_Id = ".$req['gender_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_gender");
			$this->mc->memcached->delete($this->config->config['cKey']."_gender_detail".$req['gender_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updateGenderById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["gender"])) $set .= "gender=".$this->db->escape($req["gender"]).",";
		if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update gender set ".$setValue." where gender_Id = ".$req['gender_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_gender");
				$this->mc->memcached->delete($this->config->config['cKey']."_gender_detail".$req['gender_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertGenderById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO gender(gender,createdBy) VALUES (".$this->db->escape($req["gender"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_gender");
			$status = true;
		}
		return $status;
	}
	public function getGenders() 
	{
		$key = $this->config->config['cKey']."_gender";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from gender");
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