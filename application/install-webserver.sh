#!/bin/bash



sudo apt-get update -y
sudo apt-get install -y apache2 git php5 php5-curl mysql-client php5-mysql curl 
git clone https://github.com/Ryan1870/ITMO444.git

mv ./ITMO444/images /var/www/html/images
mv ./ITMO444/index.html /var/www/html
mv ./ITMO444/*php /var/www/html


curl -sS https://getcomposer.org/installer | sudo php

sudo php composer.phar require aws/aws-sdk-php

sudo mv vendor /var/www/html
sudo php /var/www/html/setup.php
echo "DOne!" > results.txt



