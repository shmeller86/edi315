<?php
/**
 * Created by PhpStorm.
 * User: che
 * Date: 22.09.2017
 * Time: 17:22
 */

namespace app\EDI;


class Info
{
    public $out = array();
    private $mass = array();
    public function __construct($mass, $name = null, $require = null, $type = null, $min = null, $max = null, $usage = null, $comment = null, $codes = null)
    {
        $this->mass = $mass;
        $this->MsgCreate($name, $require, $type, $min, $max, $usage, $comment, $codes);
        //$this->getVesselDeparture($name, $require, $type, $min, $max, $usage, $comment, $codes);
    }

    private function MsgCreate($name, $require, $type, $min, $max, $usage, $comment, $codes){
        echo "Всего сегментов найдено: ".count($this->mass).PHP_EOL;

        foreach ($this->mass as $mass1) {
            echo "\t ==== ".$mass1['DATA'][0]['VALUE']." ===".PHP_EOL.PHP_EOL;
            $i = 0;
            foreach ($mass1['DATA'] as $mass2){

                if (@is_array($mass2['DESC'])){
                    $i++;
                    if(!empty($mass2['VALUE'])) echo PHP_EOL.$i.") ".$mass2['VALUE']."\t\t\t\t\t\t\t\t\t\t";
                    else echo PHP_EOL.$i.") ---\t\t\t\t\t\t\t\t\t\t";

                    if ($name) echo "Name: ".$mass2['DESC']['NAME'].PHP_EOL;
                    if ($require) echo "\t\t\t\t\t\t\t\t\t\t\tRequire: ".$mass2['DESC']['REQUIRE'].PHP_EOL;
                    if ($type) echo "\t\t\t\t\t\t\t\t\t\t\tType: ".$mass2['DESC']['TYPE'].PHP_EOL;
                    if ($min) echo "\t\t\t\t\t\t\t\t\t\t\tMin: ".$mass2['DESC']['MIN'].PHP_EOL;
                    if ($max) echo "\t\t\t\t\t\t\t\t\t\t\tMax: ".$mass2['DESC']['MAX'].PHP_EOL;
                    if ($usage) echo "\t\t\t\t\t\t\t\t\t\t\tUsage: ".$mass2['DESC']['USAGE'].PHP_EOL;
                    if ($comment) echo "\t\t\t\t\t\t\t\t\t\t\tComment: ".$mass2['DESC']['COMMENT'].PHP_EOL;
                    if ($codes) {
                        if (count($mass2['DESC']['CODES']) > 0) {
                            foreach ($mass2['DESC']['CODES'] as $k => $v) {
                                if (@isset($mass2['DESC']['CODES'][$mass2['VALUE']])) {
                                    echo "\t\t\t\t\t\t\t\t\t\t\tCodes: " . $mass2['DESC']['CODES'][$mass2['VALUE']] . PHP_EOL;
                                    break;
                                }
                            }
                        }
                    }


                }
            }
        }
    }

    public function getVesselDeparture($name, $require, $type, $min, $max, $usage, $comment, $codes){
        foreach ($this->mass as $mass1) {
            switch ($mass1['DATA'][0]['VALUE']) {
                case "B4":
                    echo $mass1['DATA'][11]['DESC']['NAME']." :\t\t\t ".$mass1['DATA'][11]['VALUE'].PHP_EOL.PHP_EOL;
                    break;
                case "R4":
                    echo $mass1['DATA'][1]['DESC']['NAME']." :\t\t\t ".$mass1['DATA'][1]['VALUE'].PHP_EOL;
                    break;
                case "DTM":
                    echo $mass1['DATA'][1]['DESC']['NAME']." :\t\t\t ".$mass1['DATA'][1]['VALUE'].PHP_EOL;
                    echo $mass1['DATA'][2]['DESC']['NAME']." :\t\t\t ".$mass1['DATA'][2]['VALUE'].PHP_EOL;
                    echo $mass1['DATA'][3]['DESC']['NAME']." :\t\t\t ".$mass1['DATA'][3]['VALUE'].PHP_EOL;
                    echo $mass1['DATA'][4]['DESC']['NAME']." :\t\t\t ".$mass1['DATA'][4]['VALUE'].PHP_EOL.PHP_EOL;
                    break;
            }
        }
    }


}