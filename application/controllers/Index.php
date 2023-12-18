<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed
class Index extends CI_Controller {

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
		$this->load->library('session');

	}
	public function index()
	{
		echo "Welcome to index";
	}
	public function createtable()
	{
		$arry = array();
		$arry['status'] = 'error';
		$arry['message'] = "Table Name is mandatory.";
		$data =$this->input->get();
		if(!empty($data['tableName']))
		{
			$arry['message'] = "Feilds are mandatory.";
			$fields = json_decode($data['fields']);
			//
			print_r($data['fields']);
			if(!empty($fields))
			{
				$arry['status'] = 'success';
				$arry['message'] = "Table Created successfully.";	
				$result = $this->tables->createTable($data);	
				if($result)
				{
					$arry['status'] = 'success';
					$arry['message'] = "Table Created successfully.";	
				}
			}
		}
		echo json_encode($arry);
	}
}
