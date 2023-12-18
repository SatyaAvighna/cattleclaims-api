<?php 
Class role_items extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getrole_itemsById($req) 
	{
		$key = $this->config->config['cKey']."_role_items_detail".$req['role_items_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from role_items where role_items_Id=".$req['role_items_Id']);
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
	public function deleterole_itemsById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from role_items where role_items_Id = ".$req['role_items_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_role_items");
			$this->mc->memcached->delete($this->config->config['cKey']."_role_items_detail".$req['role_items_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updaterole_itemsById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["riName"])) $set .= "riName=".$this->db->escape($req["riName"]).",";if(!empty($req["rKey"])) $set .= "rKey=".$this->db->escape($req["rKey"]).",";if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update role_items set ".$setValue." where role_items_Id = ".$req['role_items_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_role_items");
				$this->mc->memcached->delete($this->config->config['cKey']."_role_items_detail".$req['role_items_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertrole_itemsById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO role_items(riName,rKey,createdBy) VALUES (".$this->db->escape($req["riName"]).",".$this->db->escape($req["rKey"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_role_items");
			$status = true;
		}
		return $status;
	}
	public function getrole_itemss() 
	{
		$key = $this->config->config['cKey']."_role_items";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from role_items");
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