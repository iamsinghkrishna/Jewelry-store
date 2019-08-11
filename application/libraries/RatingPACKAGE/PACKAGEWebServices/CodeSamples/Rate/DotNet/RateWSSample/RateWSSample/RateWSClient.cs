using System;
using System.Collections.Generic;
using System.Text;
using RateWSSample.RateWebReference;
using System.ServiceModel;

namespace RateWSSample
{
    public class RateWSClient
    {

        static void Main()
        {
            try
            {

                RateService rate = new RateService();
                RateRequest rateRequest = new RateRequest();
                UPSSecurity upss = new UPSSecurity();
                UPSSecurityServiceAccessToken upssSvcAccessToken = new UPSSecurityServiceAccessToken();
                upssSvcAccessToken.AccessLicenseNumber = "Your Access License Number";
                upss.ServiceAccessToken = upssSvcAccessToken;
                UPSSecurityUsernameToken upssUsrNameToken = new UPSSecurityUsernameToken();
                upssUsrNameToken.Username = "Your Username";
                upssUsrNameToken.Password = "Your Password";
                upss.UsernameToken = upssUsrNameToken;
                rate.UPSSecurityValue = upss;
                RequestType request = new RequestType();
                String[] requestOption = { "Rate" };
                request.RequestOption = requestOption;
                rateRequest.Request = request;
                ShipmentType shipment = new ShipmentType();
                ShipperType shipper = new ShipperType();
                shipper.ShipperNumber = "Your Shipper Number";
                RateWSSample.RateWebReference.AddressType shipperAddress = new RateWSSample.RateWebReference.AddressType();
                String[] addressLine = { "5555 main", "4 Case Cour", "Apt 3B" };
                shipperAddress.AddressLine = addressLine;
                shipperAddress.City = "Roswell";
                shipperAddress.PostalCode = "30076";
                shipperAddress.StateProvinceCode = "GA";
                shipperAddress.CountryCode = "US";
                shipperAddress.AddressLine = addressLine;
                shipper.Address = shipperAddress;
                shipment.Shipper = shipper;
                ShipFromType shipFrom = new ShipFromType();
                RateWSSample.RateWebReference.AddressType shipFromAddress = new RateWSSample.RateWebReference.AddressType();
                shipFromAddress.AddressLine = addressLine;
                shipFromAddress.City = "Roswell";
                shipFromAddress.PostalCode = "30076";
                shipFromAddress.StateProvinceCode = "GA";
                shipFromAddress.CountryCode = "US";
                shipFrom.Address = shipFromAddress;
                shipment.ShipFrom = shipFrom;
                ShipToType shipTo = new ShipToType();
                ShipToAddressType shipToAddress = new ShipToAddressType();
                String[] addressLine1 = { "10 E. Ritchie Way", "2", "Apt 3B" };
                shipToAddress.AddressLine = addressLine1;
                shipToAddress.City = "Plam Springs";
                shipToAddress.PostalCode = "92262";
                shipToAddress.StateProvinceCode = "CA";
                shipToAddress.CountryCode = "US";
                shipTo.Address = shipToAddress;
                shipment.ShipTo = shipTo;
                CodeDescriptionType service = new CodeDescriptionType();

                //Below code uses dummy date for reference. Please udpate as required.
                service.Code = "02";
                shipment.Service = service;
                PackageType package = new PackageType();
                PackageWeightType packageWeight = new PackageWeightType();
                packageWeight.Weight = "125";
                CodeDescriptionType uom = new CodeDescriptionType();
                uom.Code = "LBS";
                uom.Description = "pounds";
                packageWeight.UnitOfMeasurement = uom;
                package.PackageWeight = packageWeight;
                CodeDescriptionType packType = new CodeDescriptionType();
                packType.Code = "02";
                package.PackagingType = packType;
                PackageType[] pkgArray = { package };
                shipment.Package = pkgArray;
                rateRequest.Shipment = shipment;
                System.Net.ServicePointManager.CertificatePolicy = new TrustAllCertificatePolicy();
                Console.WriteLine(rateRequest);
                RateResponse rateResponse = rate.ProcessRate(rateRequest);
                Console.WriteLine("The transaction was a " + rateResponse.Response.ResponseStatus.Description);
                Console.WriteLine("Total Shipment Charges " + rateResponse.RatedShipment[0].TotalCharges.MonetaryValue + rateResponse.RatedShipment[0].TotalCharges.CurrencyCode);
                Console.ReadKey();
            }
            catch (System.Web.Services.Protocols.SoapException ex)
            {
                Console.WriteLine("");
                Console.WriteLine("---------Rate Web Service returns error----------------");
                Console.WriteLine("---------\"Hard\" is user error \"Transient\" is system error----------------");
                Console.WriteLine("SoapException Message= " + ex.Message);
                Console.WriteLine("");
                Console.WriteLine("SoapException Category:Code:Message= " + ex.Detail.LastChild.InnerText);
                Console.WriteLine("");
                Console.WriteLine("SoapException XML String for all= " + ex.Detail.LastChild.OuterXml);
                Console.WriteLine("");
                Console.WriteLine("SoapException StackTrace= " + ex.StackTrace);
                Console.WriteLine("-------------------------");
                Console.WriteLine("");
            }
            catch (System.ServiceModel.CommunicationException ex)
            {
                Console.WriteLine("");
                Console.WriteLine("--------------------");
                Console.WriteLine("CommunicationException= " + ex.Message);
                Console.WriteLine("CommunicationException-StackTrace= " + ex.StackTrace);
                Console.WriteLine("-------------------------");
                Console.WriteLine("");

            }
            catch (Exception ex)
            {
                Console.WriteLine("");
                Console.WriteLine("-------------------------");
                Console.WriteLine(" Generaal Exception= " + ex.Message);
                Console.WriteLine(" Generaal Exception-StackTrace= " + ex.StackTrace);
                Console.WriteLine("-------------------------");

            }
            finally {
                Console.ReadKey();
            }

        }
    }
}
