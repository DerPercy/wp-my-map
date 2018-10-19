#!/bin/bash


sudo docker run -ti --rm \
	--name percy_wordpress \
	-v $(pwd)/../../data:/var/www/html \
	percy/wordpress
#if [ $# -eq 0 ]; then
#  echo "Only bind in function"
#  echo "Example run.sh \"cd app; yarn; node server.js;\""
#else
#  sudo docker run -ti --rm \
#    --name=percy_wordpress \
#    -v '/etc/ssl/certs/ca-certificates.crt:/etc/ssl/certs/ca-certificates.crt' \
#    -v $(pwd)/../..:/home/node \
#    percy/wordpress 
#    \
#    sh -c $1
#fi    


# Assign static IP to docker
# https://stackoverflow.com/questions/27937185/assign-static-ip-to-docker-container

#run_in_docker()
#{
#  echo $1
#  sudo docker run -ti --rm \
#    --name=joplin_nodejs \
#    -v '/etc/ssl/certs/ca-certificates.crt:/etc/ssl/certs/ca-certificates.crt' \
#    -v $1:/home/node \
#    joplin/nodejs \
#    sh -c "$2"
#  DOCKERIP= sudo docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' joplin_nodejs
#  echo $DOCKERIP
#  echo $1;
#  echo "Function";
#}
#cd ElectronClient/app
#rsync --delete -a ../../ReactNativeClient/lib/ lib/
#npm install
#yarn dist
