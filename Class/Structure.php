<?php
/**
 * Created by PhpStorm.
 * User: che
 * Date: 22.09.2017
 * Time: 14:29
 */

namespace EDI;


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