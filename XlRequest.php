<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client;

class XlRequest {
	
	private $imei; 
	
	private $msisdn;
	
	private $client;
	
	private $header;
	
	private $session;
	
	private $date;
	
	public function __construct() {
		
		$this->client =new Client(['base_uri' => 'http://myprepaid.xl.co.id']); 
		
		$this->imei = '3030912666'; 
		
		$this->date = date('Ymdhis');
		
		$this->header=array (
			'Host' => 'myprepaid.co.id',
			'Connection' => 'keep-alive',
			'Accept'=> 'application/json, text/plain, */*',
			'User-Agent'=>'Mozilla/5.0 (Linux; Android 4.0.4; Galaxy Nexus Build/IMM76B) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.133 Mobile Safari/535.19',
			'Accept-Language'=> 'en-US,en;q=0.5',
			'Accept-Encoding'=> 'gzip, deflate, br',
			'Content-Type'=> 'application/json'
		);
	}
	public function login($msisdn, $passwd) {
		
	    $payload = array (
	            'Body' => array (
	                    'Header' => array(
	                            'IMEI' => $this->imei,
	                            'ReqID' => substr($this->date, 11),
	                    ),
	                    'LoginV2Rq' => array(
	                        'msisdn' => $msisdn,
	                        'pass' => $passwd,
	                    )
	             ),
	            'onNet' => 'True',
	            'sessionId' => null,
	            'staySigned' => 'False',
	            'platform' => '00',
	            'onNetLogin' => 'YES',
	            'appVersion' => '3.0.1',
	            'sourceName' => 'Android',
	           'sourceVersion'=> '7.1.2'
	   );
	   try {

			$response = $this->client->post('/prepaid/LoginV2Rq',
				[
					'debug' => FALSE,
					'json' => $payload,
					'headers' => $this->header
				]
			);
			$body = json_decode($response->getBody());
			if ($body->responseCode === '00') {
			    return $body->sessionId;
			}
            return false;
		}
		catch (Exception $e) {
			return $e;
		}
	}
	
	public function getPass($msisdn) {
		
		$payload = array (
						'Body'=> array (
							'Header'=> array (
								'ReqID'=>substr($this->date, 10),
								'IMEI'=>$this->imei
								),
							'ForgotPasswordRq'=> array (
								'msisdn'=>$msisdn,
								'username'=>''
							)
						),
						'sessionId'=>null
				);
				
				try {
					$response = $this->client->post('prepaid/ForgotPasswordRq',[
						'debug' => FALSE,
						'json' => $payload,
						'headers' => $this->header
				  ]);
				  $body = json_decode($response->getBody());
				  return $body;
				}
				catch(Exception $e) {}
				
	}
	public function register($msisdn, $serviceID, $session) {
	 
	   $payload = array (
					'Body'=> array (
								'HeaderRequest' => array (
								    'applicationID'=> '3',
								    'applicationSubID'=> '1',
								    'touchpoint' => 'MYXL',
								    'requestID' => substr($this->date, 11),
								    'msisdn' => $msisdn,
								    'serviceID' => $serviceID
					            ),
					            'opPurchase'=> array (
								    'msisdn' => $msisdn,
								    'serviceid' => $serviceID
					             ),
					            'Header' => array (
								    'IMEI'=> $this->imei,
								    'ReqID' => substr($this->date, 10)
					        )
				    ),
				    'sessionId'=> $session,
				    'onNet'=> 'True',
				    'platform'=> '00',
				    'staySigned'=>'Yes',
				    'appVersion'=>'3.0.1',
				    'sourceName'=>'Android',
				    'sourceVersion'=> '7.1.1'
		 );
		try {
			$response = $this->client->post('/prepaid/opPurchase',[
					'debug' => FALSE,
					'json' => $payload,
					'headers' => $this->header
			]);
			$status = json_decode((string) $response->getBody());
			
			if (isset($status->responseCode)) { return $status; }
			
			else {
			    return TRUE;
			}
		}
		catch(Exception $e) {}
	}
	
}
?>
