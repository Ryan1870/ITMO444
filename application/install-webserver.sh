#!/bin/bash



sudo apt-get update -y
sudo apt-get install -y php5 php5-imagick
sudo aptitude install -y php5-imagick

sudo apt-get install -y apache2 git php5 php5-curl mysql-client curl php5-mysql

git clone https://github.com/Ryan1870/ITMO444.git

mv ./ITMO444/images /var/www/html/images
mv ./ITMO444/index.html /var/www/html
mv ./ITMO444/*php /var/www/html


curl -sS https://getcomposer.org/installer | sudo php &> getcomp.txt

sudo php composer.phar require aws/aws-sdk-php &> comp.txt

sudo mv vendor /var/www/html &> mvVen.txt
sudo php /var/www/html/setup.php &> /tmp/setupthing.txt
sudo chmod 600 /var/www/html/setup.php
#sudo php /var/www/html/dbcreate.php &> /tmp/tablecre.txt
sudo service apache2 restart

echo "DOne!" > results.txt



