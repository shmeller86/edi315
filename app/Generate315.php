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

    /**
     * Счетчик, который передается в футере, указывает сколько сообщений
     * содержит данный EDI файл
     * @var int
     */
    private $counter_body_msg = 0;

    /**
     * Id с добавлением нулей в начало, приведенный к 9 символам
     * @var
     */
    private $ID_full;

    /**
     * Id отдельно, нужен, чтобы когда будет группа сообщений, в футере
     * поставить id первой записи, в дальше будет работать $ID_st идентифицирующий
     * локальное сообщение в рамках одной транзации
     * @var
     */
    private $ID;

    /**
     * ID вложенного сообщения формируется из ID первого сообщения + счетчик в конце до 99 сообщений
     * в промежутке 0, число приведено к 9 цифрам
     * @var
     */
    private $ID_st;

    /**
     * Проверка созданной шапки, нужен для сообщений с вложениями, кода передается
     * 1 шапка и в теле несколько событий
     * @var int
     */
    private $checkHeader = 0;

    /**
     * Объект с выборкой
     * @var array|object
     */
    private $row = array();


    public function __construct()
    {

        $connection = ibase_connect("127.0.0.1/3055:/home/gsoft/db/CARGOSMART.FDB", "EDI", "gsoftGSOFT");
        $q = "select * from edi_generate_315 order by id asc";
        $res = ibase_query($connection, $q);
        while($this->row = ibase_fetch_object($res)){
            /**
             * VESSEL DEPARTURE
             */
            if($this->row->TYPE_EVENT == 'VD')
            {
                $this->counter_body_msg++;
                $this->genVesselDeparture();
            }

            /**
             * Vessel Departure Relay
             */
            if($this->row->TYPE_EVENT == 'VDR')
            {
                $this->counter_body_msg++;
                $this->genVesselDepartureRelay();
            }

            /**
             *  Vessel Arrival (Estimated)
             */
            if($this->row->TYPE_EVENT == 'VA')
            {
                $this->counter_body_msg++;
                $this->genVesselArrivalEstim();
            }

            /**
             *  Vessel Arrival (Actual)
             */
            if($this->row->TYPE_EVENT == 'VA')
            {
                $this->counter_body_msg++;
                $this->genVesselArrivalActual();
            }

            /**
             *  Actual date of departure from Port of destination (Estimated)
             */
            if($this->row->TYPE_EVENT == 'X6')
            {
                $this->counter_body_msg++;
                $this->genDeparturePortDestinEstim();
            }

            /**
             *  Actual date of departure from Port of destination (Actual)
             */
            if($this->row->TYPE_EVENT == 'X6')
            {
                $this->counter_body_msg++;
                $this->genDeparturePortDestinActual();
            }

            /**
             *  Actual date of delivery to DC (Estimated)
             */
            if($this->row->TYPE_EVENT == 'X1')
            {
                $this->counter_body_msg++;
                $this->genDeliveryDcEdstim();
            }

            /**
             *  Actual date of delivery to DC (Actual)
             */
            if($this->row->TYPE_EVENT == 'X1')
            {
                $this->counter_body_msg++;
                $this->genDeliveryDcActual();
            }
        }

        // GE*1*2894
        $this->message .= "GE*{$this->counter_body_msg}*{$this->ID}~\n";

        // IEA*1*000002894
        $this->message .= "IEA*1*{$this->ID_full}~\n";

    }


    public $message;

    public function genVesselDeparture(){
        // счетчик количества строк в теле одного сообщения
        $SE_COUNTER = 0;
        if(!$this->checkHeader) {
            /*
             *                           ISA
             */
            $date = date("ymd", strtotime($this->row->DT_CREATE));
            $time = date("Hi", strtotime($this->row->DT_CREATE));
            $this->ID_full = $this->row->ID;
            for ($i = count($this->ID_full); $i <= 8; $i++) {
                $this->ID_full = "0" . $this->ID_full;
            }
            $this->message = "ISA*00*          *00*          *ZZ*YLRUS          *ZZ*APLUNET        *{$date}*{$time}*U*00401*{$this->ID_full}*0*P*:~\n";
            /*
             *                            GS
             */
            $date = date("Ymd", strtotime($this->row->DT_CREATE));
            $time = date("Hi", strtotime($this->row->DT_CREATE));
            $this->message .= "GS*QO*YLRUS*APLUNET*{$date}*{$time}*{$this->row->ID}*X*004010~\n";

            // Признак установленной шапки. Нужна для групп сообщений, т.к. сообщений может быть много, а Header один
            $this->checkHeader = 1;
        }
        /*
         *                          ST
         * Добавляем порядковый номер для сообщения, вдруг их больше 1
         */
        if(!isset($this->ID_st)) {
            $this->ID_st = $this->row->ID;
            $this->ID = $this->row->ID;
            for ($i = count($this->ID_full); $i <= 6; $i++) {
                $this->ID_st .= "0";
            }
            (int)$this->ID_st .= substr($this->row->ID, -2, 2);
        }
        else (int)$this->ID_st++;
        $this->message .= "ST*315*{$this->ID_st}~\n";
        ++$SE_COUNTER;
        /*
         *                          B4
         */
        $date = date("Ymd", strtotime($this->row->ACTUAL_DATE_DEPARTURE));
        $time = date("Hi", strtotime($this->row->ACTUAL_DATE_DEPARTURE));
        $b4_con_num = substr($this->row->CONTAINERS, 4);
        $this->row->SCAC = substr($this->row->CONTAINERS, 0, 4);
        $this->message .= "B4***VD*{$date}*{$time}*{$this->row->PORT_DEPARTURE_CODE}*{$this->row->SCAC}*{$b4_con_num}***{$this->row->PORT_DEPARTURE}*UN~\n";
        ++$SE_COUNTER;
        /*
         *                          N9
         */
        $this->message .= "N9*BM*{$this->row->BOOKING}~\n";
        ++$SE_COUNTER;
        $this->message .= "N9*SCA*{$this->row->SCAC}~\n";
        ++$SE_COUNTER;
        $this->message .= "N9*EQ*{$this->row->CONTAINERS}~\n";
        ++$SE_COUNTER;
        /*
         *                          Q2
         */
        $this->message .= "Q2*********{$this->row->VESSEL_NUMBER}***L*{$this->row->VESSEL_NAME}~\n";
        ++$SE_COUNTER;
        /*
         *                     LOOP R4 & DTM
         *               1. code=L (Port of loading MANDATORY)
         */
        $date = date("Ymd", strtotime($this->row->ACTUAL_DATE_DEPARTURE));
        $time = date("Hi", strtotime($this->row->ACTUAL_DATE_DEPARTURE));
        $countrycode = substr($this->row->PORT_DEPARTURE_CODE, 0, 2);
        $this->message .= "R4*L*UN*{$this->row->PORT_DEPARTURE_CODE}*{$this->row->PORT_DEPARTURE}*{$countrycode}~\n";
        ++$SE_COUNTER;
        $this->message .= "DTM*370*{$date}*{$time}*LT~\n";
        ++$SE_COUNTER;
        // 2. code=D (Place of Discharge MANDATORY)
        $date = date("Ymd", strtotime($this->row->TARGET_DATE_ARRIVAL));
        $time = date("Hi", strtotime($this->row->TARGET_DATE_ARRIVAL));
        $countrycode = substr($this->row->PORT_ARRIVAL_CODE, 0, 2);
        $this->message .= "R4*D*UN*{$this->row->PORT_ARRIVAL_CODE}*{$this->row->PORT_ARRIVAL}*{$countrycode}~\n";
        ++$SE_COUNTER;
        $this->message .= "DTM*139*{$date}*{$time}*LT~\n";
        ++$SE_COUNTER;
        // 2. code=E (Place of Dilevery MANDATORY)
        $date = date("Ymd", strtotime($this->row->TARGET_DATE_ARRIVAL));
        $time = date("Hi", strtotime($this->row->TARGET_DATE_ARRIVAL));
        $countrycode = substr($this->row->PORT_ARRIVAL_CODE, 0, 2);
        $this->message .= "R4*E*UN*{$this->row->PORT_ARRIVAL_CODE}*{$this->row->PORT_ARRIVAL}*{$countrycode}~\n";
        ++$SE_COUNTER;
        $this->message .= "DTM*139*{$date}*{$time}*LT~\n";
        ++$SE_COUNTER;
        //SE*15*0001
        ++$SE_COUNTER;
        $this->message .= "SE*{$SE_COUNTER}*{$this->ID_st}~\n";
    }
    public function genVesselDepartureRelay(){}

    public function genVesselArrivalEstim(){
        // счетчик количества строк в теле одного сообщения
        $SE_COUNTER = 0;
        if(!$this->checkHeader) {
            /*
             *                           ISA
             */
            $date = date("ymd", strtotime($this->row->DT_CREATE));
            $time = date("Hi", strtotime($this->row->DT_CREATE));
            $this->ID_full = $this->row->ID;
            for ($i = count($this->ID_full); $i <= 8; $i++) {
                $this->ID_full = "0" . $this->ID_full;
            }
            $this->message = "ISA*00*          *00*          *ZZ*YLRUS          *ZZ*APLUNET        *{$date}*{$time}*U*00401*{$this->ID_full}*0*P*:~\n";
            /*
             *                            GS
             */
            $date = date("Ymd", strtotime($this->row->DT_CREATE));
            $time = date("Hi", strtotime($this->row->DT_CREATE));
            $this->message .= "GS*QO*YLRUS*APLUNET*{$date}*{$time}*{$this->row->ID}*X*004010~\n";

            // Признак установленной шапки. Нужна для групп сообщений, т.к. сообщений может быть много, а Header один
            $this->checkHeader = 1;
        }
        /*
         *                          ST
         * Добавляем порядковый номер для сообщения, вдруг их больше 1
         */
        if(!isset($this->ID_st)) {
            $this->ID_st = $this->row->ID;
            $this->ID = $this->row->ID;
            for ($i = count($this->ID_full); $i <= 6; $i++) {
                $this->ID_st .= "0";
            }
            (int)$this->ID_st .= substr($this->row->ID, -2, 2);
        }
        else (int)$this->ID_st++;
        $this->message .= "ST*315*{$this->ID_st}~\n";
        ++$SE_COUNTER;
        /*
         *                          B4
         */
        $date = date("Ymd", strtotime($this->row->ACTUAL_DATE_DEPARTURE));
        $time = date("Hi", strtotime($this->row->ACTUAL_DATE_DEPARTURE));
        $b4_con_num = substr($this->row->CONTAINERS, 4);
        $this->row->SCAC = substr($this->row->CONTAINERS, 0, 4);
        $this->message .= "B4***VD*{$date}*{$time}*{$this->row->PORT_DEPARTURE_CODE}*{$this->row->SCAC}*{$b4_con_num}***{$this->row->PORT_DEPARTURE}*UN~\n";
        ++$SE_COUNTER;
        /*
         *                          N9
         */
        $this->message .= "N9*BM*{$this->row->BOOKING}~\n";
        ++$SE_COUNTER;
        $this->message .= "N9*SCA*{$this->row->SCAC}~\n";
        ++$SE_COUNTER;
        $this->message .= "N9*EQ*{$this->row->CONTAINERS}~\n";
        ++$SE_COUNTER;
        /*
         *                          Q2
         */
        $this->message .= "Q2*********{$this->row->VESSEL_NUMBER}***L*{$this->row->VESSEL_NAME}~\n";
        ++$SE_COUNTER;
        /*
         *                     LOOP R4 & DTM
         *               1. code=L (Port of loading MANDATORY)
         */
        $date = date("Ymd", strtotime($this->row->ACTUAL_DATE_DEPARTURE));
        $time = date("Hi", strtotime($this->row->ACTUAL_DATE_DEPARTURE));
        $countrycode = substr($this->row->PORT_DEPARTURE_CODE, 0, 2);
        $this->message .= "R4*L*UN*{$this->row->PORT_DEPARTURE_CODE}*{$this->row->PORT_DEPARTURE}*{$countrycode}~\n";
        ++$SE_COUNTER;
        $this->message .= "DTM*370*{$date}*{$time}*LT~\n";
        ++$SE_COUNTER;
        // 2. code=D (Place of Discharge MANDATORY)
        $date = date("Ymd", strtotime($this->row->TARGET_DATE_ARRIVAL));
        $time = date("Hi", strtotime($this->row->TARGET_DATE_ARRIVAL));
        $countrycode = substr($this->row->PORT_ARRIVAL_CODE, 0, 2);
        $this->message .= "R4*D*UN*{$this->row->PORT_ARRIVAL_CODE}*{$this->row->PORT_ARRIVAL}*{$countrycode}~\n";
        ++$SE_COUNTER;
        $this->message .= "DTM*139*{$date}*{$time}*LT~\n";
        ++$SE_COUNTER;
        // 2. code=E (Place of Dilevery MANDATORY)
        $date = date("Ymd", strtotime($this->row->TARGET_DATE_ARRIVAL));
        $time = date("Hi", strtotime($this->row->TARGET_DATE_ARRIVAL));
        $countrycode = substr($this->row->PORT_ARRIVAL_CODE, 0, 2);
        $this->message .= "R4*E*UN*{$this->row->PORT_ARRIVAL_CODE}*{$this->row->PORT_ARRIVAL}*{$countrycode}~\n";
        ++$SE_COUNTER;
        $this->message .= "DTM*139*{$date}*{$time}*LT~\n";
        ++$SE_COUNTER;
        //SE*15*0001
        ++$SE_COUNTER;
        $this->message .= "SE*{$SE_COUNTER}*{$this->ID_st}~\n";
    }
    public function genVesselArrivalActual(){}

    public function genDeparturePortDestinActual(){}
    public function genDeparturePortDestinEstim(){}

    public function genDeliveryDcActual(){}
    public function genDeliveryDcEdstim(){}
}