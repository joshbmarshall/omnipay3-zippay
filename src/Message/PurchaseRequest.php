<?php

namespace Cognito\Omnipay3ZipPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest {
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

	public function getData() {
		return array(
			'shopper' => $this->getShopper(),
			'order' => $this->getOrder(),
			'config' => [
				'redirect_uri' => $this->getReturnUrl(),
			],
		);
	}

	public function send() {
		\zipMoney\Configuration::getDefaultConfiguration()->setApiKey('Authorization', $this->getApiKey());
		\zipMoney\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');
		\zipMoney\Configuration::getDefaultConfiguration()->setEnvironment($this->getEnvironment());
		\zipMoney\Configuration::getDefaultConfiguration()->setPlatform($this->getPlatform());
		\zipMoney\Configuration::getDefaultConfiguration()->setRetryInterval(5);

		$api_instance = new \zipMoney\Api\CheckoutsApi();
		$body = new \zipMoney\Model\CreateCheckoutRequest($this->getData());

		try {
			$checkout = $api_instance->checkoutsCreate($body);
			$this->response = new PurchaseResponse($this, $this->getData());
			$this->response->setRedirectURL($checkout->getUri());
			return $this->response;
		} catch (Exception $e) {
			echo 'Exception when calling ChargesApi->checkoutsCreate: ', $e->getMessage(), PHP_EOL;
		}
	}

	public function sendData($data) {
	}
}
