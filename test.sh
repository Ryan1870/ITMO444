#!/usr/local/bin/bash


declare -a instanceARR
./cleanup.sh

mapfile -t instanceARR < <(aws ec2 run-instances --image-id ami-d05e75b8 --count $1 --instance-type t2.micro --key-name Mac --security-group-ids sg-f647b490 --subnet-id subnet-3d0b2816 --associate-public-ip-address --user-data file:///Users/ryananderson/Documents/School/Itm444/Anderson-Ryan-MiniProject-1/install-webserver.sh --output table | grep InstanceId | sed "s/|//g" | tr -d ' '| sed "s/InstanceId//g") 

echo ${instanceARR[@]}
echo "hello"
aws ec2 wait instance-running --instance-ids ${instanceARR[@]}
echo "hello 2"
echo ${instanceARR[@]}


echo "instance are running"

aws elb create-load-balancer --load-balancer-name $2 --listeners Protocol=HTTP,LoadBalancerPort=80,InstanceProtocol=HTTP,InstancePort=80 --security-groups sg-f647b490 --subnets subnet-3d0b2816 --output=text
ELBURL=('aws elb create-load-balancer --load-balancer-name $2 --listeners Protocol=HTTP,LoadBalancerPort=80,InstanceProtocol=HTTP,InstancePort=80 --security-groups sg-f647b490 --subnets subnet-3d0b2816 --output=text'); echo $ELBURL
	
	echo -e "\nFinished launching ELB and sleeping 30 seconds"
	for i in {0..30}; do echo -ne '.'; sleep 1;done
	echo "\n"
	
aws elb register-instances-with-load-balancer --load-balancer-name $2 --instances ${instanceARR[@]}
						