#!/bin/bash



sudo apt-get update -y
sudo apt-get install -y apache2 git php5 php5-curl mysql-client curl

curl -sS https://getcomposer.org/installer | php

php composer.phar require aws/aws-sdk-php

mv vendor /var/www/html

echo "DOne!" > results.txt



