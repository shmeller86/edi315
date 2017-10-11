<?php

include('../app/Generate315.php');

$obj = new \app\EDI315GEN\Generate315();

$obj->genVesselDeparture();

echo $obj->message;


















