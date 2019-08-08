<?php

namespace Cognito\Omnipay3ZipPay\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse {
	public function isSuccessful() {
		return $this->getRequest()->getOrderSuccess();
	}

	public function getMessage() {
		return '';
	}

	public function getCode() {
		return '';
	}

	public function getTransactionReference() {
		return $this->getRequest()->getReceiptNumber();
	}
}
