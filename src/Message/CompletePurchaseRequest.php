<?php

namespace Cognito\Omnipay3ZipPay\Message;

use Omnipay\Common\Message\AbstractRequest;

class CompletePurchaseRequest extends AbstractRequest {
	public function getApiKey() {
		return $this->getParameter('apiKey');
	}

	public function setApiKey($value) {
		return $this->setParameter('apiKey', $value);
	}

	public function getEnvironment() {
		return $this->getParameter('testMode') ? 'sandbox' : 'production';
	}

	public function setEnvironment($value) {
		return $this->setParameter('testMode', $value == 'sandbox');
	}

	public function getTestMode() {
		return $this->getParameter('testMode');
	}

	public function setTestMode($value) {
		return $this->setParameter('testMode', $value);
	}

	public function getPlatform() {
		return $this->getParameter('platform');
	}

	public function setPlatform($value) {
		return $this->setParameter('platform', $value);
	}

	public function setPaymentRef($ref) {
		$this->parameters->set('payment_ref', $ref);
	}

	public function getShopper() {
		return $this->getParameter('shopper');
	}

	public function setShopper($value) {
		return $this->setParameter('shopper', $value);
	}

	public function getOrder() {
		return $this->getParameter('order');
	}

	public function setOrder($value) {
		return $this->setParameter('order', $value);
	}

	public function getOrderSuccess() {
		return $this->getParameter('orderSuccess');
	}

	public function setOrderSuccess($value) {
		return $this->setParameter('orderSuccess', $value);
	}

	public function getReceiptNumber() {
		return $this->getParameter('receiptNumber');
	}

	public function setReceiptNumber($value) {
		return $this->setParameter('receiptNumber', $value);
	}

	public function getData() {
		$data = $this->httpRequest->query->all();
		$parameters = $this->getParameters();

		if ($this->getOrderSuccess()) {
			return $data;
		}

		if (array_key_exists('result', $data)) {
			if ($data['result'] == 'approved') {
				// Now need to capture the payment

				\zipMoney\Configuration::getDefaultConfiguration()->setApiKey('Authorization', $this->getApiKey());
				\zipMoney\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');
				\zipMoney\Configuration::getDefaultConfiguration()->setEnvironment($this->getEnvironment());
				\zipMoney\Configuration::getDefaultConfiguration()->setPlatform($this->getPlatform());
				$api_instance = new \zipMoney\Api\ChargesApi();
				$body = new \zipMoney\Model\CreateChargeRequest([
					'authority' => [
						'type' => 'checkout_id',
						'value' => $data['checkoutId'],
					],
					'amount' => $this->getOrder()['amount'],
					'currency' => 'AUD',
					'capture' => true,
				]);

				try {
					$result = $api_instance->chargesCreate($body);
					$this->setOrderSuccess($result->getState() == 'captured');
					$this->setReceiptNumber($result->getReceiptNumber());
				} catch (Exception $e) {
					echo 'Exception when calling ChargesApi->chargesCreate: ', $e->getMessage(), PHP_EOL;
				}
			}
		}
		return $data;
	}

	public function sendData($data) {
		return $this->response = new CompletePurchaseResponse($this, $data);
	}
}
