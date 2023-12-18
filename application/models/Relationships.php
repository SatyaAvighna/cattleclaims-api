<?php 
Class relationships extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getrelationshipsById($req) 
	{
		$key = $this->config->config['cKey']."_relationships_detail".$req['relationships_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from relationships where relationships_Id=".$req['relationships_Id']);
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
	public function deleterelationshipsById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from relationships where relationships_Id = ".$req['relationships_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_relationships");
			$this->mc->memcached->delete($this->config->config['cKey']."_relationships_detail".$req['relationships_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updaterelationshipsById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["Relationship"])) $set .= "Relationship=".$this->db->escape($req["Relationship"]).",";if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update relationships set ".$setValue." where relationships_Id = ".$req['relationships_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_relationships");
				$this->mc->memcached->delete($this->config->config['cKey']."_relationships_detail".$req['relationships_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertrelationshipsById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO relationships(Relationship,createdBy) VALUES (".$this->db->escape($req["Relationship"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_relationships");
			$status = true;
		}
		return $status;
	}
	public function getrelationshipss() 
	{
		$key = $this->config->config['cKey']."_relationships";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from relationships");
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