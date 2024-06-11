<?php 
Class Cattle extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	public function getCattleById($cId) 
	{	
		$key = $this->config->config['cKey']."_cattle_detail".$cId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select cId,animalType,tagnumber,breed,gender,age,sumInsured,earTag,lSidePath,rSidePath,vPath from cattles where cId=".$cId);
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
	public function deleteCattleById($req) 
	{
		$status = false;
		$query =  $this->db->query("update cattles set cStatus=1 where cId = ".$req['cId']);
		if($this->db->affected_rows()>0)
		{
			$this->mc->memcached->delete($this->config->config['cKey']."_cattles");
			$this->mc->memcached->delete($this->config->config['cKey']."_cattle_detail".$req['cId']);
			$status = true;
		}
		return $status;
	}
	
	public function updateCattleById($req) 
	{
		$status = false;
		$set = "";
        //cattle,tagnumber,breed,gender,age,sumInsured,earTag,lSidePath,rSidePath,vPath,createdBy, cAddress, cPincode, cDistrict, cState
		if(!empty($req['animalType'])) $set .= "animalType=".$this->db->escape($req['animalType']).",";
		if(!empty($req['tagnumber'])) $set .= "tagnumber=".$this->db->escape($req['tagnumber']).",";
		if(!empty($req['breed'])) $set .= "breed=".$this->db->escape($req['breed']).",";
		if(!empty($req['gender'])) $set .= "gender=".$this->db->escape($req['gender']).",";
		if(!empty($req['age'])) $set .= "age=".$this->db->escape($req['age']).",";
		if(!empty($req['sumInsured'])) $set .= "sumInsured=".$this->db->escape($req['sumInsured']).",";
		if(!empty($req['earTag'])) $set .= "earTag=".$this->db->escape($req['earTag']).",";
		if(!empty($req['lSidePath'])) $set .= "lSidePath=".$this->db->escape($req['lSidePath']).",";
		if(!empty($req['rSidePath'])) $set .= "rSidePath=".$this->db->escape($req['rSidePath']).",";
		if(!empty($req['vPath'])) $set .= "vPath=".$this->db->escape($req['vPath']).",";
		if(!empty($req['cAddress'])) $set .= "cAddress=".$this->db->escape($req['cAddress']).",";
		if(!empty($req['cPincode'])) $set .= "cPincode=".$this->db->escape($req['cPincode']).",";
		if(!empty($req['cDistrict'])) $set .= "cDistrict=".$this->db->escape($req['cDistrict']).",";
		if(!empty($req['cState'])) $set .= "cState=".$this->db->escape($req['cState']).",";
		// if(!empty($req['updatedBy'])) $set .= "updatedBy=".$this->db->escape($req['sId']).",";s
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			// echo "update cattles set ".$setValue." where cId= ".$req['cId'];
			$query =  $this->db->query("update cattles set ".$setValue." where cId= ".$req['cId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_cattles");
				$this->mc->memcached->delete($this->config->config['cKey']."_cattle_detail".$req['cId']);
				$status = true;
			}
		}
		return $status;
	}
	public function insertCattleById($req) 
	{
		$plId = $cId = 0;
		$favexits = $this->db->query("select cId from cattles where tagnumber=".$this->db->escape($req['tagnumber']));
		if($favexits->num_rows() <= 0)
		{
			// $query =  $this->db->query("INSERT INTO cattles(animalType,tagnumber,breed,gender,age,sumInsured,ownerId,cAddress, cPincode, cDistrict, cState,createdBy) VALUES (".$this->db->escape($req['animalType']).",".$this->db->escape($req['tagnumber']).",".$this->db->escape($req['breed']).",".$this->db->escape($req['gender']).",".$this->db->escape($req['age']).",".$this->db->escape($req['sumInsured']).",".$this->db->escape($req['ownerId']).",".$this->db->escape($req['cAddress']).",".$this->db->escape($req['cPincode']).",".$this->db->escape($req['cDistrict']).",".$this->db->escape($req['cState']).",".$req['sId'].")");
			$query =  $this->db->query("INSERT INTO cattles(animalType,tagnumber,breed,gender,age,sumInsured,ownerId,createdBy) VALUES (".$this->db->escape($req['animalType']).",".$this->db->escape($req['tagnumber']).",".$this->db->escape($req['breed']).",".$this->db->escape($req['gender']).",".$this->db->escape($req['age']).",".$this->db->escape($req['sumInsured']).",".$this->db->escape($req['ownerId']).",".$req['sId'].")");
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_cattles");
				$cId =$this->db->insert_id();
			}
		}
		else
		{
			foreach($favexits->result() as $row)
			{
				$cId = $row->cId;
			}	
		}
		$plId = $this->insertProposer($cId);
		return array("proposalId"=>$plId,"cId"=>$cId);
	}
	public function insertProposer($cId) 
	{
		$plId = 0;
		$proposalId = time();
		$query =  $this->db->query("INSERT INTO cattle_has_proposal(cId,proposalId) VALUES (".$this->db->escape($cId).",".$proposalId.")");
		if($this->db->affected_rows()>0)
		{
			$plId = $this->db->insert_id();
			$this->mc->memcached->delete($this->config->config['cKey']."_cattles");
		}
		return $proposalId;
	}
	
	function updateOwnecStatusById($req) 
	{
		$status = false;
		$set = "";
		//cName cPerson cemailId cDesignation cMobile cAddress cPath
		if(!empty($req['cStatus'])) $set .= "cStatus=".$req['cStatus'].",";
		
		if(!empty($set))
		{
			$setValue = rtrim($set,',');
			$query =  $this->db->query("update cattles set ".$setValue." where cId = ".$req['cId']);
			if($this->db->affected_rows()>0)
			{
				$this->mc->memcached->delete($this->config->config['cKey']."_cattles");
				$this->mc->memcached->delete($this->config->config['cKey']."_cattle_detail".$req['cId']);
				$status = true;
			}
		}
		return $status;
	}
	public function getCattleDetailsBypId($proposalId) 
	{
		$key = $this->config->config['cKey']."_cattles_by_proposarId_".$proposalId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select l.*,lhp.cqrId from cattles l, cattle_has_proposal lhp where l.cId=lhp.cId and proposalId=".$proposalId);
			// echo "select l.*,lhp.cqrId from cattles l, cattle_has_proposal lhp where l.cId=lhp.cId and proposalId=".$proposalId;
			foreach($query->result() as $row)
			{
				foreach($row as $clumn_name=>$clumn_value)
				{
					$arry[$clumn_name] = $clumn_value;
				}
			}
			// if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
	function getQuotes($req) 
	{
		$arry= array();
		$query =  $this->db->query("select sumInsured,animalType,breed,gender,age,baseproductId,risk,premium,insurerName,insurerLogo from plansintegrated where sumInsured=".$this->db->escape($req['sumInsured'])." and animalType=".$this->db->escape($req['animalType'])." and breed=".$this->db->escape($req['breed'])." and gender=".$this->db->escape($req['gender'])." and age=".$this->db->escape($req['age'])."");
		// echo "select sumInsured,animalType,breed,gender,age,baseproductId,risk,premium,insurerName,insurerLogo from plansintegrated where sumInsured=".$this->db->escape($req['sumInsured'])." and animalType=".$this->db->escape($req['animalType'])." and breed=".$this->db->escape($req['breed'])." and gender=".$this->db->escape($req['gender'])." and age=".$this->db->escape($req['age'])."";
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
	function getMedicalqns($bseprdtId) 
	{
		$key = $this->config->config['cKey']."_cattle_mqns_bpd".$bseprdtId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select medicalquestions_Id,productId,qnSetCode,qnCode,qnDescription,qnType,defaultValue,isKnockoutQn,acceptedResponses,knockoutResponses,dummyOne,dummyTwo,dummyThree,dummyFour,dummyFive from medicalquestions where productId=".$bseprdtId);
			// echo "select medicalquestions_Id,productId,qnSetCode,qnCode,qnDescription,qnType,defaultValue,isKnockoutQn,acceptedResponses,knockoutResponses,dummyOne,dummyTwo,dummyThree,dummyFour,dummyFive from medicalquestions where productId=".$bseprdtId;
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
	function getAnimalqns($bseprdtId) 
	{
		$key = $this->config->config['cKey']."_cattle_aadqn_bpd".$bseprdtId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query =  $this->db->query("select animalquestions_Id,productId,qnSetCode,qnCode,qnDescription,qnType,defaultValue,isKnockoutQn,acceptedResponses,knockoutResponses,dummyOne,dummyTwo,dummyThree,dummyFour,dummyFive from animalquestions where productId=".$bseprdtId);
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
	function insertCattleMedicalQns($req) 
	{
		$chmqId = 0;
		$proposalId = $req['proposalId'];
		$favexits = $this->db->query("select chmqId from cattle_has_medicalquestions where proposalId=".$this->db->escape($req['proposalId'])." and mqId=".$this->db->escape($req['mqId'])."");
		// echo "select chmqId from cattle_has_medicalquestions where proposalId=".$this->db->escape($req['proposalId'])." and chmId=".$this->db->escape($req['chmId'])." and mqId=".$this->db->escape($req['mqId'])."<br/>";
		if($favexits->num_rows() <= 0)
		{
			// echo $favexits->num_rows();
			// echo "<br/>";
			$query =  $this->db->query("INSERT INTO cattle_has_medicalquestions(proposalId,mqId,ans,questionSetCode,questionCode) VALUES (".$this->db->escape($req['proposalId']).",".$this->db->escape($req['mqId']).",".$this->db->escape($req['ans']).",".$this->db->escape($req['questionSetCode']).",".$this->db->escape($req['questionCode']).")");
			if($this->db->affected_rows()>0)
			{
				$chmqId = $this->db->insert_id();
				$this->mc->memcached->delete($this->config->config['cKey']."_cattles");
				$this->mc->memcached->delete($this->config->config['cKey']."_cattles_by_proposarId_".$proposalId);
				$this->mc->memcached->delete($this->config->config['cKey']."_cattlemqns_by_proposarId_".$proposalId);
				$this->mc->memcached->delete($this->config->config['cKey']."_cattlemembers_by_proposarId_".$proposalId);
			}
		}
		else
		{
			$set = "";
			if(!empty($req["mqId"])) $set .= "mqId=".$this->db->escape($req["mqId"]).",";
			if(!empty($req["ans"])) $set .= "ans=".$this->db->escape($req["ans"]).",";
			if(!empty($req["questionSetCode"])) $set .= "questionSetCode=".$this->db->escape($req["questionSetCode"]).",";
			if(!empty($req["questionCode"])) $set .= "questionCode=".$this->db->escape($req["questionCode"]).",";
			if(!empty($set))
			{
				foreach($favexits->result() as $row)
				{
					$chmqId = $row->chmqId;
				}
				$setValue = rtrim($set,',');
				$query =  $this->db->query("update cattle_has_medicalquestions set ".$setValue." where chmqId = ".$chmqId);
				if($this->db->affected_rows()>0)
				{
					$this->mc->memcached->delete($this->config->config['cKey']."_cattles");
					$this->mc->memcached->delete($this->config->config['cKey']."_cattles_by_proposarId_".$proposalId);
					$this->mc->memcached->delete($this->config->config['cKey']."_cattlemembers_by_proposarId_".$proposalId);
					$this->mc->memcached->delete($this->config->config['cKey']."_cattlemqns_by_proposarId_".$proposalId);
				}
			}
		}
		return $chmqId;
	}
	function getMedicalQnsBypId($proposalId) 
	{
		$key = $this->config->config['cKey']."_cattlemqns_by_proposarId_".$proposalId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from cattle_has_medicalquestions lhm where lhm.proposalId=".$proposalId);
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
	function insertCattleVdMedicalQns($req) 
	{
		$chmqvId = 0;
		$proposalId = $req['proposalId'];
		$favexits = $this->db->query("select chmqvId from cattle_has_vdquestions where proposalId=".$this->db->escape($req['proposalId'])." and aqId=".$this->db->escape($req['aqId'])."");
		// echo "select chmqId from cattle_has_medicalquestions where proposalId=".$this->db->escape($req['proposalId'])." and chmId=".$this->db->escape($req['chmId'])." and mqId=".$this->db->escape($req['mqId'])."<br/>";
		if($favexits->num_rows() <= 0)
		{
			// echo $favexits->num_rows();
			// echo "<br/>";
			$query =  $this->db->query("INSERT INTO cattle_has_vdquestions(proposalId,aqId,ans,questionSetCode,questionCode) VALUES (".$this->db->escape($req['proposalId']).",".$this->db->escape($req['aqId']).",".$this->db->escape($req['ans']).",".$this->db->escape($req['questionSetCode']).",".$this->db->escape($req['questionCode']).")");
			if($this->db->affected_rows()>0)
			{
				$chmqvId = $this->db->insert_id();
				$this->mc->memcached->delete($this->config->config['cKey']."_cattles");
				$this->mc->memcached->delete($this->config->config['cKey']."_cattles_by_proposarId_".$proposalId);
				$this->mc->memcached->delete($this->config->config['cKey']."_cattlevdmqns_by_proposarId_".$proposalId);
			}
		}
		else
		{
			$set = "";
			if(!empty($req["aqId"])) $set .= "aqId=".$this->db->escape($req["aqId"]).",";
			if(!empty($req["ans"])) $set .= "ans=".$this->db->escape($req["ans"]).",";
			if(!empty($req["questionSetCode"])) $set .= "questionSetCode=".$this->db->escape($req["questionSetCode"]).",";
			if(!empty($req["questionCode"])) $set .= "questionCode=".$this->db->escape($req["questionCode"]).",";
			if(!empty($set))
			{
				foreach($favexits->result() as $row)
				{
					$chmqvId = $row->chmqvId;
				}
				$setValue = rtrim($set,',');
				$query =  $this->db->query("update cattle_has_vdquestions set ".$setValue." where chmqvId = ".$chmqvId);
				if($this->db->affected_rows()>0)
				{
					$this->mc->memcached->delete($this->config->config['cKey']."_cattles");
					$this->mc->memcached->delete($this->config->config['cKey']."_cattles_by_proposarId_".$proposalId);
					$this->mc->memcached->delete($this->config->config['cKey']."_cattlevdmqns_by_proposarId_".$proposalId);
				}
			}
		}
		return $chmqvId;
	}
	function getVdMedicalQnsBypId($proposalId) 
	{
		$key = $this->config->config['cKey']."_cattlevdmqns_by_proposarId_".$proposalId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select * from cattle_has_vdquestions lhm where lhm.proposalId=".$proposalId);
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
	function getSuminsureds() 
	{
		$key = $this->config->config['cKey']."_suminsureds";
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select siName from suminsureds");
			foreach($query->result() as $row)
			{
				// $list= array();
                foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
                // $arry[] = $list;
			}
			if($arry)$this->mc->memcached->save($key,$arry,0,0);
		}
		return $arry;
	}
} 
?> 