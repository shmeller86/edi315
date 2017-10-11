<?php
/**
 * Created by PhpStorm.
 * User: che
 * Date: 09.10.2017
 * Time: 12:53
 */

namespace app\EDI315GEN;

class Generate315
{
    private $row = array(
        'ID' => '13',
        'SENDER' => 'YLRUS',
        'GCN' => '000041552',
        'TYPE_EVENT' => 'VD',
        'DT_CREATE' => '20.04.2017 12:36',
        'UNCODE' => 'MYTPP',
        'SCAC' => 'MAEU',
        'CONT_NUMBER' => 'MAEU6226029',
        'BOOKING' => '100220102026A',

        'VESSEL_NUMBER' => '300W',
        'VESSEL_CODE' => '9308649',
        'VESSEL_NAME' => 'MAERSK SINGAPORE',

        'ACTUAL_DATE_DEPARTURE' => '09.10.2017 13:42',
        'ACTUAL_DATE_DEPARTURE_RELAY' => '',

        'TARGET_DATE_ARRIVAL' => '',
        'ACTUAL_DATE_ARRIVAL' => '',

        'ACTUAL_DATE_EXPORTATION' => '',
        'TARGET_DATE_EXPORTATION' => '',

        'ACTUAL_DATE_DELIVERY' => '',
        'TARGET_DATE_DELIVERY' => '20.10.2017 15:10',

        'DT_GENERATE' => '',
        'ID_LIST_ORDER' => '',
        'ID_LIST_TRAFFIC' => '',

        'COUNTRY_DEPARTURE' => '',
        'COUNTRY_ARRIVAL' => '',
        'COUNTRY_EXPORTATION' => '',
        'COUNTRY_DELIVERY' => '',

        'PORT_DEPARTURE' => 'TANJUNG PELEPAS',
        'PORT_DEPARTURE_CODE' => 'MYTPP',

        'PORT_ARRIVAL' => '',
        'PORT_ARRIVAL_CODE' => '',

        'PORT_EXPORTATION' => '',
        'PORT_EXPORTATION_CODE' => '',

        'PORT_DELIVERY' => 'SAINT-PETERSBURG',
        'PORT_DELIVERY_CODE' => 'RULED'
    );

    public function __construct()
    {
        /**
         * VESSEL DEPARTURE
         */
        if($this->row['TYPE_EVENT'] == 'VD')
        {
            $this->genVesselDeparture();
        }

        /**
         * Vessel Departure Relay
         */
        if($this->row['TYPE_EVENT'] == 'VD')
        {
            $this->genVesselDepartureRelay();
        }

        /**
         *  Vessel Arrival (Estimated)
         */
        if($this->row['TYPE_EVENT'] == 'VA')
        {
            $this->genVesselArrivalEstim();
        }

        /**
         *  Vessel Arrival (Actual)
         */
        if($this->row['TYPE_EVENT'] == 'VA')
        {
            $this->genVesselArrivalActual();
        }

        /**
         *  Actual date of departure from Port of destination (Estimated)
         */
        if($this->row['TYPE_EVENT'] == 'X6')
        {
            $this->genDeparturePortDestinEstim();
        }

        /**
         *  Actual date of departure from Port of destination (Actual)
         */
        if($this->row['TYPE_EVENT'] == 'X6')
        {
            $this->genDeparturePortDestinActual();
        }

        /**
         *  Actual date of delivery to DC (Estimated)
         */
        if($this->row['TYPE_EVENT'] == 'X1')
        {
            $this->genDeliveryDcEdstim();
        }

        /**
         *  Actual date of delivery to DC (Actual)
         */
        if($this->row['TYPE_EVENT'] == 'X1')
        {
            $this->genDeliveryDcActual();
        }
    }


    public $message;

    public function genVesselDeparture(){

        // HEADER ------------
        // ISA
        $date = date("ymd", strtotime($this->row['DT_CREATE']));
        $time = date("Hi", strtotime($this->row['DT_CREATE']));
        $this->message = "ISA*00*   *00*   *ZZ*{$this->row['SENDER']}  *ZZ*APLUNET *{$date}*{$time}*U*00401*{$this->row['GCN']}*0*P*:~\n";

        // GS
        $date = date("Ymd", strtotime($this->row['DT_CREATE']));
        $time = date("Hi", strtotime($this->row['DT_CREATE']));
        $this->message .= "GS*QO*{$this->row['SENDER']}*APLUNET*{$date}*{$time}*{$this->row['GCN']}*X*004010~\n";

        //ST
        $this->message .= "ST*315*0001~\n";

        //B4
        $date = date("Ymd", strtotime($this->row['ACTUAL_DATE_DEPARTURE']));
        $time = date("Hi", strtotime($this->row['ACTUAL_DATE_DEPARTURE']));
        $b4_con_num = substr($this->row['CONT_NUMBER'], 0, 4);
        $this->message .= "B4***{$this->row['TYPE_EVENT']}*{$date}*{$time}*{$this->row['UNCODE']}*{$this->row['SCAC']}*{$b4_con_num}***{$this->row['PORT_DEPARTURE']}*UN~\n";

        //N9
        $this->message .= "N9*BM*{$this->row['BOOKING']}~\n";
        $this->message .= "N9*SCA*{$this->row['SCAC']}~\n";
        $this->message .= "N9*EQ*{$this->row['CONT_NUMBER']}~\n";

        //Q2
        $this->message .= "Q2*{$this->row['VESSEL_CODE']}********{$this->row['VESSEL_NUMBER']}***L*{$this->row['VESSEL_NAME']}~\n";

        //LOOP R4 & DTM
        // 1. code=L (Port of loading MANDATORY)
        $date = date("Ymd", strtotime($this->row['ACTUAL_DATE_DEPARTURE']));
        $time = date("Hi", strtotime($this->row['ACTUAL_DATE_DEPARTURE']));
        $countrycode = substr($this->row['PORT_DEPARTURE_CODE'], 0, 2);
        $this->message .= "R4*L*UN*{$this->row['PORT_DEPARTURE_CODE']}*{$this->row['PORT_DEPARTURE']}*{$countrycode}~\n";
        $this->message .= "DTM*370*{$date}*{$time}*LT~\n";

        // 2. code=E (Place of Dilevery MANDATORY)
        $date = date("Ymd", strtotime($this->row['TARGET_DATE_DELIVERY']));
        $time = date("Hi", strtotime($this->row['TARGET_DATE_DELIVERY']));
        $countrycode = substr($this->row['PORT_DELIVERY_CODE'], 0, 2);
        $this->message .= "R4*E*UN*{$this->row['PORT_DELIVERY_CODE']}*{$this->row['PORT_DELIVERY']}*{$countrycode}~\n";
        $this->message .= "DTM*139*{$date}*{$time}*LT~\n";

        //SE*15*0001
        $this->message .= "SE*15*0001~\n";

        // GE*1*2894
        $this->message .= "GE*1*{$this->row['GCN']}~\n";

        // IEA*1*000002894
        $this->message .= "IEA*1*{$this->row['GCN']}~\n";
    }
    public function genVesselDepartureRelay(){}

    public function genVesselArrivalEstim(){}
    public function genVesselArrivalActual(){}

    public function genDeparturePortDestinActual(){}
    public function genDeparturePortDestinEstim(){}

    public function genDeliveryDcActual(){}
    public function genDeliveryDcEdstim(){}
}