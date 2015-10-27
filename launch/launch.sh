#!/usr/local/bin/bash


declare -a instanceARR
./cleanup.sh

mapfile -t instanceARR < <(aws ec2 run-instances --image-id $1 --count $2 --instance-type $3 --key-name $6 --security-group-ids $4 --subnet-id $5 --associate-public-ip-address --user-data file:///Users/ryananderson/Documents/git/ITMO444/application/install-webserver.sh --iam-instance-profile Name=$7 --output table | grep InstanceId | sed "s/|//g" | tr -d ' '| sed "s/InstanceId//g") 

echo ${instanceARR[@]}
echo "hello"
aws ec2 wait instance-running --instance-ids ${instanceARR[@]}
echo "hello 2"
echo ${instanceARR[@]}


echo "instance are running"

aws elb create-load-balancer --load-balancer-name lb --listeners Protocol=HTTP,LoadBalancerPort=80,InstanceProtocol=HTTP,InstancePort=80 --security-groups sg-f647b490 --subnets subnet-3d0b2816 --output=text
ELBURL=('aws elb create-load-balancer --load-balancer-name lb --listeners Protocol=HTTP,LoadBalancerPort=80,InstanceProtocol=HTTP,InstancePort=80 --security-groups sg-f647b490 --subnets subnet-3d0b2816 --output=text'); echo $ELBURL
	
	echo -e "\nFinished launching ELB and sleeping 30 seconds"
	for i in {0..30}; do echo -ne '.'; sleep 1;done
	echo "\n"
	
aws elb register-instances-with-load-balancer --load-balancer-name lb --instances ${instanceARR[@]}
aws elb configure-health-check --load-balancer-name itmo544jrh-lb --health-check Target=HTTP:80/index.html,Interval=30,UnhealthyThreshold=2,HealthyThreshold=2,Timeout=3