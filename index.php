<?php
require 'oswp-includes/loader.php';

/*$str = "\xE1";
var_dump($oswpdb->encodingController( $str , array( 'ASCII' , 'UTF-8' ) ));*/

//var_dump($oswpdb->getTotalRow( 'test_db' , 'all' ));

var_dump( 
    $oswpdb->SELECT( array( 'id', 'sdad' ) )
           ->FROM( 'test_db' )
           ->WHERE( array( 'id' ) ) 
        )
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<script defer src="oswp-includes/js/user.js"></script>
    
</body>
</html>