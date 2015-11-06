<html>
<head><title>Gallery</title>
</head>
<body>

<?php
session_start();
$email = $_POST["email"];
echo $email;
require 'vendor/autoload.php';

$rds = new Aws\Rds\RdsClient([

'version' => 'latest',
'region'  => 'us-east-1'
]);

#$result = $client->describeDBInstances(array(
 #   'DBInstanceIdentifier' => 'mp1-rca',
#));

$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'mp1-rca',
    
]);

$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
#print "============\n". $endpoint . "================\n";


echo $endpoint;
//echo "begin database";
$link = mysqli_connect($endpoint,"controller","letmein888","db444Name") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

mysqli_query($link, "SELECT * FROM comments WHERE email = '$email'");

$results = $link->insert_id;
echo $link->error;
echo $results;

$query = "SELECT * FROM comments WHERE email = '$email'";

if($res =$link->query($query))
{
	 printf("Select returned %d rows.\n", $res->num_rows);
}

//$link->real_query("SELECT * FROM items");
#$res = $link->use_result();
echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo "<img src =\" " . $row['rs3URL'] . "\" /><img src =\"" .$row['fs3URL'] . "\"/>";
echo $row['ID'] . "Email: " . $row['email'];
echo $row['rs3URL'] . "f : " . $row['fs3URL'];
}
$link->close();
?>
</body>
</html>
