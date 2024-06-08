<?php 
Class suminsured extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getsuminsuredById($req) 
	{
		$key = $this->config->config['cKey']."_suminsured_detail".$req['suminsured_Id'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from suminsured where suminsured_Id=".$req['suminsured_Id']);
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
	public function deletesuminsuredById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from suminsured where suminsured_Id = ".$req['suminsured_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_suminsured");
			$this->mc->memcached->delete($this->config->config['cKey']."_suminsured_detail".$req['suminsured_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updatesuminsuredById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["baseproductid"])) $set .= "baseproductid=".$this->db->escape($req["baseproductid"]).",";if(!empty($req["sumisnured"])) $set .= "sumisnured=".$this->db->escape($req["sumisnured"]).",";if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update suminsured set ".$setValue." where suminsured_Id = ".$req['suminsured_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_suminsured");
				$this->mc->memcached->delete($this->config->config['cKey']."_suminsured_detail".$req['suminsured_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertsuminsuredById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO suminsured(baseproductid,sumisnured,createdBy) VALUES (".$this->db->escape($req["baseproductid"]).",".$this->db->escape($req["sumisnured"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_suminsured");
			$status = true;
		}
		return $status;
	}
	public function getsuminsureds() 
	{
		$key = $this->config->config['cKey']."_suminsured";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from suminsured");
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