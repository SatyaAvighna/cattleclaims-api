<?php 
Class Common extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
		
	} 
	
	public function login($data) 
	{ 
	 	//print_r($data);
		// $password = hash_hmac("md5",$data['password'],"donotouchapnap");
		$password = $data['password'];
		//echo $password;
		//echo "select * from users where emailId =" . "'" . $data['username'] . "' AND " . "password=" . "'" . $password . "'";
		$condition = "(emailId =" . "'" . $data['username'] . "' OR eId =" . "'" . $data['username'] . "') AND " . "password=" . "'" . $password . "'";
		$this->db->select('*');
		$this->db->from('employees');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		//print_r($query->result_array());
		if ($query->num_rows() == 1) return $query->result_array();
		else return false;
	}
	
	public function loginUser($data) 
	{ 
	 	//print_r($data);
		// $password = hash_hmac("md5",$data['password'],"donotouchapnap");
		$password = $data['password'];
		//echo $password;
		//echo "select * from users where emailId =" . "'" . $data['username'] . "' AND " . "password=" . "'" . $password . "'";
		$condition = "(emailId =" . "'" . $data['username'] . "' OR eId =" . "'" . $data['username'] . "') AND " . "password=" . "'" . $password . "'";
		$this->db->select('uId,fName,lName,gender,mobile,address,password,emailId');
		$this->db->from('users');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		//print_r($query->result_array());
		if ($query->num_rows() == 1) return $query->result_array();
		else return false;
	}
	public function getInsurancetypes() 
	{
		$key = $this->config->config['cKey']."_insurancetypes";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from insurancetypes");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getInsurancetypeByIds($itId) 
	{
		$key = $this->config->config['cKey']."_insurancetype_detail".$itId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from insurancetypes where itId=".$itId);
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

	public function getInsuranceName($itId) 
	{
		$key = $this->config->config['cKey']."_insurancetype_detail".$itId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from insurancetypes where itId=".$itId);
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry['itName'];
	}
	public function getCompanies() 
	{
		$key = $this->config->config['cKey']."_companiesList";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from companies where cdStatus=2 order by cId asc");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getCompanyByIds($cId) 
	{
		$key = $this->config->config['cKey']."_company_detail".$cId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from companies where cId=".$cId);
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
				$arry['features'] = $this->getcFetures($cId);
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getCompanyFeaturesByIds($cId) 
	{
		$key = $this->config->config['cKey']."_companies_features_".$cId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from cfeatures where cId=".$cId);
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}

	public function getCompanyName($cId) 
	{
		$key = $this->config->config['cKey']."_company_detail".$cId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from companies where cId=".$cId);
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
				$arry['features'] = $this->getcFetures($cId);
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry['cName'];
	}
	function getcFetures($cId)
	{
		$key = $this->config->config['cKey']."_companies_features_".$cId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from cfeatures where cId=".$cId);
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getSettings() 
	{
		$key = $this->config->config['cKey']."_settings";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from settings order by sId asc");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getSettingByIds($sId) 
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
	public function getSettingsByName($sName) 
	{
		// $key = $this->config->config['cKey']."_setting_detail".$sId;
		// $arry = $this->mc->memcached->get($key);
		// if(!$arry)
		// {
			$arry= array();
			$query =  $this->db->query("select * from settings where settingsName='".$sName."'");
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
			}	
		// 	if($arry)$this->mc->memcached->save($key,$arry,0,0);
		// }
		return $arry;
	}
	public function getZones() 
	{
		$key = $this->config->config['cKey']."_zones";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from zones order by zId asc");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getZonesByIds($zId) 
	{
		$key = $this->config->config['cKey']."_zone_detail".$zId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from zones where zId=".$zId);
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
	public function getZoneName($zId) 
	{
		$key = $this->config->config['cKey']."_zone_detail".$zId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from zones where zId=".$zId);
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry['zoneName'];
	}
	public function getZipcodes() 
	{
		$key = $this->config->config['cKey']."_zipcodes";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from zipcodes order by zcId asc");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getZipcodesByIds($zcId) 
	{
		$key = $this->config->config['cKey']."_zipcode_detail".$zcId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from zipcodes where zcId=".$zcId);
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
	public function getCitiesByName($name) 
	{
		$arry= array();
		$query = $this->db->query("select * from zipcodes where city like '%".$name."%'");
		foreach ($query->result() as $row)
		{
			$list= array();
			foreach($row as $column_name=>$column_value)
			{
				$list[$column_name] = $column_value;
			}
			$arry[] = $list;
		}
		return $arry;
	}
	public function getPlantypes() 
	{
		$key = $this->config->config['cKey']."_plantypes";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from plantypes order by ptId asc");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getPlantypesByIds($ptId) 
	{
		$key = $this->config->config['cKey']."_plantype_detail".$ptId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from plantypes where ptId=".$ptId);
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
	public function getPlantypesNameByIds($ptId) 
	{
		$key = $this->config->config['cKey']."_plantype_detail".$ptId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from plantypes where ptId=".$ptId);
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry['ptName'];
	}
	public function getFamilydefinations() 
	{
		$key = $this->config->config['cKey']."_familydefinations";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from familydefinations order by fdId asc");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getFamilydefinationsByIds($fdId) 
	{
		$key = $this->config->config['cKey']."_familydefination_detail".$fdId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from familydefinations where fdId=".$fdId);
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
	public function getFamilydefinationsNameByIds($fdId) 
	{
		$key = $this->config->config['cKey']."_familydefination_detail".$fdId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from familydefinations where fdId=".$fdId);
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry['fdName'];
	}
	public function getFamilyDefinationByname($fdName) 
	{
		$fdId= 0;
		$query =  $this->db->query("select fdId from familydefinations where fdName='".$fdName."'");
		//echo "select fdId from familydefinations where fdName='".$fdName."'";
		foreach($query->result() as $row)
		{
			$fdId = $row->fdId;
		}	
		return $fdId;
	}
	public function getRoles() 
	{
		$key = $this->config->config['cKey']."_roles";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from roles order by rId asc");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getAgebands() 
	{
		$key = $this->config->config['cKey']."_agebands";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from agebands order by abId asc");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getAgebandsByIds($abId) 
	{
		$key = $this->config->config['cKey']."_ageband_detail".$abId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from agebands where abId=".$abId);
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
	public function getAgebandsNameByIds($abId) 
	{
		$key = $this->config->config['cKey']."_ageband_detail".$abId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from agebands where abId=".$abId);
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry['abName'];
	}
	public function getRatecharts() 
	{
		$key = $this->config->config['cKey']."_ratecharts";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from ratecharts order by rcId asc");
			foreach ($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				//$arry['companyDetails'] = $this->getCompanyByIds($arry['cId']);
				$arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getRatechartsByIds($rcId) 
	{
		$key = $this->config->config['cKey']."_ratechart_detail".$rcId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from ratecharts where rcId=".$rcId);
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
				$arry['companyDetails'] = $this->getCompanyByIds($arry['cId']);
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getZoneBYzipcode($zipcode)
	{
		$zId = 0;
		if($zipcode!=0)
		{
			$query =  $this->db->query("select zId from zipcodes where zcName='".$zipcode."'");
			//echo "select zId from zipcodes where zcName='".$zipcode."'";
			foreach($query->result() as $row)
			{
				$zId = $row->zId;
			}
		}
		return $zId;
	}
	public function getCityBYzipcode($zipcode)
	{
		$city = "";
		$query =  $this->db->query("select city from zipcodes where zcName='".$zipcode."'");
		//echo "select zId from zipcodes where zcName='".$zipcode."'";
		foreach($query->result() as $row)
		{
			$city = $row->city;
		}
		return $city;
	}
	public function getAgeBandBYAge($age)
	{
		$abName = "";
		$query =  $this->db->query("select abName from agebands where ".$age." >= minAge and ".$age." <= maxAge");
		foreach($query->result() as $row)
		{
			$abName = $row->abName;
		}
		return $abName;
	}
	public function getPolicies($customer)
	{
		$zId = $this->getZoneBYzipcode($customer['zipcode']);
		$age_band = $this->getAgeBandBYAge($customer['maxage']);
		$fdId = $this->getFamilyDefinationByname($customer['fdName']);
		$arry= array();
		$sumInsuredMin = $customer['sumInsuredMin']*100000;
		$sumInsuredMax = $customer['sumInsuredMax']*100000;
		$where = "";
		if($zId>0) $where = "zId=".$zId." and ";
		$query =  $this->db->query("select * from ratecharts where $where age_band='".$age_band."' and ptId=".$customer['planType']." and fdId=".$fdId." and sum_assured>=".$sumInsuredMin." and sum_assured<=".$sumInsuredMax);
		//echo "select * from ratecharts where $where age_band='".$age_band."' and ptId=".$customer['planType']." and fdId=".$fdId." and sum_assured>=".$sumInsuredMin." and sum_assured<=".$sumInsuredMax;
		foreach($query->result() as $row)
		{
			$list = array();
			foreach($row as $column_name=>$column_value)
			{
				$list[$column_name] = $column_value;
			}
			$list['companyDetails'] = $this->getCompanyByIds($list['cId']);
			$list['planType'] = $this->common->getPlantypesNameByIds($list['ptId']);
			$arry[] = $list;
		}	
		//print_r($arry);
		return $arry;
	}

	/* SMS History Starts */
	public function getSMSHistory()
	{
		$key = $this->config->config['cKey']."_smshistory";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from smshistory order by shId desc");
			foreach($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
				$arry[] = $list;
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	public function getSumSMSHistoryBy($type)
	{
		$key = $this->config->config['cKey']."_smshistory_".$type;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$where = "type='credit'";
			if($type=='debit')$where = "type='debit' OR type='debiti'";
			$query =  $this->db->query("select sum(sms) as sms from smshistory where $where");
			//echo "select sum(sms) as sms from smshistory where $where";
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
			}	
			if($arry) $this->mc->memcached->save($key,$arry,0,0);
		}
		$count = 0;
		if(!empty($arry['sms']))$count= $arry['sms'];
		return $count;
	}
	public function debitSMSHistory($SMSCount)
	{
		$status = false;
		$date=date("Y-m-d");
		$favexits = $this->db->query("select shId from smshistory where type='debiti' and cDate='".$date."'");
		if($favexits->num_rows() <= 0)
		{
			$query = $this->db->query("INSERT INTO smshistory(type,sms,cDate) VALUES('debiti',".$SMSCount.",'".$date."')");
			if($this->db->affected_rows()>0)
			{
				$lastId = $this->db->insert_id();
				$this->mc->memcached->delete($this->config->config['cKey']."_smshistory");
				$status = true;
				$this->mc->memcached->delete($this->config->config['cKey']."_smshistory_debit");
			}
		}
		else
		{
			foreach($favexits->result() as $row)
			{
				$shId = $row->shId;
			}
			$this->db->query("update smshistory set sms=sms+".$SMSCount." where shId=".$shId);	
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_smshistory");
				$this->mc->memcached->delete($this->config->config['cKey']."_smshistory_debit");
				$status = true;
			}
		}
		return $status;
	}
	public function creditSMSHistory($req)
	{
		$status = false;
		$date = date("Y-m-d");
		$query = $this->db->query("INSERT INTO smshistory(type,sms,cDate) VALUES('".$req['type']."',".$req['balance'].",'".$date."')");
		if($this->db->affected_rows()>0)
		{
			$lastId = $this->db->insert_id();
			$this->mc->memcached->delete($this->config->config['cKey']."_smshistory");
			$this->mc->memcached->delete($this->config->config['cKey']."_smshistory_".$req['type']);
			$status = true;
		}
		return $status;
	}
	public function insertIndividualSMS($to,$message,$messageId,$messageStatus)
	{
		$status = false;
		//$date=date("Y-m-d",strtotime($req['cDate']));='Failed'
		$query = $this->db->query("INSERT INTO smses_sent(mobile,message,messageId,messageStatus) VALUES('".$to."',".$this->db->escape($message).",".$this->db->escape($messageId).",'".$messageStatus."')");
		if($this->db->affected_rows()>0)
		{
			$status = true;
		}
		return $status;
	}
	public function addCreditsSMS($req)
	{
		$status = false;
		$favexits = $this->db->query("select scId from smscredits");
		if($favexits->num_rows() <= 0)
		{
			$query = $this->db->query("INSERT INTO smscredits(balance) VALUES(".$req['balance'].")");
			if($this->db->affected_rows()>0)
			{
				$lastId = $this->db->insert_id();
				$this->mc->memcached->delete($this->config->config['cKey']."_smscredits");
				$status = true;
			}
		}
		else
		{
			foreach($favexits->result() as $row)
			{
				$scId = $row->scId;
			}
			$this->db->query("update smscredits set balance=balance+".$req['balance']." where scId=".$scId);	
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_smscredits");
				$status = true;
			}
		}
		return $status;
	}
	public function removeCreditsSMS($req)
	{
		$status = false;
		$favexits = $this->db->query("select scId from smscredits");
		if($favexits->num_rows() > 0)
		{
			foreach($favexits->result() as $row)
			{
				$scId = $row->scId;
			}
			$this->db->query("update smscredits set balance = balance - ".$req['balance']." where scId=".$scId);	
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_smscredits");
				$status = true;
			}
		}
		return $status;
	}
	public function getCreditsSMS()
	{
		$key = $this->config->config['cKey']."_smscredits";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from smscredits order by scId desc");
			foreach($query->result() as $row)
			{
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry['balance'];
	}
	public function addorupdateSMSBalance($req)
	{
		if($req['type']=='credit') $status = $this->addCreditsSMS($req);
		if($req['type']=='debit') $status = $this->removeCreditsSMS($req);
		if($status) $this->creditSMSHistory($req);
		return $status;
	}
	public function sendSMS($to,$message,$isUnicode=1,$templateId="",$senderId="BYAENT")
	{
		$credits = $this->getCreditsSMS();
		if($credits > 3)
		{
			$username = "techtantra";
			$password = "1234567";
			//$senderid = "BYAENT";
			//$to = '9985111878';
			$url = "http://198.24.149.4/API/pushsms.aspx?&route_id=2&Unicode=".$isUnicode."&" .
				 "loginID=" . $username . "&" .
				 "password=" . $password . "&" .
				 "text="  . urlencode($message) . "&" .
				 "accusage=1&" .
				 "senderid=" . urlencode($senderId) . "&" .
				 "mobile="       . $to;
			//echo $url."<br/>";
			if($templateId) $url = $url."&Template_id=".$templateId;
			echo $url."<br/>";
			$output = file($url);
			$result = json_decode($output[0], true);
			//print_r($result);
			//echo gettype($result);
			if($result['MsgStatus'] == "Sent")
			{
				echo "Sent";
				$this->insertIndividualSMS($to,$message,$result['Transaction_ID'],'Sent');
				$this->debitSMSHistory($result['SMSCount']);
				$this->removeCreditsSMS(array('balance'=>$result['SMSCount']));	
			}
			else $this->insertIndividualSMS($to,$message,$result['Transaction_ID'],'Failed');
		}
		ob_clean();
	}
	/* SMS History Ends */
	function getCustomer() 
	{
		$key = $this->config->config['cKey']."_customersList";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select cId, cname, mobile, emailId, planType, sumInsuredMin, sumInsuredMax, zipcode, maxage, createdOn, fdName, pstate, state, pcity, city, pzipcode, cAddress, pAddress, landline, dob, identification, gender, annualIncome, maritalStatus, idNumber, pStatus, existing_illness, covid, surgical_procedure, existing_illness_data, covid_data, incomerange from customers");
			foreach($query->result() as $row)
			{
				$list= array();
				foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
                $list["policies"] = $this->getPoliciesBYcID($list['cId']);
				$arry[] = $list;
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	function getPoliciesBYcID($cId) 
	{
		$key = $this->config->config['cKey']."_customers_detail_polocies".$cId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select * from customer_details where cId=".$cId);
			foreach($query->result() as $row)
			{
				$list= array();
                foreach($row as $column_name=>$column_value)
				{
					$list[$column_name] = $column_value;
				}
                $arry[] = $list;
			}	
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
} 
?> 