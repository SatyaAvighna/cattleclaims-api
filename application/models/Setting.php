<?php 
Class Setting extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getSettingById($sId) 
	{	
		$key = $this->config->config['cKey']."_setting_detail".$sId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from settings where sId=".$sId);
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
	public function deleteSettingById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from settings where sId = ".$req['sId']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_settings");
			$this->mc->memcached->delete($this->config->config['cKey']."_setting_detail".$req['sId']);
			$status = true;
		}
		return $status;
	}
	
	public function updateSettingById($req) 
	{
		
		$status = false;
		$set = "";
		if(!empty($req['settingsName'])) $set .= "settingsName=".$this->db->escape($req['settingsName']).",";
		if(!empty($req['settingsValue'])) $set .= "settingsValue='".$req['settingsValue']."',";
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			//echo "update settings set ".$setValue." where sId= ".$req['sId'];
			$query =  $this->db->query("update settings set ".$setValue." where sId= ".$req['sId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_settings");
				$this->mc->memcached->delete($this->config->config['cKey']."_setting_detail".$req['sId']);
				$status = true;
			}
		}
		return $status;
	}
	public function insertSettingById($req) 
	{
		$status = false;
		$favexits = $this->db->query("select sId from settings where settingsName=".$this->db->escape($req['settingsName']));
		if($favexits->num_rows() <= 0)
		{
			$query =  $this->db->query("INSERT INTO settings(settingsName,settingsValue,createdBy) VALUES (".$this->db->escape($req['settingsName']).",'".$req['settingsValue']."',".$req['sId'].")");
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_settings");
				$status = true;
			}
		}
		return $status;
	}
	
} 
?> 