

<?php
require 'vendor/autoload.php';
$rds = new Aws\Rds\RdsClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'mp1-rca',
]);
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
print "============\n". $endpoint . "================\n";
$link = mysqli_connect($endpoint,"controller","letmein888","db444Name") or die("Error " . mysqli_error($link)); 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//conection: 
//echo "Hello world"; 

//echo "Here is the result: " . $link;


$sql = "CREATE TABLE comments
(
ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
uname VARCHAR(20),
email VARCHAR(32),
phone VARCHAR(20),
rs3URL VARHCHAR(256),
fs3URL VARCHAR(256),
jpgfile VARCHAR(256),
state TINYINT(3),
date TIMESTAMP)";

if (mysqli_query($link, $sql)){
    echo "Table persons created successfully";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
mysqli_close($link);
?>
