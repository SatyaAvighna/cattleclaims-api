<?php 
Class breedlist extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getbreedlistById($req) 
	{
		$key = $this->config->config['cKey']."_breedlist_detail".$req['breedlist_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from breedlist where breedlist_Id=".$req['breedlist_Id']);
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
	public function deletebreedlistById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from breedlist where breedlist_Id = ".$req['breedlist_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_breedlist");
			$this->mc->memcached->delete($this->config->config['cKey']."_breedlist_detail".$req['breedlist_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updatebreedlistById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["breedId"])) $set .= "breedId=".$this->db->escape($req["breedId"]).",";if(!empty($req["breedName"])) $set .= "breedName=".$this->db->escape($req["breedName"]).",";if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update breedlist set ".$setValue." where breedlist_Id = ".$req['breedlist_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_breedlist");
				$this->mc->memcached->delete($this->config->config['cKey']."_breedlist_detail".$req['breedlist_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertbreedlistById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO breedlist(breedId,breedName,createdBy) VALUES (".$this->db->escape($req["breedId"]).",".$this->db->escape($req["breedName"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_breedlist");
			$status = true;
		}
		return $status;
	}
	public function getbreedlists() 
	{
		$key = $this->config->config['cKey']."_breedlist";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from breedlist");
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