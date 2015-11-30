<html>
<head><title>Gallery</title>
<link rel="stylesheet" type="text/css" href="/mystyle.css">
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

#$result = $client->describeDBInstances(array(
 #   'DBInstanceIdentifier' => 'mp1-rca',
#));

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

$query = "SELECT * FROM comments";

if($res =$link->query($query))
{
	# printf("Select returned %d rows.\n", $res->num_rows);
}

//$link->real_query("SELECT * FROM items");
#$res = $link->use_result();

#function imageCreateFromAny($filepath) { 
  #  $type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize() 
 #  $allowedTypes = array( 
   #    1,  // [] gif 
    #    2,  // [] jpg 
     #  3,  // [] png 
      #  6   // [] bmp 
    #); 
    #if (!in_array($type, $allowedTypes)) { 
     #  return false; 
    #} 
    #switch ($type) { 
     #   case 1 : 
      #     $im = imageCreateFromGif($filepath); 
       # break; 
        #case 2 : 
         #  $im = imageCreateFromJpeg($filepath); 
        #break; 
        #case 3 : 
         #   $im = imageCreateFromPng($filepath); 
        #break; 
        #case 6 : 
         #   $im = imageCreateFromBmp($filepath); 
        #break; 
    #}    
    #return $im;  
#} 

#function LoadJPEG ($imgURL) {

    ##-- Get Image file from Port 80 --##
 #   $fp = fopen($imgURL, "r");
  #  $imageFile = fread ($fp, 3000000);
   # fclose($fp);

    ##-- Create a temporary file on disk --##
    #$tmpfname = tempnam ("/temp", "IMG");

    ##-- Put image data into the temp file --##
    #$fp = fopen($tmpfname, "w");
    #fwrite($fp, $imageFile);
    #fclose($fp);

    ##-- Load Image from Disk with GD library --##
    #$im = imagecreatefromjpeg ($tmpfname);

    ##-- Delete Temporary File --##
    #unlink($tmpfname);

    ##-- Check for errors --##
    #if (!$im) {
     #   print "Could not create JPEG image $imgURL";
    #}

    #return $im;
#}

#echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
#$img = imagecreatefrompng($row['rs3URL']);
#imagepng($img);
#$p = $row['rs3URL'];
#echo "here here";
#echo $p;
#$a = file_get_contents("$p");
#echo "aboutA ";
#echo $a; 
#$im = imagecreatefromjpeg("".$row['rs3URL']);
#       $image = new Imagick();
#       $f = fopen($row['rs3URL'], 'rb');
#       $image->readImageFile($f);

#    echo '<img src=$a border=0>';
#echo $row['ID'] . "Email: " . $row['email'];
#echo $row['rs3URL'] . "f : " . $row['fs3URL'];



	#$image = new Imagick();
	#$f = fopen('http://www.url.com/image.jpg', 'rb');
	#$image->readImageFile($f);
	printf("\n");
	echo $row['email'];
	#echo '<img src="'.$row['rs3URL'].'" width="200" height="200" />';
	printf("\n");
    echo "<img src =\" " . $row['rs3URL'] . "\" /><img src =\"" .$row['fs3URL'] . "\"/>";
#echo $row['ID'] . "Email: " . $row['email'];
#echo $row['rs3URL'] . "f : " . $row['fs3URL'];
}
$link->close();
?>
</body>
</html>
