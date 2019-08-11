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
import java.net.URL;
import java.util.Calendar;
import java.util.List;
import java.util.Properties;

import javax.xml.ws.BindingProvider;
import javax.xml.ws.WebServiceRef;

import com.ups.wsdl.xoltws.rate.v1.RateErrorMessage;
import com.ups.wsdl.xoltws.rate.v1.RatePortType;
import com.ups.wsdl.xoltws.rate.v1.RateService;
import com.ups.xmlschema.xoltws.common.v1.RequestType;
import com.ups.xmlschema.xoltws.rate.v1.AddressType;
import com.ups.xmlschema.xoltws.rate.v1.CodeDescriptionType;
import com.ups.xmlschema.xoltws.rate.v1.PackageType;
import com.ups.xmlschema.xoltws.rate.v1.PackageWeightType;
import com.ups.xmlschema.xoltws.rate.v1.RateRequest;
import com.ups.xmlschema.xoltws.rate.v1.RateResponse;
import com.ups.xmlschema.xoltws.rate.v1.ShipFromType;
import com.ups.xmlschema.xoltws.rate.v1.ShipToAddressType;
import com.ups.xmlschema.xoltws.rate.v1.ShipToType;
import com.ups.xmlschema.xoltws.rate.v1.ShipmentType;
import com.ups.xmlschema.xoltws.rate.v1.ShipperType;
import com.ups.xmlschema.xoltws.upss.v1.UPSSecurity;
public class JAXWSRateClient {	    
    static RateService service;
    
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
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        try {
        	service = new RateService();
            RatePortType ratePortType = service.getRatePort(); 
           
            BindingProvider bp = (BindingProvider)ratePortType;
        	bp.getRequestContext().put(BindingProvider.ENDPOINT_ADDRESS_PROPERTY, props.getProperty(ENDPOINT_URL));
           
        	RateResponse rateResponse = ratePortType.processRate(populateRateRequest(), populateUPSSecurity());
            statusCode = rateResponse.getResponse().getResponseStatus().getCode();
            description = rateResponse.getResponse().getResponseStatus().getDescription();
            updateResultsToFile(statusCode, description);
        } catch(Exception e) {
        	if(e instanceof RateErrorMessage){
        		RateErrorMessage rateErrMsg = ((RateErrorMessage)e);
        		statusCode = rateErrMsg.getFaultInfo().getErrorDetail().get(0).getPrimaryErrorCode().getCode();
        		description = rateErrMsg.getFaultInfo().getErrorDetail().get(0).getPrimaryErrorCode().getDescription();
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
		//String[] requestOption = { "rate" };
		//request.setRequestOption(requestOption);
		List<String> requestOptionList = request.getRequestOption();
		requestOptionList.add("rate");
		rateRequest.setRequest(request);

		ShipmentType shpmnt = new ShipmentType();

		/** *******Shipper*********************/
		ShipperType shipper = new ShipperType();
		shipper.setName("XYZ Associates");
		shipper.setShipperNumber("222006");
		AddressType shipperAddress = new AddressType();
		
		//String[] addressLines = { "Southam Rd", "Apt 3B" };
		//shipperAddress.setAddressLine(addressLines);
		List<String> addressLine = shipperAddress.getAddressLine();
		addressLine.add("Southam Rd");
		addressLine.add("Apt 3B");
		
		shipperAddress.setCity("TimoniumCity");
		shipperAddress.setPostalCode("21093");
		shipperAddress.setStateProvinceCode("MD");
		shipperAddress.setCountryCode("US");
		shipper.setAddress(shipperAddress);
		shpmnt.setShipper(shipper);
		/** ******Shipper**********************/

		/** ************ShipFrom*******************/
		ShipFromType shipFrom = new ShipFromType();
		shipFrom.setName("XYZ Associates");
		AddressType shipFromAddress = new AddressType();
		//shipFromAddress.setAddressLine(addressLines);
		List<String> shipFromAddressLine = shipFromAddress.getAddressLine();
		shipFromAddressLine.add("Southam Rd");
		shipFromAddressLine.add("Apt 3B");
		
		shipFromAddress.setCity("TimoniumCity");
		shipFromAddress.setPostalCode("21093");
		shipFromAddress.setStateProvinceCode("MD");
		shipFromAddress.setCountryCode("US");
		shipFrom.setAddress(shipFromAddress);
		shpmnt.setShipFrom(shipFrom);
		/** ***********ShipFrom**********************/

		/** ************ShipTo*******************/
		ShipToType shipTo = new ShipToType();
		shipTo.setName("PQR Associates");
		ShipToAddressType shipToAddress = new ShipToAddressType();
		//String[] shipToAddressLines = { "SomeUnknownStreet" };
		//shipToAddress.setAddressLine(shipToAddressLines);
		List<String> shipToAddresLine = shipToAddress.getAddressLine();
		shipToAddresLine.add("SomeUnknownStreet");
		shipToAddress.setCity("Lexington");
		shipToAddress.setPostalCode("40508");
		shipToAddress.setStateProvinceCode("KY");
		shipToAddress.setCountryCode("US");
		shipTo.setAddress(shipToAddress);
		shpmnt.setShipTo(shipTo);
		/** ***********ShipTo**********************/

		/**********Service********************** */
		CodeDescriptionType service = new CodeDescriptionType();
		service.setCode("02");
		service.setDescription("Next Day Air");
		shpmnt.setService(service);
		/** ********Service***********************/

		/********************Package***************** */
		PackageType pkg1 = new PackageType();
		CodeDescriptionType pkgingType = new CodeDescriptionType();
		pkgingType.setCode("01");
		pkgingType.setDescription("UPS Letter");
		pkg1.setPackagingType(pkgingType);
		PackageWeightType pkgWeight = new PackageWeightType();
		CodeDescriptionType UOMType = new CodeDescriptionType();
		UOMType.setCode("lbs");
		UOMType.setDescription("Pounds");
		pkgWeight.setUnitOfMeasurement(UOMType);
		pkgWeight.setWeight("30");
		pkg1.setPackageWeight(pkgWeight);
		//PackageType[] pkgArray = { pkg1 };
		
		//shpmnt.set_package(pkgArray);
		List<PackageType> pTypeList = shpmnt.getPackage();
		pTypeList.add(pkg1);
		/********************Package******************/
		rateRequest.setShipment(shpmnt);
    	return rateRequest;
    }
    
    private static UPSSecurity populateUPSSecurity(){
    	UPSSecurity upss = new UPSSecurity();
    	UPSSecurity.ServiceAccessToken upsSvcToken = new UPSSecurity.ServiceAccessToken();
		upsSvcToken.setAccessLicenseNumber(props.getProperty(LICENSE_NUMBER));
		upss.setServiceAccessToken(upsSvcToken);
		UPSSecurity.UsernameToken upsSecUsrnameToken = new UPSSecurity.UsernameToken();
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
