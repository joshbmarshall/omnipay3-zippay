<?php

namespace Cognito\Omnipay3ZipPay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway {
	public function getName() {
		return 'ZipPay';
	}

	public function getDefaultParameters() {
		return array(
			'apiKey' => 'x',
			'testMode' => false,
			'platform' => 'Omnipay',
			'shopper' => [],
			'order' => [],
		);
	}

	public function setApiKey($apiKey) {
		return $this->setParameter('apiKey', $apiKey);
	}

	public function getApiKey() {
		return $this->getParameter('apiKey');
	}

	public function setPlatform($value) {
		return $this->setParameter('platform', $value);
	}

	public function getPlatform() {
		return $this->getParameter('platform');
	}

	public function setTestMode($value) {
		return $this->setParameter('testMode', $value);
	}

	public function getTestMode() {
		return $this->getParameter('testMode');
	}

	public function setShopper($value) {
		return $this->setParameter('shopper', $value);
	}

	public function getShopper() {
		return $this->getParameter('shopper');
	}

	public function setOrder($value) {
		return $this->setParameter('order', $value);
	}

	public function getOrder() {
		return $this->getParameter('order');
	}

	public function purchase(array $parameters = array()) {
		return $this->createRequest('\Cognito\Omnipay3ZipPay\Message\PurchaseRequest', $parameters);
	}

	public function completePurchase(array $parameters = array()) {
		return $this->createRequest('\Cognito\Omnipay3ZipPay\Message\CompletePurchaseRequest', $parameters);
	}
}
