/*
 **
 ** Filename: JAXBTrackClient.java
  ** Authors: United Parcel Service of America
 **
 ** The use, disclosure, reproduction, modification, transfer, or transmittal
 ** of this work for any purpose in any form or by any means without the
 ** written permission of United Parcel Service is strictly prohibited.
 **
 ** Confidential, Unpublished Property of United Parcel Service.
 ** Use and Distribution Limited Solely to Authorized Personnel.
 **
 ** Copyright 2009 United Parcel Service of America, Inc.  All Rights Reserved.
 **
 */
package com.ups.xolt.codesamples;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileWriter;
import java.util.Calendar;
import java.util.Properties;

import com.ups.www.wsdl.xoltws.rate.v1_1.RateErrorMessage;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.AddressType;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.CodeDescriptionTypeE;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.PackageType;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.PackageWeightType;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.RateRequest;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.RateResponse;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.RequestType;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.ServiceAccessToken_type0;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.ShipFromType;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.ShipToAddressType;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.ShipToType;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.ShipmentType;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.ShipperType;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.UPSSecurity;
import com.ups.www.wsdl.xoltws.rate.v1_1.RateServiceStub.UsernameToken_type0;


public class Axis2RateClient {

	private static final String LICENSE_NUMBER = "accesskey";
	private static final String USER_NAME = "username";
	private static final String PASSWORD = "password";
	private static final String ENDPOINT_URL="url";
	private static final String OUT_FILE_LOCATION = "out_file_location";
	private static final String TOOL_OR_WEB_SERVICE_NAME = "tool_or_webservice_name";
    private static Properties props = null;
    private static String statusCode = null;
	private static String description = null;
    static {
    	props = new Properties();
    	try{
    		props.load(new FileInputStream("./build.properties"));
    	}catch (Exception e) {
			statusCode = e.getMessage();
			description = e.toString();
			updateResultsToFile(statusCode, description);
    		e.printStackTrace();
		}
    }

	public static void main(String[] args){
		try {

			RateServiceStub rateServiceStub = new RateServiceStub(props.getProperty(ENDPOINT_URL));
			RateResponse rateResponse = rateServiceStub.processRate(populateRateRequest(), populateUPSSecurity() );

			statusCode = rateResponse.getResponse().getResponseStatus().getCode();
			description = rateResponse.getResponse().getResponseStatus().getDescription();
			updateResultsToFile(statusCode, description);

		} catch (Exception e) {
			if(e instanceof RateErrorMessage){
				RateErrorMessage rateErrorMessage = (RateErrorMessage)e;

				statusCode = rateErrorMessage.getFaultMessage().getErrorDetail()[0].getPrimaryErrorCode().getCode();
				description = rateErrorMessage.getFaultMessage().getErrorDetail()[0].getPrimaryErrorCode().getDescription();
				updateResultsToFile(statusCode, description);
			} else {
        		statusCode = e.getMessage();
        		description = e.toString();
        		updateResultsToFile(statusCode, description);
        	}
			e.printStackTrace();
		}
	}

