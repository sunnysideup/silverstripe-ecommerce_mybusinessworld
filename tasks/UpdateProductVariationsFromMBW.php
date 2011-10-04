<?php


class UpdateProductVariationsFromMBW extends QuarterHourlyTask {

	function process() {
		$communicator = new RequestInformationFromMBW();
		//$communicator->startDebugging();
		$products = DB::query("SELECT \"InternalItemID\" FROM \"Product\" WHERE AllowPurchase = 1;");
		$xml = '<STOCK>';
		foreach($products as $product) {
			$xml .= '<PRODUCT><ProductNumber>'.$product["InternalItemID"].'</ProductNumber></PRODUCT>';
		}
		$xml = '<STOCK><PRODUCT><ProductNumber>a21m 607 04 720</ProductNumber></PRODUCT><PRODUCT><ProductID>4</ProductID></PRODUCT>';
		$xml .= '</STOCK>';
		print_r($xml);
		$outcome = $communicator->runXMLCommand($xml);
		if(isset($outcome->Product)) {
			foreach($outcome->Product as $variation) {
				$product = DataObject::get_one("Product", "InternalItemID = '".trim($variation->ProductNumber)."'");
				echo "GO ".$variation->ProductNumber;
				print_r($product);
			}
		}
		else {
			die("no products");
		}
		print_r($outcome);
	}

}
