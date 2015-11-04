

<?php
//conection: 
echo "Hello world"; 
$link = mysqli_connect("itmo544jrhdb","controller","letmein888","3306") or die("Error " . mysqli_error($link)); 

echo "Here is the result: " . $link;


$sql = "CREATE TABLE comments 
(
ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
PosterName VARCHAR(32),
Title VARCHAR(32),
Content VARCHAR(500),
uname Varchar(20),
email Varchar(20),
phone Varchar(20),
s3URL Varchar(256),
jpgfile Varchar(256),
state TineInt(3),
date Timestamp
)";

$con->query($sql);

?>
