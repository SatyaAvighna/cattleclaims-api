<?php 
Class User extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getuserById($uId) 
	{
		$key = $this->config->config['cKey']."_user_detail".$uId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from users where uId=".$uId);
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
	public function deleteuserById($req) 
	{s
		$status = false;
		$query =  $this->db->query("delete from users where uId = ".$req['uId']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_users");
			$this->mc->memcached->delete($this->config->config['cKey']."_user_detail".$req['uId']);
			$status = true;
		}
		return $status;
	}
	
	public function updateuserById($req) 
	{
		$status = false;
		$set = "";
		//fName,lName,gender,mobile,address,password,emailId,
		if(!empty($req["fName"])) $set .= "fName=".$this->db->escape($req["fName"]).",";
		if(!empty($req["lName"])) $set .= "lName=".$this->db->escape($req["lName"]).",";
		if(!empty($req["gender"])) $set .= "gender=".$this->db->escape($req["gender"]).",";
		if(!empty($req["mobile"])) $set .= "mobile=".$this->db->escape($req["mobile"]).",";
		if(!empty($req["address"])) $set .= "address=".$this->db->escape($req["address"]).",";
		if(!empty($req["password"])) $set .= "password=".$this->db->escape($req["password"]).",";		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update users set ".$setValue." where uId = ".$req['uId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_users");
				$this->mc->memcached->delete($this->config->config['cKey']."_user_detail".$req['uId']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertuserById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO user(fName,lName,gender,mobile,address,password,emailId,createdBy) VALUES (".$this->db->escape($req["fName"]).",".$this->db->escape($req["lName"]).",".$this->db->escape($req["gender"]).",".$this->db->escape($req["mobile"]).",".$this->db->escape($req["address"]).",".$this->db->escape($req["password"]).",".$this->db->escape($req["emailId"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_users");
			$status = true;
		}
		return $status;
	}
	public function getusers() 
	{
		$key = $this->config->config['cKey']."_users";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from user");
			foreach($query->result() as $row)
			{
				$list= array();
				foreach($row as $clumn_name=>$clumn_value)
				{
					$list[$clumn_name] = $clumn_value;
				}
				$rmId = $this->getuserById($list['rmId']);
				$rvmId = $this->getuserById($list['rvmId']);
				$list['dName'] = $this->getdepartmentsById($list['dId'])['Department'];
				$list['dsName'] = $this->getdesignationsById($list['dsId'])['Designation'];
				$list['etName'] = $this->getemployeetypeById($list['etId'])['EmployeeType'];
				$list['rName'] = $this->getRoleById($list['roId'])['rName'];
				$list['rmName'] = $rmId['fName']." ".$rmId['lName'];
				$list['rvmName'] = $rvmId['fName']." ".$rvmId['lName'];
				$arry[] = $list;
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getemployeetypeById($etId) 
	{
		$key = $this->config->config['cKey']."_employeetype_detail".$etId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from employeetype where employeetype_Id=".$etId);
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
	public function getdesignationsById($dsId) 
	{
		$key = $this->config->config['cKey']."_designations_detail".$dsId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from designations where designations_Id=".$dsId);
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
	public function getdepartmentsById($dId) 
	{
		$key = $this->config->config['cKey']."_departments_detail".$dId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from departments where departments_Id=".$dId);
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
	function updatePasswordById($req) 
	{
		$oldpassword = $req['oldpassword'];
		$status = false;
		$query = $this->db->query("select * from users where uId =".$req['uId']." AND " . "password =" . "'" . $oldpassword . "'");;
		// echo "select * from users where uId =".$req['uId']." AND " . "password =" . "'" . $oldpassword . "'";
		if ($query->num_rows() >= 1)
		{
			$newpassword = $req['newpassword'];
			$query =  $this->db->query("update users set isPwd=0, password='".$newpassword."' where uId = ".$req['uId']);
			//secho "update users set isPwd=0, password='".$newpassword."' where uId = ".$req['uId'];
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_users");
				$this->mc->memcached->delete($this->config->config['cKey']."_user_detail".$req['uId']);
				$status = true;
			}
		}
		return $status;
	}
	function forgotUserById($req) 
	{
		//$password = hash_hmac("md5",$req['oldpassword'],"donotouchapnap");
		$status = array();
		$condition = "emailId ='".$req['emailId']."'";
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() >= 1)
		{
			foreach($query->result() as $row)
			{
				$uId = $row->uId;
				foreach($row as $column_name=>$column_value)
				{
					$status[$column_name] = $column_value;
				}
			}	
			$query =  $this->db->query("update users set password='".$req['password']."', isPwd=1 where uId = ".$uId);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_users");
				$this->mc->memcached->delete($this->config->config['cKey']."_user_detail".$uId);
			}
		}
		return $status;
	}
	
} 
?> 