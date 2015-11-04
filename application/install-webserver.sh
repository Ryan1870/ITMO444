#!/bin/bash



sudo apt-get update -y
sudo apt-get install -y apache2 git php5 php5-curl mysql-client curl php5-mysql
git clone https://github.com/Ryan1870/ITMO444.git

mv ./ITMO444/images /var/www/html/images
mv ./ITMO444/index.html /var/www/html
mv ./ITMO444/*php /var/www/html


curl -sS https://getcomposer.org/installer | sudo php &> getcomp.txt

sudo php composer.phar require aws/aws-sdk-php &> comp.txt

sudo mv vendor /var/www/html &> mvVen.txt
sudo php /var/www/html/setup.php &> /tmp/setupthing.txt
sudo php /var/www/html/dbcreate.php &> /tmp/tablecre.txt

echo "DOne!" > results.txt



