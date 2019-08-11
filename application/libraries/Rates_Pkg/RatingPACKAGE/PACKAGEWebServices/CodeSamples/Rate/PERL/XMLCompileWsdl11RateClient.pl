 no warnings; # turn off warnings
 
 use XML::Compile::WSDL11;
 use XML::Compile::SOAP11;
 use XML::Compile::Transport::SOAPHTTP;
 use HTTP::Request;
 use HTTP::Response;
 use Data::Dumper;
 
 #Configuration
 $access = " Add License Key Here";
 $userid = " Add User Id Here";
 $passwd = " Add Password Here";
 $operation = "ProcessRate";
 $endpointurl = " Add URL Here";
 $wsdlfile = " Add Wsdl File Here ";
 $schemadir = "Add Schema Location Here";
 $outputFileName = "XOLTResult.xml";
 
 sub processRate
 {
 	my $request =
 	{
 		UPSSecurity =>  
	  	{
		   UsernameToken =>
		   {
			   Username => "$userid",
			   Password => "$passwd"
		   },
		   ServiceAccessToken =>
		   {
			   AccessLicenseNumber => "$access"
		   }
	  	},
	  	
 		Request =>
 		{
 			RequestOption => 'Shop'
 		},
 		PickupType =>
 		{
 			Code => '01',
 			Description => 'Daily Pickup'
 		},
 		CustomerClassification =>
 		{
 			Code => '01',
 			Description => 'Classification'
 		},
 		Shipment =>
 		{
 			Shipper =>
 			{
 				Name => 'Imani Carr',
 				ShipperNumber => '222006',
 				Address =>
 				{
 					AddressLine => 
 					[
 					    'Southam Rd',
 					    '4 Case Cour',
 					    'Apt 3B'
 					],
 					City => 'Timonium',
 					StateProvinceCode => 'MD',
 					PostalCode => '21093',
 					CountryCode => 'US'
 				}
 			},
 			ShipTo =>
 			{
 				Name => 'Imani\'s Imaginarium',
 				Address =>
 				{
 					AddressLine => '21 AROGNAUT SUITE B',
 					City => 'ALISO VIEJO',
 					StateProvinceCode => 'CA',
 					PostalCode => '92656',
 					CountryCode => 'US',
 					ResidentialAddressIndicator => ''
 				}
 			},
 			ShipFrom =>
 			{
 				Name => 'Imani\'s Imaginarium',
 				Address =>
 				{
 					AddressLine => 
 					[
 						'Southam Rd',
 						'Apt 3B',
 						'4 Case Court'
 					],
 					City => 'Timonium',
 					StateProvinceCode => 'MD',
 					PostalCode => '21093',
 					CountryCode => 'US',
 				}
 			},
 			Service =>
 			{
 				Code => '03',
 				Description => 'Service Code'
 			},
 			Package =>
 			[
 			    {
	 			    PackagingType =>
	 				{
	 					Code => '02',
	 					Description => 'Rate'
	 				},
	 				Dimensions =>
	 				{
	 					UnitOfMeasurement =>
	 					{
	 						Code => 'IN',
	 						Description => 'inches'
	 					},
	 					Length => '5',
	 					Width => '4',
	 					Height => '10'
	 				},
	 				PackageWeight =>
	 				{
	 					UnitOfMeasurement =>
	 					{
	 						Code => 'LBS',
	 						Description => 'Pounds'
	 					},
	 					Weight => '1'
	 				}
 			    },
 			    
 			    {
	 			    PackagingType =>
	 				{
	 					Code => '02',
	 					Description => 'Rate'
	 				},
	 				Dimensions =>
	 				{
	 					UnitOfMeasurement =>
	 					{
	 						Code => 'IN',
	 						Description => 'inches'
	 					},
	 					Length => '3',
	 					Width => '6',
	 					Height => '8'
	 				},
	 				PackageWeight =>
	 				{
	 					UnitOfMeasurement =>
	 					{
	 						Code => 'LBS',
	 						Description => 'Pounds'
	 					},
	 					Weight => '3'
	 				}
 			    }
 			],
 			
 			ShipmentServiceOptions => { }
 		}
 	};
 	
 	return $request;
 }
 
 my $wsdl = XML::Compile::WSDL11->new( $wsdlfile );
 my @schemas = glob "$schemadir/*.xsd";
 $wsdl->importDefinitions(\@schemas) if scalar(@schemas) > 0;
 my $operation = $wsdl->operation($operation);
 my $call = $operation->compileClient(endpoint => $endpointurl);
 
 ($answer , $trace) = $call->(processRate() , 'UTF-8');	
 
 if($answer->{Fault})
 {
	print $answer->{Fault}->{faultstring} ."\n";
	print Dumper($answer);
	print "See XOLTResult.xml for details.\n";
		
	# Save Soap Request and Response Details
	open(fw,">$outputFileName");
	$trace->printRequest(\*fw);
	$trace->printResponse(\*fw);
	close(fw);
 }
 else
 {
	# Get Response Status Description
    print "Description: " . $answer->{Body}->{Response}->{ResponseStatus}->{Description} . "\n"; 
        
    # Print Request and Response
    my $req = $trace->request();
 	print "Request: \n" . $req->content() . "\n";
	my $resp = $trace->response();
	print "Response: \n" . $resp->content();
		
	# Save Soap Request and Response Details
	open(fw,">$outputFileName");
	$trace->printRequest(\*fw);
	$trace->printResponse(\*fw);
	close(fw);
}
 