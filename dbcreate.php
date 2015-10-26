

<?php
//conection: 
echo "Hello world"; 
$link = mysqli_connect("itmo544jrhdb","controller","letmein888","3306") or die("Error " . mysqli_error($link)); 

echo "Here is the result: " . $link;

$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'mp1-rca',
   
]);


$endpoint = $result['DBInstances']['Endpoint']['Address']
    echo "============\n". $endpoint . "================";^M



$sql = "CREATE TABLE comments 
(
ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
PosterName VARCHAR(32),
Title VARCHAR(32),
Content VARCHAR(500)
)";

$con->query($sql);

?>
