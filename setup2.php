#<?php
// Start the session^M
#require 'vendor/autoload.php';
#$rds = new Aws\Rds\RdsClient([
 #   'version' => 'latest',
  #  'region'  => 'us-east-1'
#]);
#$result = $rds->createDBInstance([
 # 'AllocatedStorage' => 10,
    #'AutoMinorVersionUpgrade' => true || false,
    #'AvailabilityZone' => '<string>',
    #'BackupRetentionPeriod' => <integer>,
   # 'CharacterSetName' => '<string>',
   # 'CopyTagsToSnapshot' => true || false,
   # 'DBClusterIdentifier' => '<string>',
   # 'DBInstanceClass' => 'db.t1.micro', // REQUIRED
   # 'DBInstanceIdentifier' => 'mp1-rca', // REQUIRED
   # 'DBName' => 'customerrecords',
    #'DBParameterGroupName' => '<string>',
    #'DBSecurityGroups' => ['<string>', ...],
    #'DBSubnetGroupName' => 'testdb',
    #'Engine' => 'MySQL', // REQUIRED
    #'EngineVersion' => '5.5.41',
    #'Iops' => <integer>,
    #'KmsKeyId' => '<string>',
   # 'LicenseModel' => '<string>',
 # 'MasterUserPassword' => 'letmein888',
   # 'MasterUsername' => 'controller',
    #'MultiAZ' => true || false,
    #'OptionGroupName' => '<string>',
    #'Port' => <integer>,
    #'PreferredBackupWindow' => '<string>',
    #'PreferredMaintenanceWindow' => '<string>',
    #'PubliclyAccessible' => true,
    #'StorageEncrypted' => true || false,
    #'StorageType' => '<string>',
   # 'Tags' => [
   #     [
   #         'Key' => '<string>',
   #         'Value' => '<string>',
   #     ],
        // ...
   # ],
    #'TdeCredentialArn' => '<string>',
    #'TdeCredentialPassword' => '<string>',
   # 'VpcSecurityGroupIds' => ['<string>', ...],
#]);
#print "Create RDS DB results: \n"
 #print_r($rds);
#$result = $rds->waitUntil('DBInstanceAvailable',['DBInstanceIdentifier' => 'mp1-rca',
#]);
#// Create a table 
#$result = $rds->describeDBInstances([
#    'DBInstanceIdentifier' => 'mp1-rca',
#]);
#$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
#print "============\n". $endpoint . "================\n";
#$link = mysqli_connect($endpoint,"controller","letmein888","db444Name") or die("Error " . mysqli_error($link)); 
#echo "Here is the result: " . $link;
#$sql = "CREATE TABLE comments 
#(
#ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
#PosterName VARCHAR(32),
#Title VARCHAR(32),
#Content VARCHAR(500),
#uname VARCHAR(20),
#email VARCHAR(20),
#phone VARCHAR(20),
#s3URL VARCHAR(256),
#jpgfile VARCHAR(256),
#state TINYINT(3),
#date TIMESTAMP

#)";

#if (mysqli_query($link, $sql)){
#    echo "Table persons created successfully";
#} else {
 #   echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
#}
#mysqli_close($link);

