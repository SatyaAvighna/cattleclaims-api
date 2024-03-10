<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masters extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		// $this->load->model('common');
		$this->load->model('master');
		$this->load->model('tables');
		$this->load->dbforge();
	}
	public function index()
	{
		$arry = array();
		$masters = $this->master->getmasters();
		$arry['status'] = "success";
		$arry['message'] = "Master retrieved successfully.";	
		$arry['list'] = $masters;
		echo json_encode($arry);
	}
	public function list()
	{
		$arry = array();
		$masters = $this->master->getmasters();
		$arry['status'] = "success";
		$arry['message'] = "Master retrieved successfully.";	
		$arry['list'] = $masters;
		echo json_encode($arry);
	}
	public function add()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Master Name is mandatory.";
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		$data['sId'] =  $this->encryption->decrypt($data['sId']);
		if(!empty($data['tableName']))
		{
			$arry['message'] = "Fields are mandatory.";
			$fields = $data['fields'];
			if(!empty($fields))
			{
				//print_r($fields);
				// $this->replace_wihtTavbleName_JS($data);
				$data['tableName'] = strtolower($data['tableName']);
				$arry['message'] = "Table Already Exists.";	
				$result = $this->master->insertmasterById($data);	
				// $result = true;
				if($result)
				{
					//$data['tableName'] = strtolower($data['tableName']);
					$result1 = $this->tables->createTable($data['tableName'],$fields);	
					// $result1 = true;
					if($result1)
					{
						$arry['status'] = "success";
						$arry['message'] = "Table created successfully.";
						$this->create_depencies($data,$result1);
						$this->replace_wihtTavbleName_JS($data);
					}
				}
			}
			
		}
		echo json_encode($arry);
	}
	public function retrive()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Table id is mandatory.";
		if(!empty($data['mId']))
		{
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			$lists = $this->master->getmastersById($data);	
			$arry['status'] = "success";
			$arry['message'] = "Table retrieved successfully.";	
		}
		$arry["detail"] = $lists;
		echo json_encode($arry);
	}
	public function update()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Table id is mandatory.";
		if(!empty($data['mId']))
		{
			$arry['message'] = "Something went wrong.";	
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			$result = $this->master->updatemastersById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Table updated successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function delete()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		$arry['message'] = "Table id is mandatory.";
		if(!empty($data['mId']))
		{
			$arry['message'] = "Something went wrong.";	
			$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
			$data['sId'] =  $this->encryption->decrypt($data['sId']);
			$result = $this->master->deletemastersById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Table deleted successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function create_depencies($data,$fields)
	{
		$c_path = APPPATH."controllers/Default_C.php";
		$m_path = APPPATH."models/Default_M.php";
		$JS_path = FCPATH."sample/";
		$c_path_new = APPPATH."controllers/C_".ucfirst($data['tableName']).".php";
		$m_path_new = APPPATH."models/".ucfirst($data['tableName']).".php";
		//echo APPPATH;
		if (!copy($c_path,$c_path_new)) {
			echo "failed to copy $m_path_new...\n";
		}
		if (!copy($m_path, $m_path_new)) {
			echo "failed to copy $m_path_new...\n";
		}
		$this->replace_wihtTavbleName_C("\$tableName",$data['tableName'],$c_path_new);
		$this->replace_wihtTavbleName_C("\$tableNameC",ucfirst($data['tableName']),$c_path_new);
		$this->replace_wihtTavbleName_M("\$tableName",$data['tableName'],$m_path_new,$fields);
	}
	public function replace_wihtTavbleName_C($ostring,$nstring,$fpath)
	{
		$str=file_get_contents($fpath);
		//replace something in the file string - this is a VERY simple example
		$str=str_replace($ostring, $nstring,$str);
		//write the entire string
		file_put_contents($fpath, $str);
		//echo "<pre/>";
		//print_r($this->config->config['cKey']);
	}
	public function replace_wihtTavbleName_M($ostring,$nstring,$fpath,$fields)
	{
		$str=file_get_contents($fpath);
		//replace something in the file string - this is a VERY simple example
		$str1 = str_replace($ostring, $nstring,$str);
		$str2 = str_replace("\$tableId", $nstring."_Id",$str1);
		$colsR = "";
		$flds = "";
		$vlues = "";
		$flds1 = "";
		$vlues1 = "";
		$skp = array($nstring."_Id","createdBy","createdOn");
		$skp1 = array($nstring."_Id","createdOn","status","updatedBy","updatedOn");
		foreach($fields as $key => $value)
		{
			if(!in_array($key,$skp))
			{
				if($value['isedit']) 
				{
					$key1 = $key;
					if(in_array($key,array('updatedBy',"createdBy"))) $key1 ="sId";
					$colsR .='if(!empty($req["'.$key1.'"])) $set .= "'.$key.'=".$this->db->escape($req["'.$key1.'"]).",";';
				}
			}
			if(!in_array($key,$skp1))
			{
				$key1 = $key;
				if(in_array($key,array('updatedBy',"createdBy"))) $key1 ="sId";
				$flds .= $key.",";
				$vlues .= '".$this->db->escape($req["'.$key1.'"]).",';
			}
		}
		$flds1 = rtrim($flds,',');
		$vlues1 = rtrim($vlues,',');
		$str3 = str_replace("\$cols", $colsR,$str2);
		$str4 = str_replace("\$col", $flds1,$str3);
		$str5 = str_replace("\$val", $vlues1,$str4);
		//write the entire string
		file_put_contents($fpath, $str5);
	}
	public function replace_wihtTavbleName_JS($data)
	{
		$js_path = FCPATH."sample";
		$js_path1 = "/var/www/html/cattleclaims/src/Sidebar";
		$c_path_new = APPPATH."controllers/C_".ucfirst($data['tableName']).".php";
		$m_path_new = APPPATH."models/".ucfirst($data['tableName']).".php";
		
		$fpath = $js_path1."/".ucfirst($data['tableName']).".js";
		if (!copy($js_path."/sampleW.js",$fpath)) {
			echo "failed to copy ...\n";
		}
		if (!copy($js_path."/sample.css",$js_path1."/".ucfirst($data['tableName']).".css")) {
			echo "failed to copy ...\n";
		}
		$str = file_get_contents($fpath);
		
		$tableData = $tableContent = $tableData1  = $statV  = $componentDidMount  = $tableClms = $inputFunctions ='';
		$fields = json_decode($data['fields']);
		foreach($fields as $field)
		{
			$tableContent .= $this->getInputType(strtolower($field->inputType),$field);
			$tableContent .= "<br/>";
			$inputFunctions .= $this->getInputJs(strtolower($field->inputType),$field);
			if(strtolower($field->inputType) == "select"){
				$componentDidMount .= "this.".strtolower($field->reftableName)."fetchHandler();\n";
			} 
			$statV .= $this->load->view('react/stateview',$field,true);
			$tableClms .= $this->load->view('react/tableClms',$field,true);
			$tableData .= "formData.append('".$field->fieldName."',this.state.".$field->fieldName.");\n";
			$tableData1 .= "formData.append('".$field->fieldName."',this.state.".$field->fieldName.");\n";
		}
		
		$tableDataContent  = $this->getInputType('table',$fields,$data['tableName']);
		
		$str0 = str_replace('{{ inputFunctions }}', $inputFunctions, $str);
		$str1 = str_replace('{{ tableName }}', ucfirst($data['tableName']),$str0);
		$str10 = str_replace('{{ tableName1 }}', strtolower($data['tableName']),$str1);
		$str2 = str_replace('{{ tableClms }}', $tableClms,$str10);
		$str3 = str_replace('{{ state }}', $statV, $str2);
		$str4 = str_replace('{{ componentDidMount }}', $componentDidMount, $str3);
		$str5 = str_replace('{{ tableData }}', $tableData, $str4);
		$str6 = str_replace('{{ tableContent }}', $tableContent, $str5);
		$str7 = str_replace('{{ tableDataContent }}', $tableDataContent, $str6);
		$str9 = str_replace('{{ tableData1 }}', $tableData1, $str7);
		$str8 = str_replace('{{ formName }}', ucfirst($data['formName']),$str9);
		file_put_contents($fpath, $str8);
		
		$strh = implode("\n", file('/var/www/html/cattleclaims/src/Header/Header.js'));
		$fp1 = fopen('/var/www/html/cattleclaims/src/Header/Header.js', 'w');
		$strh2 = str_replace("/* replceimport */", "import ".ucfirst($data['tableName'])." from '../Sidebar/".ucfirst($data['tableName'])."'; /* replceimport */", $strh);
		$strh1 = str_replace("{/* <-- replaceRoute --> } */}", "<Route path='".strtolower($data['tableName'])."' element={<".ucfirst($data['tableName'])."/>}></Route>{/* <-- replaceRoute --> } */}", $strh2);
		$strh4 = str_replace('{/* <-- replace --> } */}', '{roledata.'.strtolower($data['tableName']).'_view && (<li><Link to="'.strtolower($data['tableName']).'" className="nav-link active collapsed"><div className="nav-link-icon"><span className="bi bi-speedometer2"></span></div>'.ucfirst($data['formName']).'</Link></li>)} {/* <-- replace --> } */}', $strh1);
		fwrite($fp1, $strh4, strlen($strh4));
		fclose($fp1);

		// $str3 = implode("\n", file('/var/www/html/cattleclaims/src/NewProjectOne/Header/Setting.js'));
		// $fp2 = fopen('/var/www/html/cattleclaims/src/NewProjectOne/Header/Setting.js', 'w');
		// $str4 = str_replace('{/* <-- replace --> } */}', '<li><Link to="'.ucfirst($data['tableName']).'">'.ucfirst($data['tableName']).'</Link></li>{/* <-- replace --> } */}', $str3);
		// fwrite($fp2, $str4, strlen($str4));
		// fclose($fp2);
	}
	public function getInputJs($type,$field,$tableName="")
	{
		switch ($type) {
			case 'text':
				$return = $this->load->view('react/js/textbox',$field,true);
				//echo $return;
				break;
			case 'password':
				$return = $this->load->view('react/js/password',$field,true);
				//echo $return;
				break;
			case 'date':
				$return = $this->load->view('react/js/date',$field,true);
				//echo $return;
				break;
			case 'file':
				$return = $this->load->view('react/js/file',$field,true);
				//echo $return;
				break;
			case 'mail':
				$return = $this->load->view('react/js/mail',$field,true);
				//echo $return;
				break;
			case 'select':
				$return = $this->load->view('react/js/select',$field,true);
				//echo $return;
				break;
			case 'number':
				$return = $this->load->view('react/js/number',$field,true);
				//echo $return;
				break;
			case 'table':
					$data = array();
					// $data['fieldNames'] = $this->master->getColumnNamesFromTable($tableName);
					$data['tableName'] = $tableName;
					$return = $this->load->view('react/js/table',$data,true);
					//echo $return;
					break;
			default:
				$return = $this->load->view('react/js/textbox',$field,true);
				break;
		}
		return $return;
	}
	public function getInputType($type,$field,$tableName="")
	{
		switch ($type) {
			case 'text':
				$return = $this->load->view('react/textbox',$field,true);
				//echo $return;
				break;
			case 'password':
				$return = $this->load->view('react/password',$field,true);
				//echo $return;
				break;
			case 'date':
				$return = $this->load->view('react/date',$field,true);
				//echo $return;
				break;
			case 'file':
				$return = $this->load->view('react/file',$field,true);
				//echo $return;
				break;
			case 'mail':
				$return = $this->load->view('react/mail',$field,true);
				//echo $return;
				break;
			case 'select':
				$return = $this->load->view('react/select',$field,true);
				//echo $return;
				break;
			case 'number':
				$return = $this->load->view('react/number',$field,true);
				//echo $return;
				break;
			case 'table':
					$data = array();
					// $data['fieldNames'] = $this->master->getColumnNamesFromTable($tableName);
					$data['tableName'] = $tableName;
					$return = $this->load->view('react/table',$data,true);
					//echo $return;
					break;
			default:
				$return = $this->load->view('react/textbox',$field,true);
				break;
		}
		return $return;
	}
	public function getTables()
	{
		$arry = array();
		$arry['status'] = "success";
		$arry['message'] = "Tables retrieved successfully.";
		$arry['tables'] = $this->master->getTableNames();
		echo json_encode($arry);
	}
	public function getColumns()
	{
		$arry = array();
		$arry['status'] = "error";
		$data =$this->input->post();
		// $data =$this->input->get();
		$arry['message'] = "Table Name is mandatory.";
		$arry['columns'] = array();
		if(!empty($data['tableName']))
		{
			$arry['status'] = "success";
			$arry['message'] = "Columns retrieved successfully.";
			$arry['columns'] = $this->master->getColumnNamesFromTable($data['tableName']);
			$arry['columnsWT'] = $this->master->getColumnNamesFromTableWT($data['tableName']);
		}
		echo json_encode($arry);
	}
	public function lots()
	{
		$tables = $this->master->getTableNames();
		foreach($tables as $table)
		{
			// if(!in_array($table,array('masters','mtransactions'))) print_r($table);
			if(!in_array($table,array('masters','mtransactions'))) $this->master->insertLot($table);
		}
	}
	
	public function lotslist()
	{
		$arry = array();
		$masters = $this->master->getlots();
		$arry['status'] = "success";
		$arry['message'] = "Master retrieved successfully.";	
		$arry['list'] = $masters;
		echo json_encode($arry);
	}
	
}
