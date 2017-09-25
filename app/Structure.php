<?php
/**
 * Created by PhpStorm.
 * User: che
 * Date: 22.09.2017
 * Time: 14:29
 */

namespace app\EDI;


class Structure
{
    public $arr_full = array();
    public $arr_desc = array();
    private $arr = array();
    private $Description = array(
        "ISA" => array(
            "NAME" => "Interchange Control Header",
            "Require" => "M",
            "Count" => 1,
            "USAGE" => "Must Send",
            "LOOP" => 0
        ),
        "GS" => array(
            "NAME" => "Functional Group Header",
            "Require" => "M",
            "Count" => 1,
            "USAGE" => "Must Send",
            "LOOP" => 0
        ),
        "ST" => array(
            "NAME" => "Transaction Set Header",
            "Require" => "M",
            "Count" => 1,
            "USAGE" => "Must Send",
            "LOOP" => 0
        ),
        "B4" => array(
            "NAME" => "Beginning Segment for Inquiry or Reply",
            "Require" => "M",
            "Count" => 1,
            "USAGE" => "Must Send",
            "LOOP" => 0
        ),
        "N9" => array(
            "NAME" => "Reference Identification",
            "Require" => "O",
            "Count" => 30,
            "USAGE" => "Must Send",
            "LOOP" => 0
        ),
        "Q2" => array(
            "NAME" => "Status Details (Ocean)",
            "Require" => "O",
            "Count" => 1,
            "USAGE" => "Optionally Sent",
            "LOOP" => 0
        ),
        "R4" => array(
            "NAME" => "Port or Terminal",
            "Require" => "M",
            "Count" => 1,
            "USAGE" => "Must Send",
            "LOOP" => 1
        ),
        "DTM" => array(
            "NAME" => "Date/Time Reference",
            "Require" => "M",
            "Count" => 15,
            "USAGE" => "Must Send",
            "LOOP" => 1
        ),
        "SE" => array(
            "NAME" => "Transaction Set Trailer",
            "Require" => "M",
            "Count" => 1,
            "USAGE" => "Must Send",
            "LOOP" => 0
        ),
        "GE" => array(
            "NAME" => "Functional Group Trailer",
            "Require" => "M",
            "Count" => 1,
            "USAGE" => "Must Send",
            "LOOP" => 0
        ),
        "IEA" => array(
            "NAME" => "Interchange Control Trailer",
            "Require" => "M",
            "Count" => 1,
            "USAGE" => "Must Send",
            "LOOP" => 0
        )
    );
    private $SubDescription = array(
        "ISA" => array(
            1 => array(
                "NAME" => "Authorization Information Qualifier",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "00" => "No Authorization Information Present (No Meaningful Information in I02)"
                )
            ),
            2 => array(
                "NAME" => "Authorization Information",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "10",
                "MAX" => "10",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            3 => array(
                "NAME" => "Security Information Qualifier",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "00" => "No Security Information Present (No Meaningful Information in I04) ",
                    "01" => "Password"
                )
            ),
            4 => array(
                "NAME" => "Security Information",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "10",
                "MAX" => "10",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: 10 blank spaces",
                "CODES" => array()
            ),
            5 => array(
                "NAME" => "Interchange ID Qualifier",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "02" => "SCAC (Standard Carrier Alpha Code)",
                    "12" => "Phone (Telephone Companies)",
                    "ZZ" => "Mutually Defined"
                )
            ),
            6 => array(
                "NAME" => "Interchange Sender ID",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "15",
                "MAX" => "15",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            7 => array(
                "NAME" => "Interchange ID Qualifier",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "ZZ" => "Mutually Defined"
                )
            ),
            8 => array(
                "NAME" => "Interchange Receiver ID",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "15",
                "MAX" => "15",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: . SCS Test ID = NETRTEST, SCS Production ID = APLUNET",
                "CODES" => array(
                    "NETRTEST" => "SCS Test ID",
                    "APLUNET" => "SCS Production ID"
                )
            ),
            9 => array(
                "NAME" => "Interchange Date",
                "REQUIRE" => "M",
                "TYPE" => "DT",
                "MIN" => "6",
                "MAX" => "6",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: YYMMDD",
                "CODES" => array()
            ),
            10 => array(
                "NAME" => "Interchange Time",
                "REQUIRE" => "M",
                "TYPE" => "TM",
                "MIN" => "4",
                "MAX" => "4",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: HHMM",
                "CODES" => array()
            ),
            11 => array(
                "NAME" => "Interchange Control Standards Identifier",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "1",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "U" => "U.S. EDI Community of ASC X12, TDCC, and UCS"
                )
            ),
            12 => array(
                "NAME" => "Interchange Control Version Number",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "5",
                "MAX" => "5",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "00401" => "Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board through October 1997"
                )
            ),
            13 => array(
                "NAME" => "Interchange Control Number",
                "REQUIRE" => "M",
                "TYPE" => "N0",
                "MIN" => "9",
                "MAX" => "9",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            14 => array(
                "NAME" => "Acknowledgment Requested",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "1",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "0" => "No Acknowledgment Requested"
                )
            ),
            15 => array(
                "NAME" => "Usage Indicator",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "1",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "P" => "Production Data",
                    "T" => "Test Data",
                )
            ),
            16 => array(
                "NAME" => "Component Element Separator",
                "REQUIRE" => "M",
                "TYPE" => "",
                "MIN" => "1",
                "MAX" => "1",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            )
        ),
        "GS" => array(
            1 => array(
                "NAME" => "Functional Identifier Code",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "QO" => "Ocean Shipment Status Information (313, 315)"
                )
            ),
            2 => array(
                "NAME" => "Application Sender's Code",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "2",
                "MAX" => "15",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: Trading Partner's ID",
                "CODES" => array(),
            ),
            3 => array(
                "NAME" => "Application Receiver's Code",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "2",
                "MAX" => "15",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "NETRTEST " => "SCS Test ID",
                    "APLUNET" => "SCS Production ID "
            )
            ),
            4 => array(
               "NAME" => "Date",
                "REQUIRE" => "M",
                "TYPE" => "DT",
                "MIN" => "8",
                "MAX" => "8",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: CCYYMMDD",
                "CODES" => array()
            ),
            5 => array(
                "NAME" => "Time",
                "REQUIRE" => "M",
                "TYPE" => "TM",
                "MIN" => "4",
                "MAX" => "8",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: HHMM",
                "CODES" => array()
            ),
            6 => array(
                "NAME" => "Group Control Number",
                "REQUIRE" => "M",
                "TYPE" => "N0",
                "MIN" => "1",
                "MAX" => "9",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            7 => array(
                "NAME" => "Responsible Agency Code",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "X" => "Accredited Standards Committee X12"
                )
            ),
            8 => array(
                "NAME" => "Version / Release / Industry Identifier",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "1",
                "MAX" => "12",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "004010" => "Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1997"
                )
            ),
        ),
        "ST" => array(
            1 => array(
                "NAME" => "Transaction Set Identifier Code",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "3",
                "MAX" => "3",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "315" => "Status Details (Ocean)"
                )
            ),
            2 => array(
                "NAME" => "Transaction Set Control Number",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "4",
                "MAX" => "9",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            )
        ),
        "B4" => array(
            1 => array(
                "NAME" => "Special Handling Code",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "3",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "",
                "CODES" => array(
                    "IP" => "Import Shipment ",
                    "XP" => "Export"
                )
            ),
            2 => array(
                "NAME" => "Shipment Status Code",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "D" => "Completed Unloading at Delivery Location   (MANDATORY per Shipment Lifecycle) ",
                    "I" => "In-Gate   (MANDATORY per Shipment Lifecycle) Carrier Notes: Do not send In-Gates for Empty Loads, use the code RD instead. ",
                    "K" => "Arrived at Customs  (CONDITIONAL*) ",
                    "N" => "No Paperwork Received with Shipment or Equipment   (OPTIONAL) ",
                    "P" => "Departed Terminal Location Carrier Notes: Rail passing event (Rail interim) ",
                    "A1" => "Agriculture Canada Hold  (CONDITIONAL*) ",
                    "A2" => "Agriculture Canada Released  (CONDITIONAL*) ",
                    "A3" => "Agriculture Canada Refused Entry (CONDITIONAL*) ",
                    "A4" => "Agriculture Canada Conditional Release (CONDITIONAL*) ",
                    "AA" => "Pick-up Appointment Date and Time   (OPTIONAL) ",
                    "AD" => "Delivery Appointment Date and Time   (OPTIONAL) ",
                    "AE" => "Loaded on Vessel   (MANDATORY per Shipment Lifecycle) ",
                    "AL" => "Loaded on Rail  (CONDITIONAL*) ",
                    "AM" => "Loaded on Truck  (CONDITIONAL*) ",
                    "AP" => "Loaded on Feeder Vessel   (CONDITIONAL*) ",
                    "AR" => "Rail Arrival at Destination Intermodal Ramp (CONDITIONAL*) Carrier Notes: Must be sent at least once per life cycle of  inland move ",
                    "AV" => "Available for Delivery   (CONDITIONAL*) ",
                    "BF" => "Booking Confirmed  (OPTIONAL) ",
                    "C1" => "Canada Customs Hold   (OPTIONAL) ",
                    "CO" => "Cargo Received at Contractual Place of Receipt   (MANDATORY per Shipment Lifecycle) ",
                    "CR" => "Carrier Release    (MANDATORY per Shipment Lifecycle) ",
                    "CS" => "Container Sealed  (CONDITIONAL*) ",
                    "CT" => "Customs Released     (MANDATORY per Shipment Lifecycle)",
                    "CU" => "Carrier and Customs Release  (CONDITIONAL*) ",
                    "EE" => "Empty Equipment Dispatched   (CONDITIONAL*) ",
                    "FP" => "Freight Paid    (OPTIONAL) ",
                    "FT" => "Free Time Expired    (CONDITIONAL*) ",
                    "HG" => "Held on Ground   (OPTIONAL) ",
                    "HR" => "Hold Released   (OPTIONAL) ",
                    "IB" => "U.S. Customs, In-bond Movement Authorized   (OPTIONAL) ",
                    "IR" => "Movement Type Changed from In-bond to Not In-bond   (OPTIONAL) ",
                    "NF" => "Free Time to Expire   (CONDITIONAL*) ",
                    "NH" => "No Hazardous Material Document Received   (OPTIONAL) ",
                    "NR" => "Shipment Information Not Received   (OPTIONAL) ",
                    "OA" => "Out-Gate     (MANDATORY per Shipment Lifecycle) ",
                    "OB" => "Original Bill of Lading Received   (CONDITIONAL*) ",
                    "PA" => "US Custom Hold, Intensive Examination   (CONDITIONAL*) ",
                    "PB" => "US Custom Hold, Insufficient Paperwork    (CONDITIONAL*) ",
                    "PC" => "US Custom Hold, Discrepancy in Paperwork    (CONDITIONAL*) ",
                    "PE" => "US Custom Hold, Hold by Coast Guard    (CONDITIONAL*) ",
                    "PF" => "US Custom Hold, Hold by F.B.I.    (CONDITIONAL*) ",
                    "PG" => "US Custom Hold, Hold by Local Law Enforcement    (CONDITIONAL*) ",
                    "PH" => "US Custom Hold, Hold by Court Imposed Lien   (CONDITIONAL*) ",
                    "PI" => "US Custom Hold, Hold by Food and Drug   (CONDITIONAL*) ",
                    "PJ" => "US Custom Hold, Hold by Fish and Wildlife   (CONDITIONAL*) ",
                    "PK" => "US Custom Hold, Hold by Drug Enforcement    (CONDITIONAL*) ",
                    "PL" => "US Dept. Agr, Hold for Intensive Investigation   (CONDITIONAL*) ",
                    "PM" => "US Dept. Agr, Hold for Unregistered Producer   (CONDITIONAL*) ",
                    "PN" => "US Dept. Agr, Hold for Restricted Commodity    (CONDITIONAL*) ",
                    "PO" => "US Dept. Agr, Hold for Insect Infestation   (CONDITIONAL*) ",
                    "PP" => "US Dept. Agr, Hold for Bacterial Contamination   (CONDITIONAL*) ",
                    "PQ" => "U.S. Customs Hold at Place of Vessel Arrival   (CONDITIONAL*) ",
                    "PR" => "U.S. Customs Hold at In-Bond Destination   (CONDITIONAL*) ",
                    "PS" => "U.S. Department of Agriculture Hold at Place of Vessel Arrival    (CONDITIONAL*) ",
                    "PT" => "U.S. Department of Agriculture Hold at In-Bond Destination    (CONDITIONAL*) ",
                    "PU" => "Other U.S. Agency Hold at Place of Vessel Arrival    (CONDITIONAL*) ",
                    "PV" => "Other U.S. Agency Hold at In-Bond Destination    (CONDITIONAL*) ",
                    "PW" => "U.S. Department of Agriculture, Hold for Fumigation   (CONDITIONAL*) ",
                    "PX" => "U.S. Department of Agriculture, Hold for Inspection or Documentation Review  (CONDITIONAL*) ",
                    "RD" => "Empty Container Returned    (MANDATORY per Shipment Lifecycle) ",
                    "RI" => "Movement Type Changed from Not In-bond to In-bond   (OPTIONAL) ",
                    "RL" => "Rail Departure from Origin Intermodal Ramp  (CONDITIONAL*)",
                    "SA" => "Shipment Split /Split Booking     (CONDITIONAL*) ",
                    "SB" => "Shipment Consolidation     (CONDITIONAL*) ",
                    "SI" => "Receipt of Shipping Instructions   (CONDITIONAL*) ",
                    "TC" => "Held for Terminal Charges   (OPTIONAL) ",
                    "UR" => "Unloaded from a Rail Car    (CONDITIONAL*) ",
                    "UV" => "Unloaded From Vessel    (MANDATORY per Shipment Lifecycle) ",
                    "VA" => "Vessel Arrival    (MANDATORY per Shipment Lifecycle)",
                    "VD" => "Vessel Departure    (MANDATORY per Shipment Lifecycle) ",
                    "X1" => "Arrived at Delivery Location    (CONDITIONAL*) ",
                    "X6" => "En Route to Delivery Location   (OPTIONAL) ",
                    "X9" => "Delivery Appointment Secured   (OPTIONAL) "
                )
            ),
            3 => array(
                "NAME" => "Date",
                "REQUIRE" => "O",
                "TYPE" => "DT",
                "MIN" => "8",
                "MAX" => "8",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            4 => array(
                "NAME" => "Status Time",
                "REQUIRE" => "O",
                "TYPE" => "AN",
                "MIN" => "4",
                "MAX" => "4",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: Local Time of the Event",
                "CODES" => array()
            ),
            5 => array(
                "NAME" => "Status Location",
                "REQUIRE" => "O",
                "TYPE" => "AN",
                "MIN" => "3",
                "MAX" => "5",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: Special use: Please send Schedule D, K, or UNLOCODE (Preferred) here and specify the type (D, K, or UN) by sending the appropriate qualifier in B412.",
                "CODES" => array()
            ),
            6 => array(
                "NAME" => "Equipment Initial",
                "REQUIRE" => "X",
                "TYPE" => "AN",
                "MIN" => "1",
                "MAX" => "4",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            7 => array(
                "NAME" => "Equipment Number",
                "REQUIRE" => "X",
                "TYPE" => "AN",
                "MIN" => "1",
                "MAX" => "10",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: . Equipment Number in which Event applies to",
                "CODES" => array()
            ),
            8 => array(
                "NAME" => "Equipment Status Code",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "2",
                "USAGE" => "Recommended",
                "COMMENT" => "",
                "CODES" => array(
                    "E" => "Empty",
                    "L" => "Load"
                )
            ),
            9 => array(
                "NAME" => "Equipment Type",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "4",
                "MAX" => "4",
                "USAGE" => "Optonaly Sent",
                "COMMENT" => "Carrier Notes: In ISO Standard",
                "CODES" => array()
            ),
            10 => array(
                "NAME" => "Location Identifier",
                "REQUIRE" => "X",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: Special Use: Please send the full text name of the Status Location here.  (Note: not applicable for Custom Events)",
                "CODES" => array()
            ),
            11 => array(
                "NAME" => "Location Qualifier",
                "REQUIRE" => "X",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: Special Use: Please send the Qualifier to denote type of data sent in B406. (Prefer UNLOCODE)",
                "CODES" => array(
                    "D" => "Census Schedule D",
                    "K" => "Census Schedule K",
                    "UN" => "United Nations Location Code, UNLOCODE  (PREFERRED)"
                )
            ),
            12 => array(
                "NAME" => "Equipment Number Check Digit",
                "REQUIRE" => "O",
                "TYPE" => "NO",
                "MIN" => "1",
                "MAX" => "1",
                "USAGE" => "Optionaly Sent",
                "COMMENT" => "Carrier Notes: Physical Painted Check Digit",
                "CODES" => array()
            ),
        ), // !!!!!!!!!!!!!!!!!!!!!!!!!!
        "N9" => array(
            1 => array(
                "NAME" => "Reference Identification Qualifier",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "3",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "4F" => "Carrier-assigned Shipper Number (RECOMMENDED) Carrier Notes: Identifies the Account Code for the Seechange Customer who you are sending EDI on behalf of. (Also send the name of the Seechange Customer in N9*IC) ",
                    "6A" => "Consignee Reference Number (RECOMMENDED) Carrier Notes: To be used to identify specific consignee",
                    "BM" => " Ocean Bill of Lading Number (MANDATORY) Carrier Notes: Use this qualifier to send the Forwarder House Bill of Lading (HBL#) or APLL HBL# (if it is APLL NVO). Send without the SCAC Prefix ** Send only one 'BM' value per 315 transaction ** The HBL# is required before any status/activity can be uploaded into See Change. we do not accept the Master B/L in place of the HBL.  The HBL is mandatory.  Only the House B/L will be used to receive status for NVO shipments ",
                    "BN" => "Booking Number (OPTIONAL)",
                    "CB" => "Combined Shipment (CONDITIONAL*) ",
                    "CR" => "Customer Reference Number (OPTIONAL) ",
                    "CT" => "Contract Number (RECOMMENDED)",
                    "EQ" => "Equipment Number (MANDATORY) Carrier Notes: ** Send only one 'EQ' value per 315 transaction ",
                    "IB" => "In Bond Number (IT NUMBER -CONDITIONAL)",
                    "IC" => " Inbound-to Party (MANDATORY) Carrier Notes: Send the name of the Customer or Division in plain text for easy recogition of for whom the transaction set is for. (ie: Nike, VF Intimates, Phillips, Rubbermaid Dymo, etc...)",
                    "PO" => "Purchase Order Number (OPTIONAL) ",
                    "S5" => "Routing Instruction Number / Split From Booking Number (CONDITIONAL*) ",
                    "SI" => "Shipper's Identifying Number for Shipment / SID (OPTIONAL) ",
                    "SN" => "Seal Number (CONDITIONAL*)",
                    "SCA" => "Standard Carrier Alpha Code, SCAC (OPTIONAL) Carrier Notes: SCAC of Owner of BL#"
                )
            ),
            2 => array(
                "NAME" => "Reference Identification",
                "REQUIRE" => "X",
                "TYPE" => "AN",
                "MIN" => "1",
                "MAX" => "30",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            3 => array(
                "NAME" => "Free-form Description",
                "REQUIRE" => "X",
                "TYPE" => "AN",
                "MIN" => "1",
                "MAX" => "45",
                "USAGE" => "Conditionally Sent",
                "COMMENT" => "Carrier Notes: Mandatory when N901  = 4F or SN Examples: N9*4F*NI2452*NIKE~ N9*SN*178302002*Carriers~",
                "CODES" => array()
            ),
            4 => array(
                "NAME" => "Date",
                "REQUIRE" => "O",
                "TYPE" => "DT",
                "MIN" => "8",
                "MAX" => "8",
                "USAGE" => "Conditionally Sent",
                "COMMENT" => "Carrier Notes: Required when inbond number or IT number (qualifier IB) is sent in N901/N902",
                "CODES" => array()
            ),
            5 => array(
                "NAME" => "Time",
                "REQUIRE" => "X",
                "TYPE" => "TM",
                "MIN" => "4",
                "MAX" => "8",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "",
                "CODES" => array()
            ),
            6 => array(
                "NAME" => "Time Code",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "2",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "",
                "CODES" => array(
                    "LT" => "Local Time"
                )
            ),
        ),
        "Q2" => array(
            1 => array(
                "NAME" => "Vessel Code",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "8",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "Carrier Notes: Lloyd Code identifying the Vessel or the Relay Vessel",
                "CODES" => array()
            ),
            2 => array(
                "NAME" => "Country Code",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "3",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "Carrier Notes: Code of Registration",
                "CODES" => array()
            ),
            3 => array(
                "NAME" => "Date",
                "REQUIRE" => "O",
                "TYPE" => "DT",
                "MIN" => "8",
                "MAX" => "8",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "",
                "CODES" => array()
            ),
            4 => array(
                "NAME" => "Date",
                "REQUIRE" => "O",
                "TYPE" => "DT",
                "MIN" => "8",
                "MAX" => "8",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "Carrier Notes: Departure Date Examples: A) Date Vessel Departed DISCHARGE  port B) Date Vessel Departed Relay Port C) Date Vessel Expected to Depart LOAD port",
                "CODES" => array()
            ),
            5 => array(
                "NAME" => "Date",
                "REQUIRE" => "O",
                "TYPE" => "DT",
                "MIN" => "8",
                "MAX" => "8",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "Carrier Notes: Arrival Date Examples A) Date Vessel Arrived at DISCHARGE port B) Date Vessel Arrived at Relay Port C) Date Vessel Expected to Arrive LOAD port",
                "CODES" => array()
            ),
            6 => array(
                "NAME" => "Lading Quantity",
                "REQUIRE" => "O",
                "TYPE" => "NO",
                "MIN" => "1",
                "MAX" => "7",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "",
                "CODES" => array()
            ),
            7 => array(
                "NAME" => "Weight",
                "REQUIRE" => "X",
                "TYPE" => "R",
                "MIN" => "1",
                "MAX" => "10",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "",
                "CODES" => array()
            ),
            8 => array(
                "NAME" => "Weight Quantity",
                "REQUIRE" => "X",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "2",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "",
                "CODES" => array(
                    "G" => "Gross Weight",
                    "N" => "Actual Net Weight"
                )
            ),
            9 => array(
                "NAME" => "Flight/Voyage Number",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "2",
                "MAX" => "10",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "",
                "CODES" => array()
            ),
            10 => array(
                "NAME" => "Reference Identification Qualifier",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "3",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "AF" => "Airlines Flight Identification Number",
                    "SCA" => "Standart Carrier Alpha Code (SCAC)"
                )
            ),
            11 => array(
                "NAME" => "Reference Identification",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "1",
                "MAX" => "30",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: SCAC of Vessel Owner",
                "CODES" => array()
            ),
            12 => array(
                "NAME" => "Vessel Code Qualifier",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "1",
                "USAGE" => "Must Send",
                "COMMENT" => "Carrier Notes: SCAC of Vessel Owner",
                "CODES" => array(
                    "C" => "Ship`s Radio Call Signal",
                    "L" => "Lloyd`s Register of Shipping"
                )
            ),
            13 => array(
                "NAME" => "Vessel Name",
                "REQUIRE" => "O",
                "TYPE" => "AN",
                "MIN" => "2",
                "MAX" => "28",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "Carrier Notes: Name of Vessel associated with closest activity",
                "CODES" => array()
            ),
            14 => array(
                "NAME" => "Volume",
                "REQUIRE" => "X",
                "TYPE" => "R",
                "MIN" => "1",
                "MAX" => "8",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "",
                "CODES" => array()
            ),
            15 => array(
                "NAME" => "Volume Unit Qualifier",
                "REQUIRE" => "X",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "1",
                "USAGE" => "Conditionally Sent",
                "COMMENT" => "",
                "CODES" => array(
                    "E" => "Cubic Feet",
                    "X" => "Cubic Meters"
                )
            ),
            16 => array(
                "NAME" => "Weight Unit Code",
                "REQUIRE" => "X",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "1",
                "USAGE" => "Optionally Sent",
                "COMMENT" => "",
                "CODES" => array(
                    "K" => "Kilograms",
                    "L" => "Pounds"
                )
            )
        ),
        "R4" => array(
            1 => array(
                "NAME" => "Port or Terminal Function Code",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "1",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "1" => "Final Port of Discharge (CONDITIONAL*) Carrier Notes: EITHER 1 or D is Mandatory on EVERY 315 message. ",
                    "D" => "Port of Discharge   (CONDITIONAL*) Carrier Notes: EITHER 1 or D is Mandatory on EVERY 315 message.",
                    "E" => "Place of Delivery  (MANDATORY) Carrier Notes: Mandatory on EVERY 315 message",
                    "I" => "Interim Point   (CONDITIONAL*)",
                    "L" => "Port of Loading  (MANDATORY) Carrier Notes: Mandatory on EVERY 315 message.",
                    "R" => "Place of Receipt  (RECOMMENDED*) Carrier Notes: Recommended on EVERY 315 message.",
                    "Y" => "Relay Port    (CONDITIONAL*)"
                )
            ),
            2 => array(
                "NAME" => "Location Qualifier",
                "REQUIRE" => "X",
                "TYPE" => "ID",
                "MIN" => "1",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "D" => "Census Schedule D",
                    "K" => "Census Schedule K",
                    "UN" => "United Nations Location Code, UNLOCODE (PREFERED)"
                )
            ),
            3 => array(
                "NAME" => "Location Identifier",
                "REQUIRE" => "X",
                "TYPE" => "AN",
                "MIN" => "1",
                "MAX" => "30",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            4 => array(
                "NAME" => "Port Name",
                "REQUIRE" => "O",
                "TYPE" => "AN",
                "MIN" => "2",
                "MAX" => "24",
                "USAGE" => "Recommended",
                "COMMENT" => "",
                "CODES" => array()
            ),
            5 => array(
                "NAME" => "Country Name",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "3",
                "USAGE" => "Recommended",
                "COMMENT" => "Carrier Notes: ISO Country Code",
                "CODES" => array()
            ),
            6 => array(
                "NAME" => "State Of Province Code",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "2",
                "USAGE" => "Recommended",
                "COMMENT" => "",
                "CODES" => array()
            )
        ),
        "DTM" => array(
            1 => array(
                "NAME" => "Date/Time Qualifier",
                "REQUIRE" => "M",
                "TYPE" => "ID",
                "MIN" => "3",
                "MAX" => "3",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "139" => "Estimated Arrival Date Carrier Notes: When R401 = L, Send only if POL is different than POR When R401 = D, Required When R401 = E, Required",
                    "140" => "Actual Arrival Date Carrier Notes: When R401 = L, Send when first available only if POL is different than POR When R401 = D, Required when first available When R401 = E, Required when first available",
                    "369" => "Estimated Departure Date Carrier Notes: When R401 = L, Required and if POL is same as POR send the same date for both When R401 = R, Required",
                    "370" => "Actual Departure Date Carrier Notes: When R401 = L, Required when first available and if POL is same as POR send the same date for both When R401 = R, Required when first available",
                )
            ),
            2 => array(
                "NAME" => "Date",
                "REQUIRE" => "X",
                "TYPE" => "DT",
                "MIN" => "8",
                "MAX" => "8",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            3 => array(
                "NAME" => "Time",
                "REQUIRE" => "X",
                "TYPE" => "TM",
                "MIN" => "4",
                "MAX" => "8",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            4 => array(
                "NAME" => "Time Code",
                "REQUIRE" => "O",
                "TYPE" => "ID",
                "MIN" => "2",
                "MAX" => "2",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array(
                    "CS" => "Central Standart Time",
                    "ES" => "Eastern Standart Time",
                    "ET" => "Eastern Time",
                    "LT" => "Local Time",
                    "PS" => "Pacific Standart Time",
                )
            )
        ),
        "SE" => array(
            1 => array(
                "NAME" => "Number of Included Segments",
                "REQUIRE" => "M",
                "TYPE" => "NO",
                "MIN" => "1",
                "MAX" => "10",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            2 => array(
                "NAME" => "Transaction Set Control Number",
                "REQUIRE" => "M",
                "TYPE" => "AN",
                "MIN" => "4",
                "MAX" => "9",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
        ),
        "GE" => array(
            1 => array(
                "NAME" => "Number of Transaction Sets Included",
                "REQUIRE" => "M",
                "TYPE" => "NO",
                "MIN" => "1",
                "MAX" => "6",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            2 => array(
                "NAME" => "Group Control Number",
                "REQUIRE" => "M",
                "TYPE" => "NO",
                "MIN" => "1",
                "MAX" => "9",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
        ),
        "IEA" => array(
            1 => array(
                "NAME" => "Number of Included Functional Groups",
                "REQUIRE" => "M",
                "TYPE" => "NO",
                "MIN" => "1",
                "MAX" => "5",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            ),
            2 => array(
                "NAME" => "Interchange Control Number",
                "REQUIRE" => "M",
                "TYPE" => "NO",
                "MIN" => "9",
                "MAX" => "9",
                "USAGE" => "Must Send",
                "COMMENT" => "",
                "CODES" => array()
            )
        ),


    );
    public function __construct($arr)
    {
        $this->arr = $arr;
        $this->Structurise();
        $this->SubStructurise();
    }

    private function Structurise() {
        foreach ($this->arr as $item){
            if (array_key_exists($item[0]['VALUE'],$this->Description)){
                $data['DATA'] = $item;
                $data['DESC'] = $this->Description[$item[0]['VALUE']];
                $this->arr_desc[] = $data;
            }
            else {
                $this->arr_desc['ERROR'][] = $item[0]['VALUE'];
              // nothing
            }
        }
    }

    private function SubStructurise() {
        foreach ($this->arr_desc as $k => $v) {
            if(array_key_exists($this->arr_desc[$k]['DATA'][0]['VALUE'], $this->SubDescription)) {
                foreach ($this->SubDescription[$this->arr_desc[$k]['DATA'][0]['VALUE']] as $m => $n){
                    $this->arr_desc[$k]['DATA'][$m]['DESC'] = $n;
                }
            }
        }


    }
}