<?php

include('../app/Generate315.php');

$obj = new \app\EDI315GEN\Generate315();

//$obj->genVesselDeparture();

echo $obj->message;
/*
$connection = ibase_connect("127.0.0.1/3055:/home/gsoft/db/CARGOSMART.FDB", "EDI", "gsoftGSOFT");
$q = "select first 1 * from edi_files";
$res = ibase_query($connection, $q);
$r = ibase_fetch_object($res,IBASE_TEXT);*/



















