<?php 

public class MPTools implements IMPTools
{
	private $mp;
	private $config;
	private $accepted_status = array(201, 200);
	function __construct() 
	{
		$this->config = json_decode(file_get_contents("mp_config.json"));

		$num_args = func_num_args();
		if ($num_args == 2) {
			$this->mp = new MP(func_get_args(0), func_get_args(1));
			return;
		}

		if ($num_args == 1) {
			$this->mp = new MP(func_get_args(0));
		}
		else
		{	
			throw new Exception("Error creating MPTools: Invalid credentials", 1);
		}
	}

	public function createStandardPayment(array $preference, $country)
	{
		$after_process = array('status' => 0, 'message' => "" );
		if (strpos($preference['payer']['email'], '@testuser.com') === false) {
			$preference["sponsor_id"] = $this->config['sponsors'][$country];
		}
		try 
		{
			$preferenceResult = $mp->create_preference($preference);	
			$after_process['status'] = $preferenceResult['status'];
			$after_process['message'] = $this->getMessage($preferenceResult['status']);
		} 
		catch (Exception $e) 
		{
			$after_process['status'] = 500;
			$after_process['message'] = $e->getMessage();
		}
		finally
		{
			return $after_process;
		}
	}
	public function createCustomPayment(array $payment);
	public function createTicketPayment(array $payment);
	public function getPaymentDetails($paymentId);
	public function createCustomerCard(array $card);
	public function getCustomerCards($userId);
	public function createCustomer(array $user);
	public function getCustomer($userId);
	public function getCustomerID($userEmail);
	public function getPaymentMethods($country);
	public function getMessage($status);
}