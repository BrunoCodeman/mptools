<?php
require_once './MPTools/MPTools.php';

class MPToolsTest extends PHPUnit_Framework_TestCase {
	private $test_data_path;

	public function setUp() {
		$this->test_data_path = getcwd() . "/tests/test_data.json";
	}

	public function testMustCreateCustomPayment() {
		$country_config = json_decode(file_get_contents($this->test_data_path)) or die("Unable to open file " . $this->test_data_path);

	}

	public function tearDown() {}

}
