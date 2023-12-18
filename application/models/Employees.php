<?php 
Class employees extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getemployeesById($eId) 
	{
		$key = $this->config->config['cKey']."_employees_detail".$eId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from employees where employees_Id=".$eId);
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
	public function deleteemployeesById($req) 
	{
		$status = false;
		$query =  $this->db->query("delete from employees where employees_Id = ".$req['employees_Id']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_employees");
			$this->mc->memcached->delete($this->config->config['cKey']."_employees_detail".$req['employees_Id']);
			$status = true;
		}
		return $status;
	}
	
	public function updateemployeesById($req) 
	{
		$status = false;
		$set = "";
		//Default_MName,price,staffId,tax,code,color,vendorType,priority
		if(!empty($req["fName"])) $set .= "fName=".$this->db->escape($req["fName"]).",";
		if(!empty($req["lName"])) $set .= "lName=".$this->db->escape($req["lName"]).",";
		if(!empty($req["gender"])) $set .= "gender=".$this->db->escape($req["gender"]).",";
		if(!empty($req["dob"])) $set .= "dob=".$this->db->escape($req["dob"]).",";
		if(!empty($req["doj"])) $set .= "doj=".$this->db->escape($req["doj"]).",";
		if(!empty($req["dor"])) $set .= "dor=".$this->db->escape($req["dor"]).",";
		if(!empty($req["bloodGroup"])) $set .= "bloodGroup=".$this->db->escape($req["bloodGroup"]).",";
		if(!empty($req["pan"])) $set .= "pan=".$this->db->escape($req["pan"]).",";
		if(!empty($req["dId"])) $set .= "dId=".$this->db->escape($req["dId"]).",";
		if(!empty($req["dsId"])) $set .= "dsId=".$this->db->escape($req["dsId"]).",";
		if(!empty($req["mobile"])) $set .= "mobile=".$this->db->escape($req["mobile"]).",";
		if(!empty($req["aMobile"])) $set .= "aMobile=".$this->db->escape($req["aMobile"]).",";
		if(!empty($req["rId"])) $set .= "rId=".$this->db->escape($req["rId"]).",";
		if(!empty($req["address"])) $set .= "address=".$this->db->escape($req["address"]).",";
		if(!empty($req["roId"])) $set .= "roId=".$this->db->escape($req["roId"]).",";
		if(!empty($req["rmId"])) $set .= "rmId=".$this->db->escape($req["rmId"]).",";
		if(!empty($req["rvmId"])) $set .= "rvmId=".$this->db->escape($req["rvmId"]).",";
		if(!empty($req["etId"])) $set .= "etId=".$this->db->escape($req["etId"]).",";
		if(!empty($req["eId"])) $set .= "eId=".$this->db->escape($req["eId"]).",";
		if(!empty($req["password"])) $set .= "password=".$this->db->escape($req["password"]).",";
		if(!empty($req["emailId"])) $set .= "emailId=".$this->db->escape($req["emailId"]).",";
		if(!empty($req["sId"])) $set .= "updatedBy=".$this->db->escape($req["sId"]).",";
		if(!empty($req["aProofPath"])) $set .= "aProof=".$this->db->escape($req["aProofPath"]).",";
		if(!empty($req["panProofPath"])) $set .= "updatedBy=".$this->db->escape($req["panProofPath"]).",";

		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update employees set ".$setValue." where employees_Id = ".$req['employees_Id']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_employees");
				$this->mc->memcached->delete($this->config->config['cKey']."_employees_detail".$req['employees_Id']);
				$status = true;
			}
		}
		return $status;
	}
	
	public function insertemployeesById($req) 
	{
		$status = false;
		$query =  $this->db->query("INSERT INTO employees(fName,lName,gender,dob,doj,dor,bloodGroup,pan,dId,dsId,mobile,aMobile,cPerson,rId,address,aProof,panProof,roId,rmId,rvmId,etId,eId,password,emailId,createdBy) VALUES (".$this->db->escape($req["fName"]).",".$this->db->escape($req["lName"]).",".$this->db->escape($req["gender"]).",".$this->db->escape($req["dob"]).",".$this->db->escape($req["doj"]).",".$this->db->escape($req["dor"]).",".$this->db->escape($req["bloodGroup"]).",".$this->db->escape($req["pan"]).",".$this->db->escape($req["dId"]).",".$this->db->escape($req["dsId"]).",".$this->db->escape($req["mobile"]).",".$this->db->escape($req["aMobile"]).",".$this->db->escape($req["cPerson"]).",".$this->db->escape($req["rId"]).",".$this->db->escape($req["address"]).",".$this->db->escape($req["aProofPath"]).",".$this->db->escape($req["panProofPath"]).",".$this->db->escape($req["roId"]).",".$this->db->escape($req["rmId"]).",".$this->db->escape($req["rvmId"]).",".$this->db->escape($req["etId"]).",".$this->db->escape($req["eId"]).",".$this->db->escape($req["password"]).",".$this->db->escape($req["emailId"]).",".$this->db->escape($req["sId"]).")");
		if($this->db->affected_rows()>0)
		{
			//echo "i";
			$this->mc->memcached->delete($this->config->config['cKey']."_employees");
			$status = true;
		}
		return $status;
	}
	public function getemployeess() 
	{
		$key = $this->config->config['cKey']."_employees";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from employees");
			foreach($query->result() as $row)
			{
				$list= array();
				foreach($row as $clumn_name=>$clumn_value)
				{
					$list[$clumn_name] = $clumn_value;
				}
				$rmId = $this->getemployeesById($list['rmId']);
				$rvmId = $this->getemployeesById($list['rvmId']);
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
		// $condition = "employees_Id =".$req['sId']." AND " . "password =" . "'" . $oldpassword . "'";
		// $this->db->select('*');
		// $this->db->from('employees');
		// $this->db->where($condition);
		// $this->db->limit(1);
		$query = $this->db->query("select * from employees where employees_Id =".$req['sId']." AND " . "password =" . "'" . $oldpassword . "'");;
		// echo "select * from employees where employees_Id =".$req['sId']." AND " . "password =" . "'" . $oldpassword . "'";
		if ($query->num_rows() >= 1)
		{
			$newpassword = $req['newpassword'];
			$query =  $this->db->query("update employees set isPwd=0, password='".$newpassword."' where employees_Id = ".$req['sId']);
			//secho "update employees set isPwd=0, password='".$newpassword."' where employees_Id = ".$req['sId'];
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_employees");
				$this->mc->memcached->delete($this->config->config['cKey']."_employees_detail".$req['sId']);
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
		$this->db->from('employees');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() >= 1)
		{
			foreach($query->result() as $row)
			{
				$employees_Id = $row->employees_Id;
				foreach($row as $column_name=>$column_value)
				{
					$status[$column_name] = $column_value;
				}
			}	
			$query =  $this->db->query("update employees set password='".$req['password']."', isPwd=1 where employees_Id = ".$employees_Id);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_employees");
				$this->mc->memcached->delete($this->config->config['cKey']."_employees_detail".$employees_Id);
			}
		}
		return $status;
	}
	function markAttendance($req) 
	{
		$status = false;
		//$date = strtotime($req["aDate"]); 
		$aDate =date('Y-m-d'); 
		// print_r($aDate);
		$query = $this->db->query("select * from attendance where DATE(aDate)='".$aDate."' AND employees_Id =".$req['sId']);
		// echo "select * from attendance where DATE(aDate)='".$aDate."' AND employees_Id =".$req['sId'];
		if ($query->num_rows() < 1)
		{
			$query =  $this->db->query("INSERT INTO attendance(employees_Id,aDate,aStatus) VALUES (".$this->db->escape($req["sId"]).",now(),1)");
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_employee_attendance".$req['sId']);
				$status = true;
			}
		}
		return $status;
		// 1 - attanded
		// 2 - leave
	}
	function getAttendance($req) 
	{
		$key = $this->config->config['cKey']."_employee_attendance".$req['sId'];
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$arry_list = array();
			$query = $this->db->query("select DATE(aDate) as aDate,aStatus,aId from attendance where employees_Id=".$req['sId']);
			$leave = array();
			$attend = array();
			foreach($query->result() as $row)
			{
				$list= array();
				foreach($row as $clumn_name=>$clumn_value)
				{
					$list[$clumn_name] = $clumn_value;
				}
				$arry_list[] = $list;
			}	
			foreach($arry_list as $atten)
			{
				if($atten['aStatus'] == 1) $attend[] = $atten['aDate'];
				if($atten['aStatus'] == 2) $leave[] = $atten['aDate'];
			}
			$arry['leave'] = $leave;
			$arry['attended'] = $attend;
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
} 
?> 