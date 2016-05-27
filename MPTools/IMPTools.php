<?php

interface IMPTools {
	public function createPaymentStandard(array $preference, $sandbox);
	public function createPaymentCustom(array $payment);
	public function getPaymentDetails($paymentId);
	public function createCustomerCard(array $card);
	public function getCustomerCards($userId);
	public function createCustomer(array $user);
	public function getCustomer($userId);
	public function getCustomerID($userEmail);
	public function getPaymentMethods($country);
	public function getMessage($status);

}