	private static RateRequest populateRateRequest(){
		RateRequest rateRequest = new RateRequest();
		RequestType request = new RequestType();
		String[] requestOption = { "rate" };
		request.setRequestOption(requestOption);
		rateRequest.setRequest(request);

		ShipmentType shpmnt = new ShipmentType();

		/** *******Shipper*********************/
		ShipperType shipper = new ShipperType();
		shipper.setName("ABC Associates");
		shipper.setShipperNumber("222006");
		AddressType shipperAddress = new AddressType();
		String[] addressLines = { "Southam Rd", "Apt 3B" };
		shipperAddress.setAddressLine(addressLines);
		shipperAddress.setCity("GothamCity");
		shipperAddress.setPostalCode("21093");
		shipperAddress.setStateProvinceCode("MD");
		shipperAddress.setCountryCode("US");
		shipper.setAddress(shipperAddress);
		shpmnt.setShipper(shipper);
		/** ******Shipper**********************/

		/** ************ShipFrom*******************/
		ShipFromType shipFrom = new ShipFromType();
		shipFrom.setName("ABC Associates");
		AddressType shipFromAddress = new AddressType();
		shipFromAddress.setAddressLine(addressLines);
		shipFromAddress.setCity("GothamCity");
		shipFromAddress.setPostalCode("21093");
		shipFromAddress.setStateProvinceCode("MD");
		shipFromAddress.setCountryCode("US");
		shipFrom.setAddress(shipFromAddress);
		shpmnt.setShipFrom(shipFrom);
		/** ***********ShipFrom**********************/

		/** ************ShipTo*******************/
		ShipToType shipTo = new ShipToType();
		shipTo.setName("ABC Associates");
		ShipToAddressType shipToAddress = new ShipToAddressType();
		String[] shipToAddressLines = { "SomeUnknownStreet" };
		shipToAddress.setAddressLine(shipToAddressLines);
		shipToAddress.setCity("GothamCity");
		shipToAddress.setPostalCode("21093");
		shipToAddress.setStateProvinceCode("MD");
		shipToAddress.setCountryCode("US");
		shipTo.setAddress(shipToAddress);
		shpmnt.setShipTo(shipTo);
		/** ***********ShipTo**********************/

		/**********Service********************** */
		CodeDescriptionTypeE service = new CodeDescriptionTypeE();
		service.setCode("02");
		service.setDescription("Next Day Air");
		shpmnt.setService(service);
		/** ********Service***********************/

		/********************Package***************** */
		PackageType pkg1 = new PackageType();
		CodeDescriptionTypeE pkgingType = new CodeDescriptionTypeE();
		pkgingType.setCode("01");
		pkgingType.setDescription("UPS Letter");
		pkg1.setPackagingType(pkgingType);
		PackageWeightType pkgWeight = new PackageWeightType();
		CodeDescriptionTypeE UOMType = new CodeDescriptionTypeE();
		UOMType.setCode("lbs");
		UOMType.setDescription("Pounds");
		pkgWeight.setUnitOfMeasurement(UOMType);
		pkgWeight.setWeight("30");
		pkg1.setPackageWeight(pkgWeight);
		PackageType[] pkgArray = { pkg1 };
		shpmnt.setPackage(pkgArray);
		/********************Package******************/
		rateRequest.setShipment(shpmnt);

		return rateRequest;
	}

	private static UPSSecurity populateUPSSecurity(){

		UPSSecurity upss = new UPSSecurity();
		ServiceAccessToken_type0 upsSvcToken = new ServiceAccessToken_type0();
		upsSvcToken.setAccessLicenseNumber(props.getProperty(LICENSE_NUMBER));
		upss.setServiceAccessToken(upsSvcToken);
		UsernameToken_type0 upsSecUsrnameToken = new UsernameToken_type0();
		upsSecUsrnameToken.setUsername(props.getProperty(USER_NAME));
		upsSecUsrnameToken.setPassword(props.getProperty(PASSWORD));
		upss.setUsernameToken(upsSecUsrnameToken);

		return upss;
	}

	/**
     * This method updates the XOLTResult.xml file with the received status and description
     * @param statusCode
     * @param description
     */
	   private static void updateResultsToFile(String statusCode, String description){
	    	BufferedWriter bw = null;
	    	try{

	    		File outFile = new File(props.getProperty(OUT_FILE_LOCATION));
	    		System.out.println("Output file deletion status: " + outFile.delete());
	    		outFile.createNewFile();
	    		System.out.println("Output file location: " + outFile.getCanonicalPath());
	    		bw = new BufferedWriter(new FileWriter(outFile));
	    		StringBuffer strBuf = new StringBuffer();
	    		strBuf.append("<ExecutionAt>");
	    		strBuf.append(Calendar.getInstance().getTime());
	    		strBuf.append("</ExecutionAt>\n");
	    		strBuf.append("<ToolOrWebServiceName>");
	    		strBuf.append(props.getProperty(TOOL_OR_WEB_SERVICE_NAME));
	    		strBuf.append("</ToolOrWebServiceName>\n");
	    		strBuf.append("\n");
	    		strBuf.append("<ResponseStatus>\n");
	    		strBuf.append("\t<Code>");
	    		strBuf.append(statusCode);
	    		strBuf.append("</Code>\n");
	    		strBuf.append("\t<Description>");
	    		strBuf.append(description);
	    		strBuf.append("</Description>\n");
	    		strBuf.append("</ResponseStatus>");
	    		bw.write(strBuf.toString());
	    		bw.close();
	    	}catch (Exception e) {
				e.printStackTrace();
			}finally{
				try{
					if (bw != null){
						bw.close();
						bw = null;
					}
				}catch (Exception e) {
					e.printStackTrace();
				}
			}
	    }
}
