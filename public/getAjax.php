<h2>Source</h2>
<p>

<?php
include('../app/Document.php');
include('../app/Structure.php');
include('../app/Info.php');

$file = file_get_contents('../tmp/test');


$obj2 = new app\EDI\Structure((new app\EDI\Document($file))->seg);
//echo "<pre>";
$save = 0;
foreach ($obj2->arr_desc as $value) {
    //echo "<div class=\"alert alert-success\">";

    foreach ($value['DATA'] as $key2 => $value2) {
        echo "<div class=\"btn-group\">";
        if ($key2 == '0') {
            echo "<button class=\"btn btn-primary btn-xs dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">" . $value2['VALUE'] . "<span class=\"caret\"></span></button>";
            echo "<ul class=\"dropdown-menu\">";
            echo $value['DESC']['NAME'];
        } else {
            if (isset($value2['VALUE'])) {

                $css = "info";
                if ($_GET['type'] == 'VesDep') {

                    if ($value['DATA'][0]['VALUE'] == "B4") {
                            if ($key2 == '7') $css = "success";
                            if ($key2 == '8') $css = "success";
                            if ($key2 == '11') $css = "success";
                            $container = $value['DATA'][7]['VALUE'].$value['DATA'][8]['VALUE'];
                            $location = $value['DATA'][11]['VALUE'];
                    }
                    if ($value['DATA'][0]['VALUE'] == "N9") {
                        if ($value['DATA'][1]['VALUE'] == "BM") {
                            if ($key2 == '2') $css = "success";
                            $booking = $value['DATA'][2]['VALUE'];
                        }
                    }
                    if ($value['DATA'][0]['VALUE'] == "R4") {
                        if ($value['DATA'][1]['VALUE'] == "L") {
                            if ($key2 == '1') $css = "success";
                            if ($key2 == '4') $css = "success";
                            $port = $value['DATA'][4]['VALUE'];
                            $save = 1;
                        }
                    }
                    if ($value['DATA'][0]['VALUE'] == "DTM" and $save == 1) {
                        if ($value['DATA'][1]['VALUE'] == "370") {
                            if ($key2 == '1') $css = "success";
                            if ($key2 == '2') $css = "success";
                            if ($key2 == '3') {
                                $css = "success";
                                $save = 0;
                            }
                            preg_match_all("/(\d{4})(\d{2})(\d{2})/",$value['DATA'][2]['VALUE'],$matches);
                            preg_match_all("/(\d{2})(\d{2})/",$value['DATA'][3]['VALUE'],$matches2);

                            $date = $matches[1][0].".".$matches[2][0].".".$matches[3][0]." ".$matches2[1][0].":".$matches2[2][0];
                        }
                    }
                }

                echo "<button class=\"btn btn-".$css." btn-xs dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">" . $value2['VALUE'] . "<span class=\"caret\"></span></button>";
                echo "<ul class=\"dropdown-menu\">";
                echo "<b>" . $value2['DESC']['NAME'] . "</b>";
                echo "<br>";
                echo "<b>Require: </b>" . $value2['DESC']['REQUIRE'];
                echo "<br>";
                echo "<b>Type: </b>" . $value2['DESC']['TYPE'];
                echo "<br>";
                echo "<b>Min: </b>" . $value2['DESC']['MIN'];
                echo "<br>";
                echo "<b>Max: </b>" . $value2['DESC']['MAX'];
                echo "<br>";
                echo "<b>Usage: </b>" . $value2['DESC']['USAGE'];
                echo "<br>";
                echo "<b>Comment: </b>" . $value2['DESC']['COMMENT'];
                echo "<br>";
                if (count($value2['DESC']['CODES']) > 0) {
                    foreach ($value2['DESC']['CODES'] as $k => $v) {
                        if (@isset($value2['DESC']['CODES'][$value2['VALUE']])) {
                            echo "<b>Codes: </b>" . $value2['DESC']['CODES'][$value2['VALUE']];
                            echo "<br>";
                            break;
                        }
                    }
                }

                echo "</ul>";

            }
        }
        echo "</div>";
    }
    echo "<br>";
}
    echo "<div class=\"alert alert-success alert-dismissable\">";
echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
    echo "<b>Container</b>: ".$container."<br>";
    echo "<b>Location</b>: ".$location."<br>";
    echo "<b>Booking</b>: ".$booking."<br>";
    echo "<b>Port Of Loading</b>: ".$port."<br>";
    echo "<b>Date and Time</b>: ".$date."<br>";
    echo "</div>";
    ?>