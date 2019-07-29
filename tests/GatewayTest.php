<?php

namespace Cognito\Omnipay3ZipPay;

use Omnipay\Tests\GatewayTestCase;

/**
 * @property Gateway gateway
 */
class GatewayTest extends GatewayTestCase {
	public function setUp() {
		parent::setUp();

		$this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
	}

	public function testPurchase() {
		$request = $this->gateway->purchase(array(
			'amount' => '10.00',
		));

		$this->assertInstanceOf('Cognito\Omnipay3ZipPay\Message\PurchaseRequest', $request);
		$this->assertSame('10.00', $request->getAmount());
	}

	public function testDummyOrder() {
		$gateway = $this->gateway;

		// Initialise the gateway
		$gateway->initialize(array(
			'apiKey' => 'test',
			'testMode' => true,
		));
		$gateway->setShopper([
				'first_name' => 'Josh',
				'last_name' => 'Surname',
				'email' => 'josh@mailinator.com',
				'billing_address' => [
					'line1' => '15 Some Street',
					'city' => 'Kallangur',
					'postal_code' => '4503',
					'state' => 'Queensland',
					'country' => 'AU',
					'first_name' => 'Josh',
					'last_name' => 'Surname',
				],
			]);
		$gateway->setOrder([
				'amount' => 12.00,
				'currency' => 'AUD',
				'shipping' => [
					'pickup' => false,
					'address' => [
						'line1' => '15 Some Street',
						'city' => 'Kallangur',
						'postal_code' => '4503',
						'state' => 'Queensland',
						'country' => 'AU',
						'first_name' => 'Josh',
						'last_name' => 'Surname',
					],
				],
				'items' => [
					[
						'name' => 'Item 1',
						'amount' => 6.00,
						'quantity' => 2,
						'type' => 'sku',
					],
				],
			]);
		$gateway->setConfig([
				'redirect_uri' => 'https://testsite.local/cms/blah', // https://testsite.local/cms/blah?result=approved&checkoutId=co_dPj4QaaEK4AqgGLLmHpdp3&customerId=cus_lXVYIeC7V4zVDie5BrKDT2
			]);
		$transaction = $gateway->purchase();
		$resp = $transaction->send();
		$this->assertNotEmpty($resp->getRedirectUrl());
		$this->assertTrue($resp->isRedirect());
		//$resp->redirect();
	}
}
