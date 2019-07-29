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
		return $this->getParameter('environment');
	}

	public function setEnvironment($value) {
		return $this->setParameter('environment', $value);
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

	public function getConfig() {
		return $this->getParameter('config');
	}

	public function setConfig($value) {
		return $this->setParameter('config', $value);
	}

	public function getData() {
		$data = $this->httpRequest->query->all();
		$parameters = $this->getParameters();
		$orderID = $parameters['payment_ref'];

		$query = new Query();
		$queryOrder = new QueryOrder();
		$queryOrder->id = $orderID;

		$query->request->orders[] = $queryOrder;
		$isSuccessful = false;
		try {
			$response = $query->process();
			if ($response->isSuccess()) {
				$array = $response->toArray();
				if (!empty($array['order_statuses'])) {
					foreach ($array['order_statuses'] as $order_status) {
						if ($orderID == $order_status['id'] && $order_status['status'] == 'Captured') {
							$isSuccessful = true;
						}
					}
				}
			}
		} catch (Exception $e) {
		}
		$data['order_success'] = $isSuccessful;
		return $data;
	}

	public function sendData($data) {
		return $this->response = new CompletePurchaseResponse($this, $data);
	}
}
