<?php

class MPTools implements IMPTools {
	private $mp;
	private $config;
	private $accepted_status = array(201, 200);
	function __construct() {
		$this->baseDir = getcwd() . "//MPTools//";
		$this->config = json_decode(file_get_contents($this->baseDir . "mp_config.json"));
		$this->status_messages = json_decode(file_get_contents($this->baseDir . "status_messages.json"));

		$num_args = func_num_args();
		if ($num_args == 2) {
			$this->mp = new MP(func_get_arg(0), func_get_arg(1));
		}elseif($num_args == 1) {
			$this->mp = new MP(func_get_args(0));
		} else {
			throw new Exception("Error creating MPTools: Invalid credentials", 1);
		}
	}

	public function createStandardPayment($preference, $sandbox) {
		$after_process = array('status' => 0, 'message' => "");
		if (strpos($preference->payer->email, '@testuser.com') === false) {
			$preference->sponsor_id = $this->config['sponsors']['country'];
		}
		try
		{
			$this->mp->sandbox_mode($sandbox);
			$preferenceResult = $this->mp->create_preference($preference);
			$after_process['status'] = $preferenceResult['status'];
			$after_process['message'] = $this->getMessage($preferenceResult['status']);
			return $after_process;
		} catch (Exception $e) {
			$after_process['status'] = 500;
			$after_process['message'] = $e->getMessage();
			return $after_process;
		}
	}

	public function createCustomPayment($payment) {
		try {
			if (strpos($preference['payer']['email'], '@testuser.com') === false) {
				$preference["sponsor_id"] = $this->config['country'];
			}

			$payment_json = json_decode($payment_data);
			$accepted_status = array('approved', "in_process");
			$payment_response = $this->mp->create_payment($payment_json);
			$json_response = array('status' => null, 'message' => null);

			if (in_array($payment_response['response']['status'], $accepted_status)) {
				$json_response['status'] = $payment_response['response']['status'];
			} else {
				$json_response['status'] = $payment_response['response']['status_detail'];
			}
			return $json_response;
		} catch (Exception $e) {
			echo json_encode(array("status" => $e->getCode(), "message" => $e->getMessage()));
		}}
	public function createTicketPayment($payment) {}
	public function getPaymentDetails($paymentId) {}
	public function createCustomerCard($card) {}
	public function getCustomerCards($userId) {}
	public function createCustomer($user) {}
	public function getCustomer($userId) {}
	public function getCustomerID($userEmail) {}
	public function getPaymentMethods($country) {}
	public function getMessage($status) {}
	public function mapObject($jsonOrderObject)
	{
		$mapper = json_decode(file_get_contents($this->baseDir . "dataMapper.json"));
	}

}