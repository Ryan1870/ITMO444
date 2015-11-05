

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
$link = mysqli_connect($endpoint,"controller","letmein888") or die("Error " . mysqli_error($link)); 

//conection: 
//echo "Hello world"; 
$link = mysqli_connect($endpoint,"controller","letmein888") or die("Error " . mysqli_error($link)); 
//echo "Here is the result: " . $link;


$sql = "CREATE TABLE 'comments' 
(
'ID' INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
'PosterName' VARCHAR(32),
'Title' VARCHAR(32),
'Content' VARCHAR(500),
'uname' Varchar(20),
'email' Varchar(20),
'phone' Varchar(20),
's3URL' Varchar(256),
'jpgfile' Varchar(256),
'state' TineInt(3),
'date' Timestamp
)";

if (mysqli_query($link, $sql)){
    echo "Table persons created successfully";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
mysqli_close($link);
?>
