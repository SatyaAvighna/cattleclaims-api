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
        //cattle,tagnumber,breed,gender,age,sumInsured,earTag,lSidePath,rSidePath,vPath,createdBy
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
	public function getLeadDetailsBypId($proposalId) 
	{
		$key = $this->config->config['cKey']."_cattles_by_proposarId_".$proposalId;
		$arry = $this->mc->memcached->get($key);
		if(!$arry)
		{
			$arry= array();
			$query = $this->db->query("select l.*,lhp.cqrId from cattles l, cattle_has_proposal lhp where l.cId=lhp.cId and proposalId=".$proposalId);
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
		$query =  $this->db->query("select sumInsured,animalType,breed,gender,age,baseproductId,risk,premium from plansintegrated where sumInsured=".$this->db->escape($req['sumInsured'])." and animalType=".$this->db->escape($req['animalType'])." and breed=".$this->db->escape($req['breed'])." and gender=".$this->db->escape($req['gender'])." and age=".$this->db->escape($req['age'])."");
		// echo "select sumInsured,animalType,breed,gender,age,baseproductId,risk,premium from plansintegrated where sumInsured=".$this->db->escape($req['sumInsured'])." and animalType=".$this->db->escape($req['animalType'])." and breed=".$this->db->escape($req['breed'])." and gender=".$this->db->escape($req['gender'])." and age=".$this->db->escape($req['age'])."";
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
				foreach($row as $column_name=>$column_value)
				{
					$arry[$column_name] = $column_value;
				}
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
			$query =  $this->db->query("select medicalquestions_Id,productId,qnSetCode,qnCode,qnDescription,qnType,defaultValue,isKnockoutQn,acceptedResponses,knockoutResponses,dummyOne,dummyTwo,dummyThree,dummyFour,dummyFive from animalquestions where productId=".$bseprdtId);
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
} 
?> 