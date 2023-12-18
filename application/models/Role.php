<?php 
Class Role extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getRoleById($rId) 
	{	
		$key = $this->config->config['cKey']."_role_detail".$rId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from roles where rId=".$rId);
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
	public function deleteRoleById($req) 
	{
		$status = false;
		$query =  $this->db->query("update roles set rStatus=1 where rId = ".$req['rId']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_roles");
			$this->mc->memcached->delete($this->config->config['cKey']."_role_detail".$req['rId']);
			$status = true;
		}
		return $status;
	}
	
	public function updateRoleById($req) 
	{
		$status = false;
		$set = "";
		if(!empty($req['rName'])) $set .= "rName=".$this->db->escape($req['rName']).",";
		if(!empty($req['lPage'])) $set .= "lPage=".$this->db->escape($req['lPage']).",";
		if(!empty($req['rData'])) $set .= "rData=".$this->db->escape($req['rData']).",";
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			//echo "update roles set ".$setValue." where rId= ".$req['rId'];
			$query =  $this->db->query("update roles set ".$setValue." where rId= ".$req['rId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_roles");
				$this->mc->memcached->delete($this->config->config['cKey']."_role_detail".$req['rId']);
				$status = true;
			}
		}
		return $status;
	}
	public function insertRoleById($req) 
	{
		$status = false;
		$favexits = $this->db->query("select rId from roles where rName=".$this->db->escape($req['rName']));
		if($favexits->num_rows() <= 0)
		{
			$query =  $this->db->query("INSERT INTO roles(rName,lPage,rData,createdBy) VALUES (".$this->db->escape($req['rName']).",".$this->db->escape($req['lPage']).",".$this->db->escape($req['rData']).",".$req['sId'].")");
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_roles");
				$status = true;
			}
		}
		return $status;
	}
	
	function updateRoleStatusById($req) 
	{
		$status = false;
		$set = "";
		//cName cPerson cemailId cDesignation cMobile cAddress cPath
		if(!empty($req['rStatus'])) $set .= "rStatus=".$req['rStatus'].",";
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update roles set ".$setValue." where rId = ".$req['rId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_roles");
				$this->mc->memcached->delete($this->config->config['cKey']."_role_detail".$req['rId']);
				$status = true;
			}
		}
		
		return $status;
	}
} 
?> 