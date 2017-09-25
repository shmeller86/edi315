<?php

include('../app/Document.php');
include('../app/Structure.php');
include('../app/Info.php');

$file = file_get_contents('../tmp/test');


$obj2 = new app\EDI\Structure((new app\EDI\Document($file))->seg);
new app\EDI\Info($obj2->arr_desc,1,1,1,1,1,1,1,1);

//print_r($obj->seg);
//print_r($obj2->arr_desc);