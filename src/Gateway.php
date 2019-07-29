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
			'environment' => 'production',
			'platform' => 'Omnipay',
			'shopper' => [],
			'order' => [],
			'config' => [],
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
		$environment = $value ? 'sandbox' : 'production';
		return $this->setParameter('environment', $environment);
	}

	public function getTestMode() {
		return $this->getParameter('environment') == 'sandbox';
	}

	public function setEnvironment($value) {
		return $this->setParameter('environment', $value);
	}

	public function getEnvironment() {
		return $this->getParameter('environment');
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

	public function setConfig($value) {
		return $this->setParameter('config', $value);
	}

	public function getConfig() {
		return $this->getParameter('config');
	}

	public function purchase(array $parameters = array()) {
		return $this->createRequest('\Cognito\Omnipay3ZipPay\Message\PurchaseRequest', $parameters);
	}

	public function completePurchase(array $parameters = array()) {
		return $this->createRequest('\Cognito\Omnipay3ZipPay\Message\CompletePurchaseRequest', $parameters);
	}
}
