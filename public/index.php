<?php

include('../app/Document.php');
include('../app/Structure.php');
include('../app/Info.php');

$path = '../tmp/test';
$file = file_get_contents($path);


$obj2 = new app\EDI\Structure((new app\EDI\Document($file))->seg);
//new app\EDI\Info($obj2->arr_desc,1,1,1,1,1,1,1,1);

//print_r($obj->seg);
/*
echo "<pre>";
print_r($obj2->arr_desc);
echo "</pre>";*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="navbar-collapse collapse">
            <form class="navbar-form navbar-right" role="form">
                <div class="form-group">
                    <input type="text" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>
            </form>
        </div>
    </div>
</div>

<div class="jumbotron">
    <div class="container">
        <h1>EDI X12!</h1>
    </div>
</div>
<div class="container">

    <div class="row">
        <div class="col-md-9" id="source">
            <h2>Source</h2>
            <p>

<?php
//echo "<pre>";

foreach ($obj2->arr_desc as $value) {
    //echo "<div class=\"alert alert-success\">";

    foreach ($value['DATA'] as $key2 => $value2){
        echo "<div class=\"btn-group\">";
        if($key2 == '0')  {
            echo "<button class=\"btn btn-primary btn-xs dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">".$value2['VALUE']."<span class=\"caret\"></span></button>";
            echo "<ul class=\"dropdown-menu\">";
            echo $value['DESC']['NAME'];
        }
        else {
            if (isset($value2['VALUE'])) {
                    echo "<button class=\"btn btn-info btn-xs dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">".$value2['VALUE']."<span class=\"caret\"></span></button>";
                    echo "<ul class=\"dropdown-menu\">";
                    echo "<b>".$value2['DESC']['NAME']."</b>";
                    echo "<br>";
                    echo "<b>Require: </b>".$value2['DESC']['REQUIRE'];
                    echo "<br>";
                    echo "<b>Type: </b>".$value2['DESC']['TYPE'];
                    echo "<br>";
                    echo "<b>Min: </b>".$value2['DESC']['MIN'];
                    echo "<br>";
                    echo "<b>Max: </b>".$value2['DESC']['MAX'];
                    echo "<br>";
                    echo "<b>Usage: </b>".$value2['DESC']['USAGE'];
                    echo "<br>";
                    echo "<b>Comment: </b>".$value2['DESC']['COMMENT'];
                    echo "<br>";
                    if (count($value2['DESC']['CODES']) > 0) {
                        foreach ($value2['DESC']['CODES'] as $k => $v) {
                            if (@isset($value2['DESC']['CODES'][$value2['VALUE']])) {
                                echo "<b>Codes: </b>" . $value2['DESC']['CODES'][$value2['VALUE']] ;
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

   // echo "</div>";

   // print_r($value);
}
//echo "</pre>";
?>

            </p>
        </div>
        <div class="col-md-3">
            <h3>Functions</h3>
            <p><a href="#" onclick="getAjax('VesDep','<?php echo $path; ?>');">Get Vessel Departure</a></p>
            <p><a href="#" onclick="getAjax('VesDepRelay','<?php echo $path; ?>');">Get Vessel Departure Relay</a></p>
            <p><a href="#" onclick="getAjax('VesArrEst','<?php echo $path; ?>');">Get Vessel Arrival (Estimated)</a></p>
            <p><a href="#" onclick="getAjax('VesArrAct','<?php echo $path; ?>');">Get Vessel Arrival (Actual)</a></p>
            <p><a href="#" onclick="getAjax('ADDPODEst','<?php echo $path; ?>');">Get Actual date of departure from Port of destination (Estimated)</a></p>
            <p><a href="#" onclick="getAjax('ADDPODAct','<?php echo $path; ?>');">Get Actual date of departure from Port of destination (Actual)</a></p>
            <p><a href="#" onclick="getAjax('ADDDCEst','<?php echo $path; ?>');">Get Actual date of delivery to DC (Estimated)</a></p>
            <p><a href="#" onclick="getAjax('ADDDCAct','<?php echo $path; ?>');">Get Actual date of delivery to DC (Actual)</a></p>
        </div>
    </div>
    <hr>
    <footer>
        <p>&copy; Company 2013</p>
    </footer>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<script>
    function getAjax(type, path){
        $.ajax({
            type: "GET",
            url: "getAjax.php",
            data: "type="+ type + "&path=" +path,
            success : function(text){
                $("#source").html(text);

            }
        });
    }
</script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>

