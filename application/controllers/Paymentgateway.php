<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// use Exception;
require realpath(FCPATH .  '/vendor/autoload.php'); # Required while running it as standalone, not required while integrating into existing project
// require_once FCPATH . 'pg/init.php';
use Juspay\JuspayEnvironment;
use Juspay\Model\JuspayJWT;
use Juspay\RequestOptions;
use Juspay\Model\OrderSession;
use Juspay\Model\Order;
use Juspay\Exception\JuspayException;

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
	public function initPay()
	{
		$config = '{"MERCHANT_ID":"SG393","PRIVATE_KEY_PATH":"privateKey.pem","PUBLIC_KEY_PATH":"key_9328c4d23a80499fb86e26cec53d9d5e.pem","KEY_UUID":"key_9328c4d23a80499fb86e26cec53d9d5e","PAYMENT_PAGE_CLIENT_ID":"hdfcmaster"}';
		// $config = file_get_contents(FCPATH."/pg/config.json");
		$config = json_decode($config, true);

		// block:start:read-keys-from-file
		$privateKey = array_key_exists("PRIVATE_KEY", $config) ? $config["PRIVATE_KEY"] : file_get_contents(FCPATH."/pg/".$config["PRIVATE_KEY_PATH"]);
		$publicKey =  array_key_exists("PUBLIC_KEY", $config) ? $config["PUBLIC_KEY"] : file_get_contents(FCPATH."/pg/".$config["PUBLIC_KEY_PATH"]);
		// block:end:read-keys-from-file

		if ($privateKey == false || $publicKey == false) {
			http_response_code(500);
			$response = $privateKey == false ? array("message" => "private key file not found") : array("message" => "public key file not found");
			echo json_encode($response);
			if ($privateKey == false) {
				error_log("private key file not found");
				throw new Exception ("private key file not found");
			} else {
				error_log("public key file not found");
				throw new Exception ("public key file not found");
			}
		}
		JuspayEnvironment::init()
		->withBaseUrl("https://smartgatewayuat.hdfcbank.com")
		->withMerchantId($config["MERCHANT_ID"])
		->withJuspayJWT(new JuspayJWT($config["KEY_UUID"], $publicKey, $privateKey));
		return $config;
	}

	public function index()
	{
		$this->load->view("pg");
	}
	public function pay()
	{
		$config = $this->initPay();
		$inputJSON = file_get_contents('php://input');
		$input = json_decode($inputJSON, true);
		header('Content-Type: application/json');
		$orderId = uniqid();
		$amount = mt_rand(1,100);
		try {
			$params = array();
			$params['amount'] = $amount;
			$params['currency'] = "INR";
			$params['order_id'] = $orderId;
			$params["merchant_id"] = $config["MERCHANT_ID"]; # Add merchant id
			$params['customer_id'] = "testing-customer-one";
			$params['payment_page_client_id'] = $config["PAYMENT_PAGE_CLIENT_ID"];
			$params['action'] = "paymentPage";
			$params['return_url'] = site_url('paymentgateway/handleJuspayResponse');
			$requestOption = new RequestOptions();
			$requestOption->withCustomerId("testing-customer-one");
			$session = OrderSession::create($params, $requestOption);
			if ($session->status == "NEW") {
				$response = array("orderId" => $session->orderId, "id" => $session->id, "status" => $session->status, "paymentLinks" =>  $session->paymentLinks, "sdkPayload" => $session->sdkPayload );
			} else {
				http_response_code(500);
				$response = array("message" => "session status: " . $session->status);
			}
		} catch ( JuspayException $e ) {
			http_response_code($e->getHttpResponseCode());
			$response = array("message" => $e->getErrorMessage());
			error_log($e->getErrorMessage());
		}
		echo json_encode($response);
	}
	public function buy()
	{
		$arry = array();
		$arry['status'] = "error";
		$arry['message'] = "Order Id is mandatory.";
		$data =$this->input->post();
		if(empty($data)) $data =$this->input->get();
		// $data = $_REQUEST;
		$response = array();
		$pgoId = 0;
        // orderId,corderId,coAmount,coreturnUrl,coCurrency
		if(!empty($data['corderId']))
		{
			$arry['message'] = "Amount is mandatory.";
            if($data['coAmount']!="")
            {
                // $arry['message'] = "Return Url is mandatory.";
                // if($data['coreturnUrl']!="")
                // {
                //     $arry['message'] = "Currency is mandatory.";
                //     if($data['coCurrency']!="")
                //     {
						$data['coCurrency']="";
						$data['coreturnUrl']="";
						$arry['message'] = "Order Id already exists.";
						$data['orderId'] = "CAP".time();
						$result = $this->gateway->insertpgorderById($data);	
						if($result)
						{
							// $arry['status'] = "success";
							$arry['message'] = "Order created successfully.";
							$pgoId = $result;	
							// $data1 = array();
							// $access_code = "123456";
							// $data1['merchant_id'] = "123";
							// $data1['amount'] = $data['coAmount'];
							// $data1['currenc'] = $data['coCurrency'];
							// $data1['order_id'] = $data['orderId'];
							// $data1['redirect_url'] = base_url()."Paymentgateway/successpayment";
							// $data1['cancel_url'] = base_url()."Paymentgateway/cancelpayment";
							// $enc_val = $this->encryptValue($data1);
							// $arry['enc_val'] = $enc_val;		
							// $arry['access_code'] = $access_code;	
							// $arry['order_id'] = $pgoId;	
							$config = $this->initPay();
							$orderId = $data['orderId'];
							$amount = $data['coAmount'];
							try {
								$params = array();
								$params['amount'] = $amount;
								$params['currency'] = "INR";
								$params['order_id'] = $orderId;
								$params["merchant_id"] = $config["MERCHANT_ID"]; # Add merchant id
								$params['customer_id'] = "testing-customer-one";
								$params['payment_page_client_id'] = $config["PAYMENT_PAGE_CLIENT_ID"];
								$params['action'] = "paymentPage";
								$params['return_url'] = site_url('paymentgateway/paymentstatus');
								$requestOption = new RequestOptions();
								$requestOption->withCustomerId("testing-customer-one");
								$session = OrderSession::create($params, $requestOption);
								if ($session->status == "NEW") {
									// $response = array("orderId" => $session->orderId, "id" => $session->id, "status" => "success", "paymentLinks" =>  $session->paymentLinks->web, "sdkPayload" => $session->sdkPayload );
									$response = array("orderId" => $session->orderId, "status" => "success", "paymentLink" =>  $session->paymentLinks['web'],"sdkPayload" => $session->sdkPayload);
								} else {
									http_response_code(500);
									$response = array("message" => "session status: " . $session->status);
								}
							} catch ( JuspayException $e ) {
								http_response_code($e->getHttpResponseCode());
								$response = array("message" => $e->getErrorMessage());
								error_log($e->getErrorMessage());
							}
					// 	}
                    // }
                }
            }
		}
		//$arry['pgoId'] = $pgoId;		
		$pg_result = array_merge($arry,$response);
		// print_r($pg_result);
		// $this->load->view("pg",$pg_result);
		echo json_encode($pg_result);
	}
	function getOrder($orderId, $config) {
		try {
		 $params = array();
		 $params ['order_id'] = $orderId;
		 $requestOption = new RequestOptions();
		 $requestOption->withCustomerId("testing-customer-one");
		 return Order::status($params, $requestOption);
		} catch (JuspayException $e) {
		 http_response_code($e->getHttpResponseCode());
		 $response = array("message" => $e->getErrorMessage());
		 error_log($e->getErrorMessage());
		 echo json_encode($response);
		 throw new Exception ($e->getErrorMessage());
		}
	 }
	 
	 function orderStatusMessage ($order) {
		 $response = array("order_id" => $order->orderId);
		 switch ($order->status) {
			 case "CHARGED":
				 $response += ["message" => "order payment done successfully"];
				 break;
			 case "PENDING":
			 case "PENDING_VBV":
				 $response += ["message" => "order payment pending"];
				 break;
			 case "AUTHENTICATION_FAILED":
				 $response += ["message" => "authentication failed"];
				 break;
			 case "AUTHORIZATION_FAILED":
				 $response += ["message"=> "order payment authorization failed"];
				 break;
			 default:
				 $response += ["message"=> "order status " . $order->status];
		 }
		 $response += ["order_status"=> $order->status];
		 return $response;
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
	public function paymentstatus()
	{
		$data =$this->input->post();	
		$config = $this->initPay();
		if (isset($data["order_id"])) {
			try {
				$orderId = $data["order_id"];
				$order = $this->getOrder($orderId, $config);
				$response = $this->orderStatusMessage($order);
			}
			catch (JuspayException $e ) {
				http_response_code(500);
				$response = array("message" => $e->getErrorMessage());
				error_log($e->getMessage());
			}
		} 
		// else if (isset($_GET["order_id"])) { // GET ROUTE
		// 	$orderId = $_GET["order_id"];
		// 	$order = getOrder($orderId, $config);
		// 	$response = orderStatusMessage($order);
		// } 
		else {
			http_response_code(400);
			$response = array('message' => 'order id not found');
		}
		// header('Content-Type: application/json');
		echo json_encode($response);	
		// echo json_encode($response);
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
