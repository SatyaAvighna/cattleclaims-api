<?php 
Class animaltype extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getanimaltypeById($req) 
	{
		$key = $this->config->config['cKey']."_animaltype_detail".$req['animaltype_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from animaltype where animaltype_Id=".$req['animaltype_Id']);
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
	public function deleteanimaltypeById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from animaltype where animaltype_Id = ".$req['animaltype_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_animaltype");
			$this->mc->memcached->delete($this->config->config['cKey']."_animaltypes");
			$this->mc->memcached->delete($this->config->config['cKey']."_animaltype_detail".$req['animaltype_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updateanimaltypeById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["animalType"])) $set .= "animalType=".$this->db->escape($req["animalType"]).",";
		if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update animaltype set ".$setValue." where animaltype_Id = ".$req['animaltype_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_animaltype");
				$this->mc->memcached->delete($this->config->config['cKey']."_animaltypes");
				$this->mc->memcached->delete($this->config->config['cKey']."_animaltype_detail".$req['animaltype_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertanimaltypeById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO animaltype(animalType,createdBy) VALUES (".$this->db->escape($req["animalType"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_animaltype");
			$this->mc->memcached->delete($this->config->config['cKey']."_animaltypes");
			$status = true;
		}
		return $status;
	}
	public function getanimaltypes() 
	{
		$key = $this->config->config['cKey']."_animaltype";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from animaltype");
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
	public function getanimalRtypes() 
	{
		$key = $this->config->config['cKey']."_animaltypes";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select animaltype_Id,animalType,status from animaltype");
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