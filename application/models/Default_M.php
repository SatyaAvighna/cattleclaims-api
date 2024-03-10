<?php 
Class $tableName extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function get$tableNameById($req) 
	{
		$key = $this->config->config['cKey']."_$tableName_detail".$req['$tableId'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from $tableName where $tableId=".$req['$tableId']);
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
	public function delete$tableNameById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from $tableName where $tableId = ".$req['$tableId']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_$tableName");
			$this->mc->memcached->delete($this->config->config['cKey']."_$tableName_detail".$req['$tableId']);
			$status = true;
		}
		return $status;
	}
	
	public function update$tableNameById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		$cols;
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update $tableName set ".$setValue." where $tableId = ".$req['$tableId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_$tableName");
				$this->mc->memcached->delete($this->config->config['cKey']."_$tableName_detail".$req['$tableId']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insert$tableNameById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO $tableName($col) VALUES ($val)");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_$tableName");
			$status = true;
		}
		return $status;
	}
	public function get$tableNames() 
	{
		$key = $this->config->config['cKey']."_$tableName";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from $tableName");
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