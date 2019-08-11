/* 
 ** 
 ** Filename: JAXBRateClient.java 
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

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.ByteArrayInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileWriter;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.StringWriter;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;
import java.util.List;
import java.util.Properties;

import javax.xml.bind.JAXBContext;
import javax.xml.bind.Marshaller;

import com.ups.xml.accessrequest.jaxb.AccessRequest;
import com.ups.xml.request.jaxb.AddressType;
import com.ups.xml.request.jaxb.CodeDescriptionType;
import com.ups.xml.request.jaxb.PackageType;
import com.ups.xml.request.jaxb.RatingServiceSelectionRequest;
import com.ups.xml.request.jaxb.RequestType;
import com.ups.xml.request.jaxb.ShipFromType;
import com.ups.xml.request.jaxb.ShipToType;
import com.ups.xml.request.jaxb.ShipmentType;
import com.ups.xml.request.jaxb.ShipperType;
import com.ups.xml.request.jaxb.UnitOfMeasurementType;
import com.ups.xml.request.jaxb.WeightType;
import com.ups.xml.response.jaxb.*;
import javax.xml.bind.Unmarshaller;
import com.ups.xml.accessrequest.jaxb.ObjectFactory;

public class JAXBRateClient {

	private static String LICENSE_NUMBER = "accesskey";
	private static String USER_NAME = "username";
	private static String PASSWORD = "password";
	private static String ENDPOINT_URL = "url";
	private static String OUT_FILE_LOCATION = "out_file_location";
	private static Properties props = null;
	private static String description = null;

	static {
		try {
			props = new Properties();
			props.load(new FileInputStream("./build.properties"));
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public static void main(String[] args) {
		StringWriter strWriter = null;
		try {

			// Create JAXBContext and marshaller for AccessRequest object
			JAXBContext accessRequestJAXBC = JAXBContext.newInstance(AccessRequest.class.getPackage().getName());
			Marshaller accessRequestMarshaller = accessRequestJAXBC.createMarshaller();
			ObjectFactory accessRequestObjectFactory = new ObjectFactory();
			AccessRequest accessRequest = accessRequestObjectFactory.createAccessRequest();
			populateAccessRequest(accessRequest);

			// Create JAXBContext and marshaller for
			// RatingServiceSelectionRequest object
			JAXBContext rateRequestJAXBC = JAXBContext.newInstance(RatingServiceSelectionRequest.class.getPackage().getName());
			Marshaller rateRequestMarshaller = rateRequestJAXBC.createMarshaller();
			com.ups.xml.request.jaxb.ObjectFactory requestObjectFactory = new com.ups.xml.request.jaxb.ObjectFactory();
			RatingServiceSelectionRequest rateRequest = requestObjectFactory.createRatingServiceSelectionRequest();
			populateRatingServiceSelectionRequest(rateRequest);

			// Get String out of access request and rate request objects.
			strWriter = new StringWriter();
			accessRequestMarshaller.marshal(accessRequest, strWriter);
			rateRequestMarshaller.marshal(rateRequest, strWriter);
			strWriter.flush();
			strWriter.close();
			System.out.println("Request: " + strWriter.getBuffer().toString());

			String strResults = contactService(strWriter.getBuffer().toString());

			System.out.print("What is this:::::" + strResults);

			// ------ Parse Response ---
			try {

				JAXBContext jc = JAXBContext.newInstance(props.getProperty("responseClassPackage"));

				Unmarshaller rateResponseUnmarshaller = jc.createUnmarshaller();

				ByteArrayInputStream input = new ByteArrayInputStream(strResults.getBytes());

				Object jaxbObject = rateResponseUnmarshaller.unmarshal(input);

				RatingServiceSelectionResponse reateResp = (RatingServiceSelectionResponse) jaxbObject;

				List<RatedShipmentType> rShipmentList = reateResp.getRatedShipment();
				if (rShipmentList != null && rShipmentList.size() > 0) {
					RatedShipmentType aRShipment = rShipmentList.get(0);
					ChargesType totlCharge = aRShipment.getTotalCharges();
					System.out.println("\n\nTotalCharge=" + totlCharge.getMonetaryValue());
					System.out.println("TotalChargeCurrencyCode=" + totlCharge.getCurrencyCode());

				}

				

			} catch (Exception e) {
				System.out.println("****See Error here");
				e.printStackTrace();
			}

			updateResultsToFile(strResults);

		} catch (Exception e) {
			System.out.println(e.getClass());

			e.printStackTrace();

			updateResultsToFile(e.toString());

		} finally {
			try {
				if (strWriter != null) {
					strWriter.close();
					strWriter = null;
				}
			} catch (Exception e) {
				updateResultsToFile(e.toString());
				e.printStackTrace();
			}
		}
	}

	private static String contactService(String xmlInputString) throws Exception {
		String outputStr = null;
		OutputStream outputStream = null;
		try {

			URL url = new URL(props.getProperty(ENDPOINT_URL));

			HttpURLConnection connection = (HttpURLConnection) url.openConnection();
			System.out.println("Client established connection with " + url.toString());
			// Setup HTTP POST parameters
			connection.setDoOutput(true);
			connection.setDoInput(true);
			connection.setUseCaches(false);

			outputStream = connection.getOutputStream();
			outputStream.write(xmlInputString.getBytes());
			outputStream.flush();
			outputStream.close();
			System.out.println("Http status = " + connection.getResponseCode() + " " + connection.getResponseMessage());

			outputStr = readURLConnection(connection);
			connection.disconnect();
		} catch (Exception e) {
			System.out.println("Error sending data to server");
			throw e;
		} finally {
			if (outputStream != null) {
				outputStream.close();
				outputStream = null;
			}
		}
		return outputStr;
	}

	/**
	 * This method read all of the data from a URL connection to a String
	 */

	public static String readURLConnection(URLConnection uc) throws Exception {
		StringBuffer buffer = new StringBuffer();
		BufferedReader reader = null;
		try {
			reader = new BufferedReader(new InputStreamReader(uc.getInputStream()));
			int letter = 0;
			reader.readLine();
			while ((letter = reader.read()) != -1) {
				buffer.append((char) letter);
			}
			reader.close();
		} catch (Exception e) {
			System.out.println("Could not read from URL: " + e.toString());
			throw e;
		} finally {
			if (reader != null) {
				reader.close();
				reader = null;
			}
		}
		return buffer.toString();
	}

	/**
	 * Populates the access request object.
	 * 
	 * @param accessRequest
	 */
	private static void populateAccessRequest(AccessRequest accessRequest) {
		accessRequest.setAccessLicenseNumber(props.getProperty(LICENSE_NUMBER));
		accessRequest.setUserId(props.getProperty(USER_NAME));
		accessRequest.setPassword(props.getProperty(PASSWORD));
	}

	/**
	 * Populate RatingServiceSelectionRequest object
	 * 
	 * @param rateRequest
	 */
	private static void populateRatingServiceSelectionRequest(RatingServiceSelectionRequest rateRequest) {
		RequestType request = new RequestType();
		request.setRequestOption("Rate");
		rateRequest.setRequest(request);

		ShipmentType shipment = new ShipmentType();

		/*********************** Start Shipper ****************************/
		ShipperType shipper = new ShipperType();
		shipper.setName("Carol");
		shipper.setShipperNumber("222006");
		AddressType shipperAddress = new AddressType();
		shipperAddress.setAddressLine1("4 Case Court");
		shipperAddress.setAddressLine2("Apt 3B");
		shipperAddress.setCity("Timonium");
		shipperAddress.setStateProvinceCode("MD");
		shipperAddress.setPostalCode("21093");
		shipperAddress.setCountryCode("US");
		shipper.setAddress(shipperAddress);
		shipment.setShipper(shipper);
		/************************* End Shipper ****************************/

		/***************** Start ShipTo *****************************/
		ShipToType shipTo = new ShipToType();
		shipTo.setCompanyName("Carol's Combs");
		AddressType shipToAddress = new AddressType();
		shipToAddress.setAddressLine1("21 ARGONAUT, SUITE B");
		shipToAddress.setAddressLine2("Home Sideline");
		shipToAddress.setAddressLine3("Middle Bench");
		shipToAddress.setCity("ALISO VIEJO");
		shipToAddress.setStateProvinceCode("CA");
		shipToAddress.setPostalCode("92656");
		shipToAddress.setCountryCode("US");
		shipTo.setAddress(shipToAddress);
		shipment.setShipTo(shipTo);
		/***************** End ShipTo *****************************/

		/***************** Start ShipFrom *****************************/
		ShipFromType shipFrom = new ShipFromType();
		shipFrom.setCompanyName("Carol's Combs");
		AddressType shipFromAddress = new AddressType();
		shipFromAddress.setAddressLine1("4 Case Court");
		shipFromAddress.setAddressLine2("Apt 3B");
		shipFromAddress.setCity("PIKESVILLE");
		shipFromAddress.setStateProvinceCode("MD");
		shipFromAddress.setPostalCode("21208");
		shipFromAddress.setCountryCode("US");
		shipFrom.setAddress(shipFromAddress);
		shipment.setShipFrom(shipFrom);
		/***************** End ShipFrom *****************************/

		/********** Service********************** */
		CodeDescriptionType service = new CodeDescriptionType();
		service.setCode("59");
		service.setDescription("2nd Day Air AM");
		shipment.setService(service);
		/** ********Service ***********************/

		/******************** Package***************** */
		PackageType packageType = new PackageType();
		CodeDescriptionType packagingType = new CodeDescriptionType();
		packagingType.setCode("02");
		packagingType.setDescription("UPS");
		packageType.setPackagingType(packagingType);

		WeightType pkgWeight = new WeightType();
		UnitOfMeasurementType UOMType = new UnitOfMeasurementType();
		UOMType.setCode("lbs");
		UOMType.setDescription("Pounds");
		pkgWeight.setUnitOfMeasurement(UOMType);
		pkgWeight.setWeight("30");
		packageType.setPackageWeight(pkgWeight);
		List<PackageType> packages = shipment.getPackage();
		packages.add(packageType);

		/******************** Package ******************/

		rateRequest.setShipment(shipment);
	}

	/**
	 * This method updates the XOLTResult.xml file with the received status and
	 * description
	 * 
	 * @param statusCode
	 * @param description
	 */
	private static void updateResultsToFile(String response) {
		BufferedWriter bw = null;
		try {
			File outFile = new File(props.getProperty(OUT_FILE_LOCATION));
			if (outFile.exists()) {
				System.out.println("Output file deletion status: " + outFile.delete());
			} else {
				outFile.createNewFile();
			}
			System.out.println("Output file location: " + outFile.getCanonicalPath());
			bw = new BufferedWriter(new FileWriter(outFile));
			bw.write(response);
			bw.close();

		} catch (Exception e) {

			e.printStackTrace();
		} finally {
			try {
				if (bw != null) {
					bw.close();
					bw = null;
				}
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
	}
}