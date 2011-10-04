<?php

/**
 *
 * 	<STOCK>
 *		<PRODUCT>
 *			<ProductID>4</ProductID>
 *		</PRODUCT>
 *	</STOCK>
**/


class RequestInformationFromMBW extends Object {

	protected static $url = 'https://c2.m2sc.nl/Fashion01/services/BusinessLink.asmx?WSDL';

	/**
	 *access service
	 *
	 **/
	protected static $connection_credentials = array(
		'username'=> 'xxx',
		'password'=> 'xxx',
		//'soap_version'=> SOAP_1_2,
		//'exceptions'=> true,
		'trace'=> 1
		//'cache_wsdl'=>WSDL_CACHE_NONE
	);
		static function set_connection_credentials($a) {self::$connection_credentials = $a;}
		static function add_connection_credential($key, $value) {self::$connection_credentials[$key] = $value;}
		static function set_connection_credential_username($s) {self::$connection_credentials["username"] = $s;}
		static function set_connection_credential_password($s) {self::$connection_credentials["password"] = $s;}

	/**
	 *access database
	 *
	 **/
	protected static $db_credentials = array(
		"sAccessArea" => "xxx",
		"sCustomerNumber" => "xxx",
		"sPassword" => "xxx",
		"sMethod" => "xxx",
	);
		static function set_db_credentials($a) {self::$db_credentials = $a;}
		static function add_db_connection_credential($key, $value) {self::$db_credentials[$key] = $value;}
		static function set_db_credentials_saccessarea($s) {self::$db_credentials["sAccessArea"] = $s;}
		static function set_db_credentials_scustomernumber($s) {self::$db_credentials["sCustomerNumber"] = $s;}
		static function set_db_credentials_spassword($s) {self::$db_credentials["sPassword"] = $s;}
		static function set_db_credentials_smethod($s) {self::$db_credentials["sMethod"] = $s;}

	/**
	 * show debug information
	 **/
	protected $debug = false;
		public function startDebugging() {$this->debug = true;}
		public function endDebugging() {$this->debug = false;}

	/**
	 * show xml object
	 **/
	protected static $xml_object = null;

	/**
	 *
	 *@param String $xml - string of XML content
	 *@param Boolean $returnRaw - if set to true, the raw return object will be returned...
	 *@return XML Object / Object
	 **/
	public function runXMLCommand($xml, $returnRaw = false) {
		$success = false;
		$resultObject = null;
		$client = null;
		try {
			$client = new SoapClient(self::$url, self::$connection_credentials);
		}
		catch (SoapFault $fault) {
			$client = null;
			user_error("could not create soap client", E_USER_NOTICE);
		}
		if($client) {
			$array = array_merge(self::$db_credentials, array("sParams" => $xml));
			try {
				$resultObject = $client->gbCallCustomerBusinessLinkMethod($array);
				$success = true;
			}
			catch (SoapFault $fault) {
				if($this->debug) {
					echo '<p style="color: red">Error Message:</p>';
					echo $fault->getMessage();
				}
				else {
					user_error("my crash", E_USER_WARNING);
				}
			}
			if($this->debug) {
				echo '<hr /><hr /><hr /><p style="color: green">Request : </p><xmp>'. $this->replacer($client->__getLastRequest()).'</xmp>';
				echo '<h3>Results</h3>';
				echo "<xmp>";
				print_r($resultObject);
				echo "</xmp>";
			}
			if($success) {
				if($returnRaw) {
					return $resultObject;
				}
				if($resultObject->gbCallCustomerBusinessLinkMethodResult) {
					$xml = $resultObject->sResult;
					$xmlObj = simplexml_load_string($xml);
					return $xmlObj;
					//alternative way...
					if(!self::$xml_object) {
						self::$xml_object = new XML();
					}
					return self::$xml_object->parse($xml, true);
				}
				else {
					user_error("unexpected result", E_USER_WARNING);
				}
			}
		}
		return null;
	}

	function test() {
		return $this->runXMLCommand("<DUMMY>TEST</DUMMY>", true);
	}

	/**
	 * replaces several characters in a string to make it more legible on the screen.
	 *
	 *@param String $s - string
	 *@return String
	 **/
	protected function replacer($s) {
		$s = str_replace("&lt;", "<", $s);
		$s = str_replace("&gt;", ">", $s);
		$s = str_replace("&#13;", "", $s);
		$s = str_replace("<", "\r\n<", $s);
		return $s;
	}


}
