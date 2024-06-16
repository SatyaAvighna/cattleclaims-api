<?php 
Class bannerimage extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getbannerimagesById($req) 
	{
		$key = $this->config->config['cKey']."_bannerimages_detail".$req['bannerimages_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from bannerimages where bannerimages_Id=".$req['bannerimages_Id']);
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
	public function deletebannerimagesById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from bannerimages where bannerimages_Id = ".$req['bannerimages_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_bannerimages");
			$this->mc->memcached->delete($this->config->config['cKey']."_bannerimages_detail".$req['bannerimages_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updatebannerimagesById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";
		if(!empty($req['bannerName'])) $set .= "bannerName=".$this->db->escape($req['bannerName']).",";
		if(!empty($req['bannerPath'])) $set .= "bannerPath=".$this->db->escape($req['bannerPath']).",";
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update bannerimages set ".$setValue." where bannerimages_Id = ".$req['bannerimages_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_bannerimages");
				$this->mc->memcached->delete($this->config->config['cKey']."_bannerimages_detail".$req['bannerimages_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertbannerimagesById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO bannerimages(bannerName,bannerPath,createdBy) VALUES (".$this->db->escape($req["bannerName"]).",".$this->db->escape($req["bannerPath"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_bannerimages");
			$status = true;
		}
		return $status;
	}
	public function getbannerimagess() 
	{
		$key = $this->config->config['cKey']."_bannerimages";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from bannerimages");
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