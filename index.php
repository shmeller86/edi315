<?php

include ('Class/Document.php');
include ('Class/Structure.php');
include ('Class/Info.php');

$file = file_get_contents('test');


$obj2 = new EDI\Structure((new EDI\Document($file))->seg);
new EDI\Info($obj2->arr_desc,1,1,1,1,1,1,1,1);
//print_r($obj->seg);
//print_r($obj2->arr_desc);