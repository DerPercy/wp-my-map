FROM wordpress:4.9.8-php5.6-apache


# see https://docs.docker.com/samples/library/mysql/#start-a-mysql-server-instance

ENV MYSQL_USER=mysql \
    MYSQL_VERSION=5.7.22 \
    MYSQL_DATA_DIR=/var/lib/mysql \
    MYSQL_RUN_DIR=/run/mysqld \
    MYSQL_LOG_DIR=/var/log/mysql
   

   RUN apt-get update
   
ENV MARIADB_HOST="mariadb" \
    MARIADB_PORT_NUMBER="3306" \
    MARIADB_ROOT_PASSWORD="" \
    MARIADB_ROOT_USER="root" \
    MYSQL_CLIENT_CREATE_DATABASE_NAME="" \
    MYSQL_CLIENT_CREATE_DATABASE_PASSWORD="" \
    MYSQL_CLIENT_CREATE_DATABASE_PRIVILEGES="ALL" \
    MYSQL_CLIENT_CREATE_DATABASE_USER=""



RUN DEBIAN_FRONTEND=noninteractive apt-get install -y mysql-server
# && rm -rf ${MYSQL_DATA_DIR} \
#&& rm -rf /var/lib/apt/lists/*

EXPOSE 3306/tcp

#CMD ["/usr/bin/mysqld_safe"]


#RUN apt-get install mysql-server -y



#ENV USER_NAME=node
#ENV HOME=/home/${USER_NAME}

#RUN npm install -g node-gyp


#RUN apk add --update \
#    python \
#    python-dev \
#    make
    
#RUN apk add --update \
#    gcc
    
#RUN apk add --update \
#    build-base
    
#RUN apk add --update \
#    p7zip

#ENV USE_SYSTEM_7ZA=true    

#RUN npm install nodemon -g
#RUN yarn
    
#USER ${USER_NAME}

#WORKDIR ${HOME}


