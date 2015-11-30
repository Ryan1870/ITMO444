<html>
<body>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<?php
// Start the session
session_start();
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.
require 'vendor/autoload.php';
#use Aws\S3\S3Client;
#$client = S3Client::factory();
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
echo $_POST['useremail'];
$email = $_POST['useremail'];
$sn = new Aws\Sns\SnsClient([
        'version' => 'latest',
        'region' => 'us-east-1'
]);

$resARN = $sn->createTopic([
        'Name' => 'testmp2',
]);

print("List All Platform Applications:\n");

$Model1 = $sn->listTopics();

foreach ($Model1['Topics'] as $App)
  {
    print($App['TopicArn'] . "\n");
  }
  print("\n");
  
  $AppArn = $Model1['Topics'][0]['TopicArn'];

$resSetTopicAttr = $sn->setTopicAttributes([
    'AttributeName' => 'DisplayName', // REQUIRED
    'AttributeValue' => 'mp2tester',
    'TopicArn' => $AppArn, // REQUIRED
]);




$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);




echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}

echo 'Here is some more debugging info:';
print_r($_FILES);

print "</pre>";



$bucket = uniqid("php-rca-",false);

#$result = $client->createBucket(array(
#    'Bucket' => $bucket
#));
# AWS PHP SDK version 3 create bucket
$result = $s3->createBucket([
    'ACL' => 'public-read-write',
    'Bucket' => $bucket,
]);

print_r($result);
#$client->waitUntilBucketExists(array('Bucket' => $bucket));
#Old PHP SDK version 2
#$key = $uploadfile;
#$result = $client->putObject(array(
#    'ACL' => 'public-read',
#    'Bucket' => $bucket,
#    'Key' => $key,
#    'SourceFile' => $uploadfile 
#));

# PHP version 3
$result = $s3->putObject([
    'ACL' => 'public-read-write',
    'Bucket' => $bucket,
   'Key' => $uploadfile,
   'SourceFile' => $uploadfile,
]);  






$uploaddirT = '/tmp/';
$uploadfileT = $uploaddirT . basename($_FILES['userfile']['name']);

$file = $uploadfile;
$newfile = '/tmp/Thumb.png';
if(!copy($file, $newfile)){
        echo "falled to copy";
}

$image = new Imagick($newfile);
$image->thumbnailImage(50, 0);
$image->writeImage($newfile);
#$file2 = $image;



echo $uploadfileT;
echo $_FILES['userfile']['tmp_name'];



$cthumb = $s3->putObject([
	'ACL' => 'public-read-write',
	'Bucket' => $bucket,
    'Key' => $newfile,
    'SourceFile' => $newfile,

]);

$url = $result['ObjectURL'];
echo $url;

$finurl = $cthumb['ObjectURL'];
echo $finurl;

$rds = new Aws\Rds\RdsClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);


$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'mp1-rca',
    
]);


$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
#print "============\n". $endpoint . "================\n";

//echo "begin database";^M
$link = mysqli_connect($endpoint,"controller","letmein888","db444Name") or die("Error " . mysqli_error($link));


/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
######

mysqli_query($link, "SELECT Count(*) FROM comments WHERE email = '$email'");

$results = $link->insert_id;
#echo $link->error;
#echo $results;

$query = "SELECT Count(*) FROM comments WHERE email = '$email'";

$res =$link->query($query);
$num_rows = mysqli_fetch_row($res);
#print "count is " .$num_rows[0]. "hi"; 

if($num_rows[0] > 0){
	##already in db assumed sub

	$uname = $_POST['username'];
	#$email = $_POST['useremail'];
	$phone = $_POST['phone'];
	$s3rawurl = $url; //  $result['ObjectURL']; from above
	$filename = basename($_FILES['userfile']['name']);
	$s3finishedurl = $finurl;
	$status =0;
	$issubscribed=0;
	mysqli_query($link, "INSERT INTO comments (ID, uname,email,phone,rs3URL,fs3URL,jpgfile,state,date) VALUES (NULL, '$uname', '$email', '$phone', '$s3rawurl', '$s3finishedurl', '$filename', '$status', NULL)");
	$results = $link->insert_id;
	##echo $link->error;
##echo $results;


	$resultsubArns = $sn->listSubscriptionsByTopic([
		'TopicArn' => $AppArn,
	]);

	print $resultsubArns;

	$resulstPub = $sn->publish([
		'Message' => 'An image has been posted to the gallery',
		'TopicArn' => $AppArn,
		]);

}else{
	#not in db add and send sns

	$resultSub = $sn->subscribe([
   	 'Endpoint' => $email,
   	 'Protocol' => 'email', // REQUIRED
   	 'TopicArn' => $AppArn, // REQUIRED
	]);

	$uname = $_POST['username'];
	#$email = $_POST['useremail'];
	$phone = $_POST['phone'];
	$s3rawurl = $url; //  $result['ObjectURL']; from above
	$filename = basename($_FILES['userfile']['name']);
	$s3finishedurl = $finurl;
	$status =0;
	$issubscribed=0;
	mysqli_query($link, "INSERT INTO comments (ID, uname,email,phone,rs3URL,fs3URL,jpgfile,state,date) VALUES (NULL, '$uname', '$email', '$phone', '$s3rawurl', '$s3finishedurl', '$filename', '$status', NULL)");
	$results = $link->insert_id;


	$resultsubArns = $sn->listSubscriptionsByTopic([
	'TopicArn' => $AppArn,
	]);

	#print $resultsubArns;

	$resulstPub = $sn->publish([
	'Message' => 'An image has been posted to the gallery',
	'TopicArn' => $AppArn,
	]);



	##echo $link->error;
	##echo $results;
	#not in db add and send sns
}





	header('Location: gallery.php'); 

//Dynamically resize images
function thumb_create($file, $width , $height ) {
	try
	{
	        /*** the image file ***/
	        $image = $file;
	        echo 'here1';
	
	        /*** a new imagick object ***/
	        $im = new Imagick();
	
	        /*** ping the image ***/
	        $im->pingImage($image);
	        echo 'here2';
	
	        /*** read the image into the object ***/
	        $im->readImage( $image );
	        echo 'here3';
	
	        /*** thumbnail the image ***/
	        $im->thumbnailImage( $width, $height );
	        echo 'here4';
	
	        /*** Write the thumbnail to disk ***/
	        $im->writeImage( $file );
	        echo 'here5';
	
	        /*** Free resources associated with the Imagick object ***/
	        $im->destroy();
	        return 'THUMB_'.$file;
	        echo 'here6';
	        
	}
	catch(Exception $e)
	{
	        print $e->getMessage();
	        return $file;
	}
};

   
?>
</body>


</html>