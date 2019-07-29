<?php

namespace Cognito\Omnipay3ZipPay\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse {
	public function isSuccessful() {
		$data = $this->getRequest()->getData();
		return isset($data['order_success']) && $data['order_success'] == 1;
	}

	public function getMessage() {
		return '';
	}

	public function getCode() {
		return '';
	}

	public function getTransactionReference() {
		return '';
	}
}
