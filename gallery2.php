<html>
<head><title>Gallery</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>

<?php
session_start();
$email = $_POST["email"];
#echo $email;
require 'vendor/autoload.php';

$rds = new Aws\Rds\RdsClient([

'version' => 'latest',
'region'  => 'us-east-1'
]);



$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'mp1-rca',
    
]);

$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
#print "============\n". $endpoint . "================\n";


#echo $endpoint;
//echo "begin database";
$link = mysqli_connect($endpoint,"controller","letmein888","db444Name") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

mysqli_query($link, "SELECT * FROM comments WHERE email = '$email'");

$results = $link->insert_id;
#echo $link->error;
#echo $results;

$query = "SELECT * FROM comments WHERE email = '$email'";

if($res =$link->query($query))
{
	# printf("Select returned %d rows.\n", $res->num_rows);
}


while ($row = $res->fetch_assoc()) {

	echo $row['email'];
	#echo '<img src="'.$row['rs3URL'].'" width="200" height="200" />';
	#echo '<img src="'.$row['fs3URL']/>';
	printf("\n");
    echo "<img src =\" " . $row['rs3URL'] . "\" /><img src =\"" .$row['fs3URL'] . "\"/>";
#echo $row['ID'] . "Email: " . $row['email'];
#echo $row['rs3URL'] . "f : " . $row['fs3URL'];
}
$link->close();
?>
</body>
</html>