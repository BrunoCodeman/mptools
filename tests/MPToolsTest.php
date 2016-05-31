<?php
require_once './MPTools/MPTools.php';

class MPToolsTest extends PHPUnit_Framework_TestCase {
	private $test_data_path;
	private $test_payment_data_path;
	public function setUp() {
		$this->test_data_path = getcwd() . "/tests/test_data.json";
		$this->test_payment_data_path = getcwd() . "/tests/payment_data.json";
	}

	public function testMustCreateCustomPayment() {
		$country_config = json_decode(file_get_contents($this->test_data_path));
		$payment_config = json_decode(file_get_contents($this->test_payment_data_path));
		$preference = $payment_config['standard_payment'];
		print_r('Opening ' . $this->test_data_path);
		$mptools = new MPTools($country_config['MLA']['client_id'], $country_config['MLA']['client_secret']);
		$payment_result = $mptools->createStandardPayment($preference, true);
		$this->assertNotNull($payment_result);

	}

	public function tearDown() {}

}
