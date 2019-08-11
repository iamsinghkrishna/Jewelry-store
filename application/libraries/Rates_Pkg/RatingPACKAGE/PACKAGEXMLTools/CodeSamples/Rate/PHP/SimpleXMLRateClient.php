<?php
try {
	
	// configuration
	$access = " Add License Key Here";
	$userid = " Add User Id Here";
	$passwd = " Add Password Here";
	
	$endpointurl = "  Add URL Here";
	$outputFileName = "XOLTResult.xml";
	
	// create a simple xml object for AccessRequest & RateRequest
	$accessRequesttXML = new SimpleXMLElement ( "<AccessRequest></AccessRequest>" );
	$rateRequestXML = new SimpleXMLElement ( "<RatingServiceSelectionRequest></RatingServiceSelectionRequest>" );
	
	// create AccessRequest XML
	$accessRequesttXML->addChild ( "AccessLicenseNumber", $access );
	$accessRequesttXML->addChild ( "UserId", $userid );
	$accessRequesttXML->addChild ( "Password", $passwd );
	
	// create RateRequest XML
	$request = $rateRequestXML->addChild ( 'Request' );
	$request->addChild ( "RequestAction", "Rate" );
	$request->addChild ( "RequestOption", "Rate" );
	
	$shipment = $rateRequestXML->addChild ( 'Shipment' );
	$shipper = $shipment->addChild ( 'Shipper' );
	$shipper->addChild ( "Name", "Name" );
	$shipper->addChild ( "ShipperNumber", "" );
	$shipperddress = $shipper->addChild ( 'Address' );
	$shipperddress->addChild ( "AddressLine1", "Address Line" );
	$shipperddress->addChild ( "City", "Corado" );
	$shipperddress->addChild ( "PostalCode", "00646" );
	$shipperddress->addChild ( "CountryCode", "PR" );
	
	$shipTo = $shipment->addChild ( 'ShipTo' );
	$shipTo->addChild ( "CompanyName", "Company Name" );
	$shipToAddress = $shipTo->addChild ( 'Address' );
	$shipToAddress->addChild ( "AddressLine1", "Address Line" );
	$shipToAddress->addChild ( "City", "Corado" );
	$shipToAddress->addChild ( "PostalCode", "00646" );
	$shipToAddress->addChild ( "CountryCode", "PR" );
	
	$shipFrom = $shipment->addChild ( 'ShipFrom' );
	$shipFrom->addChild ( "CompanyName", "Company Name" );
	$shipFromAddress = $shipFrom->addChild ( 'Address' );
	$shipFromAddress->addChild ( "AddressLine1", "Address Line" );
	$shipFromAddress->addChild ( "City", "Boca Raton" );
	$shipFromAddress->addChild ( "StateProvinceCode", "FL" );
	$shipFromAddress->addChild ( "PostalCode", "33434" );
	$shipFromAddress->addChild ( "CountryCode", "US" );
	
	$service = $shipment->addChild ( 'Service' );
	$service->addChild ( "Code", "02" );
	$service->addChild ( "Description", "2nd Day Air" );
	
	$package = $shipment->addChild ( 'Package' );
	$packageType = $package->addChild ( 'PackagingType' );
	$packageType->addChild ( "Code", "02" );
	$packageType->addChild ( "Description", "UPS Package" );
	
	$packageWeight = $package->addChild ( 'PackageWeight' );
	$unitOfMeasurement = $packageWeight->addChild ( 'UnitOfMeasurement' );
	$unitOfMeasurement->addChild ( "Code", "LBS" );
	$packageWeight->addChild ( "Weight", "15.2" );
	
	$requestXML = $accessRequesttXML->asXML () . $rateRequestXML->asXML ();
	
	// create Post request
	$form = array (
			'http' => array (
					'method' => 'POST',
					'header' => 'Content-type: application/x-www-form-urlencoded',
					'content' => "$requestXML" 
			) 
	);
	
	$request = stream_context_create ( $form );
	$browser = fopen ( $endpointurl, 'rb', false, $request );
	if (! $browser) {
		throw new Exception ( "Connection failed." );
	}
	
	// get response
	$response = stream_get_contents ( $browser );
	fclose ( $browser );
	
	if ($response == false) {
		throw new Exception ( "Bad data." );
	} else {
		// save request and response to file
		$fw = fopen ( $outputFileName, 'w' );
		fwrite ( $fw, "Request: \n" . $requestXML . "\n" );
		fwrite ( $fw, "Response: \n" . $response . "\n" );
		fclose ( $fw );
		
		// get response status
		$resp = new SimpleXMLElement ( $response );
		echo $resp->Response->ResponseStatusDescription . "\n";
	}
} catch ( Exception $ex ) {
	echo $ex;
}
?>