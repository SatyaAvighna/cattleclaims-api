<?php 
Class Master extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getmasters() 
	{
		$key = $this->config->config['cKey']."_masters";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from masters");
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
	public function getlots() 
	{
		$key = $this->config->config['cKey']."_lots";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from lots");
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
	public function getTransactions() 
	{
		$arry= array();
		$query = $this->db->query("select * from mtransactions where status=1");
		foreach($query->result() as $row)
		{
			$list= array();
			foreach($row as $clumn_name=>$clumn_value)
			{
				$list[$clumn_name] = $clumn_value;
			}
			$arry[] = $list;
		}
		return $arry;
	}
	public function getmastersById($mId) 
	{
		$key = $this->config->config['cKey']."_masters_detail".$mId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from masters where mId=".$mId);
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
	public function deletemastersById($mId) 
	{
		$status = false;
		$query =  $this->db->query("delete from masters where mId = ".$mId);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_masters");
			$this->mc->memcached->delete($this->config->config['cKey']."_masters_detail".$mId);
			$status = true;
		}
		return $status;
	}
	public function deletetransactionsById($mtId) 
	{
		$status = false;
		$query =  $this->db->query("delete from masters where mtId = ".$mtId);
		if($this->db->affected_rows()>0)
		{
			$status = true;
		}
		return $status;
	}
	public function updateStatusOfTransaction($mtId,$dstatus) 
	{
		$status = false;
		$query =  $this->db->query("update mtransactions set status =".$dstatus." where mtId = ".$mtId);
		if($this->db->affected_rows()>0)
		{
			$status = true;
		}
		return $status;
	}
	public function updatemastersById($req) 
	{
		$status = false;
		$set = "";
		//masterName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req['name'])) $set .= "masterName=".$this->db->escape(ucfirst($req['name'])).",";
		if(!empty($req['name'])) $set .= "componentName=".$this->db->escape("ContentComponents.".ucfirst($req['name'])).",";
		if(!empty($req['fields'])) $set .= "fields=".$this->db->escape($req['fields']).",";
		if(!empty($req['sId'])) $set .= "updatedBy=".$this->db->escape($req['sId']).",";
		if(!empty($req['updatedOn'])) $set .= "updatedBy=now(),";
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update masters set ".$setValue." where mId = ".$req['mId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_masters");
				$this->mc->memcached->delete($this->config->config['cKey']."_masters_detail".$req['mId']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertmasterById($req) 
	{
		$status = false;
		$favexits = $this->db->query("select mId from masters where masterName=".$this->db->escape($req['tableName'])."");
		if($favexits->num_rows() <= 0)
		{
			$query =  $this->db->query("INSERT INTO masters(masterName,componentName,fields,createdBy) VALUES (".$this->db->escape(ucfirst($req['tableName'])).",".$this->db->escape('ContentComponents.'.ucfirst($req['tableName'])).",".$this->db->escape($req['fields']).",".$this->db->escape($req['sId']).")");
			if($this->db->affected_rows()>0)
			{
				$req['mId'] = $this->db->insert_id();
				$req['mType'] = "create";
				$this->insertransactionById($req);
				$this->insertLot($req['tableName']);
				$this->insertRoleItem($req);
				$this->mc->memcached->delete($this->config->config['cKey']."_masters");
				$status = true;
			}
		}
		return $status;
	}
	public function insertRoleItem($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO role_items(riName,rKey,createdBy) VALUES (".$this->db->escape($req["tableName"]).",".$this->db->escape(str_replace(" ","_",strtolower($req['tableName']))).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_role_items");
			$status = true;
		}
		return $status;
	}
	public function insertransactionById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO mtransactions(mType,mId) VALUES (".$this->db->escape($req['mType']).",".$this->db->escape($req['mId']).")");
		if($this->db->affected_rows()>0)
		{
			$status = true;
		}
		return $status;
	}
	public function getColumnNamesFromTable($table){
		$fields1 =$this->db->list_fields($table);
		$fields2 = array("createdOn","updatedOn",'status','createdBy','updatedBy');
		$columns = array_values(array_diff($fields1, $fields2));
		//print_r($columns);
		return $columns;
	}
	public function getColumnNamesFromTableWT($table){
		// $fields1 =$this->db->list_fields($table);
		$fields2 = array("createdOn","updatedOn",'status','createdBy','updatedBy');
		// $columns = array_values(array_diff($fields1, $fields2));
		$columnsWT = array();
		$query =  $this->db->query("SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT, 
		COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$table."'");
		foreach($query->result() as $row)
		{
			//print_r($row);
			if(!in_array($row->COLUMN_NAME,$fields2)) $columnsWT[] = $row;
		}
		return $columnsWT;
	}
	public function getTableNames(){
		$tables =$this->db->list_tables();
		return $tables;
	}
	public function insertLot($tableName){
		$status = false;
		$query =  $this->db->query("INSERT INTO lots(ltName) VALUES (".$this->db->escape($tableName).")");
		if($this->db->affected_rows()>0)
		{
			$status = true;
			$this->mc->memcached->delete($this->config->config['cKey']."_lots");
		}
		return $status;
	}
} 
?> 