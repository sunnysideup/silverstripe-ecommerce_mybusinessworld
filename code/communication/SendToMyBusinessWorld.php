<?php

/**
 *@author nicolaas [at] sunnysideup .co .nz
 *@description: send XML data to My Business World
 *
 *
 *
 **/

class SendToMyBusinessWorld extends Object {

	var $dos = null;

	var $fields = array();

	function setDos($dos) {
		$this->dos = $dos;
	}

	function setFields($fields) {
		$this->fields = $fields;
	}

	function send() {
		$xmlObject = new CreateXMLForMyBusinessWorld();
		return $xmlObject->convertDataObjectSet($this->dos, $this->fields);
	}

}
