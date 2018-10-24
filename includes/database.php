<?php
$host = getenv('HOST');
$username = getenv('USERNAME');
$password = getenv('PASSWORD');
$database = getenv('DATABASE');
//getenv reads what environment variable exists within apache server

$connection = mysqli_connect(
    $host,
    $username,
    $password,
    $database);
if( $connection == false){
    echo "database connection error";
}
?>