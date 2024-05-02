<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentgateway extends CI_Controller {

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
		$this->load->model('common');
		$this->load->model('gateway');
	}
	public function index()
	{
		$arry = array();
		// $arry['list'] = $this->common->getPgorders();
		$arry['status'] = "success";
		$arry['message'] = "Paymentgateway retrieved successfully.";	
		echo json_encode($arry);
	}
	public function add()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Order Id is mandatory.";
		$data =$this->input->post();
		$pgoId = 0;
		$arry['enc_val'] = "";		
		$arry['access_code'] = "";	
		$arry['order_id'] = $pgoId;	
        // orderId,corderId,coAmount,coreturnUrl,coCurrency
		if(!empty($data['corderId']))
		{
			$arry['message'] = "Amount is mandatory.";
            if($data['coAmount']!="")
            {
                $arry['message'] = "Return Url is mandatory.";
                if($data['coreturnUrl']!="")
                {
                    $arry['message'] = "Currency is mandatory.";
                    if($data['coCurrency']!="")
                    {
						$arry['message'] = "Something went wrong.";
						$data['orderId'] = "CAP".time();
						$result = $this->gateway->insertpgorderById($data);	
						if($result)
						{
							$arry['status'] = "success";
							$arry['message'] = "Order created successfully.";
							$pgoId = $result;	
							$data1 = array();
							$access_code = "123456";
							$data1['merchant_id'] = "123";
							$data1['amount'] = $data['coAmount'];
							$data1['currenc'] = $data['coCurrency'];
							$data1['order_id'] = $data['orderId'];
							$data1['redirect_url'] = base_url()."Paymentgateway/successpayment";
							$data1['cancel_url'] = base_url()."Paymentgateway/cancelpayment";
							$enc_val = $this->encryptValue($data1);
							$arry['enc_val'] = $enc_val;		
							$arry['access_code'] = $access_code;	
							$arry['order_id'] = $pgoId;	
						}
                    }
                }
            }
		}
		$arry['pgoId'] = $pgoId;		
		echo json_encode($arry);
	}
	public function encryptValue($data)
	{
		$merchant_data='';
		// $working_key = CCA_WORKING_KEY;
		// $access_code = CCA_ACCESS_CODE;
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		foreach ($data as $key => $value){
			$merchant_data.=$key.'='.$value.'&';
		}
		$encval = $this->encryption->encrypt($merchant_data);
		return $encval;
	}
	public function successpayment()
	{
		$data =$this->input->post();		
		echo json_encode($data);
	}
	public function cancelpayment()
	{
		$data =$this->input->post();
		echo json_encode($data);
	}
	public function retrive()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Id is mandatory.";
		$data =$this->input->post();
		if(!empty($data['pgoId']))
		{
			$lists = $this->gateway->getpgorderById($data['pgoId']);
			$arry['status'] = "success";
			$arry['message'] ="Order retrieved successfully.";	
		}
		$arry["detail"] = $lists;
		echo json_encode($arry);
	}
	public function update()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		//$data['sId'] =  $this->encryption->decrypt($data['sId']);
		if(!empty($data['pgoId']))
		{
            if(!empty($data['corderId']))
		{
			$arry['message'] = "Amount is mandatory.";
            if($data['coAmount']!="")
            {
                $arry['message'] = "Return Url is mandatory.";
                if($data['coreturnUrl']!="")
                {
                    $arry['message'] = "Currency is mandatory.";
                    if($data['coCurrency']!="")
                    {
						$arry['message'] = "Something went wrong.";
						$result = $this->gateway->updatepgorderById($data);	
						if($result)
						{
							$arry['status'] = "success";
							$arry['message'] = "Order updated successfully.";
							$pgoId = $result;	
							$data1 = array();
							$access_code = "123456";
							$data1['merchant_id'] = "123";
							$data1['amount'] = $data['coAmount'];
							$data1['currenc'] = $data['coCurrency'];
							$data1['order_id'] = $data['orderId'];
							$data1['redirect_url'] = base_url()."Paymentgateway/successpayment";
							$data1['cancel_url'] = base_url()."Paymentgateway/cancelpayment";
							$enc_val = $this->encryptValue($data1);
							$arry['enc_val'] = $enc_val;		
							$arry['access_code'] = $access_code;	
							$arry['order_id'] = $pgoId;	
						}
                    }
                }
            }
		}
		}
		echo json_encode($arry);
	}
	
	public function delete()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		// $data['sId'] =  $this->encryption->decrypt($data['sId']);
		if(!empty($data['pgoId']))
		{	
			$arry['message'] = "Something went wrong.";	
			$result = $this->gateway->deletepgorderById($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Order deleted successfully.";	
			}
		}
		echo json_encode($arry);
	}
	public function all()
	{
		$arry = array();
		$arry['list'] = $this->common->getPgorders();
		$arry['status'] = "success";
		$arry['message'] = "Order retrieved successfully.";	
		echo json_encode($arry);
	}
	public function updatestatus()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Id is mandatory.";
		$data =$this->input->post();
		$this->encryption->initialize(array('driver' => 'openssl','cipher' => 'aes-256','mode' => 'ctr'));
		// $data['sId'] =  $this->encryption->decrypt($data['sId']);
		if(!empty($data['pgorderId']))
		{
			$result = $this->gateway->updatepgStatusByorderId($data);	
			if($result)
			{
				$arry['status'] = "success";
				$arry['message'] = "Order updated successfully.";	
			}
		}
		echo json_encode($arry);
	}
}